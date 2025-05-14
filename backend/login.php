<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require '../includes/conn.php';

    $email = trim($_POST['email']);
    $senha = $_POST['senha'];

    // Validações básicas
    if (empty($email) || empty($senha)) {
        $_SESSION['erro_login'] = 'Todos os campos são obrigatórios!';
        header("Location: ../frontend/login.php");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['erro_login'] = 'E-mail inválido!';
        header("Location: ../frontend/login.php");
        exit();
    }

    // Consulta verificando se o usuário existe e incluindo o campo 'admin'
    $sql = "SELECT id, nome, senha, admin FROM professores WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $professor = $resultado->fetch_assoc();

        if (password_verify($senha, $professor['senha'])) {
            // Armazena as informações do professor na sessão
            $_SESSION['professor_id'] = $professor['id'];
            $_SESSION['nome'] = $professor['nome'];
            $_SESSION['admin'] = $professor['admin']; // Agora esta linha funcionará corretamente

            // Redireciona para o painel adequado
            if ($professor['admin'] == 1) {
                header("Location: ../frontend/admin/dashboard.php");
            } else {
                header("Location: ../frontend/dashboard.php");
            }
            exit();
        } else {
            $_SESSION['erro_login'] = "Email ou senha incorretos!";
        }
    } else {
        $_SESSION['erro_login'] = "Email ou senha incorretos!";
    }

    $stmt->close();
    $conn->close();
    header("Location: ../frontend/login.php");
    exit();
}