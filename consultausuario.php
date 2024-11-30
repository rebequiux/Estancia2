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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Static/css/Style.css">
    <style>
        body {
            background-color: #eae2f8; /* Fondo morado claro */
            font-family: 'PT Sans', sans-serif;
        }
        .main-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        .card-custom {
            background-color: #fff;
            border: 2px solid #6f42c1;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header-title {
            color: #6f42c1;
            font-weight: bold;
            text-align: center;
        }
        .table-container {
            overflow-x: auto;
        }
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: #fff;
            border-radius: 10px;
        }
        .btn-purple:hover {
            background-color: #5a34a7;
        }
        .icon-btn {
            width: 32px;
            height: 32px;
        }
    </style>
</head>
<body>
    <div class="main-container">
        <div class="card-custom">
            <h2 class="header-title">Consultar Usuarios</h2>
            <div class="table-container mt-4">
                <!-- Tabla de usuarios -->
                <div class="table-responsive">
                    <div class="d-flex justify-content-between mb-3">
                        <div class="text-muted">Usuarios registrados</div>
                        <div class="btn-group">
                            <a href="admin.php" class="btn btn-purple">
                                <img src="./Static/img/back.png" class="icon-btn" alt="Regresar">
                            </a>
                            <a href="./index.php" class="btn btn-purple ms-2">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 48 48" class="icon-btn">
                                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9 C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52 C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z" fill="#ffffff"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-primary text-dark">
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Contraseña</th>
                                <th>Correo</th>
                                <th>Tipo de Usuario</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM usuarios";
                            $exec = mysqli_query($conn, $sql);
                            while ($rows = mysqli_fetch_array($exec)) {
                            ?>
                            <tr>
                                <td><?php echo $rows['id_usuarios']; ?></td> <!-- Cambiado a 'id_usuarios' -->
                                <td><?php echo $rows['usuario']; ?></td>
                                <td><?php echo $rows['contrasena']; ?></td>
                                <td><?php echo $rows['correo']; ?></td>
                                <td><?php echo $rows['tipo_usuario']; ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
