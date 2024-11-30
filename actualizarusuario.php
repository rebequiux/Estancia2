<?php include 'admin_layout.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Angeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Open Sans', sans-serif;
        }
        .bg-morado {
            background-color: #6f42c1;
        }
        .text-morado {
            color: #6f42c1;
        }
        .card-custom {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .card-header-custom {
            background-color: #6f42c1;
            color: white;
        }
        .form-control-custom, .form-select-custom {
            border-radius: 10px;
            border: 1px solid #6f42c1;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: white;
            border-radius: 10px;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5a2e96;
        }
        .btn-link-custom {
            color: #6f42c1;
        }
        .btn-link-custom:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
<?php
include './Static/connect/bd.php'; 

// Inicializar variables
$id = '';
$usuario = '';
$contrasena = '';
$correo = '';
$tipo_usuario = '';

// Validar si hay un ID en GET
if (isset($_GET['id_usuarios'])) {
    $id = intval($_GET['id_usuarios']); // Convertir a entero para evitar errores
    echo "<p style='color: red;'>Depuración: ID recibido es $id</p>"; // Depuración temporal
    $query = "SELECT * FROM usuarios WHERE id_usuarios=$id;";
    $resul = mysqli_query($conn, $query);

    if ($resul && mysqli_num_rows($resul) == 1) {
        $row = mysqli_fetch_assoc($resul);
        $usuario = $row['usuario'];
        $contrasena = $row['contrasena'];
        $correo = $row['correo'];
        $tipo_usuario = $row['tipo_usuario'];
    } else {
        die("<div class='alert alert-danger text-center'>Error: Usuario no encontrado con el ID proporcionado.</div>");
    }
} else {
    die("<div class='alert alert-danger text-center'>Error: ID de usuario no proporcionado.</div>");
}

// Procesar formulario de actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['actualizarusuario'])) {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);
    $correo = mysqli_real_escape_string($conn, $_POST['correo']);
    $tipo_usuario = mysqli_real_escape_string($conn, $_POST['tipo_usuario']);
    
    $sql = "UPDATE usuarios SET usuario='$usuario', contrasena='$contrasena', correo='$correo', tipo_usuario='$tipo_usuario' WHERE id_usuarios='$id';";
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>
            Swal.fire({
                title: '¡Éxito!',
                text: 'Usuario actualizado correctamente.',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'gestionusuarios.php';
                }
            });
        </script>";
        exit();
    } else {
        echo "<div class='alert alert-danger text-center'>Error al actualizar el usuario.</div>";
    }
}
?>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-header card-header-custom text-center">
                    <h3>Actualizar Usuario</h3>
                </div>
                <div class="card-body bg-white">
                    <form action="actualizarusuario.php?id_usuarios=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="usuario" class="form-label text-morado">Usuario</label>
                            <input type="text" name="usuario" id="usuario" value="<?php echo htmlspecialchars($usuario); ?>" class="form-control form-control-custom" required>
                        </div>

                        <div class="mb-3">
                            <label for="contrasena" class="form-label text-morado">Contraseña</label>
                            <input type="text" name="contrasena" id="contrasena" value="<?php echo htmlspecialchars($contrasena); ?>" class="form-control form-control-custom" required>
                        </div>

                        <div class="mb-3">
                            <label for="correo" class="form-label text-morado">Correo</label>
                            <input type="email" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" class="form-control form-control-custom" required>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_usuario" class="form-label text-morado">Tipo de Usuario</label>
                            <select name="tipo_usuario" id="tipo_usuario" class="form-select form-select-custom">
                                <option value="cliente" <?php if ($tipo_usuario == 'cliente') echo 'selected'; ?>>Cliente</option>
                                <option value="empleado" <?php if ($tipo_usuario == 'empleado') echo 'selected'; ?>>Empleado</option>
                                <option value="admin" <?php if ($tipo_usuario == 'admin') echo 'selected'; ?>>Administrador</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" name="actualizarusuario" class="btn btn-custom">Actualizar</button>
                        </div>

                        <div class="text-center mt-3">
                            <a href="gestionusuarios.php" class="btn btn-link btn-link-custom">Regresar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
