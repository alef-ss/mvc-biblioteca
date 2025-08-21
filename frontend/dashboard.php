<?php
include('../backend/dashboard.php');
// Chama a função para obter os 10 livros mais emprestados
$livrosMaisEmprestados = obterLivrosMaisEmprestados($conn);
?>

<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body>
