<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

header('Content-Type: application/json');

// Função para responder em JSON e encerrar execução
function responder($sucesso, $mensagem = '', $arquivo = '') {
    echo json_encode([
        'success' => $sucesso,
        'message' => $mensagem,
        'file' => $arquivo
    ]);
    exit;
}

// Caminho do diretório de backups
$backup_dir = realpath(__DIR__ . '/../../backups');
if ($backup_dir === false) {
    $backup_dir = __DIR__ . '/../../backups';
    if (!file_exists($backup_dir)) {
        if (!mkdir($backup_dir, 0777, true)) {
            responder(false, 'Não foi possível criar o diretório de backups.');
        }
    }
}

// Nome do arquivo de backup (apenas do banco de dados)
$timestamp = date('Y-m-d_H-i-s');
$backup_file = $backup_dir . '/backup_' . $timestamp . '.sql';

// Configurações do MySQL
$host = 'localhost';
$user = 'root'; // Altere para seu usuário
$pass = '';     // Altere para sua senha
$database = 'mvc_biblioteca'; // Altere para seu banco de dados

// Monta o comando mysqldump
if ($pass !== '') {
    $command = sprintf(
        'mysqldump --host=%s --user=%s --password=%s %s > %s',
        escapeshellarg($host),
        escapeshellarg($user),
        escapeshellarg($pass),
        escapeshellarg($database),
        escapeshellarg($backup_file)
    );
} else {
    $command = sprintf(
        'mysqldump --host=%s --user=%s %s > %s',
        escapeshellarg($host),
        escapeshellarg($user),
        escapeshellarg($database),
        escapeshellarg($backup_file)
    );
}

// Executa o comando de backup
exec($command, $output, $return_var);

// Verifica se o arquivo foi criado e tem conteúdo suficiente (> 1KB)
if (!file_exists($backup_file) || filesize($backup_file) < 1024) {
    responder(false, 'Ocorreu um erro ao realizar o backup. O arquivo não foi gerado corretamente.');
}

// Limpa backups antigos (mantém apenas os últimos 5)
$backups = glob($backup_dir . '/backup_*.sql');
usort($backups, function($a, $b) {
    return filemtime($b) - filemtime($a);
});
while (count($backups) > 5) {
    $old_backup = array_pop($backups);
    unlink($old_backup);
}

// Registrar backup no banco
$stmt = $conn->prepare("
    INSERT INTO backup_log (
        arquivo,
        data_backup,
        tamanho,
        usuario_id
    ) VALUES (?, NOW(), ?, ?)
");
$file_size = filesize($backup_file);
$usuario_id = $_SESSION['professor_id'];
$stmt->bind_param('sii', basename($backup_file), $file_size, $usuario_id);
$stmt->execute();

// Retorna sucesso com link para download do arquivo SQL
responder(
    true,
    'Backup do banco de dados realizado com sucesso!',
    basename($backup_file)
);

/*
    Correções:
    - Agora só retorna erro se o arquivo não existir ou for muito pequeno (< 1KB).
    - Se o arquivo existir e tiver tamanho suficiente, retorna sucesso.
    - Comentários explicativos em Português-BR.
*/
?>
