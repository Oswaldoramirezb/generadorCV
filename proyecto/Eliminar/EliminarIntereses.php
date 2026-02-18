<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');
    $id_interes = $_POST['id_interes'];
    $sql = "DELETE FROM InteresesPersonales WHERE id_interes = $id_interes";
    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>