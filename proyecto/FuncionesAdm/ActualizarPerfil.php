<?php
session_start();
if(isset($_SESSION["id_usuario"]) && isset($_SESSION['correo_usuario']) && $_SESSION['rol_usuario'] == 1) {
    // Incluir el archivo de conexión a la base de datos
    include_once('../Config/Conexion.php');
    
    // Obtener datos del formulario
    $id_usuario = $_SESSION["id_usuario"];
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $nuevaPassword = isset($_POST['password']) ? trim($_POST['password']) : '';
    
    // Validación básica
    if (empty($nombre)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'El nombre no puede estar vacío'
        ]);
        exit;
    }
    
    // Comprobar si la tabla AdministradorDatos existe
    $checkTableQuery = "SHOW TABLES LIKE 'AdministradorDatos'";
    $tableExists = $conexion->query($checkTableQuery)->num_rows > 0;
    
    if (!$tableExists) {
        // Crear la tabla si no existe
        $createTableQuery = "CREATE TABLE AdministradorDatos (
            id_admin INT AUTO_INCREMENT PRIMARY KEY,
            id_usuario INT,
            nombre_admin VARCHAR(100),
            FOREIGN KEY (id_usuario) REFERENCES Usuarios(id_usuario) ON DELETE CASCADE
        )";
        $conexion->query($createTableQuery);
    }
    
    // Verificar si ya existe un registro para este administrador
    $checkQuery = "SELECT id_admin FROM AdministradorDatos WHERE id_usuario = $id_usuario";
    $checkResult = $conexion->query($checkQuery);
    
    if ($checkResult->num_rows > 0) {
        // Actualizar el nombre en la tabla AdministradorDatos
        $updateNameQuery = "UPDATE AdministradorDatos SET nombre_admin = ? WHERE id_usuario = ?";
        $stmtName = $conexion->prepare($updateNameQuery);
        $stmtName->bind_param("si", $nombre, $id_usuario);
        $stmtName->execute();
        $stmtName->close();
    } else {
        // Insertar un nuevo registro en AdministradorDatos
        $insertQuery = "INSERT INTO AdministradorDatos (id_usuario, nombre_admin) VALUES (?, ?)";
        $stmtInsert = $conexion->prepare($insertQuery);
        $stmtInsert->bind_param("is", $id_usuario, $nombre);
        $stmtInsert->execute();
        $stmtInsert->close();
    }
    
    // Actualizar la contraseña si se proporcionó una nueva
    if (!empty($nuevaPassword)) {
        $updatePassQuery = "UPDATE Usuarios SET contrasena_usuario = ? WHERE id_usuario = ?";
        $stmtPass = $conexion->prepare($updatePassQuery);
        $stmtPass->bind_param("si", $nuevaPassword, $id_usuario);
        $stmtPass->execute();
        $stmtPass->close();
    }
    
    echo json_encode([
        'status' => 'success',
        'message' => 'Perfil actualizado correctamente'
    ]);
    
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Acceso no autorizado'
    ]);
}
?>