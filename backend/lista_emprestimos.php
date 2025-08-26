<?php
session_start();
require '../includes/conn.php';

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

$professor_id = $_SESSION['professor_id'];

// Marcar como devolvido
if (isset($_GET['devolver_id'])) {
    $emprestimo_id = $_GET['devolver_id'];

    // Buscar o livro_id
    $sql = "SELECT livro_id FROM emprestimos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emprestimo_id);
    $stmt->execute();
    $stmt->bind_result($livro_id);
    $stmt->fetch();
    $stmt->close();

    // Atualizar como devolvido
    $sql = "UPDATE emprestimos SET devolvido = 'Sim', data_devolucao = CURDATE() WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $emprestimo_id);

    if ($stmt->execute()) {
        $sql = "UPDATE livros SET quantidade = quantidade + 1 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $livro_id);
        $stmt->execute();
        echo "<div class='alert alert-success'>Livro devolvido com sucesso!</div>";
    } else {
        echo "<div class='alert alert-danger'>Erro ao devolver livro.</div>";
    }
    $stmt->close();
}

// Filtros
$filtro_aluno = $_GET['filtro_aluno'] ?? '';
$filtro_serie = $_GET['filtro_serie'] ?? '';
$filtro_livro = $_GET['filtro_livro'] ?? '';

$where = "WHERE e.professor_id = ?";
$params = [$professor_id];
$types = "i";

if (!empty($filtro_aluno)) {
    $where .= " AND a.nome LIKE ?";
    $params[] = "%" . $filtro_aluno . "%";
    $types .= "s";
}

if (!empty($filtro_serie)) {
    $where .= " AND a.serie = ?";
    $params[] = $filtro_serie;
    $types .= "s";
}

if (!empty($filtro_livro)) {
    $where .= " AND (l.titulo LIKE ? OR l.isbn LIKE ?)";
    $params[] = "%" . $filtro_livro . "%";
    $params[] = "%" . $filtro_livro . "%";
    $types .= "ss";
}

// Consulta final com filtros
$sql = "SELECT e.id, l.titulo, a.nome, e.data_emprestimo, e.data_devolucao, e.devolvido
        FROM emprestimos e
        JOIN livros l ON e.livro_id = l.id
        JOIN alunos a ON e.aluno_id = a.id
        $where
        ORDER BY e.data_emprestimo DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

// Obter todas as séries únicas para o filtro
$series_result = $conn->query("SELECT DISTINCT serie FROM alunos ORDER BY serie ASC");
?>
