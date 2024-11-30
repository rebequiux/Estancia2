<?php

include './Static/connect/bd.php'; 

?>

<?php

    if(isset($_GET['id'])){

        $ID = $_GET['id'];
        $delete = "DELETE FROM productos WHERE id=$ID;";
        $execute = mysqli_query($conn,$delete);
        sleep(2);
        header("Location:gestionproductos.php");
    }
?>

<p><a href="admin.php"><img src="./Static/img/back.png"></p>
           