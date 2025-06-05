<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

header('Content-Type: application/json');

function responder($sucesso, $mensagem = '', $arquivo = '') {
    echo json_encode([
        'success' => $sucesso,
        'message' => $mensagem,
        'file' => $arquivo
    ]);
    exit;
}

// Criar diretório de backup se não existir
$backup_dir = '../../backups';
if (!file_exists($backup_dir)) {
    mkdir($backup_dir, 0777, true);
}

// Nome do arquivo de backup
$timestamp = date('Y-m-d_H-i-s');
$backup_file = $backup_dir . '/backup_' . $timestamp . '.sql';

// Configurações do MySQL
$host = 'localhost';
$user = 'root'; // Altere para seu usuário
$pass = ''; // Altere para sua senha
$database = 'biblioteca'; // Altere para seu banco de dados

// Comando para realizar o backup
$command = sprintf(
    'mysqldump --host=%s --user=%s --password=%s %s > %s',
    escapeshellarg($host),
    escapeshellarg($user),
    escapeshellarg($pass),
    escapeshellarg($database),
    escapeshellarg($backup_file)
);

// Executar backup
exec($command, $output, $return_var);

if ($return_var !== 0) {
    responder(false, 'Erro ao realizar backup do banco de dados.');
}

// Criar arquivo ZIP com o backup do banco e arquivos importantes
$zip = new ZipArchive();
$zip_file = $backup_dir . '/backup_completo_' . $timestamp . '.zip';

if ($zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
    responder(false, 'Erro ao criar arquivo ZIP.');
}

// Adicionar arquivo SQL
$zip->addFile($backup_file, 'database/backup.sql');

// Diretórios para backup
$dirs_to_backup = [
    '../../frontend' => 'frontend',
    '../../backend' => 'backend',
    '../../includes' => 'includes',
    '../../uploads' => 'uploads'
];

foreach ($dirs_to_backup as $dir => $zip_path) {
    if (file_exists($dir)) {
        // Criar Iterator para percorrer diretórios
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($dir, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $file_path = $file->getRealPath();
                $relative_path = $zip_path . '/' . substr($file_path, strlen($dir) + 1);
                $zip->addFile($file_path, $relative_path);
            }
        }
    }
}

$zip->close();

// Remover arquivo SQL temporário
unlink($backup_file);

// Limpar backups antigos (manter apenas os últimos 5)
$backups = glob($backup_dir . '/backup_completo_*.zip');
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

$file_size = filesize($zip_file);
$usuario_id = $_SESSION['professor_id'];

$stmt->bind_param('sii', basename($zip_file), $file_size, $usuario_id);
$stmt->execute();

// Retornar sucesso com link para download
responder(
    true, 
    'Backup realizado com sucesso!',
    'download_backup.php?file=' . basename($zip_file)
);
?> 