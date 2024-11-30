
<?php
include './Static/connect/bd.php'; 

// Inicializar mensajes de error o éxito
$error_message = "";
$success_message = "";

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = trim($_POST['usuario']);
    $contrasena = trim($_POST['contrasena']);
    $correo = trim($_POST['correo']);
    $tipo_usuario = trim($_POST['tipo_usuario']);

    if (!empty($usuario) && !empty($contrasena) && !empty($correo) && !empty($tipo_usuario)) {
        // Validar si ya existe un usuario con el mismo nombre o correo
        $check_sql = "SELECT * FROM usuarios WHERE usuario = ? OR correo = ?";
        $stmt = mysqli_prepare($conn, $check_sql);
        mysqli_stmt_bind_param($stmt, "ss", $usuario, $correo);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error_message = "Error: El usuario o correo ya existe.";
        } else {
            // Insertar solo si no hay duplicados
            $sql = "INSERT INTO usuarios (usuario, contrasena, correo, tipo_usuario) VALUES ('$usuario', '$contrasena', '$correo', '$tipo_usuario')";
            $stmt = mysqli_prepare($conn, $sql);
            
            if (mysqli_stmt_execute($stmt)) {
                $success_message = "Usuario creado con éxito.";
            } else {
                $error_message = "Error al crear el usuario: " . mysqli_error($conn);
            }
        }
        mysqli_stmt_close($stmt);
    } else {
        $error_message = "Todos los campos obligatorios deben ser completados.";
    }
}