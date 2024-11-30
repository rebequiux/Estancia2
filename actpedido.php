<?php include './Static/connect/bd.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>

<body style="background-color: #f3f4f6;">

    <div class="container my-5 p-4 rounded" style="background-color: #6f42c1; color: #fff;">
        <h1 class="text-center mb-4">Actualizar Pedido</h1>

        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center align-middle" style="background-color: #fff;">
                <thead class="table-dark" style="background-color: #5a189a;">
                    <tr>
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Productos</th>
                        <th>Hora</th>
                        <th>Fecha</th>
                        <th>Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM pedido";
                        $exec = mysqli_query($conn, $sql);

                        while($rows = mysqli_fetch_array($exec)){
                    ?>
                    <tr>
                        <td><?php echo $rows['id']; ?></td>
                        <td><?php echo $rows['usuario']; ?></td>
                        <td><?php echo $rows['productos']; ?></td>
                        <td><?php echo $rows['hora']; ?></td>
                        <td><?php echo $rows['fecha']; ?></td>
                        <td>
                            <a href="actualizarpedido.php?id=<?php echo $rows['id']?>" class="btn btn-outline-primary btn-sm">Actualizar</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="admin.php" class="btn btn-outline-light">
                <img src="./Static/img/back.png" alt="Back" style="width: 24px;">
                Volver
            </a>
            <a href="./index.php" class="btn btn-outline-light">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48" fill="#fff">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9 C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52 C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                </svg>
                Inicio
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
