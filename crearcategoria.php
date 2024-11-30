<?php include 'admin_layout.php'; ?>
<?php include './Static/connect/bd.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Abarrotes Ángeles</title>
    <meta name="description" content="Página web de Abarrotes Ángeles">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            color: #6f42c1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
        }
        .bg-purple {
            background-color: #6f42c1 !important;
            color: #fff;
        }
        .btn-purple {
            background-color: #6f42c1;
            color: #fff;
            border-color: #6f42c1;
        }
        .btn-purple:hover {
            background-color: #5a359d;
            border-color: #5a359d;
        }
        .form-control:focus {
            border-color: #6f42c1;
            box-shadow: 0 0 0 0.25rem rgba(111, 66, 193, 0.25);
        }
        .text-purple {
            color: #6f42c1 !important;
        }
        .rounded-shadow {
            border-radius: 1.5rem;
            box-shadow: 0 1.5rem 1rem rgba(0, 0, 0, 0.1);
        }
        .form-container {
            max-width: 500px;
            width: 100%;
            background: #fff;
            padding: 2rem;
            border-radius: 1.5rem;
            box-shadow: 0 1.5rem 1rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="form-container">
    <!-- Header -->
    <div class="text-center bg-purple p-3 rounded-shadow mb-4">
        <h1 class="m-0">
            <i class="bi bi-shop"></i> 
            Abarrotes <span class="fw-bold">Ángeles</span>
        </h1>
    </div>

    <!-- Formulario -->
    <div>
        <h2 class="text-purple mb-4 text-center">
            <i class="bi bi-tag-fill"></i> Crear Categoría
        </h2>

        <!-- Mensajes de error o éxito -->
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert <?= strpos($_GET['msg'], 'éxito') !== false ? 'alert-success' : 'alert-danger'; ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['msg']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="altacategoria.php">
            <div class="mb-3">
                <label for="nombre" class="form-label fw-bold">Nombre de la Categoría</label>
                <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingresa el nombre" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label fw-bold">Descripción de la Categoría</label>
                <textarea id="descripcion" name="descripcion" class="form-control" placeholder="Ingresa una descripción" required></textarea>
            </div>
            <button type="submit" class="btn btn-purple w-100">
                <i class="bi bi-send-fill"></i> Enviar Datos
            </button>
        </form>
    </div>

    <!-- Navegación Inferior -->
    <div class="mt-4 text-center">
        <a href="gestioncategorias.php" class="btn btn-outline-purple">
            <i class="bi bi-arrow-left-circle-fill"></i> Regresar
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
