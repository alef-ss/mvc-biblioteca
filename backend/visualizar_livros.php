<?php
session_start();

if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

require '../includes/conn.php';

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = '';
if (isset($_GET['search'])) {
    $search = htmlspecialchars(trim($_GET['search']));
}

$sql = "SELECT capa_url, titulo, autor, preview_link, MIN(id) as id, COUNT(*) as quantidade 
        FROM livros 
        WHERE titulo LIKE ? OR isbn LIKE ? 
        GROUP BY capa_url, titulo, autor, preview_link 
        ORDER BY titulo ASC 
        LIMIT ?, ?";
        
$stmt = $conn->prepare($sql);
$searchTerm = "%$search%";
$stmt->bind_param('ssii', $searchTerm, $searchTerm, $offset, $limit);
$stmt->execute();
$result = $stmt->get_result();

$sql_total = "SELECT COUNT(DISTINCT capa_url) as total FROM livros WHERE titulo LIKE ? OR isbn LIKE ?";
$stmt_total = $conn->prepare($sql_total);
$stmt_total->bind_param('ss', $searchTerm, $searchTerm);
$stmt_total->execute();
$total_result = $stmt_total->get_result();
$total_books = $total_result->fetch_assoc()['total'];
$total_pages = ceil($total_books / $limit);
?>
