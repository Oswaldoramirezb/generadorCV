<?php
session_start();
if (isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    include_once('../Config/Conexion.php');

    // Función para ejecutar consultas y manejar errores
    function ejecutarConsulta($conexion, $sql) {
        $resultado = $conexion->query($sql);
        if (!$resultado) {
            die("Error in query: " . $conexion->error);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae - Creative</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            background: #e9e9e9;
            margin: 0;
            display: flex;
            letter-spacing: 2px;
            font-family: 'Arial', sans-serif;
        }
        .container {
            display: flex;
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            page-break-inside: avoid;
        }
        .left, .right {
            padding: 20px;
            box-sizing: border-box;
        }
        .left {
            background: white;
            width: 35%;
            box-shadow: 5px 0 14px 10px #eeeaea;
            page-break-inside: avoid;
        }
        .right {
            background: white;
            width: 65%;
            box-shadow: -5px 0 14px 10px #eeeaea;
            position: relative;
            page-break-inside: avoid;
        }
        .cv-header {
            text-align: center;
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .cv-header h1 {
            margin: 0;
            font-size: 36px;
        }
        .cv-header p {
            margin: 5px 0;
            font-size: 18px;
        }
        .credits {
            margin-top: 5px;
            font-size: 16px;
            color: #4f5963;
        }
        .cv-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .cv-section h2 {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
            page-break-after: avoid;
        }
        .cv-section ul {
            list-style-type: none;
            padding: 0;
        }
        .cv-section ul li {
            margin-bottom: 10px;
            page-break-inside: avoid;
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
        }
        .skill {
            font-size: 14px;
            font-weight: normal;
        }
        .hr1 {
            width: 100%;
            border: none;
            background: #4f59634d;
            height: 1px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: #4f5963;
        }
        .p1 {
            font-size: 14px;
            margin-bottom: 10px;
        }
        .p2 {
            font-size: 14px;
            margin-top: 5px;
            margin-bottom: 5px;
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
    <div id="cv-content" class="container">
        <div class="left">
            <h2>Contact</h2>
            <p class="p1"><?php echo htmlspecialchars($datosPersonales['telefono_datos'] ?? '+00-0000-0000'); ?></p>
            <p class="p1"><?php echo htmlspecialchars($datosPersonales['correo_datos'] ?? 'email@example.com'); ?></p>
            <p class="p1"><?php echo htmlspecialchars($datosPersonales['ciudad_datos'] ?? 'City'); ?></p>
            <hr class="hr1">
            <?php if ($resultHabilidades->num_rows > 0): ?>
                <h2>Skills</h2>
                <ul class="skill">
                    <?php while($row = $resultHabilidades->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['habilidad']); ?></li>
                    <?php endwhile; ?>
                </ul>
                <hr class="hr1">
            <?php endif; ?>
            <?php if ($resultIdiomas->num_rows > 0): ?>
                <h2>Languages</h2>
                <ul class="skill">
                    <?php while($row = $resultIdiomas->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['nombre_idioma'] . ' - ' . $row['nivel_idioma']); ?></li>
                    <?php endwhile; ?>
                </ul>
                <hr class="hr1">
            <?php endif; ?>
            <?php if ($resultIntereses->num_rows > 0): ?>
                <h2>Personal Interests</h2>
                <ul class="skill">
                    <?php while($row = $resultIntereses->fetch_assoc()): ?>
                    <li><?php echo htmlspecialchars($row['interes']); ?></li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="right">
            <div class="cv-header">
                <h1><?php echo htmlspecialchars($datosPersonales['nombre_datos'] ?? 'Name'); ?></h1>
                <p><?php echo htmlspecialchars($datosPersonales['licenciatura_datos'] ?? 'Degree'); ?></p>
                <?php if (!empty($datosPersonales['porcentaje_creditos'])): ?>
                <p class="credits"><?php echo htmlspecialchars($datosPersonales['porcentaje_creditos']); ?>% of credits completed at UAM Azcapotzalco</p>
                <?php endif; ?>
            </div>

            <?php if ($resultEducacion->num_rows > 0): ?>
                <div class="cv-section">
                    <h2>Education</h2>
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
                            <div class="description"><?php echo htmlspecialchars($row['nivel_institucion'] . ' in ' . $row['especialidad_institucion']); ?></div>
                        </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if ($resultExperiencia->num_rows > 0): ?>
                <div class="cv-section">
                    <h2>Work Experience</h2>
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
                    <h2>Courses and Certifications</h2>
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
        </div>
    </div>

    <!-- Botón para descargar el PDF -->
    <button id="downloadPDF">Download PDF</button>

    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            var element = document.getElementById('cv-content');
            var button = document.getElementById('downloadPDF');
            button.style.display = 'none';  // Ocultar el botón

            var opt = {
                margin: [0.3, 0.3, 0.3, 0.3],  // Márgenes reducidos para evitar páginas en blanco
                filename: 'CV-MistliE.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }  // Evitar cortes de página inadecuados
            };
            
            // Crear el PDF
            html2pdf().from(element).set(opt).save().then(function() {
                setTimeout(function() {
                    button.style.display = 'block';  // Volver a mostrar el botón
                }, 1000);
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