<?php

// Habilitar registro de errores
ini_set("log_errors", 1);
ini_set("error_log", "C:/xampp/php/logs/php_error.log"); // Cambia la ruta según tu sistema

// Conexión a la base de datos
$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'abangeles'
);

// Verificar la conexión
if (!$conn) {
    error_log("Error de conexión a la base de datos: " . mysqli_connect_error());
    die("Error de conexión: " . mysqli_connect_error());
}
?>
