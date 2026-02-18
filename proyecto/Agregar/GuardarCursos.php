<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    $nombre_curso = $_POST['nombre_curso'];
    $institucion_curso = $_POST['institucion_curso'];
    $duracion_curso = $_POST['duracion_curso'];
    $mes_finalizacion_curso = $_POST['mes_finalizacion_curso'];
    $anio_finalizacion_curso = $_POST['anio_finalizacion_curso'];

    $sql = "INSERT INTO Cursos (nombre_curso, institucion_curso, duracion_curso, mes_finalizacion_curso, anio_finalizacion_curso, id_usuario) 
            VALUES ('$nombre_curso', '$institucion_curso', '$duracion_curso', '$mes_finalizacion_curso', '$anio_finalizacion_curso', $id_usuario)";

    $conexion->query($sql);
    $conexion->close();
    header('Location: ../Home.php');
} else {
    header('location: ../Index.php');
}
?>
