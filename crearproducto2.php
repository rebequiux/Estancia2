<style>
        body {
            font-family: 'PT Sans', sans-serif;
            background-color: #f8f9fa;
        }

        .container-custom {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 1000px;
            margin-left: 16rem;
        }

        .titulo {
            color: #6f42c1;
        }

        .campo {
            margin-bottom: 15px;
        }

        .label {
            font-weight: bold;
            color: #6f42c1;
        }

        .input-custom {
            border: 1px solid #6f42c1;
            border-radius: 5px;
        }

        .btn-custom {
            background-color: #6f42c1;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background-color: #5a3591;
        }

        .btn-back {
            background-color: #6c757d;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>

<?php
include 'empleado_layout.php';
include './Static/connect/bd.php';

// Inicialización de variables
$producto = $descripcion = $precio = $fecha_vencimiento = $proveedor = $categoria = "";
$error_message = "";
$success_message = "";

// Validar el método POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $producto = isset($_POST['producto']) ? trim($_POST['producto']) : "";
    $descripcion = isset($_POST['descripcion']) ? trim($_POST['descripcion']) : "";
    $precio = isset($_POST['precio']) ? trim($_POST['precio']) : "";
    $fecha_vencimiento = isset($_POST['fecha_vencimiento']) ? trim($_POST['fecha_vencimiento']) : "";
    $proveedor = isset($_POST['proveedor']) ? trim($_POST['proveedor']) : "";
    $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : "";

    // Validación de campos vacíos
    if (!$producto || !$descripcion || !$precio || !$fecha_vencimiento || !$proveedor || !$categoria) {
        $error_message = "Todos los campos son obligatorios. Por favor, complétalos.";
    } elseif (!is_numeric($precio)) { // Validar que el precio sea numérico
        $error_message = "El precio debe ser un valor numérico.";
    } else {
        // Comprobar si el producto ya existe en la base de datos
        $check_sql = "SELECT COUNT(*) as total FROM productos WHERE LOWER(producto) = LOWER(?)";
        $check_stmt = mysqli_prepare($conn, $check_sql);

        if ($check_stmt) {
            mysqli_stmt_bind_param($check_stmt, "s", $producto);
            mysqli_stmt_execute($check_stmt);
            $result = mysqli_stmt_get_result($check_stmt);
            $row = mysqli_fetch_assoc($result);

            if ($row['total'] > 0) {
                $error_message = "El producto '$producto' ya existe en la base de datos.";
            } else {
                // Intentar guardar el producto
                $sql = "INSERT INTO productos (producto, descripcion, precio, fecha_vencimiento, proveedor, categoria_id) 
                        VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = mysqli_prepare($conn, $sql);

                if ($stmt) {
                    mysqli_stmt_bind_param($stmt, "sssssi", $producto, $descripcion, $precio, $fecha_vencimiento, $proveedor, $categoria);
                    if (mysqli_stmt_execute($stmt)) {
                        $success_message = "Producto guardado exitosamente.";
                        // Limpiar los campos después de guardar correctamente
                        $producto = $descripcion = $precio = $fecha_vencimiento = $proveedor = $categoria = "";
                    } else {
                        $error_message = "Error al guardar el producto: " . mysqli_error($conn);
                    }
                    mysqli_stmt_close($stmt);
                } else {
                    $error_message = "Error al preparar la consulta: " . mysqli_error($conn);
                }
            }

            mysqli_stmt_close($check_stmt);
        } else {
            $error_message = "Error en la consulta de validación: " . mysqli_error($conn);
        }
    }
}

// Obtener proveedores dinámicamente
$proveedores = [];
$query_proveedores = "SELECT id, nombre FROM proveedores";
$result_proveedores = mysqli_query($conn, $query_proveedores);

if ($result_proveedores) {
    while ($row_proveedor = mysqli_fetch_assoc($result_proveedores)) {
        $proveedores[] = $row_proveedor;
    }
}

// Obtener categorías dinámicamente
$categorias = [];
$query_categorias = "SELECT id, nombre FROM categorias";
$result_categorias = mysqli_query($conn, $query_categorias);

if ($result_categorias) {
    while ($row_categoria = mysqli_fetch_assoc($result_categorias)) {
        $categorias[] = $row_categoria;
    }
}
?>
<head>
    <!-- (Contenido del <head> permanece igual) -->
</head>
<body>

<div class="container mt-5">
    <div class="container-custom">
        <h2 class="titulo text-center mb-4">Crear Nuevo Producto</h2>

        <!-- Mostrar mensajes -->
        <?php if ($error_message): ?>
            <div class="alert alert-danger text-center"><?php echo $error_message; ?></div>
        <?php elseif ($success_message): ?>
            <div class="alert alert-success text-center"><?php echo $success_message; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="campo">
                <label for="producto" class="label">Producto:</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-box"></i></span>
                    <input type="text" name="producto" id="producto" class="form-control input-custom" 
                           placeholder="Nombre del producto" value="<?php echo htmlspecialchars($producto); ?>">
                </div>
            </div>

            <div class="campo">
                <label for="descripcion" class="label">Descripción:</label>
                <textarea name="descripcion" id="descripcion" class="form-control input-custom" 
                          rows="3" placeholder="Descripción del producto"><?php echo htmlspecialchars($descripcion); ?></textarea>
            </div>

            <div class="campo">
                <label for="precio" class="label">Precio:</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="text" name="precio" id="precio" class="form-control input-custom" 
                           placeholder="0.00" value="<?php echo htmlspecialchars($precio); ?>">
                </div>
            </div>

            <div class="campo">
                <label for="fecha_vencimiento" class="label">Fecha de Vencimiento:</label>
                <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control input-custom" 
                       value="<?php echo htmlspecialchars($fecha_vencimiento); ?>">
            </div>

            <div class="campo">
                <label for="proveedor" class="label">Proveedor:</label>
                <select name="proveedor" id="proveedor" class="form-select input-custom">
                    <option value="">Selecciona un proveedor</option>
                    <?php foreach ($proveedores as $prov): ?>
                        <option value="<?php echo $prov['id']; ?>" 
                            <?php echo ($proveedor == $prov['id']) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($prov['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="categoria" class="label">Categoría:</label>
                <select name="categoria" id="categoria" class="form-select input-custom">
                    <option value="">Selecciona una categoría</option>
                    <?php foreach ($categorias as $cat): ?>
                        <option value="<?php echo $cat['id']; ?>" 
                            <?php echo ($categoria == $cat['id']) ? "selected" : ""; ?>>
                            <?php echo htmlspecialchars($cat['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-custom">Guardar Producto</button>
                <a href="gestionproductos2.php" class="btn btn-back">Regresar</a>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
