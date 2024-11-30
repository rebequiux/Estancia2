<?php

include './Static/connect/bd.php';

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = trim($_POST['nombre']); // Usar trim para eliminar espacios en blanco innecesarios
    $descripcion = trim($_POST['descripcion']); // Nueva variable para la descripción

    if (!empty($nombre) && !empty($descripcion)) {
        // Verificar si el proveedor ya existe
        $query = "SELECT * FROM proveedores WHERE nombre = '$nombre'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "El proveedor con el nombre '$nombre' ya existe. Por favor, use un nombre diferente.";
        } else {
            // Insertar el nuevo proveedor si no existe
            $sql = "INSERT INTO proveedores (nombre, descripcion) VALUES ('$nombre', '$descripcion')";

            if (mysqli_query($conn, $sql)) {
                header("Location: crearproveedor.php");
                echo "Proveedor creado con éxito.";
                exit();
            } else {
                echo "Error al crear el proveedor: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Todos los campos obligatorios deben ser completados.";
    }
}
?>
