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
$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = trim($_POST['senha'] ?? '');
$admin = isset($_POST['admin']) ? 1 : 0;

if (empty($nome)) {
    responder(false, 'O nome é obrigatório.');
}

if (empty($email)) {
    responder(false, 'O email é obrigatório.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    responder(false, 'Email inválido.');
}

if (empty($senha)) {
    responder(false, 'A senha é obrigatória.');
}

if (strlen($senha) < 6) {
    responder(false, 'A senha deve ter pelo menos 6 caracteres.');
}

// Verificar se o email já existe
$stmt = $conn->prepare("SELECT id FROM professores WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
if ($stmt->get_result()->num_rows > 0) {
    responder(false, 'Este email já está cadastrado.');
}
$stmt->close();

// Criptografar a senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Inserir novo professor
$stmt = $conn->prepare("
    INSERT INTO professores (nome, email, senha, admin, ativo, data_cadastro) 
    VALUES (?, ?, ?, ?, 1, NOW())
");
$stmt->bind_param("sssi", $nome, $email, $senha_hash, $admin);

if ($stmt->execute()) {
    responder(true, 'Professor cadastrado com sucesso!');
} else {
    responder(false, 'Erro ao cadastrar professor: ' . $conn->error);
}

$stmt->close();
$conn->close();
?> 