<?php
session_start();

// Verifica se o professor está logado, se não, redireciona para a página de login
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

// Deletar professor
if (isset($_POST['delete'])) {
    $professor_id = $_POST['professor_id'];

    // Prepara a query para deletar o professor pelo ID
    $sql_delete = "DELETE FROM professores WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $professor_id);

    // Executa a query e exibe mensagem de sucesso ou erro
    if ($stmt_delete->execute()) {
        echo "<div class='alert alert-success'>Professor deletado com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao deletar professor!</div>";
    }

    $stmt_delete->close();
}

// Cadastrar professor
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['delete'])) {
    // Recebe os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    // Usa password_hash para maior segurança na senha
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    // Remove caracteres não numéricos do CPF
    $cpf_limpo = preg_replace('/[^0-9]/', '', $cpf);

    // Verifica se o email ou CPF já está cadastrado
    $sql_check = "SELECT id FROM professores WHERE email = ? OR cpf = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("ss", $email, $cpf_limpo);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        // Se já existe, define mensagem de erro e redireciona
        $_SESSION['toast'] = [
            'type' => 'error',
            'message' => "Email ou CPF já cadastrado."
        ];
        header("Location: cadastro_professor.php");
        exit();
    } else {
        // Se não existe, insere o novo professor no banco
        $sql_insert = "INSERT INTO professores (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("ssss", $nome, $email, $cpf_limpo, $senha);

        if ($stmt_insert->execute()) {
            // Mensagem de sucesso e redireciona
            $_SESSION['toast'] = [
                'type' => 'success',
                'message' => "Professor cadastrado com sucesso!"
            ];
            header("Location: cadastro_professor.php");
            exit();
        } else {
            // Mensagem de erro e redireciona
            $_SESSION['toast'] = [
                'type' => 'error',
                'message' => "Erro ao cadastrar professor."
            ];
            header("Location: cadastro_professor.php");
            exit();
        }
        $stmt_insert->close();
    }

    $stmt_check->close();
}

$conn->close();
