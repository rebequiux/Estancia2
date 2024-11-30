<?php include 'admin_layout.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Venta - Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Estilos personalizados -->
    <style>
        body {
            background-color: #f4f4f9;
            font-family: 'Open Sans', sans-serif;
        }
        .text-purple {
            color: #6a1b9a; /* Morado */
        }
        .bg-purple {
            background-color: #6a1b9a; /* Morado */
        }
        .btn-purple {
            background-color: #6a1b9a; /* Morado */
            border: none;
        }
        .btn-purple:hover {
            background-color: #9c4d97; /* Morado claro */
        }
        .card {
            border: none;
            border-radius: 1rem;
        }
        .card-header {
            background-color: #6a1b9a;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
        }
        .btn-outline-primary {
            border-color: #6a1b9a;
            color: #6a1b9a;
        }
        .btn-outline-primary:hover {
            background-color: #6a1b9a;
            color: white;
        }
    </style>
</head>
<body>

<div class="container my-5">
    <!-- Formulario -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <div class="card shadow">
                <div class="card-header">
                    Crear Venta
                </div>
                <div class="card-body">
                    <form method="POST" action="altaventa.php">
                        <!-- Cliente -->
                        <div class="mb-3">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select id="cliente_id" name="cliente_id" class="form-control" required>
                                <option value="" disabled selected>Seleccione un cliente</option>
                                <?php
                                include './Static/connect/bd.php';
                                $clientes = mysqli_query($conn, "SELECT id, nombre FROM clientes ORDER BY nombre ASC");
                                while ($cliente = mysqli_fetch_assoc($clientes)) {
                                    echo "<option value='{$cliente['id']}'>{$cliente['nombre']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Usuario -->
                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Usuario</label>
                            <select id="usuario_id" name="usuario_id" class="form-control" required>
                                <option value="" disabled selected>Seleccione un usuario</option>
                                <?php
                                $usuarios = mysqli_query($conn, "SELECT id, usuario FROM usuarios ORDER BY usuario ASC");
                                while ($usuario = mysqli_fetch_assoc($usuarios)) {
                                    echo "<option value='{$usuario['id']}'>{$usuario['usuario']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Pedido Relacionado (Opcional) -->
                        <div class="mb-3">
                            <label for="pedido_id" class="form-label">Pedido Relacionado (Opcional)</label>
                            <select id="pedido_id" name="pedido_id" class="form-control">
                                <option value="" disabled selected>Seleccione un pedido</option>
                                <?php
                                $pedidos = mysqli_query($conn, "
                                    SELECT p.id, c.nombre AS cliente, p.total
                                    FROM pedidos p
                                    JOIN clientes c ON p.cliente_id = c.id
                                    WHERE p.venta_id IS NULL
                                    ORDER BY p.fecha DESC
                                ");
                                while ($pedido = mysqli_fetch_assoc($pedidos)) {
                                    echo "<option value='{$pedido['id']}'>Pedido #{$pedido['id']} - Cliente: {$pedido['cliente']} - Total: $".number_format($pedido['total'], 2)."</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="date" id="fecha" name="fecha" class="form-control" required>
                        </div>

                        <!-- Hora -->
                        <div class="mb-3">
                            <label for="hora" class="form-label">Hora</label>
                            <input type="time" id="hora" name="hora" class="form-control" required>
                        </div>

                        <!-- Total -->
                        <div class="mb-3">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" step="0.01" id="total" name="total" class="form-control" placeholder="$0.00" required>
                        </div>

                        <!-- Botón -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-purple text-white px-4">Crear Venta</button>
                        </div>
                    </form>

                    <!-- Enlace a Gestión de Ventas -->
                    <div class="mt-4 text-center">
                        <a href="gestionventas.php" class="btn btn-outline-primary">Regresar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
