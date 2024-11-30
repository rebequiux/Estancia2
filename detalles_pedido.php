<?php include './Static/connect/bd.php'; ?>

<?php
session_start();

// Verificar si se recibe un pedido_id válido
if (!isset($_GET['pedido_id'])) {
    header("Location: pedidos.php");
    exit();
}

$pedido_id = (int) $_GET['pedido_id'];
$detalles_pedido = [];

// Consultar los detalles del pedido
$sql = "SELECT dp.producto_id, p.producto, p.descripcion, dp.cantidad, dp.precio_unitario, (dp.cantidad * dp.precio_unitario) AS subtotal
        FROM detalles_pedido dp
        JOIN productos p ON dp.producto_id = p.id
        WHERE dp.pedido_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $pedido_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $detalles_pedido[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(90deg, #6a1b9a, #8e44ad);
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
            font-weight: bold;
        }
        .btn-custom {
            background-color: #8e44ad;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #6a1b9a;
            color: #fff;
        }
        .header-text {
            color: #6a1b9a;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="productos.php">Nuestros Productos</a>
            <div class="d-flex">
                <a href="pedidos.php" class="btn btn-primary me-2">Mis Pedidos</a>
                <form method="POST" action="carrito.php">
                    <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center header-text">Detalles del Pedido #<?= $pedido_id ?></h1>
        <div class="mt-4">
            <?php if (!empty($detalles_pedido)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Producto</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detalles_pedido as $detalle): ?>
                                <tr>
                                    <td><?= $detalle['producto_id'] ?></td>
                                    <td><?= $detalle['producto'] ?></td>
                                    <td><?= $detalle['descripcion'] ?></td>
                                    <td><?= $detalle['cantidad'] ?></td>
                                    <td>$<?= number_format($detalle['precio_unitario'], 2) ?> MXN</td>
                                    <td>$<?= number_format($detalle['subtotal'], 2) ?> MXN</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No se encontraron detalles para este pedido.</p>
                <div class="d-flex justify-content-center mt-4">
                    <a href="pedidos.php" class="btn btn-custom">Volver a Mis Pedidos</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
