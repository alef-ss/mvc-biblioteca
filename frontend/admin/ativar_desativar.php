<?php
session_start();
include '../../includes/conn.php';

if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: ../../frontend/login.php");
    exit();
}

if (isset($_GET['id']) && isset($_GET['acao'])) {
    $id = intval($_GET['id']);
    $acao = $_GET['acao'] === 'ativar' ? 1 : 0;

    $stmt = $conn->prepare("UPDATE professores SET ativo = ? WHERE id = ?");
    $stmt->bind_param("ii", $acao, $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: listar_professores.php");
exit();