<?php
include './Static/connect/bd.php';

if (isset($_GET['id'])) {
    $ID = intval($_GET['id']); // Asegurarse de que sea un número entero

    // Iniciar transacción
    mysqli_begin_transaction($conn);

    try {
        // Eliminar detalles asociados
        $deleteDetailsQuery = "DELETE FROM detalles_pedido WHERE producto_id = $ID";
        mysqli_query($conn, $deleteDetailsQuery);

        // Eliminar venta
        $deleteVentaQuery = "DELETE FROM productos WHERE id = $ID";
        mysqli_query($conn, $deleteVentaQuery);

        // Confirmar transacción
        mysqli_commit($conn);
        echo "success";
    } catch (Exception $e) {
        // Revertir transacción en caso de error
        mysqli_rollback($conn);
        echo "error";
    }
}
