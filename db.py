import mysql.connector
from mysql.connector import Error
from flask import current_app

def conectar_db():
    """Estabelece conexão com o banco de dados MySQL"""
    try:
        conn = mysql.connector.connect(
            host='localhost',
            database='test',
            user='root',  # substitua pelo seu usuário do MySQL
            password=''   # substitua pela sua senha do MySQL
        )
        
        if conn.is_connected():
            current_app.logger.info('Conexão ao MySQL estabelecida com sucesso')
            return conn
            
    except Error as e:
        current_app.logger.error(f'Erro ao conectar ao MySQL: {e}')
        raise