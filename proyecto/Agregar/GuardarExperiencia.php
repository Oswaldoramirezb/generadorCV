<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $nombre_empresa = $_POST['nombre_empresa'];
    $puesto_empresa = $_POST['puesto_empresa'];
    $mes_inicio_empresa = $_POST['mes_inicio_empresa'];
    $anio_inicio_empresa = $_POST['anio_inicio_empresa'];
    $mes_finalizacion_empresa = $_POST['mes_finalizacion_empresa'];
    $anio_finalizacion_empresa = $_POST['anio_finalizacion_empresa'];
    $descripcion_empresa = $_POST['descripcion_empresa'];

    $sql = "INSERT INTO ExperienciaL (nombre_empresa, puesto_empresa, mes_inicio_empresa, anio_inicio_empresa, mes_finalizacion_empresa, anio_finalizacion_empresa, descripcion_empresa, id_usuario) 
            VALUES ('$nombre_empresa', '$puesto_empresa', '$mes_inicio_empresa', '$anio_inicio_empresa', '$mes_finalizacion_empresa', '$anio_finalizacion_empresa', '$descripcion_empresa', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
