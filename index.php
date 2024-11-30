<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abarrotes Angeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Estilos personalizados -->
    <style>
        body {
            font-family: 'PT Sans', sans-serif;
            background-color: #f5f5f5;
        }
        .navbar {
            background-color: #6f42c1;
        }
        .navbar-brand {
            color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: #ffffff;
        }
        .header-texto {
            background-color: #d63384;
            color: #ffffff;
            padding: 2rem;
            text-align: center;
        }
        .blog h3 {
            color: #6f42c1;
            text-align: center;
        }
        .card {
            text-align: center;
        }
        .card img {
            margin: 0 auto;
        }
        .entrada h4 {
            color: #6f42c1;
        }
        .boton {
            display: inline-block;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            color: #ffffff;
            text-align: center;
        }
        .boton_primario {
            background-color: #6f42c1;
        }
        .boton_secundario {
            background-color: #d63384;
        }
        .footer {
            background-color: #6f42c1;
            color: #ffffff;
            padding: 1rem 0;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="nosotros.php">Abarrotes Angeles</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Inicio de Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php">Registro de Usuario</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="productos.php">Nuestros Productos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="header-texto">
        <div class="container">
            <h2>Bienvenido a Abarrotes Angeles</h2>
        </div>
    </header>

    <!-- Contenido Principal -->
    <div class="container mt-5">
        <div class="row">
            <!-- Blog -->
            <main class="col-lg-12 mb-4">
                <h3>CONÓCENOS</h3>

                <!-- Artículo 1 -->
                <div class="card mb-3">
                    <img src="./Static/img/1.jpg" class="card-img-top" alt="Equipo de trabajo">
                    <div class="card-body">
                        <h4>Equipo de trabajo</h4>
                        <p>Abarrotes Angeles es una microempresa familiar con un equipo comprometido.</p>
                    </div>
                </div>

                <!-- Artículo 2 -->
                <div class="card mb-3">
                    <img src="./Static/img/2.jpg" class="card-img-top" alt="Productos Destacados">
                    <div class="card-body">
                        <h4>Productos Destacados</h4>
                        <h5>Lo mejor para ti</h5>
                        <p>Conoce nuestra selección de productos de alta calidad a precios accesibles.</p>
                    </div>
                </div>

                <!-- Artículo 3 -->
                <div class="card mb-3">
                    <img src="./Static/img/3.jpg" class="card-img-top" alt="Beneficios de comprar local">
                    <div class="card-body">
                        <h4>Beneficios de Comprar En la Tienda de la Esquina</h4>
                        <p>Apoyar a negocios locales ayuda al desarrollo de nuestra comunidad.</p>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p>&copy; 2024 Abarrotes Angeles</p>
            <nav>
                <a class="nav-link d-inline-block text-white" href="nosotros.php">Nosotros</a>
                <a class="nav-link d-inline-block text-white" href="contacto.php">Contacto</a>
            </nav>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
