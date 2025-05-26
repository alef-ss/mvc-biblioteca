-- Tabela de configurações
CREATE TABLE IF NOT EXISTS configuracoes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    dias_emprestimo INT NOT NULL DEFAULT 7,
    max_livros_aluno INT NOT NULL DEFAULT 3,
    max_renovacoes INT NOT NULL DEFAULT 2,
    multa_dia_atraso DECIMAL(10,2) NOT NULL DEFAULT 0.50,
    backup_automatico TINYINT(1) NOT NULL DEFAULT 1,
    email_notificacao VARCHAR(255) NOT NULL,
    tema_padrao ENUM('light', 'dark') NOT NULL DEFAULT 'light',
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Tabela de log de backups
CREATE TABLE IF NOT EXISTS backup_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    arquivo VARCHAR(255) NOT NULL,
    data_backup DATETIME NOT NULL,
    tamanho INT NOT NULL,
    usuario_id INT,
    automatico TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES professores(id) ON DELETE SET NULL
);

-- Inserir configurações padrão se não existirem
INSERT INTO configuracoes (
    dias_emprestimo, 
    max_livros_aluno, 
    max_renovacoes,
    multa_dia_atraso,
    backup_automatico,
    email_notificacao,
    tema_padrao
) 
SELECT 7, 3, 2, 0.50, 1, 'biblioteca@escola.com', 'light'
WHERE NOT EXISTS (SELECT 1 FROM configuracoes WHERE id = 1); 