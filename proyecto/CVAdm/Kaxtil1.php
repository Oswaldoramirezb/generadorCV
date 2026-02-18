<?php
session_start();
if (isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    include_once('../Config/Conexion.php');

    // Función para ejecutar consultas y manejar errores
    function ejecutarConsulta($conexion, $sql) {
        $resultado = $conexion->query($sql);
        if (!$resultado) {
            die("Error en la consulta: " . $conexion->error);
        }
        return $resultado;
    }

    // Consultar datos personales
    $sqlDatosPersonales = "SELECT * FROM DatosPersonales WHERE id_usuario = $id_usuario";
    $resultDatosPersonales = ejecutarConsulta($conexion, $sqlDatosPersonales);
    $datosPersonales = $resultDatosPersonales->fetch_assoc();

    // Consultar educación
    $sqlEducacion = "SELECT * FROM Educacion WHERE id_usuario = $id_usuario";
    $resultEducacion = ejecutarConsulta($conexion, $sqlEducacion);

    // Consultar experiencia
    $sqlExperiencia = "SELECT * FROM ExperienciaL WHERE id_usuario = $id_usuario";
    $resultExperiencia = ejecutarConsulta($conexion, $sqlExperiencia);

    // Consultar cursos
    $sqlCursos = "SELECT * FROM Cursos WHERE id_usuario = $id_usuario";
    $resultCursos = ejecutarConsulta($conexion, $sqlCursos);

    // Consultar habilidades
    $sqlHabilidades = "SELECT * FROM Habilidades WHERE id_usuario = $id_usuario";
    $resultHabilidades = ejecutarConsulta($conexion, $sqlHabilidades);

    // Consultar idiomas
    $sqlIdiomas = "SELECT * FROM Idiomas WHERE id_usuario = $id_usuario";
    $resultIdiomas = ejecutarConsulta($conexion, $sqlIdiomas);
    
    // Consultar intereses personales
    $sqlIntereses = "SELECT * FROM InteresesPersonales WHERE id_usuario = $id_usuario";
    $resultIntereses = ejecutarConsulta($conexion, $sqlIntereses);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae - Estilo Moderno</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
        }
        .cv-container {
            width: 850px;
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            page-break-inside: avoid;
        }
        .cv-header {
            text-align: center;
            margin-bottom: 40px; /* Ajustar el margen inferior para bajar el texto */
            transform: translateX(-7%);
            page-break-after: avoid;
        }
        .cv-header h1 {
            margin: 0;
            font-size: 36px;
        }
        .cv-header p {
            margin: 5px 0;
            font-size: 18px;
        }
        .cv-section {
            margin-bottom: 30px;
            page-break-inside: avoid; /* Evitar cortes de página dentro de las secciones */
        }
        .cv-section h2 {
            background-color: #082C58; /* Color azul */
            color: #fff;
            padding: 10px;
            margin: 0 -20px 20px -20px;
            font-size: 18px;
            page-break-after: avoid; /* Evitar cortes de página después del encabezado */
        }
        .cv-section ul {
            list-style-type: none;
            padding: 0;
        }
        .cv-section ul li {
            margin-bottom: 10px;
            page-break-inside: avoid; /* Evitar cortes de página dentro de los elementos de la lista */
        }
        .cv-section .institution,
        .cv-section .company {
            font-weight: bold;
        }
        .cv-section .date {
            font-style: italic;
        }
        .cv-section .description {
            margin-top: 5px;
            font-size: 14px; /* Asegurar que la descripción tenga el mismo tamaño de letra */
        }
        .skill, .language {
            font-size: 14px; /* Asegurar que las habilidades e idiomas tengan el mismo tamaño de letra */
        }
        #downloadPDF {
            display: block;
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        #downloadPDF:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="cv-container" id="cv-content">
        <div class="cv-header">
            <h1><?php echo htmlspecialchars($datosPersonales['nombre_datos'] ?? 'Nombre'); ?></h1>
            <?php if ($datosPersonales): ?>
                <p><?php echo htmlspecialchars($datosPersonales['correo_datos']); ?></p>
                <p><?php echo htmlspecialchars($datosPersonales['telefono_datos']); ?></p>
                <p><?php echo htmlspecialchars($datosPersonales['ciudad_datos']); ?></p>
                <?php if (!empty($datosPersonales['licenciatura_datos'])): ?>
                <p><?php echo htmlspecialchars($datosPersonales['licenciatura_datos']); ?></p>
                <?php if (!empty($datosPersonales['porcentaje_creditos'])): ?>
                <p><?php echo htmlspecialchars($datosPersonales['porcentaje_creditos']); ?>% de créditos concluidos en la UAM Azcapotzalco</p>
                <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if ($resultEducacion->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Educación</h2>
            <ul>
                <?php while($row = $resultEducacion->fetch_assoc()): ?>
                <li>
                    <div class="institution"><?php echo htmlspecialchars($row['nombre_institucion']); ?></div>
                    <div class="date">
                        <?php 
                        echo htmlspecialchars($row['mes_inicio_institucion'] . ' ' . $row['anio_inicio_institucion']);
                        if (!empty($row['mes_finalizacion_institucion'])) {
                            echo ' - ' . htmlspecialchars($row['mes_finalizacion_institucion']);
                            if (!empty($row['anio_finalizacion_institucion'])) {
                                echo ' ' . htmlspecialchars($row['anio_finalizacion_institucion']);
                            }
                        }
                        ?>
                    </div>
                    <div class="description"><?php echo htmlspecialchars($row['nivel_institucion'] . ' en ' . $row['especialidad_institucion']); ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultExperiencia->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Experiencia Profesional</h2>
            <ul>
                <?php while($row = $resultExperiencia->fetch_assoc()): ?>
                <li>
                    <div class="company"><?php echo htmlspecialchars($row['nombre_empresa']); ?></div>
                    <div class="date">
                        <?php 
                        echo htmlspecialchars($row['mes_inicio_empresa'] . ' ' . $row['anio_inicio_empresa']);
                        if (!empty($row['mes_finalizacion_empresa'])) {
                            echo ' - ' . htmlspecialchars($row['mes_finalizacion_empresa']);
                            if (!empty($row['anio_finalizacion_empresa'])) {
                                echo ' ' . htmlspecialchars($row['anio_finalizacion_empresa']);
                            }
                        }
                        ?>
                    </div>
                    <div class="description"><?php echo htmlspecialchars($row['puesto_empresa']); ?></div>
                    <div class="description"><?php echo htmlspecialchars($row['descripcion_empresa']); ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultCursos->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Certificaciones y Cursos</h2>
            <ul>
                <?php while($row = $resultCursos->fetch_assoc()): ?>
                <li>
                    <div class="institution"><?php echo htmlspecialchars($row['nombre_curso']); ?></div>
                    <div class="date"><?php echo htmlspecialchars($row['mes_finalizacion_curso'] . ' ' . $row['anio_finalizacion_curso']); ?></div>
                    <div class="description"><?php echo htmlspecialchars($row['institucion_curso']); ?></div>
                    <div class="description"><?php echo htmlspecialchars($row['duracion_curso']); ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultHabilidades->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Habilidades</h2>
            <ul>
                <?php while($row = $resultHabilidades->fetch_assoc()): ?>
                <li class="skill"><?php echo htmlspecialchars($row['habilidad']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultIdiomas->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Idiomas</h2>
            <ul>
                <?php while($row = $resultIdiomas->fetch_assoc()): ?>
                <li class="language"><?php echo htmlspecialchars($row['nombre_idioma'] . ' - ' . $row['nivel_idioma']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ($resultIntereses->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Intereses Personales</h2>
            <ul>
                <?php while($row = $resultIntereses->fetch_assoc()): ?>
                <li class="skill"><?php echo htmlspecialchars($row['interes']); ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Botón para descargar el PDF -->
    <button id="downloadPDF">Descargar PDF</button>

    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            var element = document.getElementById('cv-content');
            var button = document.getElementById('downloadPDF');
            button.style.display = 'none';  // Ocultar el botón

            var opt = {
                margin: [0.5, 0.5, 0.5, 0.5],  // Márgenes de 0.5 pulgadas alrededor para evitar páginas en blanco
                filename: 'CV-Kaxtil.pdf',
                image: { type: 'jpeg', quality: 1.0 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };
            html2pdf().from(element).set(opt).save().then(function () {
                button.style.display = 'inline-block';  // Volver a mostrar el botón
            });
        });
    </script>
</body>
</html>

<?php 
    $conexion->close();
} else {
    header('location: ../HomeAdmin.php');
}
?>