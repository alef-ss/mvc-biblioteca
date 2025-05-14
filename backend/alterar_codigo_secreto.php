<?php
session_start();
include '../includes/conn.php';

// Verifica se o usuário é admin
if (!isset($_SESSION['professor_id']) || !isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../frontend/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $novo_codigo = trim($_POST['novo_codigo']);

    if (empty($novo_codigo)) {
        $_SESSION['erro_codigo'] = 'O novo código não pode estar vazio!';
        header("Location: ../frontend/alterar_codigo_secreto.php");
        exit();
    }

    // Atualiza o código secreto
    $stmt = $conn->prepare("UPDATE admin_settings SET secret_code = ?");
    $stmt->bind_param("s", $novo_codigo);
    
    if ($stmt->execute()) {
        $_SESSION['sucesso_codigo'] = 'Código secreto atualizado com sucesso!';
    } else {
        $_SESSION['erro_codigo'] = 'Erro ao atualizar o código: ' . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: ../frontend/alterar_codigo_secreto.php");
    exit();
}