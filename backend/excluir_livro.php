<?php
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php'; // Arquivo de conexão com o banco

// Verifica se o ID foi passado pela URL
if (!isset($_GET['id'])) {
    header("Location: visualizar_livros.php");
    exit();
}

$id = $_GET['id'];

// Exclui o livro do banco de dados
$sql = "DELETE FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "<div class='alert alert-success'>Livro excluído com sucesso!</div>";
} else {
    echo "<div class='alert alert-danger'>Erro ao excluir o livro!</div>";
}

$stmt->close();
?>