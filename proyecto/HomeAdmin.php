<?php
session_start();
if(isset($_SESSION["id_usuario"]) && isset($_SESSION['correo_usuario']) && $_SESSION['rol_usuario'] == 1) {
    $id_usuario = $_SESSION["id_usuario"];
    $correo_usuario = $_SESSION['correo_usuario'];

    // Incluir el archivo de conexión a la base de datos
    include_once('Config/Conexion.php');

    // Comprobamos si la tabla AdministradorDatos existe
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

    // Obtener información del administrador actual
    $sqlAdmin = "SELECT Usuarios.*, AdministradorDatos.nombre_admin 
                FROM Usuarios 
                LEFT JOIN AdministradorDatos ON Usuarios.id_usuario = AdministradorDatos.id_usuario 
                WHERE Usuarios.id_usuario = $id_usuario";
    
    $resultAdmin = $conexion->query($sqlAdmin);
    $adminData = $resultAdmin->fetch_assoc();
    
    $adminNombre = isset($adminData['nombre_admin']) && !empty($adminData['nombre_admin']) 
                  ? $adminData['nombre_admin'] 
                  : "Administrador";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- jQuery para efectos y AJAX -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables para la paginación y búsqueda avanzada -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <style>
        :root {
            --primary-color: #c02727;
            --secondary-color: #e74c3c;
            --light-color: #f9f9f9;
            --dark-color: #333;
            --border-color: #ddd;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: var(--dark-color);
            line-height: 1.6;
        }
        
        .container {
            width: 95%;
            margin: 0 auto;
            padding: 20px 0;
        }
        
        /* Header */
        .header {
            background-color: var(--primary-color);
            padding: 15px 0;
            color: white;
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
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .nav-links a:hover {
            color: #ffd700;
        }
        
        /* Panel principal */
        .admin-panel {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-top: 20px;
            padding: 20px;
            overflow: hidden;
        }
        
        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
        }
        
        .panel-header h2 {
            font-size: 22px;
            color: var(--primary-color);
        }
        
        /* Filtros */
        .filter-controls {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        
        .filter-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .filter-controls select, 
        .filter-controls input[type="text"] {
            padding: 8px 12px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            font-size: 14px;
        }
        
        .filter-controls select {
            background-color: white;
            cursor: pointer;
        }
        
        .search-box {
            flex-grow: 1;
            position: relative;
        }
        
        .search-box input[type="text"] {
            width: 100%;
            padding-right: 30px;
        }
        
        .search-box i {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        
        /* Tabla de usuarios */
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
        }
        
        .user-table th, 
        .user-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }
        
        .user-table th {
            background-color: var(--primary-color);
            color: white;
            font-weight: 500;
            position: sticky;
            top: 0;
        }
        
        .user-table tr:hover {
            background-color: rgba(192, 39, 39, 0.05);
        }
        
        /* Botones de acción */
        .action-btn {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            color: white;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s;
            background: var(--primary-color);
            border: none;
            cursor: pointer;
            margin-right: 5px;
        }
        
        .action-btn:hover {
            background-color: var(--secondary-color);
        }
        
        .action-btn.delete {
            background-color: #e74c3c;
        }
        
        .action-btn.delete:hover {
            background-color: #c0392b;
        }
        
        .action-btn.edit {
            background-color: #f39c12;
        }
        
        .action-btn.edit:hover {
            background-color: #d35400;
        }
        
        .action-btn.view {
            background-color: #3498db;
        }
        
        .action-btn.view:hover {
            background-color: #2980b9;
        }
        
        /* Paginación y elementos de DataTables */
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 4px;
            color: var(--dark-color) !important;
            border: 1px solid var(--border-color) !important;
            background: white !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--light-color) !important;
            color: var(--primary-color) !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-color) !important;
        }
        
        .dataTables_wrapper .dataTables_info {
            padding-top: 15px;
        }
        
        /* Responsividad */
        @media (max-width: 1024px) {
            .container {
                width: 98%;
            }
            
            .filter-controls {
                flex-direction: column;
                align-items: stretch;
            }
            
            .user-table {
                display: block;
                overflow-x: auto;
            }
        }
        
        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                gap: 10px;
            }
            
            .nav-links {
                margin-top: 10px;
            }
        }
        
        /* Estilos para modal (perfil) */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            overflow: auto;
        }
        
        .modal-content {
            background-color: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            animation: modalopen 0.3s;
        }
        
        @keyframes modalopen {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 15px;
            margin-bottom: 15px;
        }
        
        .close {
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        
        .close:hover {
            color: var(--primary-color);
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
        }
        
        .form-actions {
            text-align: right;
            margin-top: 20px;
        }
        
        button.save-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
        }
        
        button.save-btn:hover {
            background-color: var(--secondary-color);
        }
        
        /* Badge para roles */
        .role-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
            text-align: center;
        }
        
        .role-badge.admin {
            background-color: #ffc107;
            color: #664d03;
        }
        
        .role-badge.user {
            background-color: #0dcaf0;
            color: #055160;
        }

        /* Toast notifications */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1100;
        }
        
        .toast {
            background-color: white;
            color: var(--dark-color);
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            animation: toastin 0.3s;
            max-width: 300px;
        }
        
        .toast.success {
            border-left: 4px solid #28a745;
        }
        
        .toast.error {
            border-left: 4px solid #dc3545;
        }
        
        .toast-icon {
            margin-right: 10px;
            font-size: 20px;
        }
        
        .toast.success .toast-icon {
            color: #28a745;
        }
        
        .toast.error .toast-icon {
            color: #dc3545;
        }
        
        /* Contraseña oculta */
        .password-container {
            position: relative;
            display: flex;
            align-items: center;
        }
        
        .password-text {
            margin-right: 5px;
        }
        
        .toggle-password {
            cursor: pointer;
            color: #888;
            transition: color 0.3s;
        }
        
        .toggle-password:hover {
            color: var(--primary-color);
        }
        
        /* Modal para cambiar contraseña */
        .password-modal .modal-content {
            width: 400px;
        }
        
        @keyframes toastin {
            from {opacity: 0; transform: translateX(20px);}
            to {opacity: 1; transform: translateX(0);}
        }
    </style>
</head>
<body>
    <!-- Cabecera -->
    <div class="header">
        <div class="header-content">
            <div class="logo">
                <h1>GeneraCV</h1>
            </div>
            <div class="nav-links">
                <a href="#" id="profileBtn"><i class="fas fa-user"></i> Mi Perfil</a>
                <a href="Login/CerrarSesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
            </div>
        </div>
    </div>
    
    <!-- Contenedor principal -->
    <div class="container">
        <!-- Panel de administración -->
        <div class="admin-panel">
            <div class="panel-header">
                <h2>Bienvenido, <?php echo htmlspecialchars($adminNombre); ?></h2>
                <div class="admin-info">
                    <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($correo_usuario); ?></span>
                </div>
            </div>
            
            <!-- Filtros de búsqueda -->
            <div class="filter-controls">
                <div class="filter-item">
                    <select id="filterType">
                        <option value="all">Todos los campos</option>
                        <option value="name">Nombre</option>
                        <option value="matricula">Matrícula</option>
                        <option value="email">Correo</option>
                        <option value="carrera">Ingeniería</option>
                    </select>
                </div>
                <div class="search-box">
                    <input type="text" id="searchInput" placeholder="Buscar usuarios...">
                    <i class="fas fa-search"></i>
                </div>
            </div>
            
            <!-- Tabla de usuarios -->
            <table id="userTable" class="user-table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Matrícula</th>
                        <th>Correo Contacto</th>
                        <th>Licenciatura</th>
                        <th>Teléfono</th>
                        <th>Correo Registro</th>
                        <th>Contraseña</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Consultar todos los registros de las tablas pertinentes
                    $sql = "SELECT Usuarios.id_usuario, Usuarios.correo_usuario, Usuarios.contrasena_usuario, Usuarios.rol_usuario, 
                           DatosPersonales.nombre_datos, DatosPersonales.matricula_datos, DatosPersonales.correo_datos, 
                           DatosPersonales.telefono_datos, DatosPersonales.licenciatura_datos
                    FROM Usuarios 
                    LEFT JOIN DatosPersonales ON Usuarios.id_usuario = DatosPersonales.id_usuario
                    GROUP BY Usuarios.id_usuario
                    ORDER BY Usuarios.rol_usuario = 1 DESC";
                    $result = $conexion->query($sql);
                    
                    // Iterar sobre los resultados y mostrar cada registro en una fila de la tabla
                    while($row = $result->fetch_assoc()) {
                        $currentUserId = $id_usuario;
                        $rowUserId = $row['id_usuario'];
                        $isCurrentUserAdmin = ($row['rol_usuario'] == 1 && $rowUserId == $currentUserId);
                        $isOtherAdmin = ($row['rol_usuario'] == 1 && $rowUserId != $currentUserId);
                        
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nombre_datos'] ? $row['nombre_datos'] : '(Sin nombre)') . "</td>";
                        echo "<td>" . htmlspecialchars($row['matricula_datos'] ? $row['matricula_datos'] : '(Sin matrícula)') . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo_datos'] ? $row['correo_datos'] : '(Sin correo)') . "</td>";
                        echo "<td>" . htmlspecialchars($row['licenciatura_datos'] ? $row['licenciatura_datos'] : '(Sin licenciatura)') . "</td>";
                        echo "<td>" . htmlspecialchars($row['telefono_datos'] ? $row['telefono_datos'] : '(Sin teléfono)') . "</td>";
                        echo "<td>" . htmlspecialchars($row['correo_usuario']) . "</td>";
                        
                        // Mostrar contraseña solo si no es otro administrador
                        if ($isOtherAdmin) {
                            echo "<td>***********</td>";
                        } else {
                            echo "<td>
                                <div class='password-container'>
                                    <span class='password-text password-hidden' data-password='" . htmlspecialchars($row['contrasena_usuario']) . "'>********</span>
                                    <i class='fas fa-eye toggle-password' data-userid='" . $row['id_usuario'] . "'></i>
                                </div>
                            </td>";
                        }
                        
                        // Mostrar rol como texto en lugar de número
                        if ($row['rol_usuario'] == 1) {
                            echo "<td><span class='role-badge admin'>Administrador</span></td>";
                        } else {
                            echo "<td><span class='role-badge user'>Usuario</span></td>";
                        }
                        
                        echo "<td>";
                        
                        // No mostrar botones de eliminación o cambio de rol para uno mismo
                        if (!$isCurrentUserAdmin) {
                            echo "<a href='FuncionesAdm/EliminarUsuario.php?id_usuario=" . $row['id_usuario'] . "' class='action-btn delete delete-link' title='Eliminar usuario'><i class='fas fa-trash-alt'></i></a>";
                            
                            // Cambiar rol (solo mostrar para usuarios normales o administradores que no sean el actual)
                            if ($row['rol_usuario'] == 1) {
                                echo "<a href='FuncionesAdm/CambiarRol.php?id_usuario=" . $row['id_usuario'] . "&nuevo_rol=2' class='action-btn role-link' title='Quitar privilegios de administrador'><i class='fas fa-user'></i></a>";
                            } else {
                                echo "<a href='FuncionesAdm/CambiarRol.php?id_usuario=" . $row['id_usuario'] . "&nuevo_rol=1' class='action-btn role-link' title='Hacer administrador'><i class='fas fa-user-shield'></i></a>";
                            }
                            
                            // Botón para cambiar contraseña (solo para usuarios normales o si es el propio administrador)
                            if (!$isOtherAdmin) {
                                echo "<a href='#' class='action-btn edit change-password-btn' data-userid='" . $row['id_usuario'] . "' data-email='" . htmlspecialchars($row['correo_usuario']) . "' title='Cambiar contraseña'><i class='fas fa-key'></i></a>";
                            }
                        }
                        
                        // Botón para ver CV
                        // Botón para ver CV (solo para usuarios normales)
                        if ($row['rol_usuario'] != 1) {
                            echo "<a href='FuncionesAdm/SeleccionarCV.php?id_usuario=" . $row['id_usuario'] . "' class='action-btn view cv-link' title='Ver CV'><i class='fas fa-eye'></i></a>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Modal para editar perfil -->
    <div id="profileModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Mi Perfil</h3>
                <span class="close">&times;</span>
            </div>
            <form id="profileForm">
                <div class="form-group">
                    <label for="adminName">Nombre completo:</label>
                    <input type="text" id="adminName" name="adminName" value="<?php echo htmlspecialchars($adminNombre); ?>" required>
                </div>
                <div class="form-group">
                    <label for="adminEmail">Correo electrónico:</label>
                    <input type="email" id="adminEmail" name="adminEmail" value="<?php echo htmlspecialchars($correo_usuario); ?>" readonly>
                    <small>El correo no se puede cambiar</small>
                </div>
                <div class="form-group">
                    <label for="adminPassword">Nueva contraseña (dejar en blanco para mantener la actual):</label>
                    <input type="password" id="adminPassword" name="adminPassword">
                </div>
                <div class="form-group">
                    <label for="adminConfirmPassword">Confirmar nueva contraseña:</label>
                    <input type="password" id="adminConfirmPassword" name="adminConfirmPassword">
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal para cambiar contraseña de usuario -->
    <div id="passwordModal" class="modal password-modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Cambiar Contraseña</h3>
                <span class="close">&times;</span>
            </div>
            <form id="passwordForm">
                <input type="hidden" id="userId" name="userId">
                <div class="form-group">
                    <label for="userEmail">Correo electrónico:</label>
                    <input type="email" id="userEmail" name="userEmail" readonly>
                </div>
                <div class="form-group">
                    <label for="newPassword">Nueva contraseña:</label>
                    <input type="password" id="newPassword" name="newPassword" required>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirmar nueva contraseña:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required>
                </div>
                <div class="form-actions">
                    <button type="submit" class="save-btn">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Contenedor de notificaciones toast -->
    <div class="toast-container" id="toastContainer"></div>

    <script>
        $(document).ready(function() {
            // Inicializar DataTables con paginación
            var table = $('#userTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.1/i18n/es-ES.json"
                },
                "pageLength": 20,
                "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, "Todos"]],
                "dom": '<"top"fl>rt<"bottom"ip>',
                "order": [[7, 'desc']], // Ordenar por rol (columna 7) de forma descendente
                "columnDefs": [
                    { "orderable": false, "targets": 8 } // No permitir ordenar por la columna de acciones
                ]
            });
            
            // Búsqueda personalizada según filtro seleccionado
            $('#searchInput').on('keyup', function() {
                var filterType = $('#filterType').val();
                var searchValue = $(this).val();
                
                if (filterType === 'all') {
                    table.search(searchValue).draw();
                } else {
                    // Aplicar búsqueda a columnas específicas
                    var columnIndex;
                    switch(filterType) {
                        case 'name':
                            columnIndex = 0; // Índice de la columna Nombre
                            break;
                        case 'matricula':
                            columnIndex = 1; // Índice de la columna Matrícula
                            break;
                        case 'email':
                            columnIndex = [2, 5]; // Índices de las columnas Correo Contacto y Correo Registro
                            break;
                        case 'carrera':
                            columnIndex = 3; // Índice de la columna Licenciatura
                            break;
                    }
                    
                    // Si es un array de columnas
                    if (Array.isArray(columnIndex)) {
                        table.columns().search('').draw();
                        
                        // Búsqueda en múltiples columnas con OR
                        var searchRegex = searchValue ? searchValue : '';
                        columnIndex.forEach(function(index) {
                            table.column(index).search(searchRegex, true, false);
                        });
                        table.draw();
                    } else {
                        // Búsqueda en una sola columna
                        table.columns().search('').draw();
                        table.column(columnIndex).search(searchValue).draw();
                    }
                }
            });
            
            // Cambiar búsqueda al cambiar el filtro
            $('#filterType').on('change', function() {
                $('#searchInput').keyup();
            });
            
            // Mostrar/ocultar contraseña
            $(document).on('click', '.toggle-password', function() {
                var $passwordText = $(this).siblings('.password-text');
                var isHidden = $passwordText.hasClass('password-hidden');
                
                if (isHidden) {
                    $passwordText.text($passwordText.data('password'));
                    $passwordText.removeClass('password-hidden');
                    $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    $passwordText.text('********');
                    $passwordText.addClass('password-hidden');
                    $(this).removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
            
            // Confirmación de eliminación
            $(document).on('click', '.delete-link', function(e) {
                e.preventDefault();
                var deleteUrl = $(this).attr('href');
                
                if (confirm('¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.')) {
                    // Efecto de desvanecimiento
                    $(this).closest('tr').fadeOut(300, function() {
                        // Redireccionar para la eliminación
                        window.location.href = deleteUrl;
                    });
                }
            });
            
            // Confirmación de cambio de rol
            $(document).on('click', '.role-link', function(e) {
                        e.preventDefault();
                        var roleUrl = $(this).attr('href');
                        var isToAdmin = roleUrl.includes('nuevo_rol=1');
                        var confirmMessage = isToAdmin 
                            ? '¿Está seguro de que desea convertir este usuario en administrador?'
                            : '¿Está seguro de que desea quitar los privilegios de administrador a este usuario?';
                        
                        if (confirm(confirmMessage)) {
                            // Animación simple
                            var $row = $(this).closest('tr');
                            $row.css('background-color', '#fff3cd');
                            setTimeout(function() {
                                window.location.href = roleUrl;
                            }, 300);
                        }
                    });
                    
                    // Modal para cambiar contraseña
                    var passwordModal = document.getElementById('passwordModal');
                    var passwordModalCloseBtns = passwordModal.getElementsByClassName('close');
                    
                    // Abrir modal de cambio de contraseña
                    $(document).on('click', '.change-password-btn', function(e) {
                        e.preventDefault();
                        var userId = $(this).data('userid');
                        var userEmail = $(this).data('email');
                        
                        $('#userId').val(userId);
                        $('#userEmail').val(userEmail);
                        $('#newPassword').val('');
                        $('#confirmPassword').val('');
                        
                        passwordModal.style.display = 'block';
                    });
                    
                    // Cerrar modal de cambio de contraseña
                    for (var i = 0; i < passwordModalCloseBtns.length; i++) {
                        passwordModalCloseBtns[i].onclick = function() {
                            passwordModal.style.display = 'none';
                        }
                    }
                    
                    // Cerrar modal al hacer clic fuera del contenido
                    window.onclick = function(event) {
                        if (event.target == passwordModal) {
                            passwordModal.style.display = 'none';
                        } else if (event.target == modal) {
                            modal.style.display = 'none';
                        }
                    }
                    
                    // Enviar formulario de cambio de contraseña
                    $('#passwordForm').on('submit', function(e) {
                        e.preventDefault();
                        
                        var userId = $('#userId').val();
                        var newPassword = $('#newPassword').val();
                        var confirmPassword = $('#confirmPassword').val();
                        
                        // Validación
                        if (newPassword !== confirmPassword) {
                            showToast('Las contraseñas no coinciden', 'error');
                            return;
                        }
                        
                        // Enviar datos mediante AJAX
                        $.ajax({
                            url: 'FuncionesAdm/CambiarContrasena.php',
                            type: 'POST',
                            data: {
                                userId: userId,
                                newPassword: newPassword
                            },
                            success: function(response) {
                                try {
                                    var result = JSON.parse(response);
                                    if (result.status === 'success') {
                                        showToast('Contraseña actualizada correctamente', 'success');
                                        passwordModal.style.display = 'none';
                                        
                                        // Actualizar la contraseña mostrada en la tabla
                                        var $passwordText = $('.toggle-password[data-userid="' + userId + '"]')
                                                           .siblings('.password-text');
                                        $passwordText.data('password', newPassword);
                                        if (!$passwordText.hasClass('password-hidden')) {
                                            $passwordText.text(newPassword);
                                        }
                                    } else {
                                        showToast('Error: ' + result.message, 'error');
                                    }
                                } catch(e) {
                                    showToast('Error en la respuesta del servidor', 'error');
                                }
                            },
                            error: function() {
                                showToast('Error de conexión', 'error');
                            }
                        });
                    });
                    
                    // Modal de perfil
                    var modal = document.getElementById('profileModal');
                    var btn = document.getElementById('profileBtn');
                    var span = document.getElementsByClassName('close')[0];
                    
                    // Abrir modal
                    btn.onclick = function() {
                        modal.style.display = 'block';
                    }
                    
                    // Cerrar modal
                    span.onclick = function() {
                        modal.style.display = 'none';
                    }
                    
                    // Manejar actualización de perfil con AJAX
                    $('#profileForm').on('submit', function(e) {
                        e.preventDefault();
                        
                        var adminName = $('#adminName').val();
                        var adminPassword = $('#adminPassword').val();
                        var adminConfirmPassword = $('#adminConfirmPassword').val();
                        
                        // Validación de contraseñas
                        if (adminPassword !== '' && adminPassword !== adminConfirmPassword) {
                            showToast('Las contraseñas no coinciden', 'error');
                            return;
                        }
                        
                        // Solicitud AJAX para actualizar
                        $.ajax({
                            url: 'FuncionesAdm/ActualizarPerfil.php',
                            type: 'POST',
                            data: {
                                nombre: adminName,
                                password: adminPassword
                            },
                            success: function(response) {
                                try {
                                    var result = JSON.parse(response);
                                    if (result.status === 'success') {
                                        // Actualizar la página después de un cambio exitoso
                                        showToast('Perfil actualizado correctamente', 'success');
                                        setTimeout(function() {
                                            location.reload();
                                        }, 1500);
                                    } else {
                                        showToast('Error: ' + result.message, 'error');
                                    }
                                } catch(e) {
                                    showToast('Error en la respuesta del servidor', 'error');
                                }
                            },
                            error: function() {
                                showToast('Error de conexión', 'error');
                            }
                        });
                    });
                    
                    // Función para mostrar notificaciones toast
                    function showToast(message, type) {
                        var toast = $('<div class="toast ' + type + '"></div>');
                        var icon = type === 'success' 
                            ? '<i class="fas fa-check-circle toast-icon"></i>' 
                            : '<i class="fas fa-exclamation-circle toast-icon"></i>';
                        
                        toast.html(icon + message);
                        $('#toastContainer').append(toast);
                        
                        // Eliminar toast después de 3 segundos
                        setTimeout(function() {
                            toast.fadeOut(function() {
                                $(this).remove();
                            });
                        }, 3000);
                    }
                    
                    // Verificar si hay mensajes en la URL (después de redireccionamientos)
                    var urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.has('message') && urlParams.has('type')) {
                        showToast(decodeURIComponent(urlParams.get('message')), urlParams.get('type'));
                        
                        // Limpiar parámetros de URL sin recargar la página
                        window.history.replaceState({}, document.title, window.location.pathname);
                    }
                });
            </script>
        </body>
        </html>

        <?php 
        } else {
            header('location: Index.php');
        }
        ?>