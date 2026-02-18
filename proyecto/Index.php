<?php
// Comprobar si hay una sesión activa - ESTO DEBE IR AL PRINCIPIO DEL ARCHIVO
session_start();
if(isset($_SESSION["id_usuario"]) && isset($_SESSION['correo_usuario']) && isset($_SESSION['rol_usuario'])) {
    // Obtener el rol del usuario
    $rol_usuario = $_SESSION['rol_usuario'];
    // Redireccionar según el rol del usuario
    if ($rol_usuario == 1) {
        header('Location: HomeAdmin.php');
        exit(); // Agregar esta línea para detener la ejecución
    } elseif ($rol_usuario == 2) {
        header('Location: Home.php');
        exit(); // Agregar esta línea para detener la ejecución
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GeneraCV - Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #c02727;
            --primary-dark: #a01e1e;
            --secondary-color: #e74c3c;
            --light-color: #f5f5f5;
            --gray-color: #e4e4e4;
            --dark-color: #333;
            --success-color: #28a745;
            --error-color: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-image: linear-gradient(135deg, rgba(192, 39, 39, 0.1) 10%, rgba(243, 237, 237, 0.8) 70%);
        }
        
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 2.5rem;
            margin: 30px auto;
            border-radius: 12px;
            background-color: white;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            text-align: center;
            transition: transform 0.3s ease;
        }
        
        .login-container:hover {
            transform: translateY(-5px);
        }
        
        .login-header {
            margin-bottom: 30px;
        }
        
        .login-header h1 {
            color: var(--primary-color);
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }
        
        .login-header h1::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 3px;
            background-color: var(--primary-color);
            border-radius: 10px;
        }
        
        .login-header p {
            color: #777;
            font-size: 16px;
        }
        
        .login-form .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .login-form label {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: var(--dark-color);
            margin-bottom: 8px;
            font-weight: 500;
            text-align: left;
        }
        
        .login-form label i {
            color: var(--primary-color);
            margin-right: 8px;
            font-size: 18px;
        }
        
        .login-form input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s;
            background-color: var(--gray-color);
        }
        
        .login-form input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(192, 39, 39, 0.2);
            background-color: white;
        }
        
        .error-message {
            background-color: rgba(220, 53, 69, 0.1);
            color: var(--error-color);
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: left;
            font-size: 14px;
            border-left: 4px solid var(--error-color);
        }
        
        .login-actions {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 10px;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 20px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--light-color);
            color: var(--dark-color);
            border: 1px solid #ddd;
        }
        
        .btn-secondary:hover {
            background-color: var(--gray-color);
            color: var(--primary-color);
        }
        
        .login-footer {
            margin-top: 30px;
            color: #777;
            font-size: 14px;
        }
        
        .login-footer a {
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        /* Animaciones */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animated {
            animation: fadeInUp 0.5s ease-out;
        }
        
        /* Logo */
        .logo {
            margin-bottom: 20px;
        }
        
        .logo span {
            display: inline-block;
            font-size: 36px;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 1px;
        }
        
        .logo span.highlight {
            color: var(--dark-color);
        }
        
        /* Responsivo */
        @media (max-width: 480px) {
            .login-container {
                padding: 2rem 1.5rem;
                margin: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container animated">
        <div class="logo">
            <span>Genera<span class="highlight">CV</span></span>
        </div>
        
        <div class="login-header">
            <h1>Iniciar Sesión</h1>
            <p>Ingresa tus credenciales para continuar</p>
        </div>
        
        <?php if (isset($_GET['error'])) { ?>
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> <?php echo $_GET['error']; ?>
            </div>
        <?php } ?>
        
        <form action="Login/LoginAuth.php" method="POST" class="login-form">
            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> Correo Electrónico
                </label>
                <input type="text" id="email" name="Correo" placeholder="ejemplo@dominio.com" autocomplete="off" required>
            </div>
            
            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> Contraseña
                </label>
                <input type="password" id="password" name="Contrasena" placeholder="Ingresa tu contraseña" autocomplete="off" required>
            </div>
            
            <div class="login-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-sign-in-alt"></i> Ingresar
                </button>
                <a href="Registrarse.php" class="btn btn-secondary">
                    <i class="fas fa-user-plus"></i> Crear Cuenta
                </a>
            </div>
        </form>
        
        <div class="login-footer">
            <p>Sistema de Generación de CV para estudiantes de la UAM</p>
        </div>
    </div>
</body>
</html>