<?php
session_start();
include './Static/connect/bd.php';

// Capturar y limpiar la salida del layout para evitar errores de encabezados
ob_start();
include 'admin_layout.php';
ob_end_clean();

// Verificar si se pasó el ID del producto en la URL
if (!isset($_GET['nombre'])) {
    $_SESSION['error'] = "No se especificó el producto a actualizar.";
    header("Location: gestionventas.php");
    exit;
}

// Obtener los datos del producto a actualizar
$nombre_producto = mysqli_real_escape_string($conn, $_GET['nombre']);
$query = "
    SELECT 
        p.id AS producto_id,
        p.producto AS nombre_producto,
        p.precio AS precio_producto,
        SUM(dp.cantidad) AS cantidad_vendida,
        SUM(dp.cantidad * dp.precio_unitario) AS ingresos_generados
    FROM 
        productos p
    LEFT JOIN 
        detalles_pedido dp ON dp.producto_id = p.id
    WHERE 
        p.producto = '$nombre_producto'
    GROUP BY 
        p.id, p.producto;
";

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $producto_id = $row['producto_id'];
    $nombre_producto = $row['nombre_producto'];
    $precio_producto = $row['precio_producto'];
    $cantidad_vendida = $row['cantidad_vendida'] ?? 0;
    $ingresos_generados = $row['ingresos_generados'] ?? 0.00;
} else {
    $_SESSION['error'] = "El producto '$nombre_producto' no se encontró.";
    header("Location: gestionventas.php");
    exit;
}

// Procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = mysqli_real_escape_string($conn, $_POST['nombre_producto']);
    $nuevo_precio = mysqli_real_escape_string($conn, $_POST['precio_producto']);

    $update_query = "
        UPDATE productos 
        SET producto = '$nuevo_nombre', precio = $nuevo_precio
        WHERE id = $producto_id;
    ";

    if (mysqli_query($conn, $update_query)) {
        $_SESSION['success'] = "Producto actualizado correctamente.";
        header("Location: gestionventas.php");
        exit;
    } else {
        $_SESSION['error'] = "Error al actualizar el producto: " . mysqli_error($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #6a1b9a;
            color: white;
        }
        .btn-custom:hover {
            background-color: #4a148c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">Actualizar Producto</h2>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="actualizarventa.php?nombre=<?php echo htmlspecialchars($nombre_producto); ?>">
            <div class="mb-4">
                <label for="nombre_producto" class="form-label">Nombre del Producto:</label>
                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" value="<?php echo htmlspecialchars($nombre_producto); ?>" required>
            </div>
            <div class="mb-4">
                <label for="cantidad_vendida" class="form-label">Cantidad Vendida (No editable):</label>
                <input type="text" id="cantidad_vendida" class="form-control" value="<?php echo htmlspecialchars($cantidad_vendida); ?>" readonly>
            </div>
            <div class="mb-4">
                <label for="precio_producto" class="form-label">Precio del Producto:</label>
                <input type="number" id="precio_producto" name="precio_producto" class="form-control" step="0.01" value="<?php echo htmlspecialchars($precio_producto); ?>" required>
            </div>
            <div class="mb-4">
                <label for="ingresos_generados" class="form-label">Ingresos Generados (No editable):</label>
                <input type="text" id="ingresos_generados" class="form-control" value="$<?php echo number_format($ingresos_generados, 2); ?>" readonly>
            </div>
            <button type="submit" class="btn btn-custom w-100">Actualizar Producto</button>
        </form>
        <div class="mt-3 text-center">
            <a href="gestionventas.php" class="btn btn-link">Regresar</a>
        </div>
    </div>
</body>
</html>
