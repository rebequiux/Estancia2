<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require(__DIR__ . '/libs/fpdf.php');
require('./Static/connect/bd.php'); // Conexión a la base de datos

// Rango de fechas recibido por GET
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Validar los parámetros de fecha dentro de la misma página
if (empty($fecha_inicio) || empty($fecha_fin)) {
    echo "<h3 style='color: red; text-align: center;'>Por favor selecciona un rango de fechas.</h3>";
    exit();
}

// Consulta SQL corregida para incluir solo pedidos con estado "Pendiente"
$sql = "
    SELECT 
        p.id AS pedido_id,
        u.usuario AS usuario_nombre,
        GROUP_CONCAT(CONCAT(dp.cantidad, 'x ', pr.producto) SEPARATOR ', ') AS productos,
        p.estado AS estado_pedido,
        p.fecha AS fecha_pedido,
        p.total AS total_pedido
    FROM pedidos p
    INNER JOIN usuarios u ON p.cliente_id = u.id_usuarios
    INNER JOIN detalles_pedido dp ON p.id = dp.pedido_id
    INNER JOIN productos pr ON dp.producto_id = pr.id
    WHERE DATE(p.fecha) BETWEEN '$fecha_inicio' AND '$fecha_fin'
      AND p.estado = 'Pendiente'
    GROUP BY p.id
    ORDER BY p.fecha ASC";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    echo "<h3 style='color: red; text-align: center;'>Error en la consulta: " . mysqli_error($conn) . "</h3>";
    exit();
}

// Contar resultados
$total_pedidos = mysqli_num_rows($resultado);

// Crear PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Reporte de Pedidos Pendientes', 0, 1, 'C');
$pdf->Ln(10);

// Mostrar rango de fechas
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 8, "Rango de Fechas: $fecha_inicio a $fecha_fin", 0, 1, 'C');
$pdf->Ln(8);

// Encabezados
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(15, 8, 'ID', 1);
$pdf->Cell(25, 8, 'Usuario', 1);
$pdf->Cell(60, 8, 'Productos', 1);
$pdf->Cell(20, 8, 'Estado', 1);
$pdf->Cell(30, 8, 'Fecha', 1);
$pdf->Cell(20, 8, 'Total', 1);
$pdf->Ln();

// Datos
$pdf->SetFont('Arial', '', 8);

if ($total_pedidos > 0) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $productos = strlen($row['productos']) > 60 ? substr($row['productos'], 0, 57) . '...' : $row['productos']; // Truncar productos largos

        $pdf->Cell(15, 8, $row['pedido_id'], 1);
        $pdf->Cell(25, 8, $row['usuario_nombre'], 1);
        $pdf->Cell(60, 8, $productos, 1);
        $pdf->Cell(20, 8, $row['estado_pedido'], 1);
        $pdf->Cell(30, 8, $row['fecha_pedido'], 1);
        $pdf->Cell(20, 8, '$' . number_format($row['total_pedido'], 2), 1);
        $pdf->Ln();
    }
} else {
    // Si no hay resultados, agregar una fila vacía
    $pdf->Cell(170, 8, 'No se encontraron pedidos pendientes en el rango de fechas.', 1, 0, 'C');
    $pdf->Ln();
}

// Mostrar conteo total de pedidos al final
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, "Total de Pedidos Pendientes: $total_pedidos", 0, 1, 'C');

// Generar PDF
$pdf->Output();
?>
