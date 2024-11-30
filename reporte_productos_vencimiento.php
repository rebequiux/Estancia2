<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require(__DIR__ . '/libs/fpdf.php');
require('./Static/connect/bd.php'); // Conexión a la base de datos

// Validar los parámetros de fecha
if (isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin'])) {
    $fecha_inicio = $_GET['fecha_inicio'];
    $fecha_fin = $_GET['fecha_fin'];
    
    // Validar formato de fechas
    if (!strtotime($fecha_inicio) || !strtotime($fecha_fin)) {
        die("Fechas inválidas. Por favor ingresa un rango válido.");
    }
} else {
    die("Por favor selecciona un rango de fechas.");
}

// Consulta SQL para productos en riesgo de vencimiento
$sql = "
    SELECT 
        p.producto, 
        p.fecha_vencimiento, 
        p.descripcion, 
        p.precio,
        pr.nombre AS proveedor
    FROM productos p
    LEFT JOIN proveedores pr ON p.proveedor = pr.id
    WHERE p.fecha_vencimiento BETWEEN '$fecha_inicio' AND '$fecha_fin'
    AND p.fecha_vencimiento <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
    ORDER BY p.precio ASC, p.fecha_vencimiento ASC;
";

// Depuración: verifica la consulta generada
error_log("Consulta ejecutada: $sql");

// Ejecutar la consulta
$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Verificar si hay productos en el rango
if (mysqli_num_rows($resultado) == 0) {
    die("No hay productos en riesgo de vencimiento en el rango seleccionado.");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Productos en Riesgo de Vencimiento', 0, 1, 'C');
$pdf->Ln(10);

// Mostrar rango de fechas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Rango de Fechas: $fecha_inicio a $fecha_fin", 0, 1, 'C');
$pdf->Ln(10);

// Encabezados
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(50, 10, 'Producto', 1);
$pdf->Cell(40, 10, 'Fecha Venc.', 1);
$pdf->Cell(60, 10, 'Proveedor', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Ln();

// Datos
$pdf->SetFont('Arial', '', 12);
$total_productos = 0;
while ($row = mysqli_fetch_assoc($resultado)) {
    $pdf->Cell(50, 10, $row['producto'], 1);
    $pdf->Cell(40, 10, $row['fecha_vencimiento'], 1);
    $pdf->Cell(60, 10, $row['proveedor'] ?: 'Sin proveedor', 1);
    $pdf->Cell(30, 10, '$' . number_format($row['precio'], 2), 1);
    $pdf->Ln();
    $total_productos++;
}

// Total de productos al final
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Total de productos en riesgo: $total_productos", 0, 1, 'R');

// Generar el PDF
$pdf->Output();
?>
