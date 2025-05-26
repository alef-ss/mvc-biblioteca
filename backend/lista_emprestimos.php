<?php
session_start();
require '../includes/conn.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];

// Marcar como devolvido
if (isset($_GET['devolver_id'])) {
    $emprestimo_id = $_GET['devolver_id'];

    // Buscar o livro_id para atualizar a quantidade depois
    $sql = "SELECT livro_id FROM emprestimos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emprestimo_id);
    $stmt->execute();
    $stmt->bind_result($livro_id);
    $stmt->fetch();
    $stmt->close();

    // Atualizar o empréstimo para marcar como devolvido
    $sql = "UPDATE emprestimos SET devolvido = 'Sim', data_devolucao = CURDATE() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emprestimo_id);

    if ($stmt->execute()) {
        // Atualiza a quantidade do livro, pois foi devolvido
        $sql = "UPDATE livros SET quantidade = quantidade + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $livro_id);
        $stmt->execute();

        echo "<div class='alert alert-success'>Livro devolvido com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao devolver livro.</div>";
    }
    $stmt->close();
}


// Buscar empréstimos do professor
$sql = "SELECT e.id, l.titulo, a.nome, e.data_emprestimo, e.data_devolucao, e.devolvido
        FROM emprestimos e 
        JOIN livros l ON e.livro_id = l.id
        JOIN alunos a ON e.aluno_id = a.id
        WHERE e.professor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $professor_id);
$stmt->execute();
$result = $stmt->get_result();
?>
