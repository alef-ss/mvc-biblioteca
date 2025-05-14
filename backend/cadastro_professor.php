<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php'; 

// Deletar professor
if (isset($_POST['delete'])) {
    $professor_id = $_POST['professor_id'];

    $sql_delete = "DELETE FROM professores WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $professor_id);

    if ($stmt_delete->execute()) {
        echo "<div class='alert alert-success'>Professor deletado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao deletar professor!</div>";
    }

    $stmt_delete->close();
}

// Cadastrar professor
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = md5($_POST['senha']); // Senha criptografada

    // Verifica se o email do professor já existe
    $sql_check = "SELECT id FROM professores WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-danger'>Erro: Este email já está cadastrado!</div>";
    } else {
        // Inserindo no banco de dados
        $sql = "INSERT INTO professores (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $email, $cpf, $senha);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Professor cadastrado com sucesso!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar professor!</div>";
        }
    }

    $stmt_check->close();
    $stmt->close();
}

$conn->close();
?>
