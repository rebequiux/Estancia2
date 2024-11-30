<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require(__DIR__ . '/libs/fpdf.php');
require('./Static/connect/bd.php'); // Conexión a la base de datos

// Obtener los rangos de fechas
$fecha_inicio = $_GET['fecha_inicio'] ?? '';
$fecha_fin = $_GET['fecha_fin'] ?? '';

// Validar que las fechas no estén vacías
if (empty($fecha_inicio) || empty($fecha_fin)) {
    echo "<script>alert('Por favor selecciona un rango de fechas.'); window.history.back();</script>";
    exit();
}

// Consulta SQL para obtener información de productos dentro del rango de fechas
$sql = "
    SELECT 
        p.id AS proveedor_id,
        p.nombre AS proveedor_nombre,
        pr.producto AS producto_suministrado,
        pr.fecha_vencimiento AS fecha_abastecimiento,
        pr.precio AS precio_producto
    FROM proveedores p
    LEFT JOIN productos pr ON p.id = pr.proveedor
    WHERE pr.fecha_vencimiento BETWEEN '$fecha_inicio' AND '$fecha_fin'
    ORDER BY pr.fecha_vencimiento ASC
";

$resultado = mysqli_query($conn, $sql);

if (!$resultado) {
    echo "<script>alert('Error en la consulta: " . mysqli_error($conn) . "'); window.history.back();</script>";
    exit();
}

// Verificar si hay resultados
if (mysqli_num_rows($resultado) === 0) {
    echo "<script>alert('No se encontraron productos en el rango de fechas seleccionado.'); window.history.back();</script>";
    exit();
}

// Crear el PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Reporte de Productos por Fecha', 0, 1, 'C');
$pdf->Ln(10);

// Mostrar rango de fechas en el encabezado
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Rango de Fechas: $fecha_inicio a $fecha_fin", 0, 1, 'C');
$pdf->Ln(10);

// Encabezados de la tabla
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 10, 'Proveedor', 1);
$pdf->Cell(50, 10, 'Producto', 1);
$pdf->Cell(50, 10, 'Fecha Abastecimiento', 1);
$pdf->Cell(40, 10, 'Precio', 1);
$pdf->Ln();

// Agregar datos al PDF
$pdf->SetFont('Arial', '', 8); // Reducir tamaño de letra para más datos en la hoja
$total_productos = 0; // Inicializar contador de productos
while ($row = mysqli_fetch_assoc($resultado)) {
    $producto_precio = $row['precio_producto'] !== null ? number_format($row['precio_producto'], 2) : '0.00';
    $producto_nombre = $row['producto_suministrado'] ?: 'Sin producto';
    $fecha_abastecimiento = $row['fecha_abastecimiento'] ?: 'N/A';

    $pdf->Cell(50, 8, $row['proveedor_nombre'], 1);
    $pdf->Cell(50, 8, $producto_nombre, 1);
    $pdf->Cell(50, 8, $fecha_abastecimiento, 1);
    $pdf->Cell(40, 8, '$' . $producto_precio, 1);
    $pdf->Ln();
    $total_productos++; // Incrementar contador
}

// Mostrar total de productos al final del reporte
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Total de productos encontrados: $total_productos", 0, 1, 'R');

// Generar el PDF
$pdf->Output();
?>
