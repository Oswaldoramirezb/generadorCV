<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');

    $id_datos = $_POST['id_datos'];

    $sql = "DELETE FROM DatosPersonales WHERE id_datos = $id_datos";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
