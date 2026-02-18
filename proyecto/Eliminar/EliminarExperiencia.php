<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');

    $id_experiencia = $_POST['id_experiencia'];

    $sql = "DELETE FROM ExperienciaL WHERE id_experiencia = $id_experiencia";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
