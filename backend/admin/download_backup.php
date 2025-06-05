<?php
session_start();
require_once '../../includes/auth_admin.php';

// Validar nome do arquivo
$file = $_GET['file'] ?? '';
if (!preg_match('/^backup_completo_\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2}\.zip$/', $file)) {
    die('Arquivo inválido.');
}

$backup_dir = '../../backups';
$file_path = $backup_dir . '/' . $file;

// Verificar se arquivo existe
if (!file_exists($file_path)) {
    die('Arquivo não encontrado.');
}

// Headers para download
header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $file . '"');
header('Content-Length: ' . filesize($file_path));
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

// Enviar arquivo
readfile($file_path);
exit;
?> 