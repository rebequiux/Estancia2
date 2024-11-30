<?php include './Static/connect/bd.php'; ?>
<?php include 'admin_layout.php';?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
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
        .form-label {
            color: #6a1b9a;
        }
        .form-control {
            border: 1px solid #6a1b9a;
        }
        .form-control:focus {
            border-color: #6a1b9a;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header mb-4 text-center">
        <h2>Gestión de Productos</h2>
    </div>
    
    <!-- Botón para registrar producto -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <button class="btn btn-morado" onclick="window.location.href='crearproducto.php'">Registrar Nuevo Producto</button>
    </div>

    <!-- Formulario de calendario para vencimiento -->
    <div class="mb-4">
        <form id="formVencimiento" action="reporte_productos_vencimiento.php" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="fecha_inicio_v" class="form-label">Fecha Inicio (Vencimientos):</label>
                    <input type="date" id="fecha_inicio_v" name="fecha_inicio" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="fecha_fin_v" class="form-label">Fecha Fin (Vencimientos):</label>
                    <input type="date" id="fecha_fin_v" name="fecha_fin" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="btnVencimiento" class="btn btn-morado w-100">Reporte Vencimientos</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Formulario de calendario para más vendido -->
    <div class="mb-4">
        <form id="formMasVendido" action="reporte_productos.php" method="GET">
            <div class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="fecha_inicio_mv" class="form-label">Fecha Inicio (Más Vendido):</label>
                    <input type="date" id="fecha_inicio_mv" name="fecha_inicio" class="form-control">
                </div>
                <div class="col-md-5">
                    <label for="fecha_fin_mv" class="form-label">Fecha Fin (Más Vendido):</label>
                    <input type="date" id="fecha_fin_mv" name="fecha_fin" class="form-control">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="btnMasVendido" class="btn btn-morado w-100">Reporte Más Vendido</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tabla de productos -->
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Proveedor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM productos";
                $exec = mysqli_query($conn, $sql);

                while ($rows = mysqli_fetch_array($exec)) {
                ?>
                <tr>
                    <td><?php echo $rows['id']; ?></td>
                    <td><?php echo $rows['producto']; ?></td>
                    <td><?php echo $rows['precio']; ?></td>
                    <td><?php echo $rows['categoria_id']; ?></td>
                    <td><?php echo $rows['descripcion']; ?></td>
                    <td><?php echo $rows['fecha_vencimiento']; ?></td>
                    <td><?php echo $rows['proveedor']; ?></td>
                    <td>
                        <button class="btn btn-icon btn-morado me-2" onclick="window.location.href='actualizarproducto.php?id=<?php echo $rows['id']; ?>'">
                            Actualizar
                        </button>
                        <button class="btn btn-icon btn-danger" onclick="eliminarProducto(<?php echo $rows['id']; ?>)">
                            Eliminar
                        </button>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    // Validar campos vacíos para vencimientos
    document.getElementById('btnVencimiento').addEventListener('click', function() {
        const fechaInicio = document.getElementById('fecha_inicio_v').value;
        const fechaFin = document.getElementById('fecha_fin_v').value;

        if (!fechaInicio || !fechaFin) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Vacíos',
                text: 'Por favor, selecciona un rango de fechas para el reporte de vencimientos.',
            });
        } else {
            document.getElementById('formVencimiento').submit();
        }
    });

    // Validar campos vacíos para más vendido
    document.getElementById('btnMasVendido').addEventListener('click', function() {
        const fechaInicio = document.getElementById('fecha_inicio_mv').value;
        const fechaFin = document.getElementById('fecha_fin_mv').value;

        if (!fechaInicio || !fechaFin) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos Vacíos',
                text: 'Por favor, selecciona un rango de fechas para el reporte de más vendido.',
            });
        } else {
            document.getElementById('formMasVendido').submit();
        }
    });

    function eliminarProducto(id) {
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
                window.location.href = `eliminarproducto.php?id=${id}`;
            }
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
