<?php
session_start();
require_once '../../includes/auth_admin.php';

// Recebe o nome do arquivo via GET
$filename = basename($_GET['file'] ?? '');
$backup_dir = realpath(__DIR__ . '/../../backups');
$file_path = $backup_dir . '/' . $filename;

// Verifica se o arquivo existe
if (!file_exists($file_path)) {
    http_response_code(404);
    echo "Arquivo não encontrado!";
    exit;
}

// Força o download do arquivo .sql
header('Content-Description: File Transfer');
header('Content-Type: application/sql');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($file_path));
readfile($file_path);
exit;
?>