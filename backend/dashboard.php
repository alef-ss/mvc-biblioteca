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
$total_students = $result_students->fetch_assoc()['total'];

// Query to get the total number of books
$result_books = $conn->query("SELECT COUNT(*) as total FROM livros");
$total_books = $result_books->fetch_assoc()['total'];

// Query to get the total number of active loans
$result_loans = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE devolvido = '0'");
$total_loans = $result_loans->fetch_assoc()['total'];

// Query to get the total number of pending returns
$result_pending_returns = $conn->query("SELECT COUNT(*) as total FROM emprestimos WHERE data_devolucao IS NULL");
$total_pending_returns = $result_pending_returns->fetch_assoc()['total'];
?>
