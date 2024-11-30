<?php include 'admin_layout.php'; ?>
<?php
include './Static/connect/bd.php';

$message = ""; // Variable para mensajes de error o éxito

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conn, $_POST['descripcion']);
    $fecha_abastecimiento = mysqli_real_escape_string($conn, $_POST['fecha_abastecimiento']);
    $precio = mysqli_real_escape_string($conn, $_POST['precio']);
    $producto = mysqli_real_escape_string($conn, $_POST['producto']); // Nuevo campo para producto

    if (!empty($nombre) && !empty($descripcion) && !empty($fecha_abastecimiento) && !empty($precio) && !empty($producto)) {
        // Verificar duplicados en proveedores
        $checkQuery = "SELECT * FROM proveedores WHERE nombre='$nombre';";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            $message = "<div class='alert alert-danger'>El proveedor con este nombre ya existe.</div>";
        } else {
            // Insertar en proveedores
            $sqlProveedor = "INSERT INTO proveedores (nombre, descripcion, fecha_abastecimiento, precio) 
                             VALUES ('$nombre', '$descripcion', '$fecha_abastecimiento', '$precio');";
            if (mysqli_query($conn, $sqlProveedor)) {
                // Obtener el ID del proveedor recién creado
                $proveedor_id = mysqli_insert_id($conn);

                // Depuración
                error_log("Nuevo Proveedor Insertado: ID=$proveedor_id, Nombre=$nombre");

                // Insertar en productos
                $sqlProducto = "INSERT INTO productos (producto, descripcion, precio, fecha_vencimiento, proveedor, categoria_id)
                                VALUES ('$producto', 'Producto relacionado con el proveedor', '$precio', '$fecha_abastecimiento', '$proveedor_id', 1);";

                if (mysqli_query($conn, $sqlProducto)) {
                    $message = "<div class='alert alert-success'>Proveedor y producto creados exitosamente.</div>";
                } else {
                    $message = "<div class='alert alert-danger'>Error al crear el producto: " . mysqli_error($conn) . "</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Error al crear el proveedor: " . mysqli_error($conn) . "</div>";
            }
        }
    } else {
        $message = "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
    }
}
?>


<body class="bg-light d-flex align-items-center justify-content-center" style="min-height: 100vh;">
    <div class="container text-center" style="max-width: 550px;">
        <!-- Encabezado -->
        <div class="bg-purple text-white p-3 rounded mb-4">
            <h1 class="m-0">
                <i class="bi bi-shop"></i> 
                Abarrotes <span class="fw-bold">Angeles</span>
            </h1>
        </div>

        <!-- Formulario -->
        <div class="bg-white shadow p-4 rounded">
            <h2 class="text-purple mb-3">
                <i class="bi bi-tag-fill"></i> Crear Proveedor y Producto
            </h2>

            <!-- Mensajes -->
            <?php if (!empty($message)): ?>
                <div class="mb-3">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="POST" id="frm1" action="">
                <div class="mb-3">
                    <label for="nombre" class="form-label text-purple fw-bold">Nombre del proveedor:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre del proveedor" required>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label text-purple fw-bold">Descripción del proveedor:</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa una descripción" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="producto" class="form-label text-purple fw-bold">Producto:</label>
                    <input type="text" id="producto" name="producto" class="form-control" placeholder="Ingresa el producto" required>
                </div>
                <div class="mb-3">
                    <label for="fecha_abastecimiento" class="form-label text-purple fw-bold">Fecha de Abastecimiento:</label>
                    <input type="date" id="fecha_abastecimiento" name="fecha_abastecimiento" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="precio" class="form-label text-purple fw-bold">Precio:</label>
                    <input type="number" id="precio" name="precio" class="form-control" placeholder="Ingresa el precio" step="0.01" required>
                </div>
                <button type="submit" class="btn btn-purple text-white w-100">
                    <i class="bi bi-send-fill"></i> Enviar Datos
                </button>
            </form>
        </div>

        <!-- Navegación Inferior -->
        <div class="mt-3">
            <a href="gestionproveedores.php" class="btn btn-outline-purple mx-2">
                <i class="bi bi-arrow-left-circle-fill"></i> Regresar
            </a>
        </div>
    </div>

    <style>
        .bg-purple {
            background-color: #6f42c1;
        }
        .btn-purple {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }
        .btn-purple:hover {
            background-color: #5a359d;
            border-color: #5a359d;
        }
        .text-purple {
            color: #6f42c1;
        }
        .btn-outline-purple {
            border-color: #6f42c1;
            color: #6f42c1;
        }
        .btn-outline-purple:hover {
            background-color: #6f42c1;
            color: #fff;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
