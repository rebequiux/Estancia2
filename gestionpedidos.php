<?php
session_start();
include 'admin_layout.php';
include './Static/connect/bd.php';

// Manejo de errores y consulta para obtener los pedidos
$exec = null;

try {
    $sql = "
        SELECT 
            p.id AS pedido_id,
            u.usuario AS usuario,
            GROUP_CONCAT(dp.cantidad, 'x ', prod.producto SEPARATOR ', ') AS productos,
            p.total,
            p.estado,
            DATE(p.fecha) AS fecha,
            TIME(p.fecha) AS hora
        FROM pedidos p
        JOIN usuarios u ON p.cliente_id = u.id_usuarios
        JOIN detalles_pedido dp ON p.id = dp.pedido_id
        JOIN productos prod ON dp.producto_id = prod.id
        GROUP BY p.id
        ORDER BY p.fecha DESC;
    ";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt->execute()) {
        throw new Exception("Error al ejecutar la consulta: " . $stmt->error);
    }
    $exec = $stmt->get_result();
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            margin-top: 20px;
            max-width: 1000px;
            margin-left: 16rem;
        }
        .header {
            background-color: #6a1b9a;
            color: white;
            padding: 15px;
            border-radius: 8px;
        }
        .btn-morado {
            background-color: #6a1b9a;
            color: white;
        }
        .btn-morado:hover {
            background-color: #4a148c;
        }
        .btn-icon {
            padding: 4px 8px;
        }
        table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }
        th {
            background-color: #6a1b9a;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Mensajes de error o éxito -->
    <?php if (isset($_SESSION['error'])): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?php echo addslashes($_SESSION['error']); ?>'
        });
    </script>
    <?php unset($_SESSION['error']); endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?php echo addslashes($_SESSION['success']); ?>'
        });
    </script>
    <?php unset($_SESSION['success']); endif; ?>

    <div class="header mb-4 text-center">
        <h2>Gestión de Pedidos</h2>
    </div>

    <!-- Formulario para filtrar y generar reporte -->
    <form id="reporteForm" action="reporte_pedidos.php" method="GET" class="mb-3">
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-morado w-100">Generar Reporte</button>
            </div>
        </div>
    </form>

    <!-- Botón de nuevo pedido -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-morado" onclick="window.location.href='crearpedido.php'">Registrar Nuevo Pedido</button>
    </div>

    <!-- Tabla de pedidos -->
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Productos</th>
                    <th>Hora</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($exec && $exec->num_rows > 0): ?>
                    <?php while ($rows = $exec->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $rows['pedido_id']; ?></td>
                        <td><?php echo $rows['usuario']; ?></td>
                        <td><?php echo $rows['productos']; ?></td>
                        <td><?php echo $rows['hora']; ?></td>
                        <td><?php echo $rows['fecha']; ?></td>
                        <td>$<?php echo number_format($rows['total'], 2); ?></td>
                        <td><?php echo $rows['estado']; ?></td>
                        <td>
                            <button class="btn btn-icon btn-morado me-2" onclick="window.location.href='actualizarpedido.php?id=<?php echo $rows['pedido_id']; ?>'">
                                Actualizar
                            </button>
                            <button class="btn btn-icon btn-danger" onclick="eliminarPedido(<?php echo $rows['pedido_id']; ?>)">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="8">No hay pedidos disponibles</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Validar campos vacíos en el formulario
    document.getElementById('reporteForm').addEventListener('submit', function (e) {
        const fechaInicio = document.getElementById('fecha_inicio').value;
        const fechaFin = document.getElementById('fecha_fin').value;

        if (!fechaInicio || !fechaFin) {
            e.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Campos Vacíos',
                text: 'Por favor, completa ambas fechas para generar el reporte.'
            });
        }
    });

    // Función para eliminar un pedido
    function eliminarPedido(id) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `eliminarpedido.php?id=${id}`;
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
