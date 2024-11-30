<?php
// Conexión a la base de datos
include './Static/connect/bd.php'; 
session_start();
$user = $_SESSION['usuario'];


// Obtener el ID del cliente desde el parámetro GET
$id_cliente = isset($_GET['id_cliente']) ? (int)$_GET['id_cliente'] : 0;

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Cliente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Fondo claro */
        }
        .custom-header {
            background-color: #6f42c1; /* Tono morado */
            color: white;
            padding: 20px;
            text-align: center;
        }
        .table {
            background-color: white; /* Fondo blanco para la tabla */
            border-radius: 8px;
            overflow: hidden;
        }
        .table th {
            background-color: #6f42c1; /* Morado */
            color: white;
        }
        .container {
            margin-top: 20px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="custom-header">
        <h1>Perfil del Cliente</h1>
    </div>

    <div class="container">
        <div class="button-container">
            <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
            <a href="carrito.php" class="btn btn-primary">Regresar al Carrito</a>
        </div>

        <p class="text-muted">Pedidos realizados:</p>
        <?php
        // Consultar los pedidos realizados por el cliente
        $sql = "SELECT id, fecha, total, estado FROM pedidos WHERE cliente_id = ?";
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            die("<div class='alert alert-danger'>Error en la consulta SQL (pedidos): " . $conn->error . "</div>");
        }

        $stmt->bind_param('i', $user['id_usuarios']);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>ID Pedido</th><th>Fecha</th><th>Total</th><th>Estado</th></tr></thead><tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                echo "<td>$" . htmlspecialchars($row['total']) . "</td>";
                echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-info'>No has realizado pedidos todavía.</div>";
        }

        // Cerrar conexiones
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
