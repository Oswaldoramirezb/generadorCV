<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
    include_once('../Config/Conexion.php');

    // Consultar datos personales
    $sqlDatosPersonales = "SELECT * FROM DatosPersonales WHERE id_usuario = $id_usuario";
    $resultDatosPersonales = $conexion->query($sqlDatosPersonales);
    $datosPersonales = $resultDatosPersonales->fetch_assoc();

    // Consultar educación
    $sqlEducacion = "SELECT * FROM Educacion WHERE id_usuario = $id_usuario";
    $resultEducacion = $conexion->query($sqlEducacion);

    // Consultar experiencia
    $sqlExperiencia = "SELECT * FROM ExperienciaL WHERE id_usuario = $id_usuario";
    $resultExperiencia = $conexion->query($sqlExperiencia);

    // Consultar cursos
    $sqlCursos = "SELECT * FROM Cursos WHERE id_usuario = $id_usuario";
    $resultCursos = $conexion->query($sqlCursos);

    // Consultar habilidades
    $sqlHabilidades = "SELECT * FROM Habilidades WHERE id_usuario = $id_usuario";
    $resultHabilidades = $conexion->query($sqlHabilidades);

    // Consultar idiomas
    $sqlIdiomas = "SELECT * FROM Idiomas WHERE id_usuario = $id_usuario";
    $resultIdiomas = $conexion->query($sqlIdiomas);
    
    // Consultar intereses personales
    $sqlIntereses = "SELECT * FROM InteresesPersonales WHERE id_usuario = $id_usuario";
    $resultIntereses = $conexion->query($sqlIntereses);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Curriculum Vitae - Harvard Style</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #cv-content {
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }
        .cv-header {
            text-align: center;
            margin-bottom: 40px;
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
            page-break-inside: avoid; /* Evitar división de sección */
        }
        .cv-section h2 {
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
            page-break-after: avoid; /* Evitar división después de encabezado */
        }
        .cv-section ul {
            list-style-type: none;
            padding: 0;
        }
        .cv-section ul li {
            margin-bottom: 10px;
            page-break-inside: avoid; /* Evitar división de elementos de lista */
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
            margin-left: 20px;
            font-size: 14px;
            font-weight: normal;
        }
        .hr1 {
            width: 100%;
            border: none;
            background: var(--light-color);
            height: 1px;
            margin-top: 20px;
            margin-bottom: 20px;
        }
        h2 {
            font-size: 18px;
            margin-bottom: 15px;
            color: var(--main-color);
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
    <div id="cv-content">
        <div class="cv-header">
            <h1><?php echo $datosPersonales['nombre_datos'] ?? 'User Name'; ?></h1>
            <?php if ($datosPersonales): ?>
                <p><?php echo $datosPersonales['correo_datos']; ?></p>
                <p><?php echo $datosPersonales['telefono_datos']; ?></p>
                <p><?php echo $datosPersonales['ciudad_datos']; ?></p>
                <?php if (!empty($datosPersonales['licenciatura_datos'])): ?>
                    <p><?php echo $datosPersonales['licenciatura_datos']; ?> - 
                    <?php echo !empty($datosPersonales['porcentaje_creditos']) ? $datosPersonales['porcentaje_creditos'] . '% of credits completed at UAM Azcapotzalco' : ''; ?></p>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <?php if ($resultEducacion->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Education</h2>
            <ul>
                <?php while($row = $resultEducacion->fetch_assoc()): ?>
                <li>
                    <div class="institution"><?php echo $row['nombre_institucion']; ?></div>
                    <div class="date">
                        <?php 
                        echo $row['mes_inicio_institucion'] . ' ' . $row['anio_inicio_institucion'];
                        if (!empty($row['mes_finalizacion_institucion'])) {
                            echo ' - ' . $row['mes_finalizacion_institucion'];
                            if (!empty($row['anio_finalizacion_institucion'])) {
                                echo ' ' . $row['anio_finalizacion_institucion'];
                            }
                        }
                        ?>
                    </div>
                    <div class="description"><?php echo $row['nivel_institucion'] . ' in ' . $row['especialidad_institucion']; ?></div>
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
                    <div class="company"><?php echo $row['nombre_empresa']; ?></div>
                    <div class="date">
                        <?php 
                        echo $row['mes_inicio_empresa'] . ' ' . $row['anio_inicio_empresa'];
                        if (!empty($row['mes_finalizacion_empresa'])) {
                            echo ' - ' . $row['mes_finalizacion_empresa'];
                            if (!empty($row['anio_finalizacion_empresa'])) {
                                echo ' ' . $row['anio_finalizacion_empresa'];
                            }
                        }
                        ?>
                    </div>
                    <div class="description"><?php echo $row['puesto_empresa']; ?></div>
                    <div class="description"><?php echo $row['descripcion_empresa']; ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultCursos->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Certifications and Courses</h2>
            <ul>
                <?php while($row = $resultCursos->fetch_assoc()): ?>
                <li>
                    <div class="institution"><?php echo $row['nombre_curso']; ?></div>
                    <div class="date"><?php echo $row['mes_finalizacion_curso'] . ' ' . $row['anio_finalizacion_curso']; ?></div>
                    <div class="description"><?php echo $row['institucion_curso']; ?></div>
                    <div class="description"><?php echo $row['duracion_curso'] ; ?></div>
                </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultHabilidades->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Skills</h2>
            <ul>
                <?php while($row = $resultHabilidades->fetch_assoc()): ?>
                <li><?php echo $row['habilidad']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultIdiomas->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Languages</h2>
            <ul>
                <?php while($row = $resultIdiomas->fetch_assoc()): ?>
                <li><?php echo $row['nombre_idioma'] . ' - ' . $row['nivel_idioma']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ($resultIntereses->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Personal Interests</h2>
            <ul>
                <?php while($row = $resultIntereses->fetch_assoc()): ?>
                <li><?php echo $row['interes']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Botón para descargar el PDF -->
    <button id="downloadPDF">Download PDF</button>

    <script>
        document.getElementById('downloadPDF').addEventListener('click', function () {
            var element = document.getElementById('cv-content');
            var button = document.getElementById('downloadPDF');
            button.style.display = 'none';  // Ocultar el botón

            var opt = {
                margin:       [0.3, 0.3, 0.3, 0.3], // Márgenes [top, right, bottom, left] en pulgadas
                filename:     'CV-HarvardE.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true, logging: false },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }  // Evitar cortes de página inadecuados
            };
            
            // Crear el PDF
            html2pdf().set(opt).from(element).save().then(function() {
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
    header('location: ../Index.php');
}
?>