<?php
include './Static/connect/bd.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
</head>
<body class="bg-light text-dark">

<div class="container mt-5">
    <div class="text-center mb-4">
        <h1 class="text-uppercase text-white bg-purple py-3 rounded">Actualizar Categoría</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle bg-white">
            <thead class="bg-purple text-white">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM categorias";
                $exec = mysqli_query($conn, $sql);

                while($rows = mysqli_fetch_array($exec)) {
                ?>
                <tr>
                    <td><?php echo $rows['id']; ?></td>
                    <td><?php echo $rows['nombre']; ?></td>
                    <td>
                        <a href="actualizarcategoria.php?id=<?php echo $rows['id']?>" class="btn btn-lg btn-outline-purple">Actualizar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="admin.php" class="btn btn-lg btn-outline-purple">
            <img src="./Static/img/back.png" alt="Volver" width="24" class="me-2">
            Volver
        </a>
        <a href="./index.php" class="btn btn-lg btn-outline-purple d-flex align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 48 48" style="fill:#228BE6;" class="me-2">
                <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
            </svg>
            Inicio
        </a>
    </div>
</div>

<style>
    .bg-purple {
        background-color: #6f42c1;
    }
    .btn-outline-purple {
        color: #6f42c1;
        border-color: #6f42c1;
        padding: 15px 25px;
        font-size: 1.25rem;
    }
    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: white;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
