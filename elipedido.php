<?php
include './Static/connect/bd.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles - Eliminar Pedidos</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Fuentes de Google -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="./Static/css/Style.css">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #F3E8FF; /* Fondo blanco lavanda */
        }
        .formulario {
            background-color: #6A1B9A; /* Morado oscuro */
            color: #FFF;
            padding: 20px;
            border-radius: 10px;
            max-width: 900px;
            margin: 20px auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .table thead {
            background-color: #8E24AA; /* Morado medio */
            color: #FFF;
        }
        .table tbody tr:hover {
            background-color: #E1BEE7; /* Morado claro */
        }
        .btn-delete {
            color: #FFF;
            background-color: #D32F2F; /* Rojo para el botón eliminar */
        }
        .btn-back {
            background-color: #673AB7; /* Morado fuerte */
            color: #FFF;
        }
        a {
            text-decoration: none;
            color: #FFF;
        }
        .icon-home {
            fill: #8E24AA;
        }
    </style>
</head>

<body>
    <div class="container formulario">
        <div class="text-center mb-4">
            <h1>Eliminar Pedidos</h1>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Productos</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM pedido";
                    $exec = mysqli_query($conn, $sql);

                    while($rows = mysqli_fetch_array($exec)) {
                    ?>
                        <tr>
                            <td><?php echo $rows['id']; ?></td>
                            <td><?php echo $rows['usuario']; ?></td>
                            <td><?php echo $rows['productos']; ?></td>
                            <td><?php echo $rows['hora']; ?></td>
                            <td><?php echo $rows['fecha']; ?></td>
                            <td>
                                <a href="eliminarpedido.php?id=<?php echo $rows['id']; ?>" class="btn btn-delete btn-sm">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="admin.php" class="btn btn-back btn-sm">
                <img src="./Static/img/back.png" alt="Volver" width="24">
                Volver
            </a>
            <a href="./index.php">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48" class="icon-home">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9
                        C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52
                        C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
