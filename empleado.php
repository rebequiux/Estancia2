<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #6a1b9a; /* Color morado */
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            width: 250px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: background-color 0.2s;
        }
        .sidebar a:hover {
            background-color: #4a148c; /* Color morado oscuro */
        }
        .content {
            margin-left: 250px; /* Espacio para el sidebar */
            padding: 20px;
        }
        .icon {
            width: 24px;
            height: 24px;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h4 class="text-center">Panel de Gestión</h4>

    <a href="empleado.php">
        <svg class="icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M1 2.5a1.5 1.5 0 1 1 3 0v11a1.5 1.5 0 1 1-3 0v-11zM5 2h10v2H5V2zm0 4h10v2H5V6zm0 4h10v2H5v-2zm0 4h10v2H5v-2z"/>
        </svg>
        Inicio
    </a>

    <a href="gestionproductos2.php">
        <svg class="icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M5.5 2.5a1.5 1.5 0 1 0-3 0V13a1.5 1.5 0 1 0 3 0V2.5zM6.5 3h8v2h-8V3zm0 4h8v2h-8V7zm0 4h8v2h-8v-2z"/>
        </svg>
        Gestión de Productos
    </a>

    <a href="gestionpedidos2.php">
        <svg class="icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M2 2h12v4H2V2zm0 5h12v4H2V7zm0 5h12v2H2v-2z"/>
        </svg>
        Gestión de Pedidos
    </a>

    <a href="gestionventas2.php">
        <svg class="icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M4 2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1H4V2zm0 2h8v12H4V4z"/>
        </svg>
        Gestión de Ventas
    </a>
    
    <a href="logout.php">
        <svg class="icon" fill="white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
            <path d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 0 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708z"/>
            <path d="M4.5 3a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h7a1 1 0 0 0 1-1V9.707a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v2.293a.5.5 0 0 1-1 0V4a1 1 0 0 0-1-1h-7z"/>
        </svg>
        Cerrar sesión
    </a>
</div>

<div class="content">
    <h1>Bienvenido a Abarrotes Angeles</h1>
    <p>Seleccione una opción del menú para gestionar el sistema.</p>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
