<?php
include './Static/connect/bd.php';
session_start();

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $pedidoId = intval($_GET['id']); // Sanitizar el ID del pedido

    try {
        // Iniciar transacción
        $conn->begin_transaction();

        // Debugging: Verifica el ID que se está eliminando
        error_log("Eliminando pedido con ID: $pedidoId");

        // Eliminar detalles del pedido
        $deleteDetalles = "DELETE FROM detalles_pedido WHERE pedido_id = ?";
        $stmtDetalles = $conn->prepare($deleteDetalles);

        if (!$stmtDetalles) {
            throw new Exception("Error al preparar la eliminación de detalles del pedido: " . $conn->error);
        }

        $stmtDetalles->bind_param("i", $pedidoId);
        if (!$stmtDetalles->execute()) {
            throw new Exception("Error al eliminar detalles del pedido: " . $stmtDetalles->error);
        }
        $stmtDetalles->close();

        // Eliminar la relación en usuario_pedidos (si existe esta tabla)
        $deleteUsuarioPedidos = "DELETE FROM usuario_pedidos WHERE pedido_id = ?";
        $stmtUsuarioPedidos = $conn->prepare($deleteUsuarioPedidos);

        if ($stmtUsuarioPedidos) {
            $stmtUsuarioPedidos->bind_param("i", $pedidoId);
            if (!$stmtUsuarioPedidos->execute()) {
                throw new Exception("Error al eliminar la relación en usuario_pedidos: " . $stmtUsuarioPedidos->error);
            }
            $stmtUsuarioPedidos->close();
        }

        // Eliminar el pedido
        $deletePedido = "DELETE FROM pedidos WHERE id = ?";
        $stmtPedido = $conn->prepare($deletePedido);

        if (!$stmtPedido) {
            throw new Exception("Error al preparar la eliminación del pedido: " . $conn->error);
        }

        $stmtPedido->bind_param("i", $pedidoId);
        if (!$stmtPedido->execute()) {
            throw new Exception("Error al eliminar el pedido: " . $stmtPedido->error);
        }
        $stmtPedido->close();

        // Confirmar la transacción
        $conn->commit();
        $_SESSION['success'] = "Pedido eliminado correctamente.";
    } catch (Exception $e) {
        // Revertir la transacción en caso de error
        $conn->rollback();
        $_SESSION['error'] = $e->getMessage();
    }
} else {
    $_SESSION['error'] = "ID de pedido no válido.";
}

// Redirigir a la página de gestión de pedidos
header("Location: gestionpedidos.php");
exit();
