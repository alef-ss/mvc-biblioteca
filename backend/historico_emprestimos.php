<?php
session_start();
require '../includes/conn.php'; // Arquivo de conexão com o banco

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

// Iniciando o array de tipos dos parâmetros para bind_param
$param_types = '';

// Iniciando o array de valores para bind_param
$param_values = [];

// Construir a consulta SQL dinamicamente
$sql = "
    SELECT e.id, l.titulo AS livro, a.nome AS aluno, e.data_emprestimo, e.data_devolucao, e.devolvido
    FROM emprestimos e
    JOIN livros l ON e.livro_id = l.id
    JOIN alunos a ON e.aluno_id = a.id
    WHERE 1
";

// Adicionar filtros à consulta dinamicamente
if (!empty($_GET['aluno'])) {
    $search_aluno = $_GET['aluno'];
    $sql .= " AND a.nome LIKE ?";
    $param_types .= 's'; // Tipo do parâmetro: 's' (string)
    $param_values[] = "%" . $search_aluno . "%"; // Valor do parâmetro
}
if (!empty($_GET['livro'])) {
    $search_livro = $_GET['livro'];
    $sql .= " AND l.titulo LIKE ?";
    $param_types .= 's'; // Tipo do parâmetro: 's' (string)
    $param_values[] = "%" . $search_livro . "%"; // Valor do parâmetro
}
if (!empty($_GET['estado'])) {
    $search_estado = $_GET['estado'];
    $sql .= " AND e.devolvido = ?";
    $param_types .= 's'; // Tipo do parâmetro: 's' (string)
    $param_values[] = $search_estado; // Valor do parâmetro
}
if (!empty($_GET['data_inicio'])) {
    $search_data_inicio = $_GET['data_inicio'];
    $sql .= " AND e.data_emprestimo >= ?";
    $param_types .= 's'; // Tipo do parâmetro: 's' (string para datas)
    $param_values[] = $search_data_inicio; // Valor do parâmetro
}
if (!empty($_GET['data_fim'])) {
    $search_data_fim = $_GET['data_fim'];
    $sql .= " AND e.data_emprestimo <= ?";
    $param_types .= 's'; // Tipo do parâmetro: 's' (string para datas)
    $param_values[] = $search_data_fim; // Valor do parâmetro
}

// Preparar a consulta SQL
$stmt = $conn->prepare($sql);

// Verificar se há filtros aplicados e vincular os parâmetros corretamente
if (count($param_values) > 0) {
    // Bind dos parâmetros dinamicamente
    $stmt->bind_param($param_types, ...$param_values);
}

// Executar a consulta
$stmt->execute();

// Obter os resultados
$result = $stmt->get_result();
?>