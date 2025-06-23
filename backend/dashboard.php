<?php
session_start();

/* Scriptzin pra ver se o professor tá logado, o '!' significa 'não', então
se ele não estiver logado, pede pra ele fazer login. Depois vou criar uma
mensagem pra pedir a ele pra fazer login antes de redirecionar.*/
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

/**
 * Função para obter os 10 livros mais emprestados.
 * Esta função realiza uma consulta no banco de dados para contar
 * quantas vezes cada livro foi emprestado, ordena do mais emprestado
 * para o menos, e retorna apenas os 10 primeiros resultados.
 *
 * @param mysqli $conn Conexão com o banco de dados
 * @return array Retorna um array associativo com os títulos dos livros e a quantidade de empréstimos
 */
function obterLivrosMaisEmprestados($conn) {
    // Monta a consulta SQL para contar os empréstimos por livro
    $sql = "
        SELECT l.titulo, COUNT(e.id) AS total_emprestimos
        FROM livros l
        LEFT JOIN emprestimos e ON l.id = e.livro_id
        GROUP BY l.id, l.titulo
        ORDER BY total_emprestimos DESC
        LIMIT 10
    ";

    // Executa a consulta no banco de dados
    $resultado = $conn->query($sql);

    // Verifica se a consulta retornou resultados
    if (!$resultado) {
        // Em caso de erro, retorna um array vazio
        return [];
    }

    // Inicializa o array para armazenar os livros mais emprestados
    $livrosMaisEmprestados = [];

    // Percorre os resultados e adiciona ao array
    while ($row = $resultado->fetch_assoc()) {
        $livrosMaisEmprestados[] = [
            'titulo' => $row['titulo'],
            'total_emprestimos' => $row['total_emprestimos']
        ];
    }

    // Retorna o array com os 10 livros mais emprestados
    return $livrosMaisEmprestados;
}
