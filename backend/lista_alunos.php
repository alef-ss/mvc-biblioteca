<?php
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php'; // Arquivo de conexão com o banco

// Deletar aluno
if (isset($_GET['deletar'])) {
    $aluno_id = $_GET['deletar'];

    // Deletando o aluno
    $sql = "DELETE FROM alunos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $aluno_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success fade show' role='alert'>
                Aluno deletado com sucesso!
              </div>";
    } else {
        echo "<div class='alert alert-danger fade show' role='alert'>
                Erro ao deletar aluno!
              </div>";
    }

    $stmt->close();
}

$conn->close();
?>