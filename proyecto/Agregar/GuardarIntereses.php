<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');
    $interes = ucwords(strtolower($_POST['interes']));
    $sql = "INSERT INTO InteresesPersonales (interes, id_usuario) VALUES ('$interes', $id_usuario)";
    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>