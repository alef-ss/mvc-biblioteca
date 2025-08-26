<?php
session_start();

// Verifica se o professor está logado, se não, redireciona para login
if (!isset($_SESSION['professor_id'])) {
    header("Location: login.php");
    exit();
}

require '../includes/conn.php'; // Arquivo de conexão com o banco

// Cadastro de aluno
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $serie = $_POST['serie'];
    $email = $_POST['email'];

    // Valida o formato do e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => "Erro: Email inválido!"
        ];
        header("Location: cadastro_aluno.php");
        exit();
    }

    // Usa password_hash para maior segurança na senha
    // $senha = isset($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

    // Verifica se o email do aluno já está cadastrado
    $sql_check = "SELECT id FROM alunos WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Mensagem de erro e redireciona
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => "Erro: Este email já está cadastrado!"
        ];
        header("Location: cadastro_aluno.php");
        exit();
    } else {
        // Insere o aluno no banco de dados
        $sql = "INSERT INTO alunos (nome, serie, email) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nome, $serie, $email);

        if ($stmt->execute()) {
            // Mensagem de sucesso e redireciona
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => "Aluno cadastrado com sucesso!"
            ];
            header("Location: cadastro_aluno.php");
            exit();
        } else {
            // Mensagem de erro e redireciona
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => "Erro ao cadastrar aluno!"
            ];
            header("Location: cadastro_aluno.php");
            exit();
        }
    }

    $stmt_check->close();
    $stmt->close();
}

$conn->close();
?>
