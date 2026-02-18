<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');

    $id_idioma = $_POST['id_idioma'];

    $sql = "DELETE FROM Idiomas WHERE id_idioma = $id_idioma";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
