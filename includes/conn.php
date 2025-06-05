<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";  // Mude para o usuário do seu banco de dados
$password = "";      // Senha do banco de dados
$database = "mvc_biblioteca";  // Nome do banco de dados

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
