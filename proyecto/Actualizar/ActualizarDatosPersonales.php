<?php 
include_once('../Config/Conexion.php');  
$id_datos = $_POST['id_datos']; 
$nombre_datos = ucwords(strtolower($_POST['nombre_datos'])); // Convertir a minúsculas primero y luego primera letra de cada palabra a mayúscula
$licenciatura_datos = $_POST['licenciatura_datos']; 
$matricula_datos = $_POST['matricula_datos']; 
$ciudad_datos = ucwords(strtolower($_POST['ciudad_datos'])); 
$telefono_datos = $_POST['telefono_datos']; 
$correo_datos = $_POST['correo_datos'];
$porcentaje_creditos = $_POST['porcentaje_creditos'];  

$sql = "UPDATE DatosPersonales SET nombre_datos='$nombre_datos', licenciatura_datos='$licenciatura_datos', matricula_datos='$matricula_datos', ciudad_datos='$ciudad_datos', telefono_datos='$telefono_datos', correo_datos='$correo_datos', porcentaje_creditos='$porcentaje_creditos' WHERE id_datos='$id_datos'";  

if ($conexion->query($sql) === TRUE) {     
    echo "Record updated successfully"; 
} else {     
    echo "Error updating record: " . $conexion->error; 
}  

$conexion->close(); 
header('Location: ../Home.php'); 
?>