<?php
include 'empleado_layout.php';
include './Static/connect/bd.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $productos_raw = mysqli_real_escape_string($conn, $_POST['productos']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);
    $hora = mysqli_real_escape_string($conn, $_POST['hora']);

    $productos = [];
    $total_pedido = 0;

    // Buscar ID del usuario en la base de datos
    $sql_usuario = "SELECT id_usuarios FROM usuarios WHERE usuario = '$usuario' LIMIT 1";
    $result_usuario = mysqli_query($conn, $sql_usuario);

    if ($row_usuario = mysqli_fetch_assoc($result_usuario)) {
        $usuario_id = $row_usuario['id_usuarios'];
    } else {
        $_SESSION['error'] = "El usuario '$usuario' no fue encontrado.";
        header('Location: crearpedido2.php');
        exit;
    }

    // Procesar productos
    $productos_lista = explode(',', $productos_raw);
    foreach ($productos_lista as $producto) {
        preg_match('/(\d+)x (.+)/', trim($producto), $matches);
        if (count($matches) === 3) {
            $cantidad = intval($matches[1]);
            $producto_nombre = trim($matches[2]);

            // Buscar producto
            $sql_producto = "SELECT id, precio FROM productos WHERE producto = '$producto_nombre' LIMIT 1";
            $result_producto = mysqli_query($conn, $sql_producto);

            if ($row_producto = mysqli_fetch_assoc($result_producto)) {
                $producto_id = $row_producto['id'];
                $precio_unitario = $row_producto['precio'];
                $subtotal = $cantidad * $precio_unitario;
                $total_pedido += $subtotal;

                $productos[] = [
                    'id' => $producto_id,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precio_unitario,
                    'subtotal' => $subtotal,
                ];
            } else {
                $_SESSION['error'] = "El producto '$producto_nombre' no existe.";
                header('Location: crearpedido2.php');
                exit;
            }
        } else {
            $_SESSION['error'] = "Formato de productos incorrecto. Usa el formato '1x ProductoA, 2x ProductoB'.";
            header('Location: crearpedido2.php');
            exit;
        }
    }

    // Insertar pedido
    $fecha_hora = "$fecha $hora";
    $sql_pedido = "INSERT INTO pedidos (cliente_id, fecha, total, estado) VALUES ($usuario_id, '$fecha_hora', $total_pedido, 'Pendiente')";
    if (mysqli_query($conn, $sql_pedido)) {
        $pedido_id = mysqli_insert_id($conn);

        // Insertar detalles
        foreach ($productos as $producto) {
            $sql_detalle = "INSERT INTO detalles_pedido (pedido_id, producto_id, cantidad, precio_unitario)
                            VALUES ($pedido_id, {$producto['id']}, {$producto['cantidad']}, {$producto['precio_unitario']})";
            mysqli_query($conn, $sql_detalle);
        }

        $_SESSION['success'] = "Pedido registrado correctamente con ID $pedido_id.";
    } else {
        $_SESSION['error'] = "Error al registrar el pedido: " . mysqli_error($conn);
    }

    header('Location: gestionpedidos2.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Pedido</title>
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
        <h2 class="text-center">Crear Pedido</h2>
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
        <form method="POST" action="crearpedido2.php">
            <div class="mb-4">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre del usuario" value="<?php echo isset($_POST['usuario']) ? htmlspecialchars($_POST['usuario']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="productos" class="form-label">Productos:</label>
                <input type="text" id="productos" name="productos" class="form-control" placeholder="1x ProductoA, 2x ProductoB" value="<?php echo isset($_POST['productos']) ? htmlspecialchars($_POST['productos']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="hora" class="form-label">Hora:</label>
                <input type="time" id="hora" name="hora" class="form-control" value="<?php echo isset($_POST['hora']) ? htmlspecialchars($_POST['hora']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="<?php echo isset($_POST['fecha']) ? htmlspecialchars($_POST['fecha']) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Registrar Pedido</button>
        </form>
        <div class="mt-3 text-center">
            <a href="gestionpedidos2.php" class="btn btn-link">Regresar</a>
        </div>
    </div>
</body>
</html>
