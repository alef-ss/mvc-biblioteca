<?php
session_start();

// Scriptzin pra ver se o professor tá logado, o '!' significa 'não', então se ele não estiver logado, pede pra ele fazer login
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

// Incluir o arquivo pra fazer a conexão com o banco de dados
include('../includes/conn.php');

// Consulta pra pegar o número total de alunos
$resultadoAlunos = $conn->query("SELECT COUNT(*) as total FROM alunos");
$totalAlunos = $resultadoAlunos->fetch_assoc()['total'];

// Consulta pra pegar o número total de livros
$resultadoLivros = $conn->query("SELECT COUNT(*) as total FROM livros");
$totalLivros = $resultadoLivros->fetch_assoc()['total'];

// Consulta pra pegar o número total de empréstimos
$resultadoEmprestimos = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE devolvido = '0'");
$totalEmprestimos = $resultadoEmprestimos->fetch_assoc()['total'];

// Consulta pra pegar o número total de empréstimos pendentes
$resultadoDevolucaoPendente = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE data_devolucao IS NULL");
$totalDevolucoesPendentes = $resultadoDevolucaoPendente->fetch_assoc()['total'];


$salas = $conn->query("SELECT COUNT(*) as total FROM alunos WHERE serie");
$totalSalas = $salas->fetch_assoc()['total'];
?>
