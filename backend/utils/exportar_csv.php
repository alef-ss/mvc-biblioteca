<?php
// Exportar para CSV
require 'includes/conn.php';

$sql = "SELECT e.id, l.titulo AS livro, a.nome AS aluno, e.data_emprestimo, e.data_devolucao, e.estado_livro
        FROM emprestimos e
        JOIN livros l ON e.livro_id = l.id
        JOIN alunos a ON e.aluno_id = a.id";
$result = $conn->query($sql);

// Cabeçalhos para exportação
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="historico_emprestimos.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Livro', 'Aluno', 'Data de Empréstimo', 'Data de Devolução', 'Estado do Livro']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit();
?>
