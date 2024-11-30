<?php
include './Static/connect/bd.php';
session_start();

// Vaciar el carrito
if (isset($_POST['confirmar_vaciar_carrito'])) {
    $_SESSION['carrito'] = [];
    header("Location: carrito.php?vaciar=1");
    exit();
}

// Cerrar sesión
if (isset($_POST['cerrar_sesion'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}

// Eliminar producto del carrito
if (isset($_POST['confirmar_eliminar_producto'])) {
    $producto_id = intval($_POST['producto_id']);
    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as $key => $item) {
            if ($item['producto_id'] == $producto_id) {
                unset($_SESSION['carrito'][$key]);
                $_SESSION['carrito'] = array_values($_SESSION['carrito']); // Reindexar el carrito
                break;
            }
        }
    }
    header("Location: carrito.php?eliminar=1");
    exit();
}

// Actualizar cantidad de producto en el carrito
if (isset($_POST['actualizar_producto'])) {
    $producto_id = intval($_POST['producto_id']);
    $nueva_cantidad = max(1, (int)$_POST['nueva_cantidad']); // Evitar cantidades menores a 1
    if (!empty($_SESSION['carrito'])) {
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['producto_id'] == $producto_id) {
                $item['cantidad'] = $nueva_cantidad;
                break;
            }
        }
    }
    header("Location: carrito.php?actualizar=1");
    exit();
}

// Guardar pedido en la base de datos
if (isset($_POST['guardar_pedido']) && !empty($_SESSION['carrito'])) {
    if (!isset($_SESSION['usuario']) || !is_array($_SESSION['usuario'])) {
        header("Location: login.php");
        exit();
    }

    $cliente_id = $_SESSION['usuario']['id_usuarios'];
    $total_precio = 0;

    // Calcular el total antes de insertar
    foreach ($_SESSION['carrito'] as $item) {
        $producto = $conn->query("SELECT precio FROM productos WHERE id = {$item['producto_id']}")->fetch_assoc();
        $total_precio += $producto['precio'] * $item['cantidad'];
    }

    // Insertar el pedido en la base de datos
    $sql_pedido = "INSERT INTO pedidos (cliente_id, fecha, total, estado) VALUES (?, NOW(), ?, 'Pendiente')";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("id", $cliente_id, $total_precio);

    if ($stmt_pedido->execute()) {
        $pedido_id = $stmt_pedido->insert_id;

        // Insertar detalles del pedido
        foreach ($_SESSION['carrito'] as $item) {
            $producto_id = $item['producto_id'];
            $cantidad = $item['cantidad'];
            $precio_unitario = $conn->query("SELECT precio FROM productos WHERE id = $producto_id")->fetch_assoc()['precio'];

            $sql_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
            $stmt_detalle = $conn->prepare($sql_detalle);
            $stmt_detalle->bind_param("iiid", $pedido_id, $producto_id, $cantidad, $precio_unitario);
            $stmt_detalle->execute();
        }

        $_SESSION['carrito'] = []; // Vaciar el carrito después de guardar
        header("Location: carrito.php?pedido_guardado=1");
        exit();
    }
    $stmt_pedido->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito Detallado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            <a class="navbar-brand" href="index.php">Principal</a>
            <div class="d-flex">
                <form method="POST">
                    <button type="submit" name="cerrar_sesion" class="btn btn-danger">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center header-text">Carrito de Compras - Vista Detallada</h1>
        <div class="mt-4">
            <?php if (!empty($_SESSION['carrito'])): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID Producto</th>
                                <th>Producto</th>
                                <th>Descripción</th>
                                <th>Precio Unitario</th>
                                <th>Cantidad</th>
                                <th>Subtotal</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $total_precio = 0; 
                            foreach ($_SESSION['carrito'] as $item): 
                                $producto = $conn->query("SELECT * FROM productos WHERE id = {$item['producto_id']}")->fetch_assoc();
                                $subtotal = $producto['precio'] * $item['cantidad'];
                                $total_precio += $subtotal;
                            ?>
                                <tr>
                                    <td><?= $producto['id'] ?></td>
                                    <td><?= $producto['producto'] ?></td>
                                    <td><?= $producto['descripcion'] ?></td>
                                    <td>$<?= number_format($producto['precio'], 2) ?> MXN</td>
                                    <td>
                                        <form method="POST">
                                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                            <input type="number" name="nueva_cantidad" min="1" class="form-control d-inline" style="width: 70px;" value="<?= $item['cantidad'] ?>">
                                            <button type="submit" name="actualizar_producto" class="btn btn-primary btn-sm">Actualizar</button>
                                        </form>
                                    </td>
                                    <td>$<?= number_format($subtotal, 2) ?> MXN</td>
                                    <td>
                                        <form method="POST" style="display:inline;">
                                            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                            <button type="submit" name="confirmar_eliminar_producto" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-secondary">
                                <td colspan="5" class="text-end"><strong>Total:</strong></td>
                                <td><strong>$<?= number_format($total_precio, 2) ?> MXN</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="d-flex justify-content-center mt-4 gap-3">
                    <button class="btn btn-danger" onclick="confirmarVaciarCarrito()">Vaciar Carrito</button>
                    <form method="POST">
                        <button type="submit" name="guardar_pedido" class="btn btn-success">Guardar Pedido</button>
                    </form>
                    
                        <a href="cliente.php" class="btn btn-success">Regresar a productos</a>
                   
                </div>
            <?php else: ?>
                <p class="text-center text-muted">Tu carrito está vacío.</p>
                <div class="d-flex justify-content-center mt-4 gap-3">
                    <a href="cliente.php" class="btn btn-custom">Regresar a Productos</a>
                    <a href="perfilcliente.php" class="btn btn-secondary">Perfil de Cliente</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_GET['pedido_guardado'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Pedido Guardado',
                text: 'Tu pedido ha sido guardado correctamente.',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['actualizar'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Producto Actualizado',
                text: 'La cantidad del producto fue actualizada correctamente.',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['eliminar'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Producto Eliminado',
                text: 'El producto fue eliminado correctamente del carrito.',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <?php if (isset($_GET['vaciar'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Carrito Vaciado',
                text: 'Todos los productos fueron eliminados del carrito.',
                confirmButtonText: 'Aceptar'
            });
        </script>
    <?php endif; ?>

    <script>
        function confirmarVaciarCarrito() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Se eliminarán todos los productos del carrito.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, vaciar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'confirmar_vaciar_carrito';
                    form.appendChild(input);
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
