<?php
include_once('../Config/Conexion.php');

$id_habilidades = $_POST['id_habilidades'];
$habilidad = ucwords(strtolower($_POST['habilidad']));

$sql = "UPDATE Habilidades SET habilidad='$habilidad' WHERE id_habilidades='$id_habilidades'";

if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}

$conexion->close();
header('Location: ../Home.php');
?>
