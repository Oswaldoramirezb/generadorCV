<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');

    $id_educacion = $_POST['id_educacion'];

    $sql = "DELETE FROM Educacion WHERE id_educacion = $id_educacion";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
