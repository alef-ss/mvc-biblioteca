<?php
session_start();

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

require '../includes/conn.php'; // Arquivo de conexão com o banco

// Cadastro de aluno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $serie = $_POST['serie'];
    $email = $_POST['email'];

    // Valida o formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger fade show' role='alert'>
                Erro: Email inválido!
              </div>";
        return;
    }

    // Criptografando a senha com MD5
    $senha = isset($_POST['senha']) ? md5($_POST['senha']) : null; // Senha criptografada com MD5

    // Verifica se o email do aluno já existe
    $sql_check = "SELECT id FROM alunos WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        echo "<div class='alert alert-danger fade show' role='alert'>
                Erro: Este email já está cadastrado!
              </div>";
    } else {
        // Inserindo no banco de dados
        $sql = "INSERT INTO alunos (nome, serie, email, senha) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $nome, $serie, $email, $senha);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success fade show' role='alert'>
                    Aluno cadastrado com sucesso!
                  </div>";
        } else {
            echo "<div class='alert alert-danger fade show' role='alert'>
                    Erro ao cadastrar aluno!
                  </div>";
        }
    }

    $stmt_check->close();
    $stmt->close();
}

$conn->close();
?>