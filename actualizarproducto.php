<?php
ob_start(); // Inicia el buffer de salida
include './Static/connect/bd.php';
include 'admin_layout.php';

// Verificar si se proporcionó el ID del producto
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Error: ID del producto no proporcionado.";
    exit;
}

// Si el formulario fue enviado, procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizarproducto'])) {
    $producto = trim($_POST['producto']);
    $descripcion = trim($_POST['descripcion']);
    $precio = trim($_POST['precio']);
    $fecha_vencimiento = trim($_POST['fecha_vencimiento']);
    $proveedor = intval($_POST['proveedor']);
    $categoria_id = intval($_POST['categoria_id']);

    // Validar los campos
    if ($producto && $descripcion && is_numeric($precio) && $proveedor > 0 && $categoria_id > 0) {
        $query_update = "
            UPDATE productos 
            SET producto = ?, descripcion = ?, precio = ?, fecha_vencimiento = ?, proveedor = ?, categoria_id = ? 
            WHERE id = ?";
        $stmt = $conn->prepare($query_update);
        $stmt->bind_param(
            'ssdsiid',
            $producto,
            $descripcion,
            $precio,
            $fecha_vencimiento,
            $proveedor,
            $categoria_id,
            $id
        );

        if ($stmt->execute()) {
            header("Location: gestionproductos.php?success=Producto actualizado correctamente");
            exit;
        } else {
            echo "Error al actualizar el producto: " . $stmt->error;
        }
    } else {
        echo "Error: Verifique que todos los campos sean válidos.";
    }
}

// Obtener los datos actuales del producto
$query_producto = "SELECT * FROM productos WHERE id = ?";
$stmt = $conn->prepare($query_producto);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $producto_data = $result->fetch_assoc();
    $producto = $producto_data['producto'] ?? '';
    $descripcion = $producto_data['descripcion'] ?? '';
    $precio = $producto_data['precio'] ?? '';
    $fecha_vencimiento = $producto_data['fecha_vencimiento'] ?? '';
    $proveedor = $producto_data['proveedor'] ?? '';
    $categoria_id = $producto_data['categoria_id'] ?? '';
} else {
    echo "Error: Producto no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Producto</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Open Sans', sans-serif; }
        .formulario { background-color: #6f42c1; padding: 40px; border-radius: 12px; color: white; }
        .btn-purple { background-color: #6f42c1; border: none; padding: 12px; border-radius: 8px; }
        .btn-purple:hover { background-color: #5a2e99; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="formulario mx-auto col-lg-6 col-md-8 col-sm-10">
            <h1>Actualizar Producto</h1>
            <form action="actualizarproducto.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
                <div class="mb-3">
                    <label for="producto" class="form-label">Nombre del Producto:</label>
                    <input type="text" name="producto" id="producto" value="<?php echo htmlspecialchars($producto); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción:</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control" required><?php echo htmlspecialchars($descripcion); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio del Producto:</label>
                    <input type="number" step="0.01" name="precio" id="precio" value="<?php echo htmlspecialchars($precio); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_vencimiento" class="form-label">Fecha de Vencimiento:</label>
                    <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" value="<?php echo htmlspecialchars($fecha_vencimiento); ?>" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="proveedor" class="form-label">Proveedor:</label>
                    <select id="proveedor" name="proveedor" class="form-select" required>
                        <?php
                        $query_proveedores = "SELECT id, nombre FROM proveedores";
                        $result_proveedores = mysqli_query($conn, $query_proveedores);
                        while ($row_proveedor = mysqli_fetch_assoc($result_proveedores)) {
                            $selected = ($proveedor == $row_proveedor['id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row_proveedor['id']) . "' $selected>" . htmlspecialchars($row_proveedor['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoría:</label>
                    <select id="categoria" name="categoria_id" class="form-select" required>
                        <?php
                        $query_categorias = "SELECT id, nombre FROM categorias";
                        $result_categorias = mysqli_query($conn, $query_categorias);
                        while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
                            $selected = ($categoria_id == $row_categoria['id']) ? 'selected' : '';
                            echo "<option value='" . htmlspecialchars($row_categoria['id']) . "' $selected>" . htmlspecialchars($row_categoria['nombre']) . "</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="actualizarproducto" class="btn btn-purple w-100">Actualizar</button>
                <div class="text-center mt-3">
                    <a href="gestionproductos.php">Volver a Gestión</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
