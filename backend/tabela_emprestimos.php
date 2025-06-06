<?php
include '../includes/conn.php';

// Receber os filtros
$filtroAluno = $_GET['filtro_aluno'] ?? '';
$filtroSerie = $_GET['filtro_serie'] ?? '';
$filtroLivro = $_GET['filtro_livro'] ?? '';
$filtroEmprestimo = $_GET['filtro_emprestimo'] ?? '';

// Consulta
$sql = "SELECT emprestimos.id, livros.titulo, alunos.nome, emprestimos.data_emprestimo, emprestimos.data_devolucao, emprestimos.devolvido
        FROM emprestimos
        INNER JOIN alunos ON emprestimos.aluno_id = alunos.id
        INNER JOIN livros ON emprestimos.livro_id = livros.id
        WHERE 1=1";

if (!empty($filtroAluno)) {
    $sql .= " AND alunos.nome LIKE '%" . $conn->real_escape_string($filtroAluno) . "%'";
}
if (!empty($filtroSerie)) {
    $sql .= " AND alunos.serie = '" . $conn->real_escape_string($filtroSerie) . "'";
}
if (!empty($filtroLivro)) {
    $sql .= " AND (livros.titulo LIKE '%" . $conn->real_escape_string($filtroLivro) . "%' OR livros.isbn LIKE '%" . $conn->real_escape_string($filtroLivro) . "%')";
}
if ($filtroEmprestimo !== '') {
    $sql .= " AND emprestimos.devolvido = '" . $conn->real_escape_string($filtroEmprestimo) . "'";
}


$result = $conn->query($sql);

// Renderização do tbody
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>" . htmlspecialchars($row['titulo']) . "</td>
            <td>" . htmlspecialchars($row['nome']) . "</td>
            <td>" . htmlspecialchars($row['data_emprestimo']) . "</td>
            <td>" . htmlspecialchars($row['data_devolucao']) . "</td>
            <td>";
        if ($row['devolvido'] == 'Sim') {
            echo "<button class='btn btn-success btn-sm' disabled><i class='fas fa-check'></i> Devolvido</button>";
        } else {
            echo "<button class='btn btn-danger btn-sm btn-confirmar-devolucao' data-id='" . (int)$row['id'] . "'>
            <i class='fas fa-undo-alt'></i> Devolver
            </button>";
        }

        echo "</td></tr>";
    }
} else {
    echo "<tr><td colspan='5' class='text-center'>Nenhum empréstimo encontrado.</td></tr>";
}
