<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $nombre_datos = ucwords(strtolower($_POST['nombre_datos'])); // Convertir a minúsculas primero y luego primera letra de cada palabra a mayúscula
    $licenciatura_datos = $_POST['licenciatura_datos'];
    $matricula_datos = $_POST['matricula_datos'];
    $ciudad_datos = ucwords(strtolower($_POST['ciudad_datos']));
    $telefono_datos = $_POST['telefono_datos'];
    $correo_datos = $_POST['correo_datos'];
    $porcentaje_creditos = $_POST['porcentaje_creditos'];

    $sql = "INSERT INTO DatosPersonales (nombre_datos, licenciatura_datos, matricula_datos, ciudad_datos, telefono_datos, correo_datos, porcentaje_creditos, id_usuario) 
            VALUES ('$nombre_datos', '$licenciatura_datos', '$matricula_datos', '$ciudad_datos', '$telefono_datos', '$correo_datos', '$porcentaje_creditos', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>