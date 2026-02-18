<?php
include_once('../Config/Conexion.php');

$id_curso = $_POST['id_curso'];
$nombre_curso = $_POST['nombre_curso'];
$institucion_curso = $_POST['institucion_curso'];
$duracion_curso = $_POST['duracion_curso'];
$mes_finalizacion_curso = $_POST['mes_finalizacion_curso'];
$anio_finalizacion_curso = $_POST['anio_finalizacion_curso'];

$sql = "UPDATE Cursos SET nombre_curso='$nombre_curso', institucion_curso='$institucion_curso', duracion_curso='$duracion_curso', mes_finalizacion_curso='$mes_finalizacion_curso', anio_finalizacion_curso='$anio_finalizacion_curso' WHERE id_curso='$id_curso'";

if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
header('Location: ../Home.php');
?>
