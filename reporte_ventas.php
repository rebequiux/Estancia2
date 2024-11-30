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

// Consulta SQL para obtener productos con mayor rotación
$sql = "
    SELECT 
        p.producto, 
        p.precio, 
        p.descripcion, 
        COALESCE(SUM(dp.cantidad), 0) AS total_vendido
    FROM productos p
    LEFT JOIN detalles_pedido dp ON p.id = dp.producto_id
    LEFT JOIN pedidos ped ON dp.pedido_id = ped.id AND ped.estado = 'Pagado'
    WHERE ped.fecha BETWEEN '$fecha_inicio' AND '$fecha_fin'
    GROUP BY p.id
    ORDER BY total_vendido DESC
    LIMIT 10;"; // Muestra los 10 productos más vendidos

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    die("Error en la consulta: " . mysqli_error($conn));
}

// Verificar si hay datos para mostrar
if (mysqli_num_rows($resultado) == 0) {
    die("No hay productos con mayor rotación en el rango de fechas proporcionado.");
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, 'Reporte de Productos con Mayor Rango de Rotación', 0, 1, 'C');
$pdf->Ln(5);

// Mostrar rango de fechas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Rango de Fechas: $fecha_inicio a $fecha_fin", 0, 1, 'C');
$pdf->Ln(5);

// Encabezados
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(50, 6, 'Producto', 1);
$pdf->Cell(20, 6, 'Precio', 1);
$pdf->Cell(30, 6, 'Total Vendido', 1);
$pdf->Cell(80, 6, 'Descripción', 1);
$pdf->Ln();

// Cuerpo del reporte
$pdf->SetFont('Arial', '', 7);
$total_productos = 0; // Inicializar contador de productos
while ($row = mysqli_fetch_assoc($resultado)) {
    $descripcion = strlen($row['descripcion']) > 75 ? substr($row['descripcion'], 0, 72) . '...' : $row['descripcion'];

    $pdf->Cell(50, 6, $row['producto'], 1);
    $pdf->Cell(20, 6, '$' . number_format($row['precio'], 2), 1);
    $pdf->Cell(30, 6, $row['total_vendido'], 1);
    $pdf->Cell(80, 6, $descripcion, 1);
    $pdf->Ln();
    $total_productos++; // Incrementar contador
}

// Mostrar total de productos al final del reporte
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 6, "Total de productos en el reporte: $total_productos", 0, 1, 'R');

// Generar el PDF
$pdf->Output();
?>
