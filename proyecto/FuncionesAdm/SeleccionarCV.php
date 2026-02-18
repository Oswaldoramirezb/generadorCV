<?php
include_once('../Config/Conexion.php');

// Verificar si se proporciona un ID de usuario válido
if (isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    // Obtener información del usuario
    $sql = "SELECT * FROM DatosPersonales WHERE id_usuario = $id_usuario";
    $result = $conexion->query($sql);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    // Si no se proporciona un ID válido, redirigir a HomeAdmin.php
    header('Location: ../HomeAdmin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar CV</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #c02727;
            --primary-dark: #a01e1e;
            --secondary-color: #e74c3c;
            --light-color: #f9f9f9;
            --dark-color: #333;
            --border-color: #ddd;
            --success-color: #28a745;
            --info-color: #17a2b8;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
            padding: 30px 20px;
        }
        
        /* Header */
        .header {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 15px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            position: relative;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 95%;
            margin: 0 auto;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: 700;
        }
        
        .back-link {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
            gap: 5px;
        }
        
        .back-link:hover {
            transform: translateX(-3px);
            color: #ffd700;
        }
        
        /* User profile section */
        .user-profile {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 25px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .profile-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            font-weight: 300;
        }
        
        .profile-info h2 {
            color: var(--primary-color);
            margin-bottom: 10px;
            font-size: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-top: 10px;
        }
        
        .user-detail {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #666;
            font-size: 14px;
        }
        
        .user-detail i {
            color: var(--primary-color);
        }
        
        /* CV Selection grid */
        .cv-selection-title {
            margin-bottom: 20px;
            color: var(--dark-color);
            font-size: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-color);
        }
        
        .cv-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .cv-category {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        
        .cv-category:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .cv-category-header {
            background-color: var(--primary-color);
            color: white;
            padding: 15px;
            font-weight: 500;
            font-size: 18px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .cv-category-content {
            padding: 15px;
        }
        
        .cv-list {
            list-style: none;
        }
        
        .cv-list li {
            margin-bottom: 12px;
            display: flex;
            align-items: center;
        }
        
        .cv-list li:last-child {
            margin-bottom: 0;
        }
        
        .cv-link {
            display: flex;
            align-items: center;
            color: var(--dark-color);
            text-decoration: none;
            transition: color 0.3s;
            font-weight: 400;
            gap: 8px;
            padding: 8px 5px;
            border-radius: 4px;
            transition: all 0.2s;
            width: 100%;
        }
        
        .cv-link:hover {
            background-color: rgba(192, 39, 39, 0.1);
            color: var(--primary-color);
            transform: translateX(5px);
        }
        
        .cv-link i {
            color: var(--primary-color);
        }
        
        .cv-variants {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 5px;
            padding-left: 25px;
        }
        
        .variant-link {
            display: inline-flex;
            align-items: center;
            padding: 5px 10px;
            background-color: #f5f5f5;
            border-radius: 20px;
            color: var(--dark-color);
            text-decoration: none;
            font-size: 13px;
            transition: all 0.2s;
            gap: 5px;
        }
        
        .variant-link i {
            font-size: 10px;
        }
        
        .variant-link:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .variant-link.Rojo:hover {
            background-color: #8D0D0D;
        }
        
        .variant-link.azul:hover {
            background-color: #0D4C8D;
        }
        
        .variant-link.verde:hover {
            background-color: #0D8D42;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .cv-grid {
                grid-template-columns: 1fr;
            }
            
            .user-profile {
                flex-direction: column;
                text-align: center;
            }
            
            .user-details {
                justify-content: center;
            }
            
            .profile-avatar {
                margin-bottom: 10px;
            }
        }
        
        /* Animaciones */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .animated {
            animation: fadeIn 0.5s ease-out;
        }
        
        .cv-category:nth-child(1) { animation-delay: 0.1s; }
        .cv-category:nth-child(2) { animation-delay: 0.2s; }
        .cv-category:nth-child(3) { animation-delay: 0.3s; }
        .cv-category:nth-child(4) { animation-delay: 0.4s; }
    </style>
</head>
<body>
    <!-- Cabecera -->
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>GeneraCV</h1>
            </div>
            <a href="../HomeAdmin.php" class="back-link">
                <i class="fas fa-arrow-left"></i> Volver al panel
            </a>
        </div>
    </div>
    
    <div class="container">
        <!-- Perfil del usuario -->
        <div class="user-profile animated">
            <div class="profile-avatar">
                <?php 
                // Obtener la primera letra del nombre
                $firstLetter = mb_substr($user['nombre_datos'] ?? 'U', 0, 1, 'UTF-8');
                echo strtoupper($firstLetter);
                ?>
            </div>
            <div class="profile-info">
                <h2>
                    <?php echo htmlspecialchars($user['nombre_datos'] ?? 'Usuario'); ?>
                    <span><i class="fas fa-id-card"></i></span>
                </h2>
                <div class="user-details">
                    <?php if (!empty($user['matricula_datos'])): ?>
                    <div class="user-detail">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Matrícula: <?php echo htmlspecialchars($user['matricula_datos']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['correo_datos'])): ?>
                    <div class="user-detail">
                        <i class="fas fa-envelope"></i>
                        <span><?php echo htmlspecialchars($user['correo_datos']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['licenciatura_datos'])): ?>
                    <div class="user-detail">
                        <i class="fas fa-book"></i>
                        <span><?php echo htmlspecialchars($user['licenciatura_datos']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['porcentaje_creditos'])): ?>
                    <div class="user-detail">
                        <i class="fas fa-chart-pie"></i>
                        <span><?php echo htmlspecialchars($user['porcentaje_creditos']); ?>% de créditos</span>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <!-- Sección de selección de CV -->
        <h3 class="cv-selection-title">Seleccione el formato de CV a visualizar</h3>
        
        <div class="cv-grid">
            <!-- Harvard -->
            <div class="cv-category animated">
                <div class="cv-category-header">
                    <i class="fas fa-university"></i> Harvard
                </div>
                <div class="cv-category-content">
                    <ul class="cv-list">
                        <li>
                            <a href="../CVAdm/Harvard.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="cv-link">
                                <i class="fas fa-file-alt"></i> Español
                            </a>
                        </li>
                        <li>
                            <a href="../CVAdm/HarvardEn.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="cv-link">
                                <i class="fas fa-language"></i> Inglés
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Mistli -->
            <div class="cv-category animated">
                <div class="cv-category-header">
                    <i class="fas fa-feather-alt"></i> Mistli
                </div>
                <div class="cv-category-content">
                    <ul class="cv-list">
                        <li>
                            <a href="../CVAdm/Mistli.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="cv-link">
                                <i class="fas fa-file-alt"></i> Español
                            </a>
                        </li>
                        <li>
                            <a href="../CVAdm/MistliE.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="cv-link">
                                <i class="fas fa-language"></i> Inglés
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Kaxtil -->
            <div class="cv-category animated">
                <div class="cv-category-header">
                    <i class="fas fa-palette"></i> Kaxtil
                </div>
                <div class="cv-category-content">
                    <ul class="cv-list">
                        <li>
                            <a href="#" class="cv-link">
                                <i class="fas fa-file-alt"></i> Español
                            </a>
                            <div class="cv-variants">
                                <a href="../CVAdm/Kaxtil.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link Rojo">
                                    <i class="fas fa-circle"></i> Rojo
                                </a>
                                <a href="../CVAdm/Kaxtil1.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link azul">
                                    <i class="fas fa-circle"></i> Azul
                                </a>
                                <a href="../CVAdm/Kaxtil2.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link verde">
                                    <i class="fas fa-circle"></i> Verde
                                </a>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="cv-link">
                                <i class="fas fa-language"></i> Inglés
                            </a>
                            <div class="cv-variants">
                                <a href="../CVAdm/KaxtilE.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link Rojo">
                                    <i class="fas fa-circle"></i> Rojo
                                </a>
                                <a href="../CVAdm/KaxtilE1.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link azul">
                                    <i class="fas fa-circle"></i> Azul
                                </a>
                                <a href="../CVAdm/KaxtilE2.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link verde">
                                    <i class="fas fa-circle"></i> Verde
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Amichin -->
            <div class="cv-category animated">
                <div class="cv-category-header">
                    <i class="fas fa-star"></i> Amichin
                </div>
                <div class="cv-category-content">
                    <ul class="cv-list">
                        <li>
                            <a href="#" class="cv-link">
                                <i class="fas fa-file-alt"></i> Español
                            </a>
                            <div class="cv-variants">
                                <a href="../CVAdm/Amichin.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link Rojo">
                                    <i class="fas fa-circle"></i> Rojo
                                </a>
                                <a href="../CVAdm/Amichin1.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link azul">
                                    <i class="fas fa-circle"></i> Azul
                                </a>
                                <a href="../CVAdm/Amichin2.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link verde">
                                    <i class="fas fa-circle"></i> Verde
                                </a>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="cv-link">
                                <i class="fas fa-language"></i> Inglés
                            </a>
                            <div class="cv-variants">
                                <a href="../CVAdm/AmichinE.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link Rojo">
                                    <i class="fas fa-circle"></i> Rojo
                                </a>
                                <a href="../CVAdm/AmichinE1.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link azul">
                                    <i class="fas fa-circle"></i> Azul
                                </a>
                                <a href="../CVAdm/AmichinE2.php?id_usuario=<?php echo $id_usuario; ?>" target="_blank" class="variant-link verde">
                                    <i class="fas fa-circle"></i> Verde
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Pequeña animación para las categorías
        document.addEventListener('DOMContentLoaded', function() {
            let categories = document.querySelectorAll('.cv-category');
            categories.forEach(category => {
                category.classList.add('animated');
            });
        });
    </script>
</body>
</html>