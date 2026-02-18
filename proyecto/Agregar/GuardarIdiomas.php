<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $nombre_idioma = $_POST['nombre_idioma'];
    $nivel_idioma = $_POST['nivel_idioma'];

    $sql = "INSERT INTO Idiomas (nombre_idioma, nivel_idioma, id_usuario) VALUES ('$nombre_idioma', '$nivel_idioma', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
