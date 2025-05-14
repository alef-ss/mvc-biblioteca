<?php
session_start();
require '../includes/conn.php'; // Arquivo de conexão com o banco
require '../fpdf/fpdf.php'; // Inclui a biblioteca FPDF

// Verifica se o professor está logado
if (!isset($_SESSION['professor_id'])) {
    header("Location: ../frontend/login.php");
    exit();
}

// Classe personalizada para o PDF
class PDF extends FPDF {
    // Cabeçalho do documento
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Histórico de Empréstimos', 0, 1, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, 'Gerado em: ' . date('d/m/Y H:i:s'), 0, 1, 'C');
        $this->Ln(10);
    }
    
    // Rodapé do documento
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
    
    // Cabeçalho da tabela
    function HeaderTable() {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 10, 'Livro', 1, 0, 'C');
        $this->Cell(50, 10, 'Aluno', 1, 0, 'C');
        $this->Cell(40, 10, 'Data Empréstimo', 1, 0, 'C');
        $this->Cell(40, 10, 'Data Devolução', 1, 0, 'C');
        $this->Cell(30, 10, 'Estado', 1, 1, 'C');
    }
}

// Criar uma instância do PDF
$pdf = new PDF('L'); // 'L' para orientação paisagem
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->HeaderTable();

// Iniciando o array de tipos dos parâmetros para bind_param
$param_types = '';

// Iniciando o array de valores para bind_param
$param_values = [];

// Construir a consulta SQL dinamicamente (mesma consulta da página principal)
$sql = "
    SELECT e.id, l.titulo AS livro, a.nome AS aluno, e.data_emprestimo, e.data_devolucao, e.devolvido
    FROM emprestimos e
    JOIN livros l ON e.livro_id = l.id
    JOIN alunos a ON e.aluno_id = a.id
    WHERE 1
";

// Adicionar os mesmos filtros da página principal
if (!empty($_GET['aluno'])) {
    $search_aluno = $_GET['aluno'];
    $sql .= " AND a.nome LIKE ?";
    $param_types .= 's';
    $param_values[] = "%" . $search_aluno . "%";
}
if (!empty($_GET['livro'])) {
    $search_livro = $_GET['livro'];
    $sql .= " AND l.titulo LIKE ?";
    $param_types .= 's';
    $param_values[] = "%" . $search_livro . "%";
}
if (!empty($_GET['estado'])) {
    $search_estado = $_GET['estado'];
    $sql .= " AND e.devolvido = ?";
    $param_types .= 's';
    $param_values[] = $search_estado;
}
if (!empty($_GET['data_inicio'])) {
    $search_data_inicio = $_GET['data_inicio'];
    $sql .= " AND e.data_emprestimo >= ?";
    $param_types .= 's';
    $param_values[] = $search_data_inicio;
}
if (!empty($_GET['data_fim'])) {
    $search_data_fim = $_GET['data_fim'];
    $sql .= " AND e.data_emprestimo <= ?";
    $param_types .= 's';
    $param_values[] = $search_data_fim;
}

// Preparar e executar a consulta
$stmt = $conn->prepare($sql);
if (count($param_values) > 0) {
    $stmt->bind_param($param_types, ...$param_values);
}
$stmt->execute();
$result = $stmt->get_result();

// Preencher o PDF com os dados
$pdf->SetFont('Arial', '', 10);
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(60, 10, utf8_decode($row['livro']), 1, 0, 'L');
    $pdf->Cell(50, 10, utf8_decode($row['aluno']), 1, 0, 'L');
    $pdf->Cell(40, 10, date('d/m/Y', strtotime($row['data_emprestimo'])), 1, 0, 'C');
    $pdf->Cell(40, 10, $row['data_devolucao'] ? date('d/m/Y', strtotime($row['data_devolucao'])) : 'Não devolvido', 1, 0, 'C');
    $pdf->Cell(30, 10, $row['devolvido'] == '0' ? 'Não Devolvido' : 'Devolvido', 1, 1, 'C');
}

// Verificar se há resultados
if ($result->num_rows == 0) {
    $pdf->Cell(0, 10, 'Nenhum registro encontrado', 1, 1, 'C');
}

// Saída do PDF
$pdf->Output('I', 'historico_emprestimos_' . date('Ymd') . '.pdf');

$conn->close();
?>