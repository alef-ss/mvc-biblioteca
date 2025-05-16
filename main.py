from flask import Flask, request, render_template, session, redirect, url_for, flash
from werkzeug.security import check_password_hash, generate_password_hash
from flask_session import Session
import os
from db import conectar_db
from functools import wraps
import mysql.connector

app = Flask(__name__)

# Configurações de segurança
app.secret_key = os.environ.get('SECRET_KEY') or 'sua-chave-secreta-muito-segura-aqui'
app.config['SESSION_TYPE'] = 'filesystem'
app.config['SESSION_COOKIE_SECURE'] = True
app.config['SESSION_COOKIE_HTTPONLY'] = True
app.config['SESSION_COOKIE_SAMESITE'] = 'Lax'
app.config['PERMANENT_SESSION_LIFETIME'] = 1800  # 30 minutos

# Configurações do banco de dados
app.config['MYSQL_HOST'] = 'localhost'
app.config['MYSQL_DATABASE'] = 'test'
app.config['MYSQL_USER'] = 'root'  # substitua pelo seu usuário
app.config['MYSQL_PASSWORD'] = ''   # substitua pela sua senha

Session(app)

# Decorator para rotas que requerem login
def login_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'professor_id' not in session:
            flash('Por favor, faça login para acessar esta página.', 'warning')
            return redirect(url_for('login', next=request.url))
        return f(*args, **kwargs)
    return decorated_function

# Decorator para rotas administrativas
def admin_required(f):
    @wraps(f)
    def decorated_function(*args, **kwargs):
        if 'professor_id' not in session:
            flash('Por favor, faça login para acessar esta página.', 'warning')
            return redirect(url_for('login', next=request.url))
        if not session.get('admin'):
            flash('Acesso negado: você não tem privilégios de administrador.', 'danger')
            return redirect(url_for('dashboard'))
        return f(*args, **kwargs)
    return decorated_function




@app.route('/')
def index():
    return render_template('index.html')





@app.route('/login', methods=['GET', 'POST'])
def login():
    if request.method == 'GET':
        session.pop('_flashes', None)
        return render_template('login.html')
    
    email = request.form.get('email', '').strip().lower()
    senha = request.form.get('senha', '')
    next_page = request.args.get('next')

    if not email or not senha:
        flash('Todos os campos são obrigatórios!', 'danger')
        return redirect(url_for('login'))
    
    if '@' not in email or '.' not in email:
        flash('E-mail inválido!', 'danger')
        return redirect(url_for('login'))

    try:
        conn = conectar_db()
        with conn.cursor(dictionary=True) as cursor:
            sql = "SELECT id, nome, senha, admin FROM professores WHERE email = %s"
            cursor.execute(sql, (email,))
            professor = cursor.fetchone()

            if professor and check_password_hash(professor['senha'], senha):
                session.clear()
                session['professor_id'] = professor['id']
                session['nome'] = professor['nome']
                session['admin'] = bool(professor['admin'])
                session.permanent = True
                
                # Atualiza último login
                update_sql = "UPDATE professores SET ultimo_login = NOW() WHERE id = %s"
                cursor.execute(update_sql, (professor['id'],))
                conn.commit()
                
                flash('Login realizado com sucesso!', 'success')
                
                if next_page:
                    return redirect(next_page)
                return redirect(url_for('admin_dashboard' if professor['admin'] else 'dashboard'))
            else:
                flash('Email ou senha incorretos!', 'danger')
                return redirect(url_for('login'))
    except Exception as e:
        app.logger.error(f'Erro durante o login: {str(e)}')
        flash('Erro no servidor. Tente novamente.', 'danger')
        return redirect(url_for('login'))
    finally:
        if 'conn' in locals():
            conn.close()




@app.route('/logout')
def logout():
    session.clear()
    flash('Você foi desconectado com sucesso.', 'info')
    return redirect(url_for('index'))




@app.route('/dashboard')
@login_required
def dashboard():
    try:
        conn = conectar_db()
        with conn.cursor(dictionary=True) as cursor:
            # Busca alunos associados ao professor
            cursor.execute("SELECT * FROM alunos WHERE professor_id = %s", (session['professor_id'],))
            alunos = cursor.fetchall()
            
            # Busca empréstimos recentes
            cursor.execute("""
                SELECT e.*, l.titulo as livro_titulo, a.nome as aluno_nome 
                FROM emprestimos e
                JOIN livros l ON e.livro_id = l.id
                JOIN alunos a ON e.aluno_id = a.id
                WHERE e.professor_id = %s
                ORDER BY e.data_emprestimo DESC
                LIMIT 5
            """, (session['professor_id'],))
            emprestimos = cursor.fetchall()
            
            return render_template('dashboard.html', 
                                 nome=session.get('nome'),
                                 alunos=alunos,
                                 emprestimos=emprestimos)
    except Exception as e:
        app.logger.error(f'Erro ao acessar dashboard: {str(e)}')
        flash('Erro ao carregar dados do dashboard.', 'danger')
        return redirect(url_for('index'))
    finally:
        if 'conn' in locals():
            conn.close()



@app.route('/admin/dashboard')
@login_required
@admin_required
def admin_dashboard():
    try:
        conn = conectar_db()
        with conn.cursor(dictionary=True) as cursor:
            # Estatísticas para admin
            cursor.execute("SELECT COUNT(*) as total FROM professores")
            total_professores = cursor.fetchone()['total']
            
            cursor.execute("SELECT COUNT(*) as total FROM alunos")
            total_alunos = cursor.fetchone()['total']
            
            cursor.execute("SELECT COUNT(*) as total FROM livros")
            total_livros = cursor.fetchone()['total']
            
            cursor.execute("""
                SELECT e.*, l.titulo as livro_titulo, a.nome as aluno_nome, p.nome as professor_nome
                FROM emprestimos e
                JOIN livros l ON e.livro_id = l.id
                JOIN alunos a ON e.aluno_id = a.id
                LEFT JOIN professores p ON e.professor_id = p.id
                ORDER BY e.data_emprestimo DESC
                LIMIT 10
            """)
            emprestimos = cursor.fetchall()
            
            return render_template('admin/dashboard.html',
                                 total_professores=total_professores,
                                 total_alunos=total_alunos,
                                 total_livros=total_livros,
                                 emprestimos=emprestimos)
    except Exception as e:
        app.logger.error(f'Erro ao acessar admin dashboard: {str(e)}')
        flash('Erro ao carregar dados administrativos.', 'danger')
        return redirect(url_for('dashboard'))
    finally:
        if 'conn' in locals():
            conn.close()

import re

def validar_cpf(cpf):
    cpf = re.sub(r'[^0-9]', '', cpf)
    if len(cpf) != 11:
        return False
    if re.match(r'(\d)\1{10}', cpf):
        return False

    for t in [9, 10]:
        soma = 0
        for i in range(t):
            soma += int(cpf[i]) * ((t + 1) - i)
        digito = (10 * soma) % 11
        digito = 0 if digito == 10 else digito
        if int(cpf[t]) != digito:
            return False
    return True



@app.route('/cadastro_professor_principal', methods=['GET', 'POST'])
def cadastro_professor_principal():
    if request.method == 'GET':
        return render_template('cadastro_professor_principal.html')

    nome = request.form.get('nome', '').strip()
    email = request.form.get('email', '').strip()
    cpf = request.form.get('cpf', '').strip()
    senha = request.form.get('senha', '')
    codigo_secreto = request.form.get('codigo_secreto', '').strip()

    if not nome or not email or not cpf or not senha:
        flash('Todos os campos são obrigatórios!', 'danger')
        return redirect(url_for('cadastro_professor_principal'))

    if not validar_cpf(cpf):
        flash('CPF inválido!', 'danger')
        return redirect(url_for('cadastro_professor_principal'))

    is_admin = 0
    try:
        conn = conectar_db()
        with conn.cursor(dictionary=True) as cursor:
            if codigo_secreto:
                cursor.execute("SELECT secret_code FROM admin_settings LIMIT 1")
                row = cursor.fetchone()
                if not row or codigo_secreto != row['secret_code']:
                    flash('Código secreto inválido!', 'danger')
                    return redirect(url_for('cadastro_professor_principal'))

                is_admin = 1

            senha_hash = generate_password_hash(senha)

            sql = "INSERT INTO professores (nome, email, cpf, senha, ativo, admin) VALUES (%s, %s, %s, %s, 1, %s)"
            cursor.execute(sql, (nome, email, cpf, senha_hash, is_admin))
            conn.commit()

            flash('Cadastro realizado com sucesso! Você já pode fazer login.', 'success')
            return redirect(url_for('login'))
    except Exception as e:
        app.logger.error(f'Erro ao cadastrar professor: {str(e)}')
        flash('Erro ao cadastrar: ' + str(e), 'danger')
        return redirect(url_for('cadastro_professor_principal'))
    finally:
        if 'conn' in locals():
            conn.close()

if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
