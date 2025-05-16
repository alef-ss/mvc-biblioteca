<?php
session_start();
include('../includes/conn.php');

// Ativar relatório de erros detalhados
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Função para registrar e exibir logs
function debug_log($message) {
    error_log($message); // Registra no log do servidor
    $_SESSION['debug_log'][] = $message; // Armazena para exibir na tela
}

// Processamento do formulário se houver envio via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $cpf = isset($_POST['cpf']) ? preg_replace('/[^0-9]/', '', $_POST['cpf']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';

    debug_log("Dados recebidos do formulário:");
    debug_log("Nome: " . ($nome ?: '[vazio]'));
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
            
            // Verifica se a conexão está ativa
            if (!$conn || $conn->connect_error) {
                debug_log("Erro na conexão com o banco: " . ($conn->connect_error ?? 'Conexão não estabelecida'));
                $erros[] = "Erro no sistema. Por favor, tente novamente.";
            } else {
                debug_log("Conexão com o banco estabelecida com sucesso");
                
                // Verifica se a tabela existe
                $tabela_existe = $conn->query("SELECT 1 FROM professores LIMIT 1");
                if (!$tabela_existe) {
                    debug_log("Tabela 'professores' não encontrada. Erro: " . $conn->error);
                    $erros[] = "Erro no sistema. Tabela não encontrada.";
                } else {
                    debug_log("Tabela 'professores' encontrada");
                    
                    // Verifica o formato do CPF no banco
                    $sql_check_cpf = "SELECT cpf FROM professores LIMIT 1";
                    $result_check = $conn->query($sql_check_cpf);
                    if ($result_check && $row = $result_check->fetch_assoc()) {
                        debug_log("Exemplo de CPF no banco: " . $row['cpf']);
                        debug_log("Comparando com CPF fornecido: $cpf");
                    }
                    
                    // Consulta principal
                    $sql = "SELECT id FROM professores WHERE cpf = ? AND email = ?";
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
                                debug_log("Nenhum registro encontrado para CPF e email fornecidos juntos");
                            
                                // Verifica separadamente se CPF existe
                                $sql_cpf = "SELECT COUNT(*) as total FROM professores WHERE cpf = ?";
                                $stmt_cpf = $conn->prepare($sql_cpf);
                                $stmt_cpf->bind_param("s", $cpf);
                                $stmt_cpf->execute();
                                $result_cpf = $stmt_cpf->get_result();
                                $row_cpf = $result_cpf->fetch_assoc();
                                $cpf_exists = $row_cpf['total'] > 0;
                                debug_log("Registros com este CPF: " . $row_cpf['total']);
                            
                                // Verifica separadamente se email existe
                                $sql_email = "SELECT COUNT(*) as total FROM professores WHERE email = ?";
                                $stmt_email = $conn->prepare($sql_email);
                                $stmt_email->bind_param("s", $email);
                                $stmt_email->execute();
                                $result_email = $stmt_email->get_result();
                                $row_email = $result_email->fetch_assoc();
                                $email_exists = $row_email['total'] > 0;
                                debug_log("Registros com este email: " . $row_email['total']);
                            
                                // Mensagens de erro mais precisas
                                if ($cpf_exists && !$email_exists) {
                                    $erros[] = "O CPF informado existe, mas o e-mail não corresponde.";
                                } elseif (!$cpf_exists && $email_exists) {
                                    $erros[] = "O e-mail informado existe, mas o CPF não corresponde.";
                                } elseif (!$cpf_exists && !$email_exists) {
                                    $erros[] = "CPF e e-mail não encontrados em nosso sistema.";
                                } else {
                                    $erros[] = "CPF e e-mail não correspondem entre si.";
                                }
                            }
                            
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
        // If verification successful, set session flag and user id for password reset
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
                // Atualiza a senha no banco (hash da senha)
                $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                $sql_update = "UPDATE professores SET senha = ? WHERE id = ?";
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
