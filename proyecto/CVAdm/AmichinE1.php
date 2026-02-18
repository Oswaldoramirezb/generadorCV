<?php
session_start();
if (isset($_GET['id_usuario']) && is_numeric($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];
    include_once('../Config/Conexion.php');

    function ejecutarConsulta($conexion, $sql) {
        $resultado = $conexion->query($sql);
        if (!$resultado) {
            die("Error en la consulta: " . $conexion->error);
        }
        return $resultado;
    }

    $sqlDatosPersonales = "SELECT * FROM DatosPersonales WHERE id_usuario = $id_usuario";
    $resultDatosPersonales = ejecutarConsulta($conexion, $sqlDatosPersonales);
    $datosPersonales = $resultDatosPersonales->fetch_assoc();

    $sqlEducacion = "SELECT * FROM Educacion WHERE id_usuario = $id_usuario";
    $resultEducacion = ejecutarConsulta($conexion, $sqlEducacion);

    $sqlExperiencia = "SELECT * FROM ExperienciaL WHERE id_usuario = $id_usuario";
    $resultExperiencia = ejecutarConsulta($conexion, $sqlExperiencia);

    $sqlCursos = "SELECT * FROM Cursos WHERE id_usuario = $id_usuario";
    $resultCursos = ejecutarConsulta($conexion, $sqlCursos);

    $sqlHabilidades = "SELECT * FROM Habilidades WHERE id_usuario = $id_usuario";
    $resultHabilidades = ejecutarConsulta($conexion, $sqlHabilidades);

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
    <title>Curriculum Vitae</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
        }

        #page {
            min-height: 200px;
            width: 60%;
            min-width: 600px;
            background: whitesmoke;
            margin: 10px auto; /* Reduced margin to move content up */
            padding: 20px; /* Reduced padding */
            color: #082C58;
            background-color: white;
        }

        .contact-info-box {
            text-align: center;
            margin-bottom: 10px; /* Reduced margin */
        }

        .name {
            margin-bottom: -5px;
            color: #082C58;
            font-size: 24px; /* Reduced font size */
        }

        .job-title {
            display: inline-block;
            color: #082C58;
            border: none;
            font-size: 18px; /* Reduced font size */
        }
        
        .credits {
            display: block;
            font-size: 14px;
            margin-top: 5px;
            color: #082C58;
        }

        .contact-details {
            background: #082C58;
            color: white;
            text-align: center;
            margin: auto;
            margin-top: 10px; /* Reduced margin */
            padding: 5px;
            font-size: 14px; /* Reduced font size */
        }

        h3 {
            border: 2px solid #082C58; /* Línea más gruesa */
            text-transform: uppercase;
            padding: 5px;
            border-radius: 5px;
            margin: 20px 0 10px; /* Reduced margin */
            color: #082C58;
        }

        p, table td, .skill {
            padding: 5px;
            font-size: 14px;
            color: #000;
        }

        table tr td:first-child {
            width: 150px; /* Más ancho para acomodar meses y años */
            color: gray;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
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

        .contact-details b {
            font-weight: bold;
        }
    </style>
</head>
<body>
<div id="page">
    <div class="contact-info-box">
        <h1 class="name"><?php echo htmlspecialchars($datosPersonales['nombre_datos'] ?? 'Name'); ?></h1>
        <h3 class="job-title"><?php echo htmlspecialchars($datosPersonales['licenciatura_datos'] ?? 'Degree'); ?></h3>
        <?php if (!empty($datosPersonales['porcentaje_creditos'])): ?>
        <p class="credits"><?php echo htmlspecialchars($datosPersonales['porcentaje_creditos']); ?>% of credits completed at UAM Azcapotzalco</p>
        <?php endif; ?>
        <p class="contact-details"><b>Phone:</b> <?php echo htmlspecialchars($datosPersonales['telefono_datos']); ?> &nbsp; - &nbsp; <b>Email:</b> <?php echo htmlspecialchars($datosPersonales['correo_datos']); ?></p>
    </div>

    <?php if ($resultEducacion->num_rows > 0): ?>
    <div id="education">
        <h3>Education</h3>
        <table>
            <?php while($row = $resultEducacion->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['mes_inicio_institucion'] . ' ' . $row['anio_inicio_institucion'] . ' - ' . $row['mes_finalizacion_institucion'] . ' ' . $row['anio_finalizacion_institucion']); ?></td>
                <td><b><?php echo htmlspecialchars($row['nombre_institucion']); ?></b>: <?php echo htmlspecialchars($row['nivel_institucion']); ?> in <?php echo htmlspecialchars($row['especialidad_institucion']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultExperiencia->num_rows > 0): ?>
    <div id="work">
        <h3>Work Experience</h3>
        <table>
            <?php while($row = $resultExperiencia->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['mes_inicio_empresa'] . ' ' . $row['anio_inicio_empresa'] . ' - ' . $row['mes_finalizacion_empresa'] . ' ' . $row['anio_finalizacion_empresa']); ?></td>
                <td><b><?php echo htmlspecialchars($row['nombre_empresa']); ?></b>: <?php echo htmlspecialchars($row['puesto_empresa']); ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo htmlspecialchars($row['descripcion_empresa']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultCursos->num_rows > 0): ?>
    <div id="courses">
        <h3>Certifications and Courses</h3>
        <table>
            <?php while($row = $resultCursos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['mes_finalizacion_curso'] . ' ' . $row['anio_finalizacion_curso']); ?></td>
                <td><b><?php echo htmlspecialchars($row['nombre_curso']); ?></b>: <?php echo htmlspecialchars($row['institucion_curso']); ?> (<?php echo htmlspecialchars($row['duracion_curso']); ?>)</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultHabilidades->num_rows > 0): ?>
    <div id="skills">
        <h3>Skills</h3>
        <ul>
            <?php while($row = $resultHabilidades->fetch_assoc()): ?>
            <li class="skill"><?php echo htmlspecialchars($row['habilidad']); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if ($resultIdiomas->num_rows > 0): ?>
    <div id="languages">
        <h3>Languages</h3>
        <ul>
            <?php while($row = $resultIdiomas->fetch_assoc()): ?>
            <li class="skill"><?php echo htmlspecialchars($row['nombre_idioma'] . ' - ' . $row['nivel_idioma']); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if ($resultIntereses->num_rows > 0): ?>
    <div id="interests">
        <h3>Personal Interests</h3>
        <ul>
            <?php while($row = $resultIntereses->fetch_assoc()): ?>
            <li class="skill"><?php echo htmlspecialchars($row['interes']); ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<!-- Botón para descargar el PDF -->
<button id="downloadPDF">Download PDF</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('downloadPDF').addEventListener('click', function () {
        var element = document.getElementById('page');
        var button = document.getElementById('downloadPDF');
        button.style.display = 'none';  // Ocultar el botón

        var opt = {
            margin: [0.5, 0, 0.5, 0],  // Márgenes ajustados para evitar páginas en blanco
            filename: 'CV-AmichinE.pdf',
            image: { type: 'jpeg', quality: 1.0 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
            pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }  // Evitar cortes de página inadecuados
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