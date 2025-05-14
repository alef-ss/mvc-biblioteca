<?php
require(__DIR__ . '/fpdf/fpdf.php'); // Caminho absoluto

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(200, 10, 'Teste de PDF', 0, 1, 'C');
$pdf->Output();
?>
