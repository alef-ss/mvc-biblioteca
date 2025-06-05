<?php
require_once '../../includes/conn.php';

// Verificar se backup automático está ativado
$stmt = $conn->prepare("SELECT backup_automatico FROM configuracoes WHERE id = 1");
$stmt->execute();
$config = $stmt->get_result()->fetch_assoc();

if (!$config['backup_automatico']) {
    exit('Backup automático desativado.');
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
    exit('Erro ao realizar backup do banco de dados.');
}

// Criar arquivo ZIP com o backup do banco e arquivos importantes
$zip = new ZipArchive();
$zip_file = $backup_dir . '/backup_automatico_' . $timestamp . '.zip';

if ($zip->open($zip_file, ZipArchive::CREATE) !== TRUE) {
    exit('Erro ao criar arquivo ZIP.');
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

// Limpar backups automáticos antigos (manter apenas os últimos 7 dias)
$backups = glob($backup_dir . '/backup_automatico_*.zip');
usort($backups, function($a, $b) {
    return filemtime($b) - filemtime($a);
});

$dias_retencao = 7;
$data_limite = strtotime("-$dias_retencao days");

foreach ($backups as $backup) {
    if (filemtime($backup) < $data_limite) {
        unlink($backup);
    }
}

// Registrar backup no banco
$stmt = $conn->prepare("
    INSERT INTO backup_log (
        arquivo,
        data_backup,
        tamanho,
        usuario_id,
        automatico
    ) VALUES (?, NOW(), ?, NULL, 1)
");

$file_size = filesize($zip_file);
$stmt->bind_param('si', basename($zip_file), $file_size);
$stmt->execute();

// Enviar email de notificação
$stmt = $conn->prepare("SELECT email_notificacao FROM configuracoes WHERE id = 1");
$stmt->execute();
$config = $stmt->get_result()->fetch_assoc();

$to = $config['email_notificacao'];
$subject = 'Backup Automático - Sistema Biblioteca';
$message = "
<html>
<head>
    <title>Backup Automático Realizado</title>
</head>
<body>
    <h2>Backup Automático Realizado com Sucesso</h2>
    <p>O backup automático do sistema foi realizado em " . date('d/m/Y H:i:s') . "</p>
    <p>Detalhes do backup:</p>
    <ul>
        <li>Arquivo: " . basename($zip_file) . "</li>
        <li>Tamanho: " . round($file_size / 1024 / 1024, 2) . " MB</li>
    </ul>
    <p>Este é um email automático, não responda.</p>
</body>
</html>
";

$headers = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=utf-8\r\n";
$headers .= "From: Sistema Biblioteca <noreply@biblioteca.com>\r\n";

mail($to, $subject, $message, $headers);

echo "Backup automático realizado com sucesso!\n";
echo "Arquivo: " . basename($zip_file) . "\n";
echo "Tamanho: " . round($file_size / 1024 / 1024, 2) . " MB\n";
?> 