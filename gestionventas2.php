<?php
session_start();
include './Static/connect/bd.php';
include 'empleado_layout.php';

// Inicializar $result para evitar "Undefined variable"
$result = false;

try {
    $sql = "
        SELECT 
            p.producto AS nombre_producto,
            p.id AS producto_id,
            SUM(dp.cantidad) AS cantidad_vendida,
            GROUP_CONCAT(
                CONCAT('Pedido ID: ', pe.id, ', Fecha: ', DATE_FORMAT(pe.fecha, '%Y-%m-%d %H:%i:%s'), ', Total: $', FORMAT(pe.total, 2))
                ORDER BY pe.fecha ASC SEPARATOR '<br>'
            ) AS historial_transacciones,
            SUM(dp.cantidad * dp.precio_unitario) AS ingresos_generados
        FROM 
            detalles_pedido dp
        INNER JOIN 
            productos p ON dp.producto_id = p.id
        INNER JOIN 
            pedidos pe ON dp.pedido_id = pe.id
        WHERE 
            pe.estado = 'Pagado'
        GROUP BY 
            p.id, p.producto
        ORDER BY 
            ingresos_generados DESC;
    ";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        throw new Exception("Error al ejecutar la consulta: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div class="header mb-4 text-center">
        <h2>Gestión de Ventas</h2>
    </div>

    <!-- Botones para agregar funcionalidades -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <form action="reporte_ventas.php" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                    <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                    <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-morado w-100">Generar Reporte Ventas</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Botones principales -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-morado" onclick="window.location.href='crearpedido2.php'">Registrar Nuevo Pedido</button>
        <button class="btn btn-morado" onclick="window.location.href='gestionusuarios2.php'">Gestión de Usuarios</button>
        <button class="btn btn-morado" onclick="window.location.href='gestionproductos2.php'">Gestión de Productos</button>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>Cantidad Vendida</th>
                    <th>Nombre del Producto</th>
                    <th>Historial de Transacciones</th>
                    <th>Ingresos Generados</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr id='row-{$row['producto_id']}'>
                            <td>{$row['cantidad_vendida']}</td>
                            <td>{$row['nombre_producto']}</td>
                            <td>{$row['historial_transacciones']}</td>
                            <td>$" . number_format($row['ingresos_generados'], 2) . "</td>
                            <td>
                                <div class='d-flex justify-content-center gap-2'>
                                    <button class='btn btn-warning btn-sm' onclick=\"window.location.href='actualizarventa2.php?nombre={$row['nombre_producto']}'\">Actualizar</button>
                                    <button class='btn btn-danger btn-sm' onclick=\"confirmarEliminarVenta({$row['producto_id']})\">Eliminar</button>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No se encontraron datos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Función para confirmar y eliminar una venta usando AJAX
    function confirmarEliminarVenta(productoId) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Eliminarás esta venta. Esta acción no se puede deshacer.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'eliminarventa2.php',
                    type: 'GET',
                    data: { id: productoId },
                    success: function(response) {
                        // Eliminar la fila de la tabla
                        $(`#row-${productoId}`).remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Eliminado',
                            text: 'La venta fue eliminada correctamente.',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Ocurrió un error al intentar eliminar la venta.',
                        });
                    }
                });
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
