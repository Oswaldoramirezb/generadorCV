<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $nombre_institucion = $_POST['nombre_institucion'];
    $nivel_institucion = $_POST['nivel_institucion'];
    $especialidad_institucion = $_POST['especialidad_institucion'];
    $mes_inicio_institucion = $_POST['mes_inicio_institucion'];
    $anio_inicio_institucion = $_POST['anio_inicio_institucion'];
    $mes_finalizacion_institucion = $_POST['mes_finalizacion_institucion'];
    $anio_finalizacion_institucion = $_POST['anio_finalizacion_institucion'];

    $sql = "INSERT INTO Educacion (nombre_institucion, nivel_institucion, especialidad_institucion, mes_inicio_institucion, anio_inicio_institucion, mes_finalizacion_institucion, anio_finalizacion_institucion, id_usuario) 
            VALUES ('$nombre_institucion', '$nivel_institucion', '$especialidad_institucion', '$mes_inicio_institucion', '$anio_inicio_institucion', '$mes_finalizacion_institucion', '$anio_finalizacion_institucion', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
