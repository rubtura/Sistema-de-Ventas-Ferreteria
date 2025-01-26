<?php
require_once __DIR__ . '/../../FPDF/fpdf.php';

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, '¡Prueba de FPDF exitosa!');
$pdf->Output();
?>
