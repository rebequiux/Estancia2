<?php include './Static/connect/bd.php'; ?>

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
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" crossorigin="crossorigin" as="font">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .bg-purple { background-color: #6f42c1; } /* Tonos morados */
        .text-white { color: white; }
    </style>
</head>

<body class="bg-light">

<div class="container py-5">
    <div class="card bg-purple text-white">
        <div class="card-body">
            <h1 class="text-center mb-4">Actualizar Usuario</h1>
            <table class="table table-bordered table-striped table-hover text-white">
                <thead>
                    <tr class="bg-dark">
                        <th>Id</th>
                        <th>Usuario</th>
                        <th>Contraseña</th>
                        <th>Correo</th>
                        <th>Tipo de Usuario</th>
                        <th>Actualizar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $sql = "SELECT * FROM usuarios";
                        $exec = mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_array($exec)){
                    ?>
                    <tr>
                        <td> <?php echo $rows['id']; ?> </td>
                        <td> <?php echo $rows['usuario']; ?> </td>
                        <td> <?php echo $rows['contrasena']; ?> </td>
                        <td> <?php echo $rows['correo']; ?> </td>
                        <td> <?php echo $rows['tipo_usuario']; ?> </td>
                        <td><a href="actualizarusuario.php?id=<?php echo $rows['id']?>" class="btn btn-warning">Actualizar</a></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="admin.php" class="btn btn-secondary">
            <img src="./Static/img/back.png" alt="Volver">
        </a>
        <a href="./index.php" class="btn btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="48" height="48" viewBox="0 0 48 48" style="fill:#ffffff;">
                <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
            </svg>
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
