<?php
session_start();
if (isset($_SESSION["id_usuario"]) && isset($_SESSION['correo_usuario']) && $_SESSION['rol_usuario'] == 1) {
    // Incluir el archivo de conexión a la base de datos
    include_once('../Config/Conexion.php');
    
    // Verificar si se envió una solicitud POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener datos del formulario
        $userId = isset($_POST['userId']) ? intval($_POST['userId']) : 0;
        $newPassword = isset($_POST['newPassword']) ? trim($_POST['newPassword']) : '';
        
        // Validación básica
        if ($userId <= 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID de usuario inválido'
            ]);
            exit;
        }
        
        if (empty($newPassword)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'La contraseña no puede estar vacía'
            ]);
            exit;
        }
        
        // Consultar si el usuario existe y si es administrador
        $checkUserQuery = "SELECT rol_usuario FROM Usuarios WHERE id_usuario = $userId";
        $checkResult = $conexion->query($checkUserQuery);
        
        if ($checkResult->num_rows === 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario no encontrado'
            ]);
            exit;
        }
        
        $userInfo = $checkResult->fetch_assoc();
        $adminId = $_SESSION["id_usuario"];
        
        // Un administrador no puede cambiar la contraseña de otro administrador a menos que sea él mismo
        if ($userInfo['rol_usuario'] == 1 && $userId != $adminId) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No tiene permisos para cambiar la contraseña de otro administrador'
            ]);
            exit;
        }
        
        // Actualizar la contraseña en la base de datos
        $updateQuery = "UPDATE Usuarios SET contrasena_usuario = ? WHERE id_usuario = ?";
        $stmt = $conexion->prepare($updateQuery);
        $stmt->bind_param("si", $newPassword, $userId);
        
        if ($stmt->execute()) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Contraseña actualizada correctamente'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error al actualizar la contraseña: ' . $conexion->error
            ]);
        }
        
        $stmt->close();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Método no permitido'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Acceso no autorizado'
    ]);
}
?>