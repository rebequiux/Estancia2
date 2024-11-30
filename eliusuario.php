<?php
include './Static/connect/bd.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #fafafa;
            font-family: 'Open Sans', sans-serif;
        }

        .container-custom {
            background-color: #fff;
            border-radius: 12px;
            padding: 20px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .header-title {
            background-color: #6a1b9a;
            color: #fff;
            padding: 15px;
            border-radius: 12px 12px 0 0;
            text-align: center;
        }

        .user-row {
            background-color: #f3e5f5;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-row:nth-child(even) {
            background-color: #e1bee7;
        }

        .user-data {
            flex: 1;
            text-align: center;
            font-size: 14px;
        }

        .btn-purple {
            background-color: #6a1b9a;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 14px;
        }

        .btn-purple:hover {
            background-color: #4a148c;
        }

        .icon-back {
            width: 20px;
            height: 20px;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="container-custom">
        <!-- Encabezado -->
        <div class="header-title">
            <h2>Gestión de Usuarios</h2>
            <p class="mb-0">Eliminar usuarios registrados</p>
        </div>

        <!-- Listado de usuarios -->
        <div class="p-3">
            <div class="d-flex fw-bold text-white mb-3" style="background-color: #6a1b9a; border-radius: 8px; padding: 10px;">
                <div class="user-data">ID</div>
                <div class="user-data">Usuario</div>
                <div class="user-data">Correo</div>
                <div class="user-data">Tipo</div>
                <div class="user-data">Acciones</div>
            </div>

            <?php
            $sql = "SELECT * FROM usuarios";
            $exec = mysqli_query($conn, $sql);
            while ($rows = mysqli_fetch_array($exec)) {
            ?>
            <div class="user-row">
                <div class="user-data"><?php echo $rows['id']; ?></div>
                <div class="user-data"><?php echo $rows['usuario']; ?></div>
                <div class="user-data"><?php echo $rows['correo']; ?></div>
                <div class="user-data"><?php echo $rows['tipo_usuario']; ?></div>
                <div class="user-data">
                    <div class="action-buttons">
                        <a href="eliminarusuario.php?id=<?php echo $rows['id']?>" class="btn btn-danger btn-sm mx-1">Eliminar</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>

        <!-- Botones de navegación -->
        <div class="text-center mt-4">
            <a href="admin.php" class="btn btn-purple">
                <img src="./Static/img/back.png" alt="Regresar" class="icon-back me-2">Regresar
            </a>
            <a href="./index.php" class="btn btn-purple ms-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 48 48" fill="#fff">
                    <path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9	C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52	C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path>
                </svg> Ir al inicio
            </a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
