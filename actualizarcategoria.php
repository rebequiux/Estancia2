<?php
include './Static/connect/bd.php';
include 'admin_layout.php'; 

if (!$conn) {
    die("<div class='alert alert-danger'>Error al conectar con la base de datos: " . mysqli_connect_error() . "</div>");
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("<div class='alert alert-danger'>ID no válido o no proporcionado.</div>");
}

$ID = (int)$_GET['id'];
$nombre = '';
$descripcion = '';

// Obtener los datos de la categoría
$query = "SELECT * FROM categorias WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $ID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $nombre = $row['nombre'];
    $descripcion = $row['descripcion'];
} else {
    die("<div class='alert alert-danger'>Categoría no encontrada.</div>");
}

$mensaje = ''; // Variable para mensajes

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizarcategoria'])) {
    $nombreNuevo = trim($_POST['nombre']);
    $descripcionNueva = trim($_POST['descripcion']);

    if (!empty($nombreNuevo) && !empty($descripcionNueva)) {
        // Verificar si el nombre ya existe
        $checkQuery = "SELECT * FROM categorias WHERE nombre = ? AND id != ?";
        $stmt = $conn->prepare($checkQuery);
        $stmt->bind_param('si', $nombreNuevo, $ID);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            $mensaje = "<div class='alert alert-warning'>La categoría '$nombreNuevo' ya existe. Intente con otro nombre.</div>";
        } else {
            // Actualizar categoría
            $updateQuery = "UPDATE categorias SET nombre = ?, descripcion = ? WHERE id = ?";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bind_param('ssi', $nombreNuevo, $descripcionNueva, $ID);

            if ($stmt->execute()) {
                $mensaje = "<div class='alert alert-success'>Categoría actualizada correctamente.</div>";
                $nombre = $nombreNuevo; // Actualizar los valores mostrados en el formulario
                $descripcion = $descripcionNueva;
            } else {
                $mensaje = "<div class='alert alert-danger'>Error al actualizar la categoría: " . $conn->error . "</div>";
            }
        }
    } else {
        $mensaje = "<div class='alert alert-danger'>Todos los campos son obligatorios.</div>";
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Categoría</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        /* Estilos CSS (sin cambios) */
    </style>
</head>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="formulario">
                    <h1>Actualizar Categoría</h1>

                    <?php if (!empty($mensaje)) echo $mensaje; ?>

                    <form action="actualizarcategoria.php?id=<?php echo htmlspecialchars($ID); ?>" method="POST">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la Categoría:</label>
                            <input type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" class="form-control formulario_input" required>
                        </div>
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción de la Categoría:</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa una descripción" required></textarea>                        </div>
                        <div class="mb-3">
                            <input type="submit" name="actualizarcategoria" value="Actualizar" class="btn btn-morado w-100">
                        </div>
                        <div class="text-center">
                            <p><a href="gestioncategorias.php" class="back-btn"><img src="./Static/img/back.png" alt="Regresar" style="width: 20px;"> Volver</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
