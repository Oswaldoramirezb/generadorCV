<?php
include_once('../Config/Conexion.php');

$id_idioma = $_POST['id_idioma'];
$nombre_idioma = $_POST['nombre_idioma'];
$nivel_idioma = $_POST['nivel_idioma'];

$sql = "UPDATE Idiomas SET nombre_idioma='$nombre_idioma', nivel_idioma='$nivel_idioma' WHERE id_idioma='$id_idioma'";

if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
header('Location: ../Home.php');
?>