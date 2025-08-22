<?php
session_start();
$professor_id = $_SESSION['professor_id'] ?? null;
// var_dump($_POST);


if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

// Inicializa as variáveis de mensagem
$success_message = null;
$error_message = null;

// Funções para pesquisa com segurança contra SQL injection
$filtro_aluno = isset($_GET['filtro_aluno']) ? trim($_GET['filtro_aluno']) : '';
$filtro_livro = isset($_GET['filtro_livro']) ? trim($_GET['filtro_livro']) : '';
$filtro_serie = isset($_GET['filtro_serie']) ? trim($_GET['filtro_serie']) : '';

// Consulta alunos com filtros usando prepared statements
$alunos_query = "SELECT * FROM alunos WHERE 1=1";
if (!empty($filtro_aluno)) {
    $alunos_query .= " AND nome LIKE ?";
}
if (!empty($filtro_serie)) {
    $alunos_query .= " AND serie = ?";
}

$stmt_alunos = $conn->prepare($alunos_query);
if (!empty($filtro_aluno) && !empty($filtro_serie)) {
    $aluno_param = "%$filtro_aluno%";
    $stmt_alunos->bind_param("ss", $aluno_param, $filtro_serie);
} elseif (!empty($filtro_aluno)) {
    $aluno_param = "%$filtro_aluno%";
    $stmt_alunos->bind_param("s", $aluno_param);
} elseif (!empty($filtro_serie)) {
    $stmt_alunos->bind_param("s", $filtro_serie);
}

$stmt_alunos->execute();
$alunos_result = $stmt_alunos->get_result();

// Consulta livros com filtros
$livros_query = "SELECT * FROM livros WHERE 1=1";
if (!empty($filtro_livro)) {
    $livros_query .= " AND (titulo LIKE ? OR isbn LIKE ?)";
}

$stmt_livros = $conn->prepare($livros_query);
if (!empty($filtro_livro)) {
    $livro_param = "%$filtro_livro%";
    $stmt_livros->bind_param("ss", $livro_param, $livro_param);
}

$stmt_livros->execute();
$livros_result = $stmt_livros->get_result();

// Obter séries distintas para o filtro
$series_query = "SELECT DISTINCT serie FROM alunos ORDER BY serie";
$series_result = $conn->query($series_query);

// Processamento do formulário de empréstimo
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validação dos dados de entrada
    $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
    $livro_id = filter_input(INPUT_POST, 'livro_id', FILTER_VALIDATE_INT);
    $data_emprestimo = filter_input(INPUT_POST, 'data_emprestimo');
    $data_devolucao = filter_input(INPUT_POST, 'data_devolucao');

    if (!$aluno_id || !$livro_id || !$data_emprestimo || !$data_devolucao) {
        $error_message = "Dados inválidos fornecidos!";
    } else {
        // Verifica disponibilidade do livro
        $livro_check_sql = "SELECT quantidade FROM livros WHERE id = ?";
        $stmt = $conn->prepare($livro_check_sql);
        $stmt->bind_param("i", $livro_id);
        $stmt->execute();
        $stmt->bind_result($quantidade);
        $stmt->fetch();
        $stmt->close();

        if ($quantidade > 0) {
            // Inicia transação para garantir consistência
            $conn->begin_transaction();

            try {
                // Registra o empréstimo
                $sql = "INSERT INTO emprestimos (aluno_id, livro_id, data_emprestimo, data_devolucao, devolvido, professor_id)
                        VALUES (?, ?, ?, ?, 0, ?)";
                $stmt_emprestimo = $conn->prepare($sql);
                $stmt_emprestimo->bind_param("iissi", $aluno_id, $livro_id, $data_emprestimo, $data_devolucao, $professor_id);

                if ($stmt_emprestimo->execute()) {
                    // Atualiza o estoque do livro
                    $sql_update = "UPDATE livros SET quantidade = quantidade - 1 WHERE id = ?";
                    $stmt_update = $conn->prepare($sql_update);
                    $stmt_update->bind_param("i", $livro_id);
                    $stmt_update->execute();

                    $conn->commit();
                    $success_message = "Empréstimo registrado com sucesso!";
                } else {
                    throw new Exception("Erro ao registrar empréstimo!");
                }
            } catch (Exception $e) {
                $conn->rollback();
                $error_message = $e->getMessage();
            }

            if (isset($stmt_emprestimo)) $stmt_emprestimo->close();
            if (isset($stmt_update)) $stmt_update->close();
        } else {
            $error_message = "Este livro não está disponível no momento!";
        }
    }
}

// Fechar conexões de consulta se ainda estiverem abertas
if (isset($stmt_alunos)) $stmt_alunos->close();
if (isset($stmt_livros)) $stmt_livros->close();
$conn->close();
?>
