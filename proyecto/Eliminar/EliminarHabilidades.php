<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    include_once('../Config/Conexion.php');

    $id_habilidades = $_POST['id_habilidades'];

    $sql = "DELETE FROM Habilidades WHERE id_habilidades = $id_habilidades";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
