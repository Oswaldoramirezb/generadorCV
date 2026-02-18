<?php
include_once('../Config/Conexion.php');
$id_interes = $_POST['id_interes'];
$interes = ucwords(strtolower($_POST['interes']));
$sql = "UPDATE InteresesPersonales SET interes='$interes' WHERE id_interes='$id_interes'";
if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error updating record: " . $conexion->error;
}
$conexion->close();
header('Location: ../Home.php');
?>