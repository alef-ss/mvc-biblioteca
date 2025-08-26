<?php
require '../includes/conn.php';

//Os alunos não precisam de senha, então não tem necessidade de puxar mais dados.
$resultado = $conn->query("SELECT nome, serie, email FROM alunos");
$res = $conn->query("
  SELECT alunos.nome AS nome_do_aluno, livros.titulo AS titulo_do_livro
  FROM emprestimos
  INNER JOIN alunos ON emprestimos.aluno_id = aluno_id
  INNER JOIN livros ON emprestimos.livro_id = livro_id
");
$rows = [];

// Laço pra acessar o resultado da consulta da linha 5
// esse laço aqui pedi ao ChatGPT pra fazer porque não sei fazer ainda 👍
while ($r = $resultado->fetch_assoc()){
  $rows[] = $r;
}

while ($a = $res->fetch_assoc()) {
  $rows[] = $a;
}
$json = json_encode($rows, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo json_encode($rows);

$caminhoDoArquivo = "dados.json";

if (file_put_contents($caminhoDoArquivo, $json)) {
  echo "Dados salvos";
} else {
  echo "erro";
}

$conteudo = file_get_contents('dados.json');
$dados =json_decode($conteudo, true);

foreach ($dados as $item) {
  echo $item['nome_do_aluno'] . "\n";
}
