<?php
include_once('../Config/Conexion.php'); // Ruta actualizada

// Verificar si se proporciona un ID de usuario válido y un nuevo rol
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario']) && isset($_GET['nuevo_rol']) && is_numeric($_GET['nuevo_rol'])) {
    $id_usuario = $_GET['id_usuario'];
    $nuevo_rol = $_GET['nuevo_rol'];

    // Actualizar el rol del usuario
    $sql_update_rol = "UPDATE Usuarios SET rol_usuario = $nuevo_rol WHERE id_usuario = $id_usuario";
    $conexion->query($sql_update_rol);

    // Redirigir a HomeAdmin.php después de actualizar
    header('Location: ../HomeAdmin.php'); // Ruta actualizada
    exit();
} else {
    // Si no se proporciona un ID o un nuevo rol válido, redirigir a HomeAdmin.php
    header('Location: ../HomeAdmin.php'); // Ruta actualizada
    exit();
}
?>
