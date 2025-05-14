<?php
session_start();
require_once '../includes/conn.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    try {
        $stmt = $conn->prepare("DELETE FROM livros WHERE id = ?");
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['sucesso'] = "Livro excluído com sucesso!";
        } else {
            $_SESSION['erro'] = "Erro ao excluir o livro.";
        }
    } catch (Exception $e) {
        $_SESSION['erro'] = "Erro: " . $e->getMessage();
    }
    
    header("Location: visualizar_livros.php");
    exit();
}
?>