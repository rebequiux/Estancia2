<?php include 'admin_layout.php'; ?>
<?php
include './Static/connect/bd.php'; 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #f8f9fa;
            color: #333;
            font-family: 'Open Sans', sans-serif;
        }
        .container-custom {
            margin-top: 20px;
            max-width: 1000px;
            margin-left: 16rem;
        }
        .header {
            background-color: #6a1b9a; /* Morado */
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .header h2 {
            font-size: 28px;
            font-weight: bold;
        }
        .btn-morado {
            background-color: #6a1b9a;
            color: white;
            border-radius: 5px;
        }
        .btn-morado:hover {
            background-color: #4a148c;
        }
        .btn-icon {
            padding: 6px 12px;
            font-size: 14px;
        }
        .search-bar {
            border: 1px solid #6a1b9a;
            border-radius: 5px;
            padding: 10px;
        }
        .search-bar::placeholder {
            color: #6a1b9a;
        }
        .table-responsive {
            margin-top: 20px;
        }
        table {
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th {
            background-color: #6a1b9a;
            color: white;
            padding: 15px;
            font-weight: bold;
        }
        td {
            padding: 10px;
        }
        .btn-action {
            margin-top: 10px;
        }
        /* Asegura que los botones de acción estén en fila */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<div class="container container-custom">
    <div class="header text-center">
        <h2>Gestión de Usuarios</h2>
    </div>
    
    <!-- Barra de búsqueda y botón de nuevo usuario -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <button class="btn btn-morado" onclick="window.location.href='crearusuario.php'">Registrar Nuevo Usuario</button>
    </div>

    <!-- Tabla de usuarios -->
    <div class="table-responsive">
        <table class="table table-striped align-middle text-center">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Contraseña</th>
                    <th>Correo</th>
                    <th>Tipo de Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM usuarios";
                $exec = mysqli_query($conn, $sql);

                while ($rows = mysqli_fetch_array($exec)) {
                ?>
                <tr>
                    <td><?php echo $rows['id_usuarios']; ?></td>
                    <td><?php echo $rows['usuario']; ?></td>
                    <td><?php echo $rows['contrasena']; ?></td>
                    <td><?php echo $rows['correo']; ?></td>
                    <td><?php echo $rows['tipo_usuario']; ?></td>
                    <td>
                    <button class="btn btn-icon btn-morado me-2" onclick="window.location.href='actualizarusuario.php?id_usuarios=<?php echo $rows['id_usuarios']; ?>'">
    Actualizar
</button>

                        <form method="POST" action="eliminarusuario.php" style="display:inline;" onsubmit="return confirmarEliminacion(event)">
                            <input type="hidden" name="user_ids[]" value="<?php echo $rows['id_usuarios']; ?>">
                            <button class="btn btn-icon btn-danger" type="submit">
                                Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    function confirmarEliminacion(event) {
        event.preventDefault(); // Detiene el envío del formulario
        const form = event.target; // Obtiene el formulario actual
        Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Envía el formulario si el usuario confirma
            }
        });
        return false; // Previene el envío del formulario hasta que SweetAlert se resuelva
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
