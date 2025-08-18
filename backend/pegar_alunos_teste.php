<?php
require '../includes/conn.php';

//Os alunos não precisam de senha, então não tem necessidade de puxar mais dados.
$resultado = $conn->query("SELECT nome, serie, email FROM alunos");
$rows = [];

// Laço pra acessar o resultado da consulta da linha 5
while ($r = $resultado->fetch_assoc()){
  $rows[] = $r;
}

//
header('Content-Type: application/json');
echo json_encode($rows);
