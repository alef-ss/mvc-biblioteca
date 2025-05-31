# Sistema Gestão de Biblioteca

Sistema de gerenciamento de biblioteca escolar com controle de empréstimos, alunos, professores, livros e relatórios.

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Composer
- Servidor web (Apache/Nginx)

## Instalação

1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/sistema-biblioteca.git
cd sistema-biblioteca
```

2. Instale as dependências via Composer:
```bash
composer install
```

3. Crie o banco de dados:
```sql
CREATE DATABASE biblioteca CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

4. Importe as tabelas:
```bash
mysql -u seu_usuario -p biblioteca < database/tabelas.sql
```

5. Configure o acesso ao banco de dados:
   - Abra o arquivo `includes/conn.php`
   - Atualize as credenciais de acesso ao banco

6. Configure as permissões:
```bash
chmod 777 backups
chmod 777 uploads
```

7. Configure o backup automático:
   - Adicione a seguinte linha ao crontab:
```bash
0 0 * * * php /caminho/para/backend/admin/backup_automatico.php
```

## Configuração


1. Acesse o sistema com as credenciais padrão:
   - Email: admin@biblioteca.com
   - Senha: admin123

2. Acesse a área administrativa e configure:
   - Dias de empréstimo
   - Máximo de livros por aluno
   - Máximo de renovações
   - Multa por atraso
   - Email para notificações
   - Backup automático
   - Tema padrão

## Funcionalidades

- Gerenciamento de alunos
- Gerenciamento de professores
- Gerenciamento de livros
- Controle de empréstimos
- Relatórios em PDF e Excel
- Backup automático
- Tema claro/escuro
- Estatísticas e gráficos

## Segurança

- Autenticação de usuários
- Controle de acesso por perfil
- Proteção contra SQL Injection
- Validação de dados
- Backup automático
- Log de atividades

## Estrutura de Diretórios


## Dependências

- Bootstrap 5.3.0
- Font Awesome 6.4.0
- jQuery 3.6.0
- Chart.js 3.7.0
- SweetAlert2 11.0.19
- PhpSpreadsheet
- DOMPDF

## Contribuição

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/nova-feature`)
3. Commit suas mudanças (`git commit -am 'Adiciona nova feature'`)
4. Push para a branch (`git push origin feature/nova-feature`)
5. Crie um Pull Request