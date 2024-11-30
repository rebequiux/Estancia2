<?php

// Ruta corregida para incluir el archivo de conexión
include __DIR__ . '/Static/connect/db.php'; 
session_start();

// Verificar si el usuario está autenticado
if (isset($_SESSION['usuario'])) {
    $host = 'localhost'; // Usualmente localhost
    $user_db = 'root';   // Usualmente 'root' para XAMPP
    $pass = '';          // Sin contraseña por defecto en XAMPP
    $db = 'abangeles';   // Nombre de la base de datos

    // Conectar a la base de datos si no está en Static/connect/db.php
    $conn = mysqli_connect($host, $user_db, $pass, $db);
    if (!$conn) {
        die("Error de conexión a la base de datos: " . mysqli_connect_error());
    }

    // Generamos el nombre del archivo de respaldo con fecha y hora
    $backup_dir = __DIR__ . '/respaldos/';
    $backup_file = $backup_dir . $db . '.sql';
    //$backup_file = $backup_dir . $db . '_' . $fecha . '.sql';


    // Crear el directorio de respaldos si no existe
    if (!is_dir($backup_dir)) {
        mkdir($backup_dir, 0777, true); // Crear el directorio con permisos
    }

    // Crear el archivo SQL
    $sql = "SHOW TABLES";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Error al obtener las tablas: " . mysqli_error($conn));
    }

    $sql_script = "";

    while ($row = mysqli_fetch_row($result)) {
        $table = $row[0];

        // Crear la estructura de la tabla
        $create_table_result = mysqli_query($conn, "SHOW CREATE TABLE $table");
        if (!$create_table_result) {
            die("Error al obtener la estructura de la tabla $table: " . mysqli_error($conn));
        }
        $row2 = mysqli_fetch_row($create_table_result);

        $sql_script .= "DROP TABLE IF EXISTS $table;"; // Eliminar tabla si existe
        $sql_script .= "\n\n" . $row2[1] . ";\n\n"; // Agregar la estructura de la tabla

        // Insertar datos de la tabla
        $result2 = mysqli_query($conn, "SELECT * FROM $table");
        while ($row2 = mysqli_fetch_row($result2)) {
            $sql_script .= "INSERT INTO $table VALUES(";
            for ($j = 0; $j < count($row2); $j++) {
                $row2[$j] = addslashes($row2[$j]);
                $row2[$j] = str_replace("\n", "\\n", $row2[$j]);
                if (isset($row2[$j])) {
                    $sql_script .= '"' . $row2[$j] . '"';
                } else {
                    $sql_script .= '""';
                }
                if ($j < (count($row2) - 1)) {
                    $sql_script .= ','; // Agregar coma entre valores
                }
            }
            $sql_script .= ");\n";
        }
        $sql_script .= "\n\n\n";
    }

    // Guardar el script en un archivo
    file_put_contents($backup_file, $sql_script);

    // Comprobar si el archivo de respaldo se creó exitosamente
    if (file_exists($backup_file)) {
        header("Location: admin.php?respaldo=true");
    } else {
        header("Location: admin.php?respaldoError=true");
    }
    exit;
} else {
    header("Location: login.php");
    exit;
}
?>