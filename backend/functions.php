<?php 
function getTopAlunosPorSala($limite = 3) {
    require '../includes/conn.php'; // ou ajuste o caminho conforme necessário

    $query = "
        SELECT 
            alunos.nome, 
            alunos.serie, 
            COUNT(emprestimos.id) AS total_emprestimos
        FROM emprestimos
        JOIN alunos ON emprestimos.aluno_id = alunos.id
        GROUP BY alunos.id, alunos.nome, alunos.serie
        ORDER BY alunos.serie ASC, total_emprestimos DESC
    ";

    $result = $conn->query($query);
    $alunos_por_sala = [];

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $sala = $row['serie'];
            if (!isset($alunos_por_sala[$sala])) {
                $alunos_por_sala[$sala] = [];
            }

            if (count($alunos_por_sala[$sala]) < $limite) {
                $aluno = [
                    'nome' => $row['nome'],
                    'total_emprestimos' => $row['total_emprestimos'],
                    'posicao' => count($alunos_por_sala[$sala]) + 1
                ];
                $alunos_por_sala[$sala][] = $aluno;
            }
        }
    }

    return $alunos_por_sala;
}
