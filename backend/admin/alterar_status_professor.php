<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

header('Content-Type: application/json');

function responder($sucesso, $mensagem = '') {
    echo json_encode([
        'success' => $sucesso,
        'message' => $mensagem
    ]);
    exit;
}

// Validar dados recebidos
$id = intval($_POST['id'] ?? 0);
$status = intval($_POST['status'] ?? 0);

if ($id <= 0) {
    responder(false, 'ID do professor inválido.');
}

// Verificar se o professor existe
$stmt = $conn->prepare("SELECT id FROM professores WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
if ($stmt->get_result()->num_rows === 0) {
    responder(false, 'Professor não encontrado.');
}
$stmt->close();

// Atualizar status
$stmt = $conn->prepare("UPDATE professores SET ativo = ? WHERE id = ?");
$stmt->bind_param("ii", $status, $id);

if ($stmt->execute()) {
    responder(true, 'Status do professor atualizado com sucesso!');
} else {
    responder(false, 'Erro ao atualizar status do professor: ' . $conn->error);
}

$stmt->close();
$conn->close();
?> 