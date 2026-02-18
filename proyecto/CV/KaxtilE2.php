<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
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
            width: 900px;
            background-color: #fff;
            padding: 20px;
            margin: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            box-sizing: border-box;
            page-break-after: auto;
        }
        .cv-header {
            text-align: center;
            margin-bottom: 40px;
            transform: translateX(-6%);
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
        }
        .cv-section h2 {
            background-color: #063F24;
            color: #fff;
            padding: 10px;
            margin: 0 -20px 20px -20px;
            font-size: 18px;
        }
        .cv-section ul {
            list-style-type: none;
            padding: 0;
        }
        .cv-section ul li {
            margin-bottom: 10px;
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
            font-size: 14px;
        }
        .skill, .language {
            font-size: 14px;
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
            <h1><?php echo $datosPersonales['nombre_datos'] ?? 'Name'; ?></h1>
            <?php if ($datosPersonales): ?>
                <p><?php echo $datosPersonales['correo_datos']; ?></p>
                <p><?php echo $datosPersonales['telefono_datos']; ?></p>
                <p><?php echo $datosPersonales['ciudad_datos']; ?></p>
                <?php if (!empty($datosPersonales['licenciatura_datos'])): ?>
                <p><?php echo $datosPersonales['licenciatura_datos']; ?></p>
                <?php if (!empty($datosPersonales['porcentaje_creditos'])): ?>
                <p><?php echo $datosPersonales['porcentaje_creditos']; ?>% of credits completed at UAM Azcapotzalco</p>
                <?php endif; ?>
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
                    <div class="date"><?php echo $row['mes_inicio_institucion'] . ' ' . $row['anio_inicio_institucion'] . ' - ' . $row['mes_finalizacion_institucion'] . ' ' . $row['anio_finalizacion_institucion']; ?></div>
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
                    <div class="date"><?php echo $row['mes_inicio_empresa'] . ' ' . $row['anio_inicio_empresa'] . ' - ' . $row['mes_finalizacion_empresa'] . ' ' . $row['anio_finalizacion_empresa']; ?></div>
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
                    <div class="description"><?php echo $row['duracion_curso']; ?></div>
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
                <li class="skill"><?php echo $row['habilidad']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>

        <?php if ($resultIdiomas->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Languages</h2>
            <ul>
                <?php while($row = $resultIdiomas->fetch_assoc()): ?>
                <li class="language"><?php echo $row['nombre_idioma'] . ' - ' . $row['nivel_idioma']; ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php endif; ?>
        
        <?php if ($resultIntereses->num_rows > 0): ?>
        <div class="cv-section">
            <h2>Personal Interests</h2>
            <ul>
                <?php while($row = $resultIntereses->fetch_assoc()): ?>
                <li class="skill"><?php echo $row['interes']; ?></li>
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
                margin:       [0.5, 0, 0, 0.3], // Establecer márgenes a 0 para evitar páginas en blanco
                filename:     'CV-KaxtilE.pdf',
                image:        { type: 'jpeg', quality: 1.0 },
                html2canvas:  { scale: 4 },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }  // Evitar cortes de página inadecuados
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
    header('location: ../Index.php');
}
?>