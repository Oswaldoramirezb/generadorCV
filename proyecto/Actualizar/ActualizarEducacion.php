<?php
include_once('../Config/Conexion.php');

$id_educacion = $_POST['id_educacion'];
$nombre_institucion = $_POST['nombre_institucion'];
$nivel_institucion = $_POST['nivel_institucion'];
$especialidad_institucion = $_POST['especialidad_institucion'];
$mes_inicio_institucion = $_POST['mes_inicio_institucion'];
$anio_inicio_institucion = $_POST['anio_inicio_institucion'];
$mes_finalizacion_institucion = $_POST['mes_finalizacion_institucion'];
$anio_finalizacion_institucion = $_POST['anio_finalizacion_institucion'];

$sql = "UPDATE Educacion SET nombre_institucion='$nombre_institucion', nivel_institucion='$nivel_institucion', especialidad_institucion='$especialidad_institucion', mes_inicio_institucion='$mes_inicio_institucion', anio_inicio_institucion='$anio_inicio_institucion', mes_finalizacion_institucion='$mes_finalizacion_institucion', anio_finalizacion_institucion='$anio_finalizacion_institucion' WHERE id_educacion='$id_educacion'";

if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
header('Location: ../Home.php');
?>
