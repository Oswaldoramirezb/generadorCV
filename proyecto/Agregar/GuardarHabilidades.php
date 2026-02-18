<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $habilidad = ucwords(strtolower($_POST['habilidad']));

    $sql = "INSERT INTO Habilidades (habilidad, id_usuario) VALUES ('$habilidad', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
