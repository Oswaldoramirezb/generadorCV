<?php
include_once('../Config/Conexion.php');

// Verificar si se proporciona un ID de usuario válido
if(isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Eliminar registro de la tabla DatosPersonales
    $sql_delete_datos_personales = "DELETE FROM DatosPersonales WHERE id_usuario = $id_usuario";
    $conexion->query($sql_delete_datos_personales);

    // Eliminar registro de la tabla Usuarios
    $sql_delete_usuario = "DELETE FROM Usuarios WHERE id_usuario = $id_usuario";
    $conexion->query($sql_delete_usuario);

    // Redirigir a HomeAdmin.php después de eliminar
    header('Location: ../HomeAdmin.php');
    exit();
} else {
    // Si no se proporciona un ID válido, redirigir a HomeAdmin.php
    header('Location: ../HomeAdmin.php');
    exit();
}
