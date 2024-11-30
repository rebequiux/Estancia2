<?php
include './Static/connect/bd.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'PT Sans', sans-serif;
        }
        .container {
            background-color: #6f42c1;
            color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #fff;
        }
        .table-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 1rem;
            overflow-x: auto;
        }
        .table thead th {
            background-color: #6f42c1;
            color: #fff;
        }
        .btn-custom {
            color: #fff;
            background-color: #6f42c1;
            border: none;
        }
        .btn-custom:hover {
            background-color: #5a359f;
        }
        .icons {
            display: flex;
            justify-content: space-between;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <h1>Actualizar Productos</h1>
    <div class="table-container mt-4">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
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
                while($rows = mysqli_fetch_array($exec)){
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
                        <a href="actualizarproducto.php?id=<?php echo $rows['id']?>" class="btn btn-custom btn-sm">Actualizar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="icons">
        <a href="admin.php">
            <img src="./Static/img/back.png" alt="Volver" width="32">
        </a>
        <a href="./index.php">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="32" height="32" viewBox="0 0 48 48" style="fill:#fff;">
                <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
            </svg>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
