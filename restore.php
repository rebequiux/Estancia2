<?php
include __DIR__ . '/Static/connect/db.php'; 
session_start();

if (isset($_SESSION['usuario'])) {
    // Directorio donde se encuentran los respaldos
    $backup_dir = __DIR__ . '/respaldos/';
    
    // Comprobar que el directorio existe
    if (!is_dir($backup_dir)) {
        echo "<script>alert('El directorio de respaldos no existe.'); window.location.href = 'perfil.php';</script>";
        exit;
    }
    
    // Obtener el archivo de respaldo más reciente
    $files = glob($backup_dir . '*.sql');
    
    if (empty($files)) {
        echo "<script>alert('No se encontraron archivos de respaldo.'); window.location.href = 'perfil.php';</script>";
        exit;
    }

    // Ordenar archivos por fecha de modificación descendente
    usort($files, function ($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    
    // Obtener el archivo más reciente
    $latest_backup_file = $files[0];

    if (file_exists($latest_backup_file)) {
        // Conectar a la base de datos
        $host = 'localhost';
        $user_db = 'root';
        $pass = '';
        $db = 'abangeles';

        $conn = new mysqli($host, $user_db, $pass, $db);

        if ($conn->connect_error) {
            die("Error de conexión: " . $conn->connect_error);
        }

        // Leer el archivo SQL
        $sql = file_get_contents($latest_backup_file);

        // Desactivar las verificaciones de claves foráneas
        $conn->query('SET foreign_key_checks = 0');

        // Ejecutar la restauración
        if ($conn->multi_query($sql)) {
            do {
                if ($result = $conn->store_result()) {
                    $result->free();
                }
            } while ($conn->next_result());

            // Reactivar las verificaciones de claves foráneas
            $conn->query('SET foreign_key_checks = 1');
            header("Location: admin.php?restauracion=true");
        } else {
            // Reactivar las verificaciones de claves foráneas si hay un error
            $conn->query('SET foreign_key_checks = 1');
            header("Location: admin.php?restauracionError=true");
        }

        $conn->close();
    } else {
        echo "<script>alert('No se encontró el archivo de respaldo más reciente.'); window.location.href = 'admin.php';</script>";
    }
} else {
    header("Location: login.php");
}
?>
