<?php
session_start();
include_once('../Config/Conexion.php');

if (isset($_POST['Correo']) && isset($_POST['Contrasena']) && isset($_POST['Rcontrasena'])) {

    function validar($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $correo = validar($_POST['Correo']);
    $contrasena = validar($_POST['Contrasena']);
    $Rcontrasena = validar($_POST['Rcontrasena']);

    // Verificar si el correo contiene el símbolo "@"
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        header("location: ../Registrarse.php?error=El correo no es válido");
        exit();
    }

    if (empty($contrasena)) {
        header("location: ../Registrarse.php?error=La contraseña es requerida");
        exit();
    } elseif (empty($Rcontrasena)) {
        header("location: ../Registrarse.php?error=Repetir clave es requerido");
        exit();
    } elseif ($contrasena !== $Rcontrasena) {
        header("location: ../Registrarse.php?error=La clave no coincide");
        exit();
    } else {
        //$contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM Usuarios WHERE correo_usuario ='$correo'";
        $query = $conexion->query($sql);

        if (mysqli_num_rows($query) > 0) {
            header("location: ../Registrarse.php?error=El usuario ya existe");
            exit();
        } else {
            $sql2 = "INSERT INTO Usuarios(correo_usuario, contrasena_usuario, rol_usuario) VALUES ('$correo', '$contrasena', 2)";
            $query2 = $conexion->query($sql2);

            if ($query2) {
                header("location: ../Registrarse.php?success=Usuario creado con éxito");
                exit();
            } else {
                header("location: ../Registrarse.php?error=Ocurrió un error al crear el usuario");
                exit();
            }
        }
    }
} else {
    header('location: ../Registrarse.php');
    exit();
}
?>
