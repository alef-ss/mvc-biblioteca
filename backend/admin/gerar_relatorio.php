<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';

$tipo = $_POST['tipo'] ?? 'emprestimos';
$data_inicial = $_POST['data_inicial'] ?? '';
$data_final = $_POST['data_final'] ?? '';
$status = $_POST['status'] ?? '';

function gerarRelatorioEmprestimos($conn, $data_inicial, $data_final, $status) {
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
            $where[] = "e.devolvido = 0 AND e.data_devolucao >= CURRENT_DATE()";
            break;
        case 'devolvido':
            $where[] = "e.devolvido = 1";
            break;
        case 'atrasado':
            $where[] = "e.devolvido = 0 AND e.data_devolucao < CURRENT_DATE()";
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
    $result = $stmt->get_result();

    echo '<h4 class="mb-4">Relatório de Empréstimos</h4>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Data</th>';
    echo '<th>Aluno</th>';
    echo '<th>Livro</th>';
    echo '<th>Professor</th>';
    echo '<th>Devolução</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        $status_class = $row['devolvido'] ? 'success' : 
            (strtotime($row['data_devolucao']) < time() ? 'danger' : 'warning');
        
        echo '<tr>';
        echo '<td>' . date('d/m/Y', strtotime($row['data_emprestimo'])) . '</td>';
        echo '<td>' . htmlspecialchars($row['aluno_nome']) . '</td>';
        echo '<td>' . htmlspecialchars($row['livro_titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['professor_nome']) . '</td>';
        echo '<td>' . date('d/m/Y', strtotime($row['data_devolucao'])) . '</td>';
        echo '<td><span class="badge bg-' . $status_class . '">' . 
            ($row['devolvido'] ? 'Devolvido' : 
                (strtotime($row['data_devolucao']) < time() ? 'Atrasado' : 'Pendente')) . 
            '</span></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function gerarRelatorioLivros($conn) {
    $sql = "
        SELECT 
            l.*,
            (SELECT COUNT(*) FROM emprestimos WHERE livro_id = l.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE livro_id = l.id AND devolvido = 0) as emprestimos_ativos
        FROM livros l
        ORDER BY l.titulo
    ";

    $result = $conn->query($sql);

    echo '<h4 class="mb-4">Relatório de Livros</h4>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Título</th>';
    echo '<th>Autor</th>';
    echo '<th>ISBN</th>';
    echo '<th>Total Empréstimos</th>';
    echo '<th>Empréstimos Ativos</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['titulo']) . '</td>';
        echo '<td>' . htmlspecialchars($row['autor']) . '</td>';
        echo '<td>' . htmlspecialchars($row['isbn']) . '</td>';
        echo '<td>' . $row['total_emprestimos'] . '</td>';
        echo '<td>' . $row['emprestimos_ativos'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function gerarRelatorioAlunos($conn) {
    $sql = "
        SELECT 
            a.*,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 0) as emprestimos_ativos,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 0 AND data_devolucao < CURRENT_DATE()) as emprestimos_atrasados
        FROM alunos a
        ORDER BY a.nome
    ";

    $result = $conn->query($sql);

    echo '<h4 class="mb-4">Relatório de Alunos</h4>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>Série</th>';
    echo '<th>Total Empréstimos</th>';
    echo '<th>Empréstimos Ativos</th>';
    echo '<th>Empréstimos Atrasados</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($row['serie']) . '</td>';
        echo '<td>' . $row['total_emprestimos'] . '</td>';
        echo '<td>' . $row['emprestimos_ativos'] . '</td>';
        echo '<td>' . $row['emprestimos_atrasados'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

function gerarRelatorioProfessores($conn) {
    $sql = "
        SELECT 
            p.*,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id AND devolvido = 0) as emprestimos_ativos,
            (SELECT MAX(data_emprestimo) FROM emprestimos WHERE professor_id = p.id) as ultimo_emprestimo
        FROM professores p
        ORDER BY p.nome
    ";

    $result = $conn->query($sql);

    echo '<h4 class="mb-4">Relatório de Professores</h4>';
    echo '<div class="table-responsive">';
    echo '<table class="table table-striped">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Nome</th>';
    echo '<th>Email</th>';
    echo '<th>Total Empréstimos</th>';
    echo '<th>Empréstimos Ativos</th>';
    echo '<th>Último Empréstimo</th>';
    echo '<th>Status</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['nome']) . '</td>';
        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
        echo '<td>' . $row['total_emprestimos'] . '</td>';
        echo '<td>' . $row['emprestimos_ativos'] . '</td>';
        echo '<td>' . ($row['ultimo_emprestimo'] ? date('d/m/Y', strtotime($row['ultimo_emprestimo'])) : 'Nunca') . '</td>';
        echo '<td><span class="badge bg-' . ($row['ativo'] ? 'success' : 'danger') . '">' . 
            ($row['ativo'] ? 'Ativo' : 'Inativo') . '</span></td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}

switch ($tipo) {
    case 'emprestimos':
        gerarRelatorioEmprestimos($conn, $data_inicial, $data_final, $status);
        break;
    case 'livros':
        gerarRelatorioLivros($conn);
        break;
    case 'alunos':
        gerarRelatorioAlunos($conn);
        break;
    case 'professores':
        gerarRelatorioProfessores($conn);
        break;
}
?> 