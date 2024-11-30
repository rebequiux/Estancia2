<?php
include './Static/connect/bd.php'; 

// Verifica si existe el parámetro `id` en la URL
if(isset($_GET['id'])){
    // Obtiene el ID de la categoría
    $ID = $_GET['id'];

    // Ejecuta la consulta para eliminar la categoría
    $delete = "DELETE FROM categorias WHERE id=$ID;";
    $execute = mysqli_query($conn, $delete);

    // Redirige después de la eliminación
    header("Location: gestioncategorias.php");
    exit();
}
?>

<p><a href="admin.php"><img src="./Static/img/back.png"></a></p>
