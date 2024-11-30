<?php
include './Static/connect/bd.php';

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = trim($_POST['cliente_id']);
    $fecha = trim($_POST['fecha']);
    $total = trim($_POST['total']);
    $estado = trim($_POST['estado']);

    if ($cliente_id && $fecha && $hora && $fecha) {
        $sql = "INSERT INTO pedidos (cliente_id, fecha, total, estado) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('ssss', $usuario, $productos, $hora, $fecha);

            if ($stmt->execute()) {
                header("Location: gestionpedidos.php");
                exit();
            } else {
                echo "Error al crear el pedido: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Todos los campos obligatorios deben ser completados.";
    }
}
?>
