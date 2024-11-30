<?php include './Static/connect/bd.php'; ?>

<?php
session_start();

// Verificar si el cliente está autenticado
$cliente_id = 1; // Cambia esto según tu sistema de autenticación
$pedidos = [];

// Obtener todos los pedidos del cliente
$sql = "SELECT id, fecha, total, estado FROM pedidos WHERE cliente_id = ? ORDER BY fecha DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cliente_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Pedidos</title>
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
                <a href="index.php" class="btn btn-custom me-2">Inicio</a>
                <a href="pedidos.php" class="btn btn-primary me-2">Mis Pedidos</a>
                <form method="POST" action="carrito.php">
                    <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center header-text">Mis Pedidos</h1>
        <div class="mt-4">
            <?php if (!empty($pedidos)): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Pedido</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pedidos as $pedido): ?>
                                <tr>
                                    <td><?= $pedido['id'] ?></td>
                                    <td><?= $pedido['fecha'] ?></td>
                                    <td>$<?= number_format($pedido['total'], 2) ?> MXN</td>
                                    <td><?= $pedido['estado'] ?></td>
                                    <td>
                                        <a href="detalles_pedido.php?pedido_id=<?= $pedido['id'] ?>" class="btn btn-sm btn-primary">Ver Detalles</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No tienes pedidos registrados.</p>
                <div class="d-flex justify-content-center mt-4">
                    <a href="productos.php" class="btn btn-custom">Ir a Comprar</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
