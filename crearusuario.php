<?php include './Static/connect/bd.php'; ?>
<?php include 'admin_layout.php'; ?>
<?php
// Inicializar variables para evitar errores
$error_message = '';
$success_message = '';

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturar los datos enviados
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $correo = trim($_POST['correo']);
    $tipo_usuario = $_POST['tipo_usuario'];

    // Validar el correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Error: El formato del correo es inválido.";
    } elseif (empty($usuario) || empty($contrasena) || empty($correo)) {
        $error_message = "Error: Todos los campos son obligatorios.";
    } else {
        // Verificar si el correo ya está registrado
        $sql = "SELECT id_usuarios FROM usuarios WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            // Si el correo ya está registrado
            $error_message = "Error: El correo ya está registrado con otro usuario.";
        } else {
            // Si el correo no está registrado, insertar los datos en la base de datos
            $stmt = $conn->prepare("INSERT INTO usuarios (usuario, contrasena, correo, tipo_usuario) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $usuario, $contrasena, $correo, $tipo_usuario);
            if ($stmt->execute()) {
                $success_message = "Éxito: El usuario ha sido creado correctamente.";
            } else {
                $error_message = "Error al guardar el usuario: " . $conn->error;
            }
        }

        $stmt->close();
    }
}

// Cerrar la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <link rel="stylesheet" href="./Static/css/Style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .text-purple {
            color: #6a1b9a; 
        }
        .btn-purple {
            background-color: #6a1b9a;
            border-color: #6a1b9a;
            font-size: 1.2rem; /* Botón más grande */
            padding: 15px 30px; /* Botón más grande */
        }
        .btn-purple:hover {
            background-color: #9c4d97;
            border-color: #9c4d97;
        }
        .card-header {
            background-color: #6a1b9a;
            color: white;
        }
        .card-body {
            font-size: 1.2rem; /* Texto más grande */
        }
        .form-control, .form-select {
            font-size: 1.2rem; /* Entrada de texto más grande */
            padding: 15px; /* Aumentar el padding */
        }
        .container {
            max-width: 900px; /* Mayor ancho de contenedor */
        }
        .mb-3 {
            margin-bottom: 1.5rem; /* Espacio más grande entre los campos */
        }
        .card {
            padding: 30px; /* Más espacio dentro de la tarjeta */
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-12 text-center mb-5">
                <h1 class="text-primary">
                    Abarrotes <span class="fw-bold text-purple">Angeles</span>
                </h1>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 rounded-4 shadow-lg">
                    <div class="card-header text-center">
                        <h3>Crear Usuario</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar mensajes -->
                        <?php if ($error_message): ?>
                            <div class="alert alert-danger text-center">
                                <?php echo htmlspecialchars($error_message); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($success_message): ?>
                            <div class="alert alert-success text-center">
                                <?php echo htmlspecialchars($success_message); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            <div class="mb-3">
                                <label for="usuario" class="form-label">Usuario:</label>
                                <input type="text" id="usuario" name="usuario" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña:</label>
                                <input type="password" id="contrasena" name="contrasena" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo:</label>
                                <input type="email" id="correo" name="correo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuario:</label>
                                <select id="tipo_usuario" name="tipo_usuario" class="form-select" required>
                                    <option value="cliente">Cliente</option>
                                    <option value="empleado">Empleado</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-purple text-white px-5 py-2">Enviar Datos</button>
                            </div>
                        </form>

                        <div class="mt-4 text-center">
                            <a href="gestionusuarios.php" class="btn btn-outline-primary btn-sm">Regresar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>  
