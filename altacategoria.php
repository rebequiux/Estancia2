<?php
include './Static/connect/bd.php'; // Asegúrate de que este archivo establece correctamente la conexión

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir y limpiar datos del formulario
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if ($nombre && $descripcion) {
        try {
            // Verificar si el nombre ya existe
            $stmt = $conn->prepare("SELECT 1 FROM categorias WHERE nombre = ?");
            $stmt->bind_param("s", $nombre);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $errorMsg = "Error: La categoría '$nombre' ya existe.";
            } else {
                // Insertar nueva categoría
                $insertStmt = $conn->prepare("INSERT INTO categorias (nombre, descripcion) VALUES (?, ?)");
                $insertStmt->bind_param("ss", $nombre, $descripcion);

                if ($insertStmt->execute()) {
                    $successMsg = "Categoría '$nombre' creada con éxito.";
                    header("Location: crearcategoria.php?msg=" . urlencode($successMsg));
                    exit();
                } else {
                    $errorMsg = "Error al crear la categoría. Inténtalo nuevamente.";
                }
                $insertStmt->close();
            }
            $stmt->close();
        } catch (Exception $e) {
            $errorMsg = "Error al procesar la solicitud: " . $e->getMessage();
        }
    } else {
        $errorMsg = "Todos los campos obligatorios deben ser completados.";
    }

    // Redirigir con mensaje de error
    header("Location: crearcategoria.php?msg=" . urlencode($errorMsg));
    exit();
}
?>
