<?php

include './Static/connect/bd.php'; 

session_start();

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contrasena = '$contrasena';";
$execute = mysqli_query($conn, $sql);

if (mysqli_num_rows($execute) > 0) {
    
    $row = mysqli_fetch_assoc($execute);

    if ($row['tipo_usuario'] == 'admin') {
        $_SESSION['usuario'] = $usuario;
        header('Location: admin.php');
        exit();
    } elseif ($row['tipo_usuario'] == 'empleado') {
        $_SESSION['usuario'] = $usuario;
        header('Location: empleado.php');
        exit();
    } elseif ($row['tipo_usuario'] == 'cliente') {
        $_SESSION['usuario'] = $usuario;
        header('Location: cliente.php');
        exit();
    } else {
        $_SESSION['error'] = 'Tipo de usuario no reconocido.';
        header('Location: login.php');
        exit();
    }
} else {
    $_SESSION['error'] = 'Usuario o contraseña incorrectos.';
    header('Location: login.php');
    exit();
}
?>
