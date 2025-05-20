<?php
session_start();
include('../includes/conn.php');

// Ativar relatório de erros detalhados
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Função para registrar e exibir logs
function debug_log($message) {
    error_log($message);
    $_SESSION['debug_log'][] = $message;
}

// Processamento do formulário se houver envio via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['action'])) {
    // Limpa logs anteriores
    unset($_SESSION['debug_log']);
    
    // Função para validar CPF
    function validaCPF($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpf) != 11 || preg_match('/(\d)\1{10}/', $cpf)) return false;
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) $d += $cpf[$c] * (($t + 1) - $c);
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) return false;
        }
        return true;
    }

    // Validação de e-mail
    function validaEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    $cpf = isset($_POST['cpf']) ? preg_replace('/[^0-9]/', '', $_POST['cpf']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    debug_log("Dados recebidos do formulário:");
    debug_log("CPF (após limpeza): $cpf");
    debug_log("Email: $email");

    $erros = [];
    if (empty($cpf)) $erros[] = "CPF é obrigatório.";
    elseif (!validaCPF($cpf)) $erros[] = "CPF inválido.";
    if (empty($email)) $erros[] = "E-mail é obrigatório.";
    elseif (!validaEmail($email)) $erros[] = "E-mail inválido.";

    if (empty($erros)) {
        try {
            debug_log("Iniciando verificação no banco de dados...");
            
            if (!$conn || $conn->connect_error) {
                debug_log("Erro na conexão com o banco: " . ($conn->connect_error ?? 'Conexão não estabelecida'));
                $erros[] = "Erro no sistema. Por favor, tente novamente.";
            } else {
                debug_log("Conexão com o banco estabelecida com sucesso");
                
                // Consulta principal
                $sql = "SELECT id FROM professores WHERE cpf = ? AND email = ? AND ativo = 1";
                debug_log("Preparando consulta: $sql");
                
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    debug_log("Erro ao preparar consulta: " . $conn->error);
                    $erros[] = "Erro no sistema. Por favor, tente novamente.";
                } else {
                    debug_log("Consulta preparada com sucesso");
                    
                    $stmt->bind_param("ss", $cpf, $email);
                    $executado = $stmt->execute();
                    
                    if (!$executado) {
                        debug_log("Erro ao executar consulta: " . $stmt->error);
                        $erros[] = "Erro no sistema. Por favor, tente novamente.";
                    } else {
                        $result = $stmt->get_result();
                        debug_log("Número de registros encontrados: " . $result->num_rows);
                        
                        if ($result->num_rows === 0) {
                            debug_log("Nenhum registro encontrado para CPF e email fornecidos");
                            $erros[] = "CPF e/ou e-mail não encontrados ou não correspondem.";
                        }
                    }
                }
            }
        } catch (Exception $e) {
            debug_log("EXCEÇÃO: " . $e->getMessage());
            $erros[] = "Erro no sistema. Por favor, tente novamente.";
        }
    }

    if (empty($erros)) {
        $row = $result->fetch_assoc();
        $_SESSION['dados_validos'] = true;
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['email'] = $email;
    } else {
        $_SESSION['erros'] = $erros;
        $_SESSION['email'] = $email;
    }

    header("Location: ../frontend/redefinir_senha.php");
    exit;
}

// Process password reset
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'reset') {
    unset($_SESSION['debug_log']);
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
    $nova_senha = isset($_POST['nova_senha']) ? trim($_POST['nova_senha']) : '';
    $confirmar_senha = isset($_POST['confirmar_senha']) ? trim($_POST['confirmar_senha']) : '';

    $erros = [];

    if (!$user_id) {
        $erros[] = "Sessão inválida. Por favor, refaça o processo de verificação.";
    }

    if (empty($nova_senha) || strlen($nova_senha) < 6) {
        $erros[] = "A nova senha deve ter pelo menos 6 caracteres.";
    }

    if ($nova_senha !== $confirmar_senha) {
        $erros[] = "A confirmação da senha não confere.";
    }

    if (empty($erros)) {
        try {
            if (!$conn || $conn->connect_error) {
                $erros[] = "Erro no sistema. Por favor, tente novamente.";
            } else {
                // Atualiza a senha no banco usando password_hash
                $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql_update = "UPDATE professores SET senha = ? WHERE id = ? AND ativo = 1";
                $stmt_update = $conn->prepare($sql_update);
                if (!$stmt_update) {
                    $erros[] = "Erro no sistema. Por favor, tente novamente.";
                } else {
                    $stmt_update->bind_param("si", $senha_hash, $user_id);
                    $executado = $stmt_update->execute();
                    if ($executado) {
                        $_SESSION['sucesso'] = "Senha alterada com sucesso!";
                        // Limpa dados da sessão relacionados ao reset
                        unset($_SESSION['dados_validos']);
                        unset($_SESSION['user_id']);
                        unset($_SESSION['email']);
                    } else {
                        $erros[] = "Erro ao atualizar a senha. Por favor, tente novamente.";
                    }
                }
            }
        } catch (Exception $e) {
            $erros[] = "Erro no sistema. Por favor, tente novamente.";
        }
    }

    if (!empty($erros)) {
        $_SESSION['erros'] = $erros;
    }

    header("Location: ../frontend/redefinir_senha.php");
    exit;
}
?>
