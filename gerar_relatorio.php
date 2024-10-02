<?php
require('lib/fpdf186/fpdf.php'); // Inclui a biblioteca FPDF

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Relatorio de Ordens de Servico', 0, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 10, 'ID', 1);
$pdf->Cell(50, 10, 'Cliente', 1);
$pdf->Cell(50, 10, 'Tecnico', 1);
$pdf->Cell(30, 10, 'Status', 1);
$pdf->Cell(30, 10, 'Data', 1);
$pdf->Ln();

// Loop para preencher os dados no PDF
foreach ($ordens as $ordem) {
    $pdf->Cell(30, 10, $ordem['numero_os'], 1);
    $pdf->Cell(50, 10, $ordem['cliente_nome'], 1);
    $pdf->Cell(50, 10, $ordem['tecnico_nome'], 1);
    $pdf->Cell(30, 10, $ordem['status'], 1);
    $pdf->Cell(30, 10, date('d/m/Y', strtotime($ordem['data'])), 1);
    $pdf->Ln();
}

$pdf->Output();
?>