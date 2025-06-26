<?php
session_start();

/* Scriptzin pra ver se o professor tá logado, o '!' significa 'não', então
se ele não estiver logado, pede pra ele fazer login. Depois vou criar uma
mensagem pra pedir a ele pra fazer login antes de redirecionar.*/
// if (!isset($_SESSION['professor_id'])) {
//     header("Location: ../frontend/login.php");
//     exit();
// }

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
 * Função para obter a tendência de empréstimos da semana atual comparada à semana anterior.
 * Retorna a porcentagem de aumento ou diminuição dos empréstimos.
 *
 * @param mysqli $conn Conexão com o banco de dados
 * @return float|null Retorna a porcentagem de variação ou null se não houver dados suficientes
 */
function obterTendenciaEmprestimos($conn) {
    // Obtém a data do início da semana atual (segunda-feira)
    $inicioSemanaAtual = date('Y-m-d', strtotime('monday this week'));
    // Obtém a data do início da semana anterior
    $inicioSemanaAnterior = date('Y-m-d', strtotime('monday last week'));
    // Obtém a data do fim da semana anterior (domingo)
    $fimSemanaAnterior = date('Y-m-d', strtotime('sunday last week'));

    // Consulta para contar empréstimos na semana atual
    $sqlSemanaAtual = "
        SELECT COUNT(*) as total
        FROM emprestimos
        WHERE data_emprestimo >= '$inicioSemanaAtual'
    ";
    $resultadoAtual = $conn->query($sqlSemanaAtual);
    $totalAtual = $resultadoAtual ? (int)$resultadoAtual->fetch_assoc()['total'] : 0;

    // Consulta para contar empréstimos na semana anterior
    $sqlSemanaAnterior = "
        SELECT COUNT(*) as total
        FROM emprestimos
        WHERE data_emprestimo BETWEEN '$inicioSemanaAnterior' AND '$fimSemanaAnterior'
    ";
    $resultadoAnterior = $conn->query($sqlSemanaAnterior);
    $totalAnterior = $resultadoAnterior ? (int)$resultadoAnterior->fetch_assoc()['total'] : 0;

    if ($totalAnterior === 0) {
        // Evita divisão por zero, retorna null para indicar dados insuficientes
        return null;
    }

    // Calcula a variação percentual
    $variacao = (($totalAtual - $totalAnterior) / $totalAnterior) * 100;

    return round($variacao, 2);
}

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

/**
 * Função para obter os gêneros mais lidos.
 * Esta função realiza uma consulta no banco de dados para contar
 * quantos empréstimos cada gênero teve, ordena do mais lido para o menos,
 * e retorna os resultados.
 *
 * @param mysqli $conn Conexão com o banco de dados
 * @return array Retorna um array associativo com os gêneros e a quantidade de empréstimos
 */
function obterGenerosMaisLidos($conn) {
    // Monta a consulta SQL para contar os empréstimos por gênero
    $sql = "
        SELECT l.genero AS genero, COUNT(e.id) AS total_emprestimos
        FROM livros l
        LEFT JOIN emprestimos e ON l.id = e.livro_id
        GROUP BY l.genero
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

    // Inicializa o array para armazenar os gêneros mais lidos
    $generosMaisLidos = [];

    // Percorre os resultados e adiciona ao array
    while ($row = $resultado->fetch_assoc()) {
        $generosMaisLidos[] = [
            'genero' => $row['genero'],
            'total_emprestimos' => $row['total_emprestimos']
        ];
    }

    // Retorna o array com os gêneros mais lidos
    return $generosMaisLidos;
}

/**
 * Função para obter o tempo desde o último empréstimo em formato legível.
 *
 * @param mysqli $conn Conexão com o banco de dados
 * @return string|null Retorna o tempo desde o último empréstimo (ex: "2 horas") ou null se não houver empréstimos
 */
function obterTempoUltimoEmprestimo($conn) {
    $sql = "SELECT data_emprestimo FROM emprestimos ORDER BY data_emprestimo DESC LIMIT 1";
    $resultado = $conn->query($sql);

    if (!$resultado || $resultado->num_rows === 0) {
        return null;
    }

    $row = $resultado->fetch_assoc();
    $dataUltimoEmprestimo = new DateTime($row['data_emprestimo']);
    $agora = new DateTime();

    $intervalo = $agora->diff($dataUltimoEmprestimo);

    if ($intervalo->d > 0) {
        return $intervalo->d . ' dia' . ($intervalo->d > 1 ? 's' : '');
    } elseif ($intervalo->h > 0) {
        return $intervalo->h . ' hora' . ($intervalo->h > 1 ? 's' : '');
    } elseif ($intervalo->i > 0) {
        return $intervalo->i . ' minuto' . ($intervalo->i > 1 ? 's' : '');
    } else {
        return 'menos de um minuto';
    }
}
