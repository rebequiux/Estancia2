<?php
require(__DIR__ . '/libs/fpdf.php'); // Asegúrate de que esta ruta sea correcta

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Prueba de FPDF');
$pdf->Output();
?>
