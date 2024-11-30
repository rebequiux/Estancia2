<?php
// Inicia la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

include 'admin_layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #6f42c1;
            color: white;
            min-height: 100vh;
            padding: 20px;
        }
        .sidebar h4 {
            font-weight: bold;
            margin-bottom: 30px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            margin-bottom: 10px;
            display: block;
            padding: 10px;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #5a32a3;
        }
        .header {
            background-color: #6f42c1;
            color: white;
            padding: 15px 20px;
            margin-top: 20px;
            max-width: 1000px;
            margin-left: 16rem;
        }
        .header h1 {
            margin: 0;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

        <!-- Main Content -->
        <div class="flex-grow-1">
            <!-- Header -->
            <div class="header">
                <h1>Bienvenido, Administrador</h1>
            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
