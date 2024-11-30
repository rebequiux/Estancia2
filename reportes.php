<?php
// Incluye la librería FPDF
require(__DIR__ . '/libs/fpdf.php'); // Ruta absoluta para asegurar la inclusión
require('conexion.php'); // Archivo de conexión a la base de datos

// Clase personalizada de FPDF
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Reporte de Ventas Totales por Semana', 0, 1, 'C');
        $this->Ln(10);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo(), 0, 0, 'C');
    }
}

// Crear un PDF
$pdf = new PDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(40, 10, 'Reporte Generado Exitosamente');
$pdf->Output();
?>


