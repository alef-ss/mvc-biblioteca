<?php
session_start();
require_once '../includes/conn.php';

// Função para retornar resposta JSON
function responderJson($sucesso, $mensagem, $redirect = '') {
    echo json_encode([
        'sucesso' => $sucesso,
        'mensagem' => $mensagem,
        'redirect' => $redirect
    ]);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    // Validações iniciais
    if (empty($email)) {
        responderJson(false, "O campo email é obrigatório.");
    } elseif (empty($senha)) {
        responderJson(false, "O campo senha é obrigatório.");
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        responderJson(false, "Por favor, insira um email válido.");
    } elseif (strlen($senha) < 6) {
        responderJson(false, "A senha deve ter pelo menos 6 caracteres.");
    } else {
        // Preparar e executar a consulta
        $stmt = $conn->prepare("SELECT id, nome, email, senha, admin FROM professores WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            responderJson(false, "Email não encontrado. Verifique se digitou corretamente.");
        } else {
            $professor = $result->fetch_assoc();
            
            // Verificar a senha
            if (password_verify($senha, $professor['senha'])) {
                // Login bem-sucedido
                $_SESSION['professor_id'] = $professor['id'];
                $_SESSION['professor_nome'] = $professor['nome'];
                $_SESSION['professor_email'] = $professor['email'];
                $_SESSION['admin'] = $professor['admin'];
                
                // Registrar o horário do login
                $stmt = $conn->prepare("UPDATE professores SET ultimo_login = NOW() WHERE id = ?");
                $stmt->bind_param("i", $professor['id']);
                $stmt->execute();

                // Determinar para onde redirecionar baseado no tipo de usuário
                $redirect = $professor['admin'] == 1 ? 'admin/dashboard.php' : 'dashboard.php';
                
                responderJson(true, "Login realizado com sucesso! Redirecionando...", $redirect);
            } else {
                responderJson(false, "Senha incorreta. Por favor, tente novamente.");
            }
        }
        $stmt->close();
    }
}

$conn->close();
?>