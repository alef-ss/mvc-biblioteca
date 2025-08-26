<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

// Database connection
include('../includes/conn.php');

// Query to get the total number of students
$result_students = $conn->query("SELECT COUNT(*) as total FROM alunos");
$totalAlunos = $result_students->fetch_assoc()['total'];

// Query to get the total number of books
$result_books = $conn->query("SELECT COUNT(*) as total FROM livros");
$totalLivros = $result_books->fetch_assoc()['total'];

// Query to get the total number of active loans
$result_loans = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE devolvido = '0'");
$totalEmprestimos = $result_loans->fetch_assoc()['total'];

// Query to get the total number of pending returns
$result_pending_returns = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE data_devolucao IS NULL");
$totalDevolucoesPendentes = $result_pending_returns->fetch_assoc()['total'];
?>
