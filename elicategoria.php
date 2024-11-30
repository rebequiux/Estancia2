<?php 
include './Static/connect/bd.php'; 
include 'admin_layout.php'; 

// Mensaje de confirmación o error
$msg = "";
if (isset($_GET['success'])) {
    $msg = $_GET['success'] == 1 
        ? "Categoría eliminada correctamente." 
        : "Error al eliminar la categoría.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f9f9ff;
            font-family: 'PT Sans', sans-serif;
        }
        .header {
            background-color: #6f42c1;
            color: white;
            padding: 15px;
            text-align: center;
            margin-bottom: 20px;
        }
        .table {
            border-color: #6f42c1;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: white;
        }
        .btn-purple:hover {
            background-color: #563d7c;
        }
        .icon-home {
            fill: #6f42c1;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="header">
            <h1>Eliminar Categoría</h1>
        </div>

        <!-- Mensaje de éxito o error -->
        <?php if (!empty($msg)): ?>
            <div class="alert <?= strpos($msg, 'correctamente') ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                <?= $msg; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered border-primary text-center">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM categorias";
                    $exec = mysqli_query($conn, $sql);

                    if (!$exec) {
                        echo "<tr><td colspan='3'>Error al cargar las categorías.</td></tr>";
                    } else {
                        while ($rows = mysqli_fetch_assoc($exec)) {
                            echo "<tr>
                                <td>{$rows['id']}</td>
                                <td>{$rows['nombre']}</td>
                                <td>
                                    <a href='eliminarcategoria.php?id={$rows['id']}' class='btn btn-purple btn-sm'>Eliminar</a>
                                </td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            <a href="gestioncategoria.php" class="btn btn-purple">Volver al Panel</a>
            <a href="./index.php" class="btn btn-purple">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 48 48" class="icon-home">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                </svg>
                Inicio
            </a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
