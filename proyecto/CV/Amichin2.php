<?php
session_start();
if (isset($_SESSION["id_usuario"])) {
    $id_usuario = $_SESSION['id_usuario'];
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
<html lang="es">
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
            margin: 10px auto;
            padding: 20px;
            color: #063F24;
            background-color: white;
        }

        .contact-info-box {
            text-align: center;
            margin-bottom: 10px;
        }

        .name {
            margin-bottom: -5px;
            color: #063F24;
            font-size: 24px;
        }

        .job-title {
            display: inline-block;
            color: #063F24;
            border: none;
            font-size: 18px;
        }
        
        .credits {
            display: block;
            font-size: 14px;
            margin-top: 5px;
            color: #063F24;
        }

        .contact-details {
            background: #063F24;
            color: white;
            text-align: center;
            margin: auto;
            margin-top: 10px;
            padding: 5px;
            font-size: 14px;
        }

        h3 {
            border: 2px solid #063F24;
            text-transform: uppercase;
            padding: 5px;
            border-radius: 5px;
            margin: 20px 0 10px;
            color: #063F24;
        }

        p, table td, .skill {
            padding: 5px;
            font-size: 14px;
            color: #000;
        }

        table tr td:first-child {
            width: 150px;
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
        <h1 class="name"><?php echo $datosPersonales['nombre_datos'] ?? 'Nombre'; ?></h1>
        <h3 class="job-title"><?php echo $datosPersonales['licenciatura_datos'] ?? 'Licenciatura'; ?></h3>
        <?php if (!empty($datosPersonales['porcentaje_creditos'])): ?>
        <p class="credits"><?php echo $datosPersonales['porcentaje_creditos']; ?>% de créditos concluidos en la UAM Azcapotzalco</p>
        <?php endif; ?>
        <p class="contact-details"><b>Teléfono:</b> <?php echo $datosPersonales['telefono_datos']; ?> &nbsp; - &nbsp; <b>Correo:</b> <?php echo $datosPersonales['correo_datos']; ?></p>
    </div>

    <?php if ($resultEducacion->num_rows > 0): ?>
    <div id="education">
        <h3>Educación</h3>
        <table>
            <?php while($row = $resultEducacion->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['mes_inicio_institucion'] . ' ' . $row['anio_inicio_institucion'] . ' - ' . $row['mes_finalizacion_institucion'] . ' ' . $row['anio_finalizacion_institucion']; ?></td>
                <td><b><?php echo $row['nombre_institucion']; ?></b>: <?php echo $row['nivel_institucion']; ?> en <?php echo $row['especialidad_institucion']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultExperiencia->num_rows > 0): ?>
    <div id="work">
        <h3>Experiencia Profesional</h3>
        <table>
            <?php while($row = $resultExperiencia->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['mes_inicio_empresa'] . ' ' . $row['anio_inicio_empresa'] . ' - ' . $row['mes_finalizacion_empresa'] . ' ' . $row['anio_finalizacion_empresa']; ?></td>
                <td><b><?php echo $row['nombre_empresa']; ?></b>: <?php echo $row['puesto_empresa']; ?></td>
            </tr>
            <tr>
                <td colspan="2"><?php echo $row['descripcion_empresa']; ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultCursos->num_rows > 0): ?>
    <div id="courses">
        <h3>Certificaciones y Cursos</h3>
        <table>
            <?php while($row = $resultCursos->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['mes_finalizacion_curso'] . ' ' . $row['anio_finalizacion_curso']; ?></td>
                <td><b><?php echo $row['nombre_curso']; ?></b>: <?php echo $row['institucion_curso']; ?> (<?php echo $row['duracion_curso']; ?>)</td>
            </tr>
            <?php endwhile; ?>
        </table>
    </div>
    <?php endif; ?>

    <?php if ($resultHabilidades->num_rows > 0): ?>
    <div id="skills">
        <h3>Habilidades</h3>
        <ul>
            <?php while($row = $resultHabilidades->fetch_assoc()): ?>
            <li class="skill"><?php echo $row['habilidad']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>

    <?php if ($resultIdiomas->num_rows > 0): ?>
    <div id="languages">
        <h3>Idiomas</h3>
        <ul>
            <?php while($row = $resultIdiomas->fetch_assoc()): ?>
            <li class="skill"><?php echo $row['nombre_idioma'] . ' - ' . $row['nivel_idioma']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if ($resultIntereses->num_rows > 0): ?>
    <div id="interests">
        <h3>Intereses Personales</h3>
        <ul>
            <?php while($row = $resultIntereses->fetch_assoc()): ?>
            <li class="skill"><?php echo $row['interes']; ?></li>
            <?php endwhile; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>

<!-- Botón para descargar el PDF -->
<button id="downloadPDF">Descargar PDF</button>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('downloadPDF').addEventListener('click', function () {
        var element = document.getElementById('page');
        var button = document.getElementById('downloadPDF');
        button.style.display = 'none';  // Ocultar el botón

        var opt = {
            margin:       0.5,
            filename:     'CV-Amichin.pdf',
            image:        { type: 'jpeg', quality: 1.0 },
            html2canvas:  { scale: 4 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' },
            pagebreak:    { mode: ['avoid-all', 'css', 'legacy'] }  // Evitar cortes de página inadecuados
        };
        
        // Crear el PDF
        html2pdf().from(element).set(opt).save().then(function () {
            button.style.display = 'block';  // Volver a mostrar el botón
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