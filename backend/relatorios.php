<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

$sql = "
    SELECT 
        livros.titulo, 
        COUNT(emprestimos.id) AS total_emprestimos
    FROM emprestimos
    JOIN livros ON emprestimos.livro_id = livros.id
    WHERE emprestimos.devolvido = '0'
    GROUP BY emprestimos.livro_id
    ORDER BY total_emprestimos DESC
";

$sql_alunos = "
    SELECT alunos.nome, alunos.serie, COUNT(emprestimos.id) AS total_emprestimos
    FROM emprestimos
    JOIN alunos ON emprestimos.aluno_id = alunos.id
    WHERE emprestimos.devolvido = '0'
    GROUP BY emprestimos.aluno_id
    ORDER BY total_emprestimos DESC
    LIMIT 5
";

$sql_salas = "
    SELECT alunos.serie, COUNT(emprestimos.id) AS total_emprestimos
    FROM emprestimos
    JOIN alunos ON emprestimos.aluno_id = alunos.id
    
    GROUP BY alunos.serie
    ORDER BY total_emprestimos DESC
    LIMIT 1
";

$result_livros = $conn->query($sql);
$result_alunos = $conn->query($sql_alunos);
$result_salas = $conn->query($sql_salas);
?>