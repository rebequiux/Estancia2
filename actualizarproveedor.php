<?php
session_start();
include 'admin_layout.php';
include './Static/connect/bd.php';

// Initialize variables
$nombre = '';
$descripcion = '';
$producto = '';
$fecha_abastecimiento = '';
$precio = '';
$message = '';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $ID = (int)$_GET['id'];
    $query = "SELECT * FROM proveedores WHERE id=$ID;";
    $resul = mysqli_query($conn, $query);

    if (mysqli_num_rows($resul) == 1) {
        $row = mysqli_fetch_array($resul);
        $nombre = $row['nombre'];
        $descripcion = $row['descripcion'];
    } else {
        $message = "<p class='text-danger'>No se encontró el registro.</p>";
    }
} else {
    $message = "<p class='text-danger'>ID no especificado o no válido.</p>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $producto = mysqli_real_escape_string($conn, $_POST['producto']);
    $fecha_abastecimiento = mysqli_real_escape_string($conn, $_POST['fecha_abastecimiento']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);

    if (!empty($nombre) && !empty($descripcion) && !empty($producto) && !empty($fecha_abastecimiento) && !empty($precio)) {
        $sql = "UPDATE proveedores 
                SET nombre='$nombre', 
                    descripcion='$descripcion' 
                WHERE id=$ID;";
        
        $sql_producto = "INSERT INTO productos (producto, descripcion, precio, fecha_vencimiento, proveedor, categoria_id) 
                         VALUES ('$producto', 'Producto del proveedor $nombre', $precio, '$fecha_abastecimiento', $ID, 1);";
        
        if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql_producto)) {
            $message = "<p class='text-success'>Proveedor y producto actualizados con éxito.</p>";
        } else {
            $message = "<p class='text-danger'>Error al actualizar el proveedor o producto.</p>";
        }
    } else {
        $message = "<p class='text-danger'>Todos los campos son obligatorios.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Proveedor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f7f7f7;
        }
        .formulario {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .formulario h1 {
            color: #6f42c1;
            text-align: center;
            margin-bottom: 30px;
        }
        .formulario label {
            font-weight: bold;
            color: #6f42c1;
        }
        .formulario_input {
            border-radius: 5px;
            border: 1px solid #ddd;
            padding: 10px;
            width: 100%;
            margin-top: 5px;
        }
        .boton_1 {
            background-color: #6f42c1;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            width: 100%;
            cursor: pointer;
        }
        .boton_1:hover {
            background-color: #5a2a9c;
        }
        .back-btn {
            color: #6f42c1;
            text-decoration: none;
            font-size: 18px;
        }
        .back-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="formulario">
                    <h1>Actualizar Proveedor</h1>
                    
                    <?php if (!empty($message)): ?>
                        <div class="alert alert-dismissible fade show" role="alert">
                            <?php echo $message; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form action="actualizarproveedor.php?id=<?php echo $ID; ?>" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Proveedor:</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" class="form-control formulario_input" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del Proveedor:</label>
                            <textarea name="descripcion" id="descripcion" class="form-control formulario_input" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                        </div>

                        <h3 class="mt-4 mb-3">Agregar Producto al Proveedor</h3>

                        <div class="mb-3">
                            <label for="producto" class="form-label">Producto:</label>
                            <input type="text" name="producto" id="producto" value="<?php echo htmlspecialchars($producto); ?>" class="form-control formulario_input" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_abastecimiento" class="form-label">Fecha de Abastecimiento:</label>
                            <input type="date" name="fecha_abastecimiento" id="fecha_abastecimiento" value="<?php echo htmlspecialchars($fecha_abastecimiento); ?>" class="form-control formulario_input" required>
                        </div>
                        <div class="mb-3">
                            <label for="precio" class="form-label">Precio:</label>
                            <input type="number" step="0.01" name="precio" id="precio" value="<?php echo htmlspecialchars($precio); ?>" class="form-control formulario_input" required>
                        </div>

                        <div class="mb-3">
                            <input type="submit" name="actualizarcategoria" value="Actualizar" class="btn boton_1">
                        </div>

                        <div class="text-center">
                            <p><a href="gestionproveedores.php" class="back-btn"><img src="./Static/img/back.png" alt="Regresar" style="width: 20px;"> Volver</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
