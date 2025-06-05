<?php
require_once '../includes/conn.php';

// Inicializar a query base
$query = "SELECT 
    e.id,
    a.nome as aluno_nome,
    a.serie as aluno_serie,
    l.titulo as livro_titulo,
    l.isbn as livro_isbn,
    e.data_emprestimo,
    e.data_devolucao
FROM emprestimos e
JOIN alunos a ON e.aluno_id = a.id
JOIN livros l ON e.livro_id = l.id
WHERE 1=1";

$params = array();

// Aplicar filtros
if (!empty($_GET['filtro_aluno'])) {
    $query .= " AND a.nome LIKE ?";
    $params[] = "%" . $_GET['filtro_aluno'] . "%";
}

if (!empty($_GET['filtro_serie'])) {
    $query .= " AND a.serie = ?";
    $params[] = $_GET['filtro_serie'];
}

if (!empty($_GET['filtro_livro'])) {
    $query .= " AND (l.titulo LIKE ? OR l.isbn LIKE ?)";
    $params[] = "%" . $_GET['filtro_livro'] . "%";
    $params[] = "%" . $_GET['filtro_livro'] . "%";
}

// Ordenar por data de empréstimo mais recente
$query .= " ORDER BY e.data_emprestimo DESC";

// Preparar e executar a query
$stmt = $conn->prepare($query);
if (!empty($params)) {
    $stmt->bind_param(str_repeat('s', count($params)), ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Formatar os resultados em HTML
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data_emprestimo = date('d/m/Y', strtotime($row['data_emprestimo']));
        $data_devolucao = date('d/m/Y', strtotime($row['data_devolucao']));
        
        echo "<tr>
                <td>{$row['aluno_nome']} ({$row['aluno_serie']})</td>
                <td>{$row['livro_titulo']} <br><small class='text-muted'>ISBN: {$row['livro_isbn']}</small></td>
                <td>{$data_emprestimo}</td>
                <td>{$data_devolucao}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='4' class='text-center'>Nenhum resultado encontrado</td></tr>";
}

$stmt->close();
$conn->close();
?> 