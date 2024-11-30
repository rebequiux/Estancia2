<?php
include 'admin_layout.php';
include './Static/connect/bd.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Proveedores</title>
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
            background-color: #6a1b9a; /* Morado */
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
        .search-bar {
            border: 1px solid #6a1b9a;
        }
        .search-bar::placeholder {
            color: #6a1b9a;
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
        <h2>Gestión de Proveedores</h2>
    </div>

    <!-- Formulario para filtrar por rango de fechas -->
    <form action="reporte_proveedores.php" method="GET" class="mb-4">
        <div class="row g-3 align-items-center">
            <div class="col-md-5">
                <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" required>
            </div>
            <div class="col-md-5">
                <label for="fecha_fin" class="form-label">Fecha Fin:</label>
                <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-morado w-100">Generar Reporte</button>
            </div>
        </div>
    </form>

    <!-- Barra de búsqueda y botón de nuevo proveedor -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-morado" onclick="window.location.href='crearproveedor.php'">Registrar Nuevo Proveedor</button>
    </div>

    <!-- Tabla de proveedores y productos -->
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>ID Proveedor</th>
                    <th>Nombre Proveedor</th>
                    <th>Producto</th>
                    <th>Fecha de Abastecimiento</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Consulta SQL para combinar datos de proveedores y productos
                    $sql = "
                        SELECT 
                            p.id AS proveedor_id, 
                            p.nombre AS proveedor_nombre, 
                            pr.producto AS producto_nombre, 
                            pr.fecha_vencimiento AS fecha_vencimiento, 
                            pr.precio AS producto_precio 
                        FROM proveedores p
                        LEFT JOIN productos pr ON pr.proveedor = p.id
                    ";

                    $exec = mysqli_query($conn, $sql);

                    if (!$exec) {
                        echo '<tr><td colspan="6">Error al ejecutar la consulta: ' . mysqli_error($conn) . '</td></tr>';
                    } elseif (mysqli_num_rows($exec) == 0) {
                        echo '<tr><td colspan="6">No hay proveedores registrados.</td></tr>';
                    } else {
                        while ($rows = mysqli_fetch_assoc($exec)) {
                            ?>
                            <tr>
                                <td><?php echo htmlspecialchars($rows['proveedor_id']); ?></td>
                                <td><?php echo htmlspecialchars($rows['proveedor_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($rows['producto_nombre'] ?? 'Sin producto'); ?></td>
                                <td><?php echo htmlspecialchars($rows['fecha_vencimiento'] ?? 'Sin fecha'); ?></td>
                                <td><?php echo '$' . number_format($rows['producto_precio'] ?? 0, 2); ?></td>
                                <td>
                                    <button class="btn btn-icon btn-morado me-2" onclick="window.location.href='actualizarproveedor.php?id=<?php echo urlencode($rows['proveedor_id']); ?>'">
                                        Actualizar
                                    </button>
                                    <button class="btn btn-icon btn-danger" onclick="eliminarProveedor(<?php echo htmlspecialchars($rows['proveedor_id']); ?>)">
                                        Eliminar
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                } catch (Exception $e) {
                    echo '<tr><td colspan="6">Error: ' . htmlspecialchars($e->getMessage()) . '</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function eliminarProveedor(id) {
        if (!id) {
            Swal.fire({
                title: 'Error',
                text: 'ID de proveedor inválido.',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
            return;
        }

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
                window.location.href = `eliminarproveedor.php?id=${id}`;
            }
        });
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
