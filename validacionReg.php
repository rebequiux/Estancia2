<?php

include './Static/connect/bd.php'; 

?>

<?php

// Manejar objetos PDO (proyectos más grandes)

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (!empty($_POST['usuario']) && !empty($_POST['contrasena']) && !empty($_POST['correo'])) {

        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $correo = $_POST['correo'];

        $sql = "INSERT INTO usuarios (usuario, contrasena, correo) VALUES ('$usuario', '$contrasena', '$correo')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<h1>Usuario registrado exitosamente</h1>";
            header('Location: login.php');
            exit();
        } else {
            echo "<h1>Error al registrar el usuario: " . mysqli_error($conn) . "</h1>";
        }
    } else {
        echo "Complete todos los campos";
    }
} else {
    echo "Acceso Denegado";
}
?>

<form action="login.php" method="POST" class="form_container">
    <button type="submit" class="boton_1">Salir</button>
</form>
