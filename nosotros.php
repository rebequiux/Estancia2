<?php include './Static/connect/bd.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Angeles">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5fa;
            font-family: 'Open Sans', sans-serif;
        }

        .navbar {
            background-color: #6a1b9a;
        }

        .navbar-brand {
            color: #fff;
            font-weight: bold;
        }

        .navbar-brand span {
            color: #e1bee7;
        }

        .section {
            padding: 2rem;
            background-color: #fff;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #6a1b9a;
        }

        p {
            color: #333;
        }

        .social-media a {
            margin: 0 10px;
            color: #6a1b9a;
        }

        .social-media svg {
            width: 40px;
            height: 40px;
        }

        .footer {
            background-color: #6a1b9a;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }
    </style>
</head>

<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Principal</a>
        </div>
    </nav>

    <!-- Contenedor principal -->
    <div class="container mt-4">
        <!-- Sección de Antecedentes -->
        <div class="section">
            <h2>Antecedentes de la Empresa</h2>
            <p>
                Abarrotes Angeles es una empresa dedicada a la comercialización de productos de abarrotes, con 12 años de experiencia en el sector, ubicada en la colonia Progreso, Calle Emiliano Zapata S/N, CP.62574 Jiutepec, Mor.
            </p>
            <p>
                Ante los cambios en los hábitos de consumo y la creciente necesidad de digitalización, la empresa ha identificado la importancia de modernizar su gestión, lo que ha impulsado el desarrollo del presente proyecto.
            </p>
        </div>

        <!-- Sección de Misión -->
        <div class="section">
            <h2>Misión</h2>
            <p>
                La misión de Abarrotes Angeles es brindar productos de calidad a precios accesibles, ofreciendo un servicio excepcional que se enfoque en satisfacer las necesidades diarias de sus clientes.
            </p>
        </div>

        <!-- Sección de Visión -->
        <div class="section">
            <h2>Visión</h2>
            <p>
                La visión de Abarrotes Angeles es consolidarse como una tienda de referencia en la región, reconocida por su catálogo de productos y precios competitivos, además de su capacidad de adaptarse a los cambios tecnológicos.
            </p>
        </div>

        <!-- Sección de Redes Sociales -->
        <div class="section text-center">
            <h2>Síguenos en redes</h2>
            <div class="social-media">
                <a href="https://www.instagram.com">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="fill:#6a1b9a;"><path d="M16.5,5C10.159,5,5,10.159,5,16.5V31.5C5,37.841,10.159,43,16.5,43H31.5C37.841,43,43,37.841,43,31.5V16.5C43,10.159,37.841,5,31.5,5H16.5z M34,12c1.105,0,2,0.895,2,2s-0.895,2-2,2s-2-0.895-2-2S32.895,12,34,12z M24,14c5.514,0,10,4.486,10,10s-4.486,10-10,10S14,29.514,14,24S18.486,14,24,14z"></path></svg>
                </a>
                <a href="https://www.facebook.com">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" style="fill:#6a1b9a;"><path d="M24,4C12.972,4,4,12.972,4,24c0,10.006,7.394,18.295,17,19.75V29h-4c-0.552,0-1-0.447-1-1v-3c0-0.553,0.448-1,1-1h4v-3.632C21,15.617,23.427,13,27.834,13c1.786,0,3.195,0.124,3.254,0.129C31.604,13.175,32,13.607,32,14.125V17.5c0,0.553-0.448,1-1,1h-2c-1.103,0-2,0.897-2,2V24h4c0.287,0,0.56,0.123,0.75,0.338l-0.375,3H27v14.75C36.606,42.295,44,34.006,44,24C44,12.972,35.028,4,24,4z"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>© 2024 Abarrotes Angeles. Todos los derechos reservados.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
