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
$dias_emprestimo = intval($_POST['dias_emprestimo'] ?? 0);
$max_livros_aluno = intval($_POST['max_livros_aluno'] ?? 0);
$max_renovacoes = intval($_POST['max_renovacoes'] ?? 0);
$multa_dia_atraso = floatval($_POST['multa_dia_atraso'] ?? 0);
$backup_automatico = isset($_POST['backup_automatico']) ? 1 : 0;
$email_notificacao = filter_var($_POST['email_notificacao'] ?? '', FILTER_VALIDATE_EMAIL);
$tema_padrao = in_array($_POST['tema_padrao'] ?? '', ['light', 'dark']) ? $_POST['tema_padrao'] : 'light';

// Validações
if ($dias_emprestimo < 1 || $dias_emprestimo > 30) {
    responder(false, 'Dias de empréstimo deve ser entre 1 e 30.');
}

if ($max_livros_aluno < 1 || $max_livros_aluno > 10) {
    responder(false, 'Máximo de livros por aluno deve ser entre 1 e 10.');
}

if ($max_renovacoes < 0 || $max_renovacoes > 5) {
    responder(false, 'Máximo de renovações deve ser entre 0 e 5.');
}

if ($multa_dia_atraso < 0) {
    responder(false, 'Multa por dia de atraso não pode ser negativa.');
}

if (!$email_notificacao) {
    responder(false, 'Email de notificação inválido.');
}

// Atualizar configurações
$stmt = $conn->prepare("
    UPDATE configuracoes SET
        dias_emprestimo = ?,
        max_livros_aluno = ?,
        max_renovacoes = ?,
        multa_dia_atraso = ?,
        backup_automatico = ?,
        email_notificacao = ?,
        tema_padrao = ?
    WHERE id = 1
");

$stmt->bind_param(
    "iiiidss",
    $dias_emprestimo,
    $max_livros_aluno,
    $max_renovacoes,
    $multa_dia_atraso,
    $backup_automatico,
    $email_notificacao,
    $tema_padrao
);

if ($stmt->execute()) {
    responder(true, 'Configurações salvas com sucesso!');
} else {
    responder(false, 'Erro ao salvar configurações: ' . $conn->error);
}

$stmt->close();
$conn->close();
?> 