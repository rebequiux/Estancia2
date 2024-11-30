<?php
require(__DIR__ . '/libs/fpdf.php');
require('./Static/connect/bd.php'); // Conexión a la base de datos

// Recibir los filtros de fecha
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Validar los parámetros
if (!$fecha_inicio || !$fecha_fin) {
    die("Error: Debes proporcionar un rango de fechas.");
}

// Consulta SQL para obtener los productos vendidos ordenados por total vendido
$sql = "
    SELECT 
        p.producto, 
        p.precio, 
        p.descripcion, 
        COALESCE(SUM(dp.cantidad), 0) AS total_vendido
    FROM productos p
    LEFT JOIN detalles_pedido dp ON p.id = dp.producto_id
    LEFT JOIN pedidos ped ON dp.pedido_id = ped.id AND ped.estado = 'Pagado'
    WHERE DATE(ped.fecha) BETWEEN '$fecha_inicio' AND '$fecha_fin'
    GROUP BY p.id
    ORDER BY total_vendido DESC;
";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Verificar si hay datos para mostrar
$total_productos = mysqli_num_rows($resultado);
if ($total_productos == 0) {
    die("No se encontraron ventas en el rango de fechas proporcionado.");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Productos Vendidos', 0, 1, 'C');
$pdf->Ln(10);

// Mostrar rango de fechas
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Rango de Fechas: $fecha_inicio a $fecha_fin", 0, 1, 'C');
$pdf->Ln(10);

// Encabezados
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(60, 10, 'Producto', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(40, 10, 'Total Vendido', 1);
$pdf->Cell(60, 10, 'Descripción', 1);
$pdf->Ln();

// Cuerpo del reporte
$pdf->SetFont('Arial', '', 10);
while ($row = mysqli_fetch_assoc($resultado)) {
    $descripcion = strlen($row['descripcion']) > 40 ? substr($row['descripcion'], 0, 37) . '...' : $row['descripcion'];

    $pdf->Cell(60, 10, $row['producto'], 1);
    $pdf->Cell(30, 10, '$' . number_format($row['precio'], 2), 1);
    $pdf->Cell(40, 10, $row['total_vendido'], 1);
    $pdf->Cell(60, 10, $descripcion, 1);
    $pdf->Ln();
}

// Mostrar total de productos encontrados al final del reporte
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Total de productos encontrados: $total_productos", 0, 1, 'C');

// Generar el PDF
$pdf->Output();
?>
