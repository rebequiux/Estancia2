<?php 
include './Static/connect/bd.php';

// Inicializa un array para errores
$errores = [];

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $correo = trim($_POST['correo']);

    // Validaciones
    if (empty($usuario)) {
        $errores[] = "El campo Usuario es obligatorio.";
    }
    if (empty($contrasena)) {
        $errores[] = "El campo Contraseña es obligatorio.";
    }
    if (empty($correo) || !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El campo Correo es obligatorio y debe tener un formato válido.";
    }

    // Si no hay errores, proceder con la consulta de duplicidad del correo
    if (empty($errores)) {
        // Verificar si el correo ya existe
        $query_check_email = "SELECT * FROM usuarios WHERE correo = ?";
        $stmt_email = $conn->prepare($query_check_email);
        $stmt_email->bind_param("s", $correo);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();

        if ($result_email->num_rows > 0) {
            $errores[] = "El correo ya está registrado. Intente con uno diferente.";
        } else {
            // Insertar el nuevo usuario en la base de datos
            $query_insert = "INSERT INTO usuarios (usuario, contrasena, correo, tipo_usuario) VALUES (?, ?, ?, 'cliente')";
            $stmt_insert = $conn->prepare($query_insert);
            $stmt_insert->bind_param("sss", $usuario, $contrasena, $correo);

            if ($stmt_insert->execute()) {
                echo "<div class='alert alert-success'>Usuario registrado correctamente.</div>";
            } else {
                $errores[] = "Error al registrar el usuario. Inténtelo más tarde.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: 'PT Sans', sans-serif; background-color: #f8f9fa; color: #5a5a5a; }
        .container { max-width: 500px; background-color: white; border-radius: 8px; box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1); padding: 2rem; margin-top: 5rem; }
        .btn-primary { background-color: #6f42c1; border: none; }
        .btn-primary:hover { background-color: #5a2c94; }
        .form-label { color: #6f42c1; }
        h2 { color: #6f42c1; }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Registro de Usuario</h2>

        <!-- Muestra errores aquí -->
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" name="frm1" id="frm1" action="">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" id="usuario" class="form-control" value="<?php echo isset($usuario) ? htmlspecialchars($usuario) : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Password:</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo:</label>
                <input type="email" name="correo" id="correo" class="form-control" value="<?php echo isset($correo) ? htmlspecialchars($correo) : ''; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar</button>
        </form>

        <div class="text-center mt-3">
            <a href="./index.php" class="text-decoration-none" title="Inicio">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48" style="fill:#6f42c1;">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9 C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52 C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                </svg>
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
