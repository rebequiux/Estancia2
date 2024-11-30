<?php include './Static/connect/bd.php'; ?> 

<?php
session_start();

// Inicializar el carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

// Agregar producto al carrito
if (isset($_POST['agregar_carrito'])) {
    $producto_id = filter_input(INPUT_POST, 'producto_id', FILTER_SANITIZE_NUMBER_INT);
    $cantidad = filter_input(INPUT_POST, 'cantidad', FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]) ?? 1;

    if ($producto_id && $cantidad) {
        $existe = false;

        // Buscar si el producto ya está en el carrito
        foreach ($_SESSION['carrito'] as &$item) {
            if ($item['producto_id'] == $producto_id) {
                $item['cantidad'] += $cantidad; // Acumula la cantidad
                $existe = true;
                break;
            }
        }

        // Si no existe, agregarlo como nuevo
        if (!$existe) {
            $_SESSION['carrito'][] = [
                'producto_id' => $producto_id,
                'cantidad' => $cantidad
            ];
        }
    }
}

// Obtener el total de productos en el carrito
$total_productos = array_sum(array_column($_SESSION['carrito'], 'cantidad'));

// Consulta para obtener los productos
$sql = "SELECT * FROM productos";
$result = $conn->query($sql);

// Verifica si se encontraron productos
$productos = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    echo "No se encontraron productos.";
}

$conn->close(); // Cerrar la conexión a la base de datos
?>

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
        .navbar {
            background-color: #6f42c1;
            color: white;
        }
        .navbar .icon-container {
            display: flex;
            align-items: center;
        }
        .icon-container a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
        }
        .icon-container a svg {
            width: 24px;
            height: 24px;
        }
        .icon-container .cart-icon .badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            font-size: 12px;
            padding: 5px 8px;
            border-radius: 50%;
        }
        .card img {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Principal</a>
            <div class="ms-auto icon-container">
                <!-- Ícono de carrito -->
                <a href="carrito.php" class="cart-icon position-relative">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1h1a.5.5 0 0 1 .485.379L2.89 5H14.5a.5.5 0 0 1 .491.592l-1.5 7A.5.5 0 0 1 13 13H4a.5.5 0 0 1-.491-.408L1.01 1.607 1.607 1H.5a.5.5 0 0 1-.5-.5zM5.5 13a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm8 0a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm-8-1h7.01l1.25-6H4.89l-1.25 6z"/>
                    </svg>
                    <span class="badge"><?= $total_productos ?></span>
                </a>
                <!-- Ícono de perfil de cliente -->
                <a href="perfilcliente.php" class="profile-icon position-relative">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                    <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 1a6.978 6.978 0 0 0-4.285 1.443A5.978 5.978 0 0 0 2 14h12a5.978 5.978 0 0 0-1.715-4.557A6.978 6.978 0 0 0 8 9z"/>
                </svg>
                 </a>

            </div>
        </div>
    </nav>

    <!-- Contenido de la página -->
    <main class="container my-5">
        <h2 class="text-center mb-4">Productos Disponibles</h2>
        <div class="row">
            <!-- Mostrar productos desde la base de datos -->
            <?php foreach ($productos as $producto): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <?php
                        $imagePath = "./Static/img/{$producto['producto']}.png";
                        $defaultImage = "./Static/img/sinfoto.png"; // Imagen por defecto si no se encuentra
                        ?>
                        <img src="<?= file_exists($imagePath) ? $imagePath : $defaultImage ?>" 
                             class="card-img-top" 
                             alt="<?= $producto['producto'] ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= $producto['producto'] ?></h5>
                            <p class="card-text">$<?= number_format($producto['precio'], 2) ?> MXN</p>
                            <form method="POST">
                                <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">
                                <label for="cantidad<?= $producto['id'] ?>">Cantidad:</label>
                                <input type="number" id="cantidad<?= $producto['id'] ?>" name="cantidad" class="form-control mb-2" min="1" value="1">
                                <button type="submit" name="agregar_carrito" class="btn btn-primary w-100">Agregar al Carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
