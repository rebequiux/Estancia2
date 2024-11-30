<?php
include './Static/connect/bd.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Angeles">
    <link rel="prefetch" href="nosotros.html" as="document">
    <link rel="preload" href="./Static/css/Style.css" as="style">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap"  crossorigin="crossorigin" as="font">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom Styles */
        body {
            background-color: #f4f5f7;
            font-family: 'Open Sans', sans-serif;
        }

        .bg-purple {
            background-color: #9b4dca; /* Lighter purple */
        }

        .text-primary-custom {
            color: #9b4dca; /* Custom primary color */
        }

        .card-custom {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header-custom {
            background-color: #9b4dca;
            color: white;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            text-align: center;
            padding: 15px;
        }

        .table-custom {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        }

        .table-custom th, .table-custom td {
            vertical-align: middle;
        }

        .btn-custom {
            background-color: #9b4dca;
            color: white;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background-color: #8a3fb6;
        }

        .btn-danger-custom {
            background-color: #e74c3c;
            color: white;
            border-radius: 8px;
        }

        .btn-danger-custom:hover {
            background-color: #c0392b;
        }

        .svg-icon {
            fill: #3498db;
        }

        .container-custom {
            margin-top: 50px;
        }

        .table-warning {
            background-color: #f9f5f0;
        }

        .back-link {
            font-size: 1.1rem;
            text-decoration: none;
            color: #9b4dca;
        }

        .back-link:hover {
            color: #8a3fb6;
        }
    </style>
</head>

<body>
    <div class="container container-custom">
        <div class="row">
            <div class="col-12 text-center mb-4">
                <h1 class="text-primary-custom mb-3">Eliminar Productos</h1>
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h3 class="mb-0">Productos Disponibles</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-custom table-warning">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Producto</th>
                                        <th>Precio</th>
                                        <th>Categoría</th>
                                        <th>Descripción</th>
                                        <th>Fecha de Vencimiento</th>
                                        <th>Proveedor</th>
                                        <th>Eliminar</th>
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
                                            <a href="eliminarproducto.php?id=<?php echo $rows['id'] ?>" class="btn btn-danger-custom btn-sm">Eliminar</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-6">
                <a href="admin.php" class="btn btn-custom btn-sm">
                    <img src="./Static/img/back.png" alt="Back" style="width: 20px;"> Volver
                </a>
            </div>
            <div class="col-6 text-end">
                <a href="./index.php" class="back-link">
                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" class="svg-icon">
                        <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
