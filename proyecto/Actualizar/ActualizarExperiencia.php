<?php
include_once('../Config/Conexion.php');

$id_experiencia = $_POST['id_experiencia'];
$nombre_empresa = $_POST['nombre_empresa'];
$puesto_empresa = $_POST['puesto_empresa'];
$mes_inicio_empresa = $_POST['mes_inicio_empresa'];
$anio_inicio_empresa = $_POST['anio_inicio_empresa'];
$mes_finalizacion_empresa = $_POST['mes_finalizacion_empresa'];
$anio_finalizacion_empresa = $_POST['anio_finalizacion_empresa'];
$descripcion_empresa = $_POST['descripcion_empresa'];

$sql = "UPDATE ExperienciaL SET nombre_empresa='$nombre_empresa', puesto_empresa='$puesto_empresa', mes_inicio_empresa='$mes_inicio_empresa', anio_inicio_empresa='$anio_inicio_empresa', mes_finalizacion_empresa='$mes_finalizacion_empresa', anio_finalizacion_empresa='$anio_finalizacion_empresa', descripcion_empresa='$descripcion_empresa' WHERE id_experiencia='$id_experiencia'";

if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
header('Location: ../Home.php');
?>
