<?php include './Static/connect/bd.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <style>
        body {
            background-color: #f0f0f5;
            font-family: 'Open Sans', sans-serif;
        }
        .container {
            margin-top: 30px;
        }
        h1 {
            color: #6a0dad;
        }
        .btn-custom {
            background-color: #6a0dad;
            color: #fff;
        }
        .btn-custom:hover {
            background-color: #5c0ca8;
        }
        .table thead {
            background-color: #e6e6fa;
        }
        .table th, .table td {
            color: #4b0082;
        }
        .formulario {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Encabezado -->
    <div class="text-center mb-4">
        <h1>Consultar Productos</h1>
    </div>

    <!-- Tabla de Productos -->
    <div class="formulario">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Fecha de Vencimiento</th>
                        <th>Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM productos";
                        $exec = mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_array($exec)) {
                    ?>
                        <tr>
                            <td><?php echo $rows['id']; ?></td>
                            <td><?php echo $rows['producto']; ?></td>
                            <td>$<?php echo number_format($rows['precio'], 2); ?></td>
                            <td><?php echo $rows['categoria_id']; ?></td>
                            <td><?php echo $rows['descripcion']; ?></td>
                            <td><?php echo date('d/m/Y', strtotime($rows['fecha_vencimiento'])); ?></td>
                            <td><?php echo $rows['proveedor']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- Botones de navegación -->
        <div class="d-flex justify-content-between mt-4">
            <a href="admin.php" class="btn btn-custom">
                <img src="./Static/img/back.png" alt="Volver" style="width: 24px; vertical-align: middle;"> Volver
            </a>
            <a href="./index.php" class="btn btn-custom">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48" fill="#fff">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9 C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52 C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                </svg> Inicio
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
