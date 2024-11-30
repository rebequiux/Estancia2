<?php
$host = 'localhost';
$user = 'root'; // Cambia si tienes otro usuario
$password = ''; // Cambia si tienes contraseña
$database = 'abangeles';

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>
