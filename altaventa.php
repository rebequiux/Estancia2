<?php

include './Static/connect/bd.php'; 

if (!isset($conn)) {
    die("Error: No se pudo establecer la conexión a la base de datos.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $cliente_id = $_POST['cliente_id'];
    $usuario_id = $_POST['usuario_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $total = $_POST['total'];

    // Validar que los campos no estén vacíos
    if ($cliente_id && $usuario_id && $fecha && $hora && $total) {
        
        // Verificar si el cliente existe
        $sql_verificar_cliente = "SELECT id FROM clientes WHERE id = '$cliente_id'";
        $resultado_cliente = mysqli_query($conn, $sql_verificar_cliente);

        // Verificar si el usuario existe
        $sql_verificar_usuario = "SELECT id FROM usuarios WHERE id = '$usuario_id'";
        $resultado_usuario = mysqli_query($conn, $sql_verificar_usuario);

        if (mysqli_num_rows($resultado_cliente) > 0 && mysqli_num_rows($resultado_usuario) > 0) {
            // Si ambos existen, inserta la venta
            $sql = "INSERT INTO ventas (cliente_id, usuario_id, fecha, hora, total) 
                    VALUES ('$cliente_id', '$usuario_id', '$fecha', '$hora', '$total')";

            if (mysqli_query($conn, $sql)) {
                header("Location: crearventa.php"); 
                echo "Venta creada con éxito.";
                exit();
            } else {
                echo "Error al crear la venta: " . mysqli_error($conn);
            }
        } else {
            if (mysqli_num_rows($resultado_cliente) == 0) {
                echo "El cliente con ID $cliente_id no existe. Verifica el ID del cliente.<br>";
            }
            if (mysqli_num_rows($resultado_usuario) == 0) {
                echo "El usuario con ID $usuario_id no existe. Verifica el ID del usuario.<br>";
            }
        }
    } else {
        echo "Todos los campos obligatorios deben ser completados.";
    }
}
?>
