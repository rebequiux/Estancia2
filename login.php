<?php
include './Static/connect/bd.php';

session_start();

// Mostrar el mensaje de error si existe en la sesión
if (isset($_SESSION['error'])) {
    $errorMessage = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $errorMessage = '';
}

// Procesar el formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = mysqli_real_escape_string($conn, $_POST['usuario']);
    $contrasena = mysqli_real_escape_string($conn, $_POST['contrasena']);

    // Consulta para verificar las credenciales
    $query = "SELECT * FROM usuarios WHERE usuario = ? AND contrasena = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ss', $usuario, $contrasena);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Guardar datos del usuario en la sesión
        $_SESSION['usuario'] = [
            'id_usuarios' => $user['id_usuarios'],
            'usuario' => $user['usuario'],
            'tipo_usuario' => $user['tipo_usuario']
        ];

        // Redirigir según el tipo de usuario
        if ($user['tipo_usuario'] === 'admin') {
            header("Location: admin.php");
        } elseif ($user['tipo_usuario'] === 'empleado') {
            header("Location: empleado.php");
        } else {
            header("Location: cliente.php");
        }
        exit();
    } else {
        $_SESSION['error'] = "Usuario o contraseña incorrectos.";
        header("Location: login.php");
        exit();
    }
}
?>

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
            color: #333;
        }
        .formulario {
            max-width: 400px;
            margin: 3rem auto;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #6f42c1;
        }
        .form-label {
            color: #6f42c1;
        }
        .boton_1 {
            background-color: #6f42c1;
            color: #ffffff;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .boton_1:hover {
            background-color: #d63384;
        }
        .icon-links svg {
            fill: #6f42c1;
            width: 40px;
            height: 40px;
            margin: 0 10px;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .icon-links svg:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <!-- Formulario de autenticación -->
    <div class="formulario container">
        <legend><h2>Autenticación</h2></legend>
        
        <!-- Si hay un mensaje de error, lo mostramos como una alerta -->
        <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <!-- Campo Usuario -->
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario:</label>
                <input type="text" name="usuario" id="usuario" class="form-control" placeholder="Ingresa tu usuario" required>
            </div>

            <!-- Campo Contraseña -->
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña:</label>
                <input type="password" name="contrasena" id="contrasena" class="form-control" placeholder="Ingresa tu contraseña" required>
            </div>

            <!-- Botón Enviar -->
            <div class="d-grid">
                <button type="submit" class="boton_1">Enviar</button>
            </div>
        </form>

        <!-- Enlaces a Registro e Inicio -->
        <div class="text-center mt-4 icon-links">
            <a href="./index.php">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path d="M39.5,43h-9c-1.381,0-2.5-1.119-2.5-2.5v-9c0-1.105-0.895-2-2-2h-4c-1.105,0-2,0.895-2,2v9c0,1.381-1.119,2.5-2.5,2.5h-9C7.119,43,6,41.881,6,40.5V21.413c0-2.299,1.054-4.471,2.859-5.893L23.071,4.321c0.545-0.428,1.313-0.428,1.857,0L39.142,15.52C40.947,16.942,42,19.113,42,21.411V40.5C42,41.881,40.881,43,39.5,43z"></path></svg>
            </a>
            <a href="./registro.php">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50"><path d="M 25.90625 3.28125 C 16.566406 3.492188 15.507813 10.316406 17.5 18.1875 C 17.1875 18.398438 16.550781 19.148438 16.65625 20.40625 C 16.96875 22.714844 17.914063 23.34375 18.4375 23.34375 C 18.648438 24.917969 19.390625 26.574219 20.125 27.625 C 20.648438 28.359375 20.84375 29.304688 20.84375 30.25 C 20.84375 31.089844 20.855469 30.554688 20.75 31.5 C 20.644531 31.804688 20.496094 32.082031 20.3125 32.34375 C 20.527344 33.152344 21.765625 37 26 37 C 30.335938 37 31.5 32.847656 31.625 32.34375 C 31.429688 32.085938 31.273438 31.804688 31.15625 31.5 C 31.050781 30.347656 31.03125 30.882813 31.03125 29.9375 C 31.03125 29.097656 31.359375 28.378906 31.78125 27.75 C 32.515625 26.699219 33.226563 24.917969 33.4375 23.34375 C 34.070313 23.34375 35.007813 22.714844 35.21875 20.40625 C 35.324219 19.148438 34.828125 18.398438 34.40625 18.1875 C 35.457031 15.25 37.433594 6.132813 30.71875 5.1875 C 29.984375 3.929688 28.214844 3.28125 25.90625 3.28125 Z"></path></svg>
            </a>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
