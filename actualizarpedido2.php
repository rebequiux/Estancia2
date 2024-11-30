<?php
ob_start(); // Inicia el búfer de salida
include 'empleado_layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f9f6ff;
            font-family: 'PT Sans', sans-serif;
        }
        .formulario {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #fff;
            border: 2px solid #dcd4f7;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .formulario h1 {
            color: #6a1b9a;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }
        .formulario label {
            font-weight: bold;
            color: #6a1b9a;
        }
        .formulario input,
        .formulario select {
            border: 1px solid #dcd4f7;
        }
        .formulario .btn {
            background-color: #6a1b9a;
            color: white;
            border: none;
        }
        .formulario .btn:hover {
            background-color: #8e44ad;
        }
        .formulario a {
            color: #6a1b9a;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .formulario a img {
            margin-right: 5px;
        }
    </style>
</head>
<body>

<?php
include './Static/connect/bd.php'; 

if (isset($_GET['id'])) {
    $ID = intval($_GET['id']); // Asegurarse de que es un entero
    $query = "
        SELECT p.*, u.usuario AS usuario_nombre 
        FROM pedidos p
        INNER JOIN usuarios u ON p.cliente_id = u.id_usuarios
        WHERE p.id = $ID;
    ";
    $resul = mysqli_query($conn, $query);

    if ($resul && mysqli_num_rows($resul) == 1) {
        $row = mysqli_fetch_array($resul);
        $cliente_id = $row['cliente_id'];
        $usuario_nombre = $row['usuario_nombre'];
        $total = $row['total'];
        $estado = $row['estado'];
        $fecha = explode(' ', $row['fecha'])[0]; // Solo la parte de la fecha
    } else {
        echo "<div class='alert alert-danger'>No se encontró el pedido.</div>";
        exit();
    }
} else {
    echo "<div class='alert alert-danger'>No se proporcionó un ID válido.</div>";
    exit();
}

if (isset($_POST['actualizarpedido'])) {
    $id = intval($_GET['id']);
    $cliente_id = intval(mysqli_real_escape_string($conn, $_POST['cliente_id']));
    $total = floatval(mysqli_real_escape_string($conn, $_POST['total']));
    $estado = mysqli_real_escape_string($conn, $_POST['estado']);
    $fecha = mysqli_real_escape_string($conn, $_POST['fecha']);

    $sql = "UPDATE pedidos 
            SET cliente_id = '$cliente_id', total = '$total', estado = '$estado', fecha = '$fecha' 
            WHERE id = '$id';";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Pedido actualizado correctamente.";
        header("Location: gestionpedidos2.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error al actualizar el pedido: " . mysqli_error($conn) . "</div>";
    }
}
?>

<div class="container">
    <div class="formulario">
        <h1>Actualizar Pedido</h1>
        <form action="actualizarpedido2.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="mb-3">
                <label for="cliente_id" class="form-label">Cliente ID:</label>
                <input type="text" name="cliente_id" id="cliente_id" value="<?php echo $cliente_id; ?>" class="form-control" required>
                <small class="form-text text-muted">Cliente actual: <?php echo htmlspecialchars($usuario_nombre); ?></small>
            </div>

            <div class="mb-3">
                <label for="total" class="form-label">Total:</label>
                <input type="number" step="0.01" name="total" id="total" value="<?php echo $total; ?>" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="Pendiente" <?php echo ($estado == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                    <option value="Pagado" <?php echo ($estado == 'Pagado') ? 'selected' : ''; ?>>Pagado</option>
                    <option value="Cancelado" <?php echo ($estado == 'Cancelado') ? 'selected' : ''; ?>>Cancelado</option>
                    <option value="Vendido" <?php echo ($estado == 'Vendido') ? 'selected' : ''; ?>>Vendido</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" name="fecha" id="fecha" value="<?php echo $fecha; ?>" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" name="actualizarpedido" class="btn btn-primary w-100">Actualizar</button>
            </div>
        </form>
        <div class="mt-3 text-center">
            <a href="gestionpedidos2.php">
                <img src="./Static/img/back.png" alt="Regresar" width="20"> Regresar
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
ob_end_flush(); // Finaliza el búfer de salida 
?>
