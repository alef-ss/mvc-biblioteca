<?php
session_start();
require_once '../../includes/auth_admin.php';
require_once '../../includes/conn.php';
require_once '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Dompdf\Dompdf;

$tipo = $_GET['tipo'] ?? 'emprestimos';
$data_inicial = $_GET['data_inicial'] ?? '';
$data_final = $_GET['data_final'] ?? '';
$status = $_GET['status'] ?? '';
$formato = $_GET['formato'] ?? 'excel';

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
            (SELECT COUNT(*) FROM emprestimos WHERE livro_id = l.id AND devolvido = 0) as emprestimos_ativos
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
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 0) as emprestimos_ativos,
            (SELECT COUNT(*) FROM emprestimos WHERE aluno_id = a.id AND devolvido = 0 AND data_devolucao < CURRENT_DATE()) as emprestimos_atrasados
        FROM alunos a
        ORDER BY a.nome
    ";
    return $conn->query($sql);
}

function gerarDadosProfessores($conn) {
    $sql = "
        SELECT 
            p.*,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id) as total_emprestimos,
            (SELECT COUNT(*) FROM emprestimos WHERE professor_id = p.id AND devolvido = 0) as emprestimos_ativos,
            (SELECT MAX(data_emprestimo) FROM emprestimos WHERE professor_id = p.id) as ultimo_emprestimo
        FROM professores p
        ORDER BY p.nome
    ";
    return $conn->query($sql);
}

function exportarExcel($dados, $tipo) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    
    // Definir cabeçalhos baseado no tipo
    switch ($tipo) {
        case 'emprestimos':
            $headers = ['Data', 'Aluno', 'Livro', 'Professor', 'Devolução', 'Status'];
            $sheet->fromArray($headers, NULL, 'A1');
            
            $row = 2;
            while ($item = $dados->fetch_assoc()) {
                $status = ($item['devolvido'] === 'Sim' || $item['devolvido'] === '1') ? 'Devolvido' : 
                    (strtotime($item['data_devolucao']) < time() ? 'Atrasado' : 'Pendente');
                
                $sheet->setCellValue('A'.$row, date('d/m/Y', strtotime($item['data_emprestimo'])));
                $sheet->setCellValue('B'.$row, $item['aluno_nome']);
                $sheet->setCellValue('C'.$row, $item['livro_titulo']);
                $sheet->setCellValue('D'.$row, $item['professor_nome']);
                $sheet->setCellValue('E'.$row, date('d/m/Y', strtotime($item['data_devolucao'])));
                $sheet->setCellValue('F'.$row, $status);
                $row++;
            }
            break;
            
        case 'livros':
            $headers = ['Título', 'Autor', 'ISBN', 'Total Empréstimos', 'Empréstimos Ativos'];
            $sheet->fromArray($headers, NULL, 'A1');
            
            $row = 2;
            while ($item = $dados->fetch_assoc()) {
                $sheet->setCellValue('A'.$row, $item['titulo']);
                $sheet->setCellValue('B'.$row, $item['autor']);
                $sheet->setCellValue('C'.$row, $item['isbn']);
                $sheet->setCellValue('D'.$row, $item['total_emprestimos']);
                $sheet->setCellValue('E'.$row, $item['emprestimos_ativos']);
                $row++;
            }
            break;
            
        case 'alunos':
            $headers = ['Nome', 'Série', 'Total Empréstimos', 'Empréstimos Ativos', 'Empréstimos Atrasados'];
            $sheet->fromArray($headers, NULL, 'A1');
            
            $row = 2;
            while ($item = $dados->fetch_assoc()) {
                $sheet->setCellValue('A'.$row, $item['nome']);
                $sheet->setCellValue('B'.$row, $item['serie']);
                $sheet->setCellValue('C'.$row, $item['total_emprestimos']);
                $sheet->setCellValue('D'.$row, $item['emprestimos_ativos']);
                $sheet->setCellValue('E'.$row, $item['emprestimos_atrasados']);
                $row++;
            }
            break;
            
        case 'professores':
            $headers = ['Nome', 'Email', 'Total Empréstimos', 'Empréstimos Ativos', 'Último Empréstimo', 'Status'];
            $sheet->fromArray($headers, NULL, 'A1');
            
            $row = 2;
            while ($item = $dados->fetch_assoc()) {
                $sheet->setCellValue('A'.$row, $item['nome']);
                $sheet->setCellValue('B'.$row, $item['email']);
                $sheet->setCellValue('C'.$row, $item['total_emprestimos']);
                $sheet->setCellValue('D'.$row, $item['emprestimos_ativos']);
                $sheet->setCellValue('E'.$row, $item['ultimo_emprestimo'] ? date('d/m/Y', strtotime($item['ultimo_emprestimo'])) : 'Nunca');
                $sheet->setCellValue('F'.$row, $item['ativo'] ? 'Ativo' : 'Inativo');
                $row++;
            }
            break;
    }

    // Auto-size columns
    foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }

    // Estilo para cabeçalho
    $headerStyle = [
        'font' => ['bold' => true],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['rgb' => '4361EE']
        ],
        'font' => [
            'color' => ['rgb' => 'FFFFFF']
        ]
    ];
    $sheet->getStyle('A1:' . $sheet->getHighestDataColumn() . '1')->applyFromArray($headerStyle);

    // Criar arquivo Excel
    $writer = new Xlsx($spreadsheet);
    if (headers_sent($file, $line)) {
        die("ERRO: Headers já enviados em $file na linha $line");
    }
    
    // Headers para download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="relatorio_' . $tipo . '_' . date('Y-m-d') . '.xlsx"');
    header('Cache-Control: max-age=0');

    ob_clean();
    flush();
    
    $writer->save('php://output');
    exit;
}

function exportarPDF($dados, $tipo) {
    $html = '<style>
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #4361EE; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        h2 { color: #4361EE; margin-bottom: 20px; }
        .badge { padding: 5px 10px; border-radius: 4px; color: white; }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; }
        .badge-danger { background-color: #dc3545; }
    </style>';

    $html .= '<h2>Relatório de ' . ucfirst($tipo) . '</h2>';
    $html .= '<table>';

    switch ($tipo) {
        case 'emprestimos':
            $html .= '<tr><th>Data</th><th>Aluno</th><th>Livro</th><th>Professor</th><th>Devolução</th><th>Status</th></tr>';
            while ($item = $dados->fetch_assoc()) {
                $status = $item['devolvido'] ? 'success' : 
                    (strtotime($item['data_devolucao']) < time() ? 'danger' : 'warning');
                $status_text = $item['devolvido'] ? 'Devolvido' : 
                    (strtotime($item['data_devolucao']) < time() ? 'Atrasado' : 'Pendente');
                
                $html .= '<tr>';
                $html .= '<td>' . date('d/m/Y', strtotime($item['data_emprestimo'])) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['aluno_nome']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['livro_titulo']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['professor_nome']) . '</td>';
                $html .= '<td>' . date('d/m/Y', strtotime($item['data_devolucao'])) . '</td>';
                $html .= '<td><span class="badge badge-' . $status . '">' . $status_text . '</span></td>';
                $html .= '</tr>';
            }
            break;
            
        case 'livros':
            $html .= '<tr><th>Título</th><th>Autor</th><th>ISBN</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th></tr>';
            while ($item = $dados->fetch_assoc()) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($item['titulo']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['autor']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['isbn']) . '</td>';
                $html .= '<td>' . $item['total_emprestimos'] . '</td>';
                $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
                $html .= '</tr>';
            }
            break;
            
        case 'alunos':
            $html .= '<tr><th>Nome</th><th>Série</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th><th>Empréstimos Atrasados</th></tr>';
            while ($item = $dados->fetch_assoc()) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($item['nome']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['serie']) . '</td>';
                $html .= '<td>' . $item['total_emprestimos'] . '</td>';
                $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
                $html .= '<td>' . $item['emprestimos_atrasados'] . '</td>';
                $html .= '</tr>';
            }
            break;
            
        case 'professores':
            $html .= '<tr><th>Nome</th><th>Email</th><th>Total Empréstimos</th><th>Empréstimos Ativos</th><th>Último Empréstimo</th><th>Status</th></tr>';
            while ($item = $dados->fetch_assoc()) {
                $html .= '<tr>';
                $html .= '<td>' . htmlspecialchars($item['nome']) . '</td>';
                $html .= '<td>' . htmlspecialchars($item['email']) . '</td>';
                $html .= '<td>' . $item['total_emprestimos'] . '</td>';
                $html .= '<td>' . $item['emprestimos_ativos'] . '</td>';
                $html .= '<td>' . ($item['ultimo_emprestimo'] ? date('d/m/Y', strtotime($item['ultimo_emprestimo'])) : 'Nunca') . '</td>';
                $html .= '<td><span class="badge badge-' . ($item['ativo'] ? 'success' : 'danger') . '">' . 
                    ($item['ativo'] ? 'Ativo' : 'Inativo') . '</span></td>';
                $html .= '</tr>';
            }
            break;
    }

    $html .= '</table>';

    // Criar PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // Headers para download
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="relatorio_' . $tipo . '_' . date('Y-m-d') . '.pdf"');
    
    echo $dompdf->output();
    exit;
}

// Buscar dados
switch ($tipo) {
    case 'emprestimos':
        $dados = gerarDadosEmprestimos($conn, $data_inicial, $data_final, $status);
        break;
    case 'livros':
        $dados = gerarDadosLivros($conn);
        break;
    case 'alunos':
        $dados = gerarDadosAlunos($conn);
        break;
    case 'professores':
        $dados = gerarDadosProfessores($conn);
        break;
}

// Exportar no formato solicitado
if ($formato === 'excel') {
    exportarExcel($dados, $tipo);
} else {
    exportarPDF($dados, $tipo);
}
?> 