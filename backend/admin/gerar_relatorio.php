<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

$tipo = $_POST['tipo'] ?? 'emprestimos';
$data_inicial = $_POST['data_inicial'] ?? '';
$data_final = $_POST['data_final'] ?? '';
$status = $_POST['status'] ?? '';

// Usa a função que de fato filtra com base nas datas e status
$dados = gerarDadosEmprestimos($conn, $data_inicial, $data_final, $status);
// echo gerarTabelaEmprestimos($dados);


function gerarDadosEmprestimos($conn, $data_inicial, $data_final, $status) {
    $where = [];
    $params = [];
    $types = "";

    if ($data_inicial) {
        $where[] = "e.data_emprestimo >= ?";
        $params[] = $data_inicial;
        $types .= "s";
    }

    if ($data_final) {
        $where[] = "e.data_emprestimo <= ?";
        $params[] = $data_final;
        $types .= "s";
    }

    switch ($status) {
        case 'pendente':
            $where[] = "e.devolvido = 'Nao' AND e.data_devolucao >= CURRENT_DATE()";
            break;
        case 'devolvido':
            $where[] = "e.devolvido = 'Sim'";
            break;
        case 'atrasado':
            $where[] = "e.devolvido = 'Nao' AND e.data_devolucao < CURRENT_DATE()";
            break;
    }

    $whereClause = $where ? "WHERE " . implode(" AND ", $where) : "";

    $sql = "
        SELECT 
            e.*,
            a.nome as aluno_nome,
            l.titulo as livro_titulo,
            p.nome as professor_nome
        FROM emprestimos e
        JOIN alunos a ON e.aluno_id = a.id
        JOIN livros l ON e.livro_id = l.id
        JOIN professores p ON e.professor_id = p.id
        $whereClause
        ORDER BY e.data_emprestimo DESC
    ";

    $stmt = $conn->prepare($sql);
    if ($params) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result();
}

function gerarDadosLivros($conn) {
    $sql = "
        SELECT 
            l.*,
            (SELECT COUNT(*) FROM emprestimos WHERE livro_id = l.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE livro_id = l.id AND devolvido = 'Nao') as emprestimos_ativos
        FROM livros l
        ORDER BY l.titulo
    ";
    return $conn->query($sql);
}

function gerarDadosAlunos($conn) {
    $sql = "
        SELECT 
            a.*,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 'Nao') as emprestimos_ativos,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 'Nao' AND data_devolucao < CURRENT_DATE()) as emprestimos_atrasados
        FROM alunos a
        ORDER BY a.nome
    ";
    return $conn->query($sql);
}

function buscarEmprestimosDetalhados($conn) {
    $sql = "
        SELECT 
            e.data_emprestimo,
            e.data_devolucao,
            e.devolvido,
            a.nome AS aluno_nome,
            l.titulo AS livro_titulo,
            p.nome AS professor_nome
        FROM emprestimos e
        JOIN alunos a ON e.aluno_id = a.id
        JOIN livros l ON e.livro_id = l.id
        JOIN professores p ON e.professor_id = p.id
        ORDER BY e.data_devolucao DESC
    ";
    return $conn->query($sql);
}


function gerarDadosProfessores($conn) {
    $sql = "
        SELECT 
            p.*,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id AND devolvido = 'Nao') as emprestimos_ativos,
            (SELECT MAX(data_emprestimo) FROM emprestimos WHERE professor_id = p.id) as ultimo_emprestimo
        FROM professores p
        ORDER BY p.nome
    ";
    return $conn->query($sql);
}

function gerarTabelaEmprestimos($dados) {
    $html = '<table class="table table-striped">';
    $html .= '<thead><tr><th>Data</th><th>Aluno</th><th>Livro</th><th>Professor</th><th>Devolução</th><th>Status</th></tr></thead><tbody>';
    while ($item = $dados->fetch_assoc()) {
        $status = ($item['devolvido'] === 'Sim' || $item['devolvido'] === '1') ? 'Devolvido' : 
            (strtotime($item['data_devolucao']) < time() ? 'Atrasado' : 'Pendente');
        $html .= '<tr>';
        $html .= '<td>' . date('d/m/Y', strtotime($item['data_emprestimo'])) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['aluno_nome']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['livro_titulo']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['professor_nome']) . '</td>';
        $html .= '<td>' . date('d/m/Y', strtotime($item['data_devolucao'])) . '</td>';
        $html .= '<td>' . $status . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

function gerarTabelaLivros($dados) {
    $html = '<table class="table table-striped">';
    $html .= '<thead><tr><th>Título</th><th>Autor</th><th>ISBN</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th></tr></thead><tbody>';
    while ($item = $dados->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($item['titulo']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['autor']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['isbn']) . '</td>';
        $html .= '<td>' . $item['total_emprestimos'] . '</td>';
        $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

function gerarTabelaAlunos($dados) {
    $html = '<table class="table table-striped">';
    $html .= '<thead><tr><th>Nome</th><th>Série</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th><th>Empréstimos Atrasados</th></tr></thead><tbody>';
    while ($item = $dados->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($item['nome']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['serie']) . '</td>';
        $html .= '<td>' . $item['total_emprestimos'] . '</td>';
        $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
        $html .= '<td>' . $item['emprestimos_atrasados'] . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

function gerarTabelaProfessores($dados) {
    $html = '<table class="table table-striped">';
    $html .= '<thead><tr><th>Nome</th><th>Email</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th><th>Último Empréstimo</th><th>Status</th></tr></thead><tbody>';
    while ($item = $dados->fetch_assoc()) {
        $status = $item['ativo'] ? 'Ativo' : 'Inativo';
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($item['nome']) . '</td>';
        $html .= '<td>' . htmlspecialchars($item['email']) . '</td>';
        $html .= '<td>' . $item['total_emprestimos'] . '</td>';
        $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
        $html .= '<td>' . ($item['ultimo_emprestimo'] ? date('d/m/Y', strtotime($item['ultimo_emprestimo'])) : 'Nunca') . '</td>';
        $html .= '<td>' . $status . '</td>';
        $html .= '</tr>';
    }
    $html .= '</tbody></table>';
    return $html;
}

switch ($tipo) {
    case 'emprestimos':
        $dados = gerarDadosEmprestimos($conn, $data_inicial, $data_final, $status);
        echo gerarTabelaEmprestimos($dados);
        break;
    case 'livros':
        $dados = gerarDadosLivros($conn);
        echo gerarTabelaLivros($dados);
        break;
    case 'alunos':
        $dados = gerarDadosAlunos($conn);
        echo gerarTabelaAlunos($dados);
        break;
    case 'professores':
        $dados = gerarDadosProfessores($conn);
        echo gerarTabelaProfessores($dados);
        break;
    default:
        echo '<p>Tipo de relatório inválido.</p>';
        break;
}
?>
