<?php
include './Static/connect/bd.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_ids'][0])) {
    $userId = intval($_POST['user_ids'][0]); // Sanitizar el ID

    try {
        // Iniciar transacción
        $conn->begin_transaction();

        // Eliminar relaciones en usuario_pedidos
        $deleteUsuarioPedidos = "DELETE FROM usuario_pedidos WHERE usuario_id = ?";
        $stmtUsuarioPedidos = $conn->prepare($deleteUsuarioPedidos);
        $stmtUsuarioPedidos->bind_param("i", $userId);
        $stmtUsuarioPedidos->execute();
        $stmtUsuarioPedidos->close();

        // Eliminar pedidos relacionados directamente con el usuario
        $deletePedidos = "DELETE FROM pedidos WHERE cliente_id = ?";
        $stmtPedidos = $conn->prepare($deletePedidos);
        $stmtPedidos->bind_param("i", $userId);
        $stmtPedidos->execute();
        $stmtPedidos->close();

        // Eliminar el usuario
        $deleteUsuarios = "DELETE FROM usuarios WHERE id_usuarios = ?";
        $stmtUsuarios = $conn->prepare($deleteUsuarios);
        $stmtUsuarios->bind_param("i", $userId);
        $stmtUsuarios->execute();
        $stmtUsuarios->close();

        // Confirmar transacción
        $conn->commit();
        $_SESSION['success'] = "Usuario eliminado correctamente.";
    } catch (Exception $e) {
        $conn->rollback(); // Revertir transacciones en caso de error
        $_SESSION['error'] = $e->getMessage();
    }
} else {
    $_SESSION['error'] = "Solicitud inválida.";
}

// Redirigir a la página de gestión de usuarios con mensajes de estado
header("Location: gestionusuarios.php");
exit();
