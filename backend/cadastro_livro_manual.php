<?php
include '../includes/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'] ?? '';
    $autor = $_POST['autor'] ?? '';
    $isbn = $_POST['isbn'] ?? '';
    $genero = $_POST['genero'] ?? '';
    $ano_publicacao = $_POST['ano_publicacao'] ?? '';

    // Validação simples
    if (empty($titulo)) {
        echo "Preencha ao menos o título do livro.";
        exit;
    }

    // Insere o livro no banco de dados
    $stmt = $conn->prepare("INSERT INTO livros (titulo, autor, isbn, genero, ano_publicacao) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titulo, $autor, $isbn, $genero, $ano_publicacao);

    if ($stmt->execute()) {
        echo "Livro cadastrado com sucesso!";
        echo "Você pode ver o livro em <a href='../frontend/visualizar_livros.php'>Visualizar Livros.</a>.";
    } else {
        echo "Erro ao cadastrar livro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
