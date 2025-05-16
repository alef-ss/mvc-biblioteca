<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

$alunos_sql = "SELECT id, nome FROM alunos";
$livros_sql = "SELECT id, titulo FROM livros";
$alunos_result = $conn->query($alunos_sql);
$livros_result = $conn->query($livros_sql);

// Inicializa as variáveis de mensagem
$success_message = null;
$error_message = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aluno_id = $_POST['aluno_id'];
    $livro_id = $_POST['livro_id'];
    $data_emprestimo = $_POST['data_emprestimo'];
    $data_devolucao = $_POST['data_devolucao'];

    $livro_check_sql = "SELECT quantidade FROM livros WHERE id = ?";
    $stmt = $conn->prepare($livro_check_sql);
    $stmt->bind_param("i", $livro_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($quantidade);
    $stmt->fetch();

    if ($quantidade > 0) {
        $sql = "INSERT INTO emprestimos (aluno_id, livro_id, data_emprestimo, data_devolucao, devolvido) VALUES (?, ?, ?, ?, 0)";
        $stmt_emprestimo = $conn->prepare($sql);
        $stmt_emprestimo->bind_param("iiss", $aluno_id, $livro_id, $data_emprestimo, $data_devolucao);

        if ($stmt_emprestimo->execute()) {
            $sql_update = "UPDATE livros SET quantidade = quantidade - 1 WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param("i", $livro_id);
            $stmt_update->execute();

            $success_message = "Empréstimo registrado com sucesso!";
            $stmt_update->close();
            $stmt_emprestimo->close();
        } else {
            $error_message = "Erro ao registrar empréstimo!";
            $stmt_emprestimo->close();
        }
    } else {
        $error_message = "Este livro não está disponível no momento!";
    }

    $stmt->close();
    
    $conn->close();
}
?>