<?php
include './Static/connect/bd.php'; 

// Verificar la conexión a la base de datos
if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

// Inicialización de variables
$producto = $descripcion = $precio = $fecha_vencimiento = $proveedor = $categoria = "";
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recuperar valores del formulario con validación
    $producto = isset($_POST['producto']) ? trim($_POST['producto']) : null;
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : null;
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : null;
    $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? trim($_POST['fecha_vencimiento']) : null;
    $proveedor = isset($_POST['proveedor']) ? trim($_POST['proveedor']) : null;
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : null;

    // Validar que todos los campos estén completos
    if ($producto && $descripcion && $precio && $fecha_vencimiento && $proveedor && $categoria) {
        // Validar que el precio sea numérico
        if (!is_numeric($precio)) {
            $error_message = "El precio debe ser un valor numérico.";
        } else {
            // Comprobar si el producto ya existe
            $check_sql = "SELECT COUNT(*) as total FROM productos WHERE LOWER(producto) = LOWER(?)";
            $check_stmt = mysqli_prepare($conn, $check_sql);
            
            if ($check_stmt) {
                mysqli_stmt_bind_param($check_stmt, "s", $producto);
                mysqli_stmt_execute($check_stmt);
                $result = mysqli_stmt_get_result($check_stmt);
                $row = mysqli_fetch_assoc($result);

                if ($row['total'] > 0) {
                    $error_message = "El producto '$producto' ya existe.";
                } else {
                    // Preparar la consulta para insertar el nuevo producto
                    $sql = "INSERT INTO productos (producto, descripcion, precio, fecha_vencimiento, proveedor, categoria_id) 
                            VALUES (?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_prepare($conn, $sql);

                    if ($stmt) {
                        // Vincular parámetros
                        mysqli_stmt_bind_param($stmt, "sssssi", $producto, $descripcion, $precio, $fecha_vencimiento, $proveedor, $categoria);

                        // Ejecutar la consulta
                        if (mysqli_stmt_execute($stmt)) {
                            // Redirigir en caso de éxito
                            header("Location: crearproducto.php");
                            exit();
                        } else {
                            $error_message = "Error al crear el producto: " . mysqli_error($conn);
                        }

                        mysqli_stmt_close($stmt);
                    } else {
                        $error_message = "Error en la preparación de la consulta: " . mysqli_error($conn);
                    }
                }

                mysqli_stmt_close($check_stmt);
            } else {
                $error_message = "Error en la consulta de validación: " . mysqli_error($conn);
            }
        }
    } else {
        $error_message = "Todos los campos obligatorios deben ser completados.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alta Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Alta de Producto</h2>

    <!-- Mostrar mensaje de error -->
    <?php if ($error_message): ?>
        <div class="alert alert-danger text-center">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <!-- Formulario -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="producto" class="form-label">Producto:</label>
            <input type="text" name="producto" id="producto" class="form-control" value="<?php echo htmlspecialchars($producto); ?>" required>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" rows="3" required><?php echo htmlspecialchars($descripcion); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio:</label>
            <input type="text" name="precio" id="precio" class="form-control" value="<?php echo htmlspecialchars($precio); ?>" required>
        </div>
        <div class="mb-3">
            <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
            <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="<?php echo htmlspecialchars($fecha_vencimiento); ?>" required>
        </div>
        <div class="mb-3">
            <label for="proveedor" class="form-label">Proveedor:</label>
            <select name="proveedor" id="proveedor" class="form-select" required>
                <option value="">Selecciona un proveedor</option>
                <option value="1" <?php if ($proveedor == "1") echo "selected"; ?>>Barcel</option>
                <option value="2" <?php if ($proveedor == "2") echo "selected"; ?>>Marinela</option>
                <option value="3" <?php if ($proveedor == "3") echo "selected"; ?>>Sabritas</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría:</label>
            <select name="categoria" id="categoria" class="form-select" required>
                <option value="">Selecciona una categoría</option>
                <option value="1" <?php if ($categoria == "1") echo "selected"; ?>>Panadería</option>
                <option value="3" <?php if ($categoria == "3") echo "selected"; ?>>Sabritas</option>
                <option value="4" <?php if ($categoria == "4") echo "selected"; ?>>Alcohol</option>
                <option value="5" <?php if ($categoria == "5") echo "selected"; ?>>Lácteos</option>
            </select>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Guardar Producto</button>
        </div>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
