<?php
session_start();
include '../includes/conn.php';

function validarCPF($cpf) {
    // Remover qualquer coisa que não seja número
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Aqui verifica se tem 11 dígitos
    if (strlen($cpf) != 11) {
        return false;
    }

    // Elimina CPF inválido que tem todos os números iguais
    if (preg_match('/(\d)\1{10}/', $cpf)){
        return false;
    }

    // Calcula os dois dígitos verificadores
    for ($t = 9; $t < 11; $t++) {
        $soma = 0;
        for($i = 0; $i < $t; $i++) {
            $soma += $cpf[$i] * (($t + 1) - $i);
        }

        $digito = (10 * $soma) % 11;
        $digito = ($digito == 10) ? 0 : $digito;

        if($cpf[$t] != $digito) {
            return false;
        }
    }

    // Se passou por tudo, o CPF é válido
    return true;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);
    $senha = $_POST['senha'];
    $codigo_secreto = trim($_POST['codigo_secreto'] ?? ''); // Novo campo opcional

    // Validações básicas
    if (empty($nome) || empty($email) || empty($cpf) || empty($senha)) {
        $_SESSION['erro_cadastro'] = 'Todos os campos são obrigatórios!';
        header("Location: ../frontend/cadastro_professor_principal.php");
        exit();
    }

    // Aqui você pode adicionar validações adicionais para e-mail, CPF, etc.

    // Verifica se o código secreto está correto (se fornecido)
    $is_admin = 0; // Por padrão, não é admin
    if (!empty($codigo_secreto)) {
        $stmt = $conn->prepare("SELECT secret_code FROM admin_settings LIMIT 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($codigo_secreto === $row['secret_code']) {
            $is_admin = 1; // Virar admin
        } else {
            $_SESSION['erro_cadastro'] = 'Código secreto inválido!';
            header("Location: ../frontend/cadastro_professor_principal.php");
            exit();
        }
    }

    // Hash da senha antes de inserir no banco de dados
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere o professor (agora com campo 'admin')
    $stmt = $conn->prepare("INSERT INTO professores (nome, email, cpf, senha, ativo, admin) VALUES (?, ?, ?, ?, 1, ?)");
    $stmt->bind_param("ssssi", $nome, $email, $cpf, $senha_hash, $is_admin);
    
    if ($stmt->execute()) {
        $_SESSION['sucesso_cadastro'] = 'Cadastro realizado com sucesso! Você já pode fazer login.';
        header("Location: ../frontend/login.php");
    } else {
        $_SESSION['erro_cadastro'] = 'Erro ao cadastrar: ' . $conn->error;
        header("Location: ../frontend/cadastro_professor_principal.php");
    }
    
    $stmt->close();
    $conn->close();
    exit();
}