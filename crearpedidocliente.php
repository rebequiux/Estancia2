<?php
include './Static/connect/bd.php'; 
?>    
    <title>Crear Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'PT Sans', sans-serif;
            background-color: #f3f0ff; /* Fondo morado claro */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container-custom {
            background-color: #fff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 1000px;
            margin-left: 16rem;
        }
        .header {
            text-align: center;
            color: #6f42c1;
            margin-bottom: 30px;
            font-size: 2rem;
        }
        .form-label {
            color: #6f42c1;
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #6f42c1;
            border-radius: 8px;
        }
        .btn-custom {
            background-color: #6f42c1;
            color: #fff;
            border: none;
            border-radius: 8px;
            width: 100%;
            padding: 12px;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #5a3591;
        }
        .btn-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
        }
        .btn-link {
            color: #6f42c1;
            text-decoration: none;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .btn-link:hover {
            text-decoration: underline;
        }
        .icon {
            margin-right: 5px;
        }
        /* Agregar transiciones para suavizar el hover */
        .btn-custom, .btn-link {
            transition: all 0.3s ease-in-out;
        }
    </style>

    <div class="container">
        <div class="container-custom">
            <h2 class="header">Crear Pedido</h2>
            
            <!-- Formulario para crear pedido -->
            <form method="POST" action="altapedido.php">
                <div class="mb-4">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" id="usuario" name="usuario" class="form-control" placeholder="Nombre del usuario" required>
                </div>
                
                <div class="mb-4">
                    <label for="productos" class="form-label">Productos:</label>
                    <input type="text" id="productos" name="productos" class="form-control" placeholder="Lista de productos" required>
                </div>

                <div class="mb-4">
                    <label for="hora" class="form-label">Hora:</label>
                    <input type="time" id="hora" name="hora" class="form-control" required>
                </div>

                <div class="mb-4">
                    <label for="fecha" class="form-label">Fecha:</label>
                    <input type="date" id="fecha" name="fecha" class="form-control">
                </div>

                <button type="submit" class="btn btn-custom">Registrar Pedido</button>

                <div class="btn-container">
                    <a href="gestionpedidos.php" class="btn-link"><i class="bi bi-arrow-left icon"></i>Regresar</a>
                
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

