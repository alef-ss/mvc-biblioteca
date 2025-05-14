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

// Busca os dados do livro a ser editado
$sql = "SELECT * FROM livros WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger'>Livro não encontrado!</div>";
    exit();
}

$livro = $result->fetch_assoc();

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano_publicacao = $_POST['ano_publicacao'];
    $genero = $_POST['genero'];
    $isbn = $_POST['isbn'];
    $quantidade = $_POST['quantidade'];

    // Atualiza o livro no banco de dados
    $sql_update = "UPDATE livros SET titulo = ?, autor = ?, ano_publicacao = ?, genero = ?, isbn = ?, quantidade = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssssssi", $titulo, $autor, $ano_publicacao, $genero, $isbn, $quantidade, $id);

    if ($stmt_update->execute()) {
        echo "<div class='alert alert-success'>Livro atualizado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao atualizar o livro!</div>";
    }
}

$stmt->close();
?>