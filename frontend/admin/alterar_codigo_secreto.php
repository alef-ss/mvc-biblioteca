<?php
session_start();
include '../../includes/conn.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header(header: "Location: ../../frontend/login.php");
    exit();
}

// Busca o código atual
$sql = "SELECT secret_code FROM admin_settings LIMIT 1";
$result = $conn->query($sql);
$codigo_atual = $result->fetch_assoc()['secret_code'];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <title>Alterar Código Secreto</title>
</head>
<body>
    <h1>Alterar Código Secreto</h1>
    <p>Código atual: <strong><?= $codigo_atual ?></strong></p>
    
    <form method="POST" action="../../backend/alterar_codigo_secreto.php">
        <label for="novo_codigo">Novo Código:</label>
        <input type="text" name="novo_codigo" required>
        <button type="submit">Salvar</button>
    </form>
    
    <a href="dashboard.php">Voltar</a>
</body>
</html>