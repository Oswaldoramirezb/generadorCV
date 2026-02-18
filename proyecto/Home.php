<?php
session_start();
if (isset($_SESSION['id_usuario']) && isset($_SESSION['correo_usuario']) && $_SESSION['rol_usuario'] == 2) {
    $correo_usuario = $_SESSION['correo_usuario'];
    $id_usuario = $_SESSION['id_usuario'];
    include_once('Config/Conexion.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - CV Manager</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            color: #333;
            line-height: 1.6;
        }
        
        /* Estilos para el menú */
        #menu {
            background: linear-gradient(135deg, #c02727 0%, #8b0000 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        #menu a {
            float: left;
            display: flex;
            align-items: center;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        #menu a i {
            margin-right: 8px;
        }
        
        #menu a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }
        
        #menu a.active {
            background-color: #350000;
            color: white;
        }
        
        /* Estilos para la sección de consultas */
        #consulta {
            margin: 30px auto;
            max-width: 1000px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        #consulta h2 {
            color: #c02727;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        
        #consulta ul {
            list-style-type: none;
        }
        
        #consulta li {
            margin-bottom: 10px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        
        #consulta li:hover {
            background-color: #f1f1f1;
        }
        
        /* Estilos para formularios */
        form {
            display: none;
            margin: 30px auto;
            max-width: 800px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        form h2 {
            color: #c02727;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
        }
        
        form div {
            margin-bottom: 15px;
        }
        
        form label {
            display: inline-block;
            width: 180px;
            color: #555;
            font-weight: 500;
        }
        
        form input[type="text"],
        form input[type="email"],
        form textarea,
        form select {
            width: calc(100% - 190px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
            transition: border 0.3s ease;
        }
        
        form textarea {
            min-height: 100px;
            resize: vertical;
        }
        
        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form textarea:focus,
        form select:focus {
            border-color: #c02727;
            outline: none;
        }
        
        form small {
            display: block;
            margin-left: 180px;
            color: #777;
            font-size: 12px;
            margin-top: 5px;
        }
        
        /* Estilos para los botones */
        button {
            background-color: white;
            color: #c02727;
            border: 2px solid #c02727;
            padding: 8px 15px;
            cursor: pointer;
            font-size: 14px;
            border-radius: 4px;
            transition: all 0.3s ease;
            margin-right: 10px;
            font-weight: 500;
        }
        
        button:hover {
            background-color: #c02727;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        
        /* Botones específicos */
        button.delete {
            background-color: white;
            color: #dc3545;
            border: 2px solid #dc3545;
        }
        
        button.delete:hover {
            background-color: #dc3545;
            color: white;
        }
        
        button.edit {
            background-color: white;
            color: #007bff;
            border: 2px solid #007bff;
        }
        
        button.edit:hover {
            background-color: #007bff;
            color: white;
        }
        
        button.view {
            background-color: white;
            color: #28a745;
            border: 2px solid #28a745;
        }
        
        button.view:hover {
            background-color: #28a745;
            color: white;
        }
        
        /* Estilos para las tarjetas de CV */
        .cv-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .cv-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .cv-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .cv-card h3 {
            color: #c02727;
            margin-bottom: 15px;
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        
        .cv-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 15px;
        }
        
        /* Estilo para los datos existentes */
        .data-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border-left: 3px solid #c02727;
        }
        
        .data-actions {
            margin-top: 10px;
            display: flex;
            gap: 10px;
        }
    </style>
</head>
<body>
    <div id="menu">
        <a href="#" id="cv"><i class="fas fa-file-alt"></i> CV</a>
        <a href="#" id="datos_personales"><i class="fas fa-user"></i> Datos personales</a>
        <a href="#" id="educacion"><i class="fas fa-graduation-cap"></i> Educación</a>
        <a href="#" id="experiencia"><i class="fas fa-briefcase"></i> Experiencia</a>
        <a href="#" id="habilidades"><i class="fas fa-chart-bar"></i> Habilidades</a>
        <a href="#" id="intereses"><i class="fas fa-heart"></i> Intereses personales</a>
        <a href="#" id="idiomas"><i class="fas fa-language"></i> Idiomas</a>
        <a href="#" id="cursos"><i class="fas fa-certificate"></i> Cursos</a>
        <a href="Login/CerrarSesion.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a>
    </div>

    <div id="consulta">
        <!-- Aquí se mostrarán las consultas según la opción seleccionada -->
    </div>

    <!-- Formularios -->
    <form id="form_datos_personales" method="POST" action="Agregar/GuardarDatosPersonales.php">
        <h2><i class="fas fa-user"></i> Agregar Datos Personales</h2>
        <div>
            <label for="nombre_datos">Nombre:</label>
            <input type="text" id="nombre_datos" name="nombre_datos" required placeholder="Nombre completo">
        </div>
        <div>
            <label for="licenciatura_datos">Licenciatura:</label>
            <select id="licenciatura_datos" name="licenciatura_datos" required>
                <option value="">Seleccione una opción</option>
                <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                <option value="Ingeniería Civil">Ingeniería Civil</option>
                <option value="Ingeniería en Computación">Ingeniería en Computación</option>
                <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                <option value="Ingeniería Electrónica">Ingeniería Electrónica</option>
                <option value="Ingeniería Física">Ingeniería Física</option>
                <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                <option value="Ingeniería Mecánica">Ingeniería Mecánica</option>
                <option value="Ingeniería Metalúrgica">Ingeniería Metalúrgica</option>
                <option value="Ingeniería Química">Ingeniería Química</option>
                <option value="other">Otra (Especificar)</option>
            </select>
        </div>
        <div id="otra_licenciatura_div" style="display:none;">
            <label for="otra_licenciatura">Especificar:</label>
            <input type="text" id="otra_licenciatura" name="otra_licenciatura" placeholder="Ingrese su licenciatura">
        </div>
        <div>
            <label for="matricula_datos">Matrícula:</label>
            <input type="text" id="matricula_datos" name="matricula_datos" required placeholder="Ej. A12345678">
        </div>
        <div>
            <label for="ciudad_datos">Ciudad:</label>
            <input type="text" id="ciudad_datos" name="ciudad_datos" required placeholder="Ciudad actual">
        </div>
        <div>
            <label for="telefono_datos">Teléfono:</label>
            <input type="text" id="telefono_datos" name="telefono_datos" required placeholder="Ej. 555-123-4567">
        </div>
        <div>
            <label for="correo_datos">Correo:</label>
            <input type="email" id="correo_datos" name="correo_datos" required placeholder="ejemplo@dominio.com">
        </div>
        <div>
            <label for="porcentaje_creditos">Porcentaje de créditos:</label>
            <input type="text" id="porcentaje_creditos" name="porcentaje_creditos" required placeholder="Ej. 75%">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_educacion" method="POST" action="Agregar/GuardarEducacion.php">
        <h2><i class="fas fa-graduation-cap"></i> Agregar Educación</h2>
        <div>
            <label for="nombre_institucion">Nombre de la Institución:</label>
            <input type="text" id="nombre_institucion" name="nombre_institucion" required placeholder="Nombre de la institución educativa">
        </div>
        <div>
            <label for="nivel_institucion">Nivel:</label>
            <input type="text" id="nivel_institucion" name="nivel_institucion" required placeholder="Ej. Licenciatura, Maestría, etc.">
        </div>
        <div>
            <label for="especialidad_institucion">Especialidad:</label>
            <input type="text" id="especialidad_institucion" name="especialidad_institucion" required placeholder="Ej. Ingeniería en Sistemas">
        </div>
        <div>
            <label for="mes_inicio_institucion">Mes de Inicio:</label>
            <input type="text" id="mes_inicio_institucion" name="mes_inicio_institucion" required placeholder="Ej. Enero">
        </div>
        <div>
            <label for="anio_inicio_institucion">Año de Inicio:</label>
            <input type="text" id="anio_inicio_institucion" name="anio_inicio_institucion" required placeholder="Ej. 2020">
        </div>
        <div>
            <label for="mes_finalizacion_institucion">Mes de Finalización:</label>
            <input type="text" id="mes_finalizacion_institucion" name="mes_finalizacion_institucion" placeholder="Ej. Diciembre o Actual"><br>
            <small>Si actualmente estás estudiando AQUÍ, escribe "Actual", "Actualmente", "Presente" según tu preferencia en el campo del mes, y omite año de finalización.</small>
        </div>
        <div>
            <label for="anio_finalizacion_institucion">Año de Finalización:</label>
            <input type="text" id="anio_finalizacion_institucion" name="anio_finalizacion_institucion" placeholder="Ej. 2024">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_experiencia" method="POST" action="Agregar/GuardarExperiencia.php">
        <h2><i class="fas fa-briefcase"></i> Agregar Experiencia</h2>
        <div>
            <label for="nombre_empresa">Nombre Empresa:</label>
            <input type="text" id="nombre_empresa" name="nombre_empresa" required placeholder="Nombre de la empresa">
        </div>
        <div>
            <label for="puesto_empresa">Puesto:</label>
            <input type="text" id="puesto_empresa" name="puesto_empresa" required placeholder="Puesto o cargo desempeñado">
        </div>
        <div>
            <label for="mes_inicio_empresa">Mes de Inicio:</label>
            <input type="text" id="mes_inicio_empresa" name="mes_inicio_empresa" required placeholder="Ej. Enero">
        </div>
        <div>
            <label for="anio_inicio_empresa">Año de Inicio:</label>
            <input type="text" id="anio_inicio_empresa" name="anio_inicio_empresa" required placeholder="Ej. 2020">
        </div>
        <div>
            <label for="mes_finalizacion_empresa">Mes de Finalización:</label>
            <input type="text" id="mes_finalizacion_empresa" name="mes_finalizacion_empresa" placeholder="Ej. Diciembre o Actual"><br>
            <small>Si actualmente estás trabajando AQUÍ, escribe "Actual", "Actualmente", "Presente" según tu preferencia en el campo del mes, y omite año de finalización.</small><br>
        </div>
        <div>
            <label for="anio_finalizacion_empresa">Año de Finalización:</label>
            <input type="text" id="anio_finalizacion_empresa" name="anio_finalizacion_empresa" placeholder="Ej. 2024">
        </div>
        <div>
            <label for="descripcion_empresa">Descripción:</label>
            <textarea id="descripcion_empresa" name="descripcion_empresa" placeholder="Describe tus responsabilidades y logros en esta posición"></textarea>
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_habilidades" method="POST" action="Agregar/GuardarHabilidades.php">
        <h2><i class="fas fa-chart-bar"></i> Agregar Habilidades</h2>
        <div>
            <label for="habilidad">Habilidad:</label>
            <input type="text" id="habilidad" name="habilidad" required placeholder="Ej. Programación en Python">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_intereses" method="POST" action="Agregar/GuardarIntereses.php">
        <h2><i class="fas fa-heart"></i> Agregar Intereses Personales</h2>
        <div>
            <label for="interes">Interés:</label>
            <input type="text" id="interes" name="interes" required placeholder="Ej. Fotografía">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_idiomas" method="POST" action="Agregar/GuardarIdiomas.php">
        <h2><i class="fas fa-language"></i> Agregar Idiomas</h2>
        <div>
            <label for="nombre_idioma">Idioma:</label>
            <input type="text" id="nombre_idioma" name="nombre_idioma" required placeholder="Ej. Inglés">
        </div>
        <div>
            <label for="nivel_idioma">Nivel:</label>
            <input type="text" id="nivel_idioma" name="nivel_idioma" required placeholder="Ej. Avanzado, B2, etc.">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <form id="form_cursos" method="POST" action="Agregar/GuardarCursos.php">
        <h2><i class="fas fa-certificate"></i> Agregar Cursos</h2>
        <div>
            <label for="nombre_curso">Nombre del Curso:</label>
            <input type="text" id="nombre_curso" name="nombre_curso" required placeholder="Nombre del curso o certificación">
        </div>
        <div>
            <label for="institucion_curso">Institución:</label>
            <input type="text" id="institucion_curso" name="institucion_curso" required placeholder="Nombre de la institución que lo impartió">
        </div>
        <div>
            <label for="duracion_curso">Duración:</label>
            <input type="text" id="duracion_curso" name="duracion_curso" required placeholder="Ej. 40 horas">
            <small>Especifique si son horas, días, meses, y cantidad.</small>
        </div>
        <div>
            <label for="mes_finalizacion_curso">Mes de Finalización:</label>
            <input type="text" id="mes_finalizacion_curso" name="mes_finalizacion_curso" required placeholder="Ej. Diciembre">
        </div>
        <div>
            <label for="anio_finalizacion_curso">Año de Finalización:</label>
            <input type="text" id="anio_finalizacion_curso" name="anio_finalizacion_curso" required placeholder="Ej. 2023">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Guardar</button>
    </form>

    <!-- Formularios de edición -->
    <form id="form_editar_datos_personales" method="POST" action="Actualizar/ActualizarDatosPersonales.php">
        <h2><i class="fas fa-user-edit"></i> Editar Datos Personales</h2>
        <input type="hidden" id="id_datos_editar" name="id_datos">
        <div>
            <label for="nombre_datos_editar">Nombre:</label>
            <input type="text" id="nombre_datos_editar" name="nombre_datos" required>
        </div>
        <div>
            <label for="licenciatura_datos_editar">Licenciatura:</label>
            <select id="licenciatura_datos_editar" name="licenciatura_datos" required>
                <option value="">Seleccione una opción</option>
                <option value="Ingeniería Ambiental">Ingeniería Ambiental</option>
                <option value="Ingeniería Civil">Ingeniería Civil</option>
                <option value="Ingeniería en Computación">Ingeniería en Computación</option>
                <option value="Ingeniería Eléctrica">Ingeniería Eléctrica</option>
                <option value="Ingeniería Electrónica">Ingeniería Electrónica</option>
                <option value="Ingeniería Física">Ingeniería Física</option>
                <option value="Ingeniería Industrial">Ingeniería Industrial</option>
                <option value="Ingeniería Mecánica">Ingeniería Mecánica</option>
                <option value="Ingeniería Metalúrgica">Ingeniería Metalúrgica</option>
                <option value="Ingeniería Química">Ingeniería Química</option>
                <option value="other">Otra (Especificar)</option>
            </select>
        </div>
        <div id="otra_licenciatura_editar_div" style="display:none;">
            <label for="otra_licenciatura_editar">Especificar:</label>
            <input type="text" id="otra_licenciatura_editar" name="otra_licenciatura">
        </div>
        <div>
            <label for="matricula_datos_editar">Matrícula:</label>
            <input type="text" id="matricula_datos_editar" name="matricula_datos" required>
        </div>
        <div>
            <label for="ciudad_datos_editar">Ciudad:</label>
            <input type="text" id="ciudad_datos_editar" name="ciudad_datos" required>
        </div>
        <div>
            <label for="telefono_datos_editar">Teléfono:</label>
            <input type="text" id="telefono_datos_editar" name="telefono_datos" required>
        </div>
        <div>
            <label for="correo_datos_editar">Correo:</label>
            <input type="email" id="correo_datos_editar" name="correo_datos" required>
        </div>
        <div>
            <label for="porcentaje_creditos_editar">Porcentaje de créditos:</label>
            <input type="text" id="porcentaje_creditos_editar" name="porcentaje_creditos" required>
        </div>
        <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
    </form>

    <form id="form_editar_educacion" method="POST" action="Actualizar/ActualizarEducacion.php">
        <h2><i class="fas fa-graduation-cap"></i> Editar Educación</h2>
        <input type="hidden" id="id_educacion_editar" name="id_educacion">
        <div>
            <label for="nombre_institucion_editar">Nombre de la Institución:</label>
            <input type="text" id="nombre_institucion_editar" name="nombre_institucion" required>
        </div>
        <div>
            <label for="nivel_institucion_editar">Nivel:</label>
            <input type="text" id="nivel_institucion_editar" name="nivel_institucion" required>
        </div>
        <div>
            <label for="especialidad_institucion_editar">Especialidad:</label>
            <input type="text" id="especialidad_institucion_editar" name="especialidad_institucion" required>
        </div>
        <div>
            <label for="mes_inicio_institucion_editar">Mes de Inicio:</label>
            <input type="text" id="mes_inicio_institucion_editar" name="mes_inicio_institucion" required>
        </div>
        <div>
            <label for="anio_inicio_institucion_editar">Año de Inicio:</label>
            <input type="text" id="anio_inicio_institucion_editar" name="anio_inicio_institucion" required>
        </div>
        <div>
            <label for="mes_finalizacion_institucion_editar">Mes de Finalización:</label>
            <input type="text" id="mes_finalizacion_institucion_editar" name="mes_finalizacion_institucion"><br>
            <small>Si actualmente estás estudiando AQUÍ, escribe "Actual", "Actualmente", "Presente" según tu preferencia en el campo del mes, y omite año de finalización.</small>
        </div>
        <div>
            <label for="anio_finalizacion_institucion_editar">Año de Finalización:</label>
            <input type="text" id="anio_finalizacion_institucion_editar" name="anio_finalizacion_institucion">
        </div>
        <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
    </form>

    <form id="form_editar_experiencia" method="POST" action="Actualizar/ActualizarExperiencia.php">
        <h2><i class="fas fa-briefcase"></i> Editar Experiencia</h2>
        <input type="hidden" id="id_experiencia_editar" name="id_experiencia">
        <div>
            <label for="nombre_empresa_editar">Nombre Empresa:</label>
            <input type="text" id="nombre_empresa_editar" name="nombre_empresa" required>
        </div>
        <div>
            <label for="puesto_empresa_editar">Puesto:</label>
            <input type="text" id="puesto_empresa_editar" name="puesto_empresa" required>
        </div>
        <div>
            <label for="mes_inicio_empresa_editar">Mes de Inicio:</label>
            <input type="text" id="mes_inicio_empresa_editar" name="mes_inicio_empresa" required>
        </div>
        <div>
            <label for="anio_inicio_empresa_editar">Año de Inicio:</label>
            <input type="text" id="anio_inicio_empresa_editar" name="anio_inicio_empresa" required>
        </div>
        <div>
           <label for="mes_finalizacion_empresa_editar">Mes de Finalización:</label>
           <input type="text" id="mes_finalizacion_empresa_editar" name="mes_finalizacion_empresa"><br>
           <small>Si actualmente estás trabajando AQUÍ, escribe "Actual", "Actualmente", "Presente" según tu preferencia en el campo del mes, y omite año de finalización.</small>
       </div>
       <div>
           <label for="anio_finalizacion_empresa_editar">Año de Finalización:</label>
           <input type="text" id="anio_finalizacion_empresa_editar" name="anio_finalizacion_empresa">
       </div>
       <div>
           <label for="descripcion_empresa_editar">Descripción:</label>
           <textarea id="descripcion_empresa_editar" name="descripcion_empresa"></textarea>
       </div>
       <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
   </form>

   <form id="form_editar_habilidades" method="POST" action="Actualizar/ActualizarHabilidad.php">
       <h2><i class="fas fa-chart-bar"></i> Editar Habilidades</h2>
       <input type="hidden" id="id_habilidades_editar" name="id_habilidades">
       <div>
           <label for="habilidad_editar">Habilidad:</label>
           <input type="text" id="habilidad_editar" name="habilidad" required>
       </div>
       <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
   </form>

   <form id="form_editar_intereses" method="POST" action="Actualizar/ActualizarInteres.php">
       <h2><i class="fas fa-heart"></i> Editar Intereses Personales</h2>
       <input type="hidden" id="id_interes_editar" name="id_interes">
       <div>
           <label for="interes_editar">Interés:</label>
           <input type="text" id="interes_editar" name="interes" required>
       </div>
       <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
   </form>

   <form id="form_editar_idiomas" method="POST" action="Actualizar/ActualizarIdioma.php">
       <h2><i class="fas fa-language"></i> Editar Idiomas</h2>
       <input type="hidden" id="id_idioma_editar" name="id_idioma">
       <div>
           <label for="nombre_idioma_editar">Idioma:</label>
           <input type="text" id="nombre_idioma_editar" name="nombre_idioma" required>
       </div>
       <div>
           <label for="nivel_idioma_editar">Nivel:</label>
           <input type="text" id="nivel_idioma_editar" name="nivel_idioma" required>
       </div>
       <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
   </form>

   <form id="form_editar_cursos" method="POST" action="Actualizar/ActualizarCursos.php">
       <h2><i class="fas fa-certificate"></i> Editar Cursos</h2>
       <input type="hidden" id="id_curso_editar" name="id_curso">
       <div>
           <label for="nombre_curso_editar">Nombre del Curso:</label>
           <input type="text" id="nombre_curso_editar" name="nombre_curso" required>
       </div>
       <div>
           <label for="institucion_curso_editar">Institución:</label>
           <input type="text" id="institucion_curso_editar" name="institucion_curso" required>
       </div>
       <div>
           <label for="duracion_curso_editar">Duración:</label>
           <input type="text" id="duracion_curso_editar" name="duracion_curso" required>
           <small>Especifique si son horas, días, meses, y cantidad.</small>
       </div>
       <div>
           <label for="mes_finalizacion_curso_editar">Mes de Finalización:</label>
           <input type="text" id="mes_finalizacion_curso_editar" name="mes_finalizacion_curso" required>
       </div>
       <div>
           <label for="anio_finalizacion_curso_editar">Año de Finalización:</label>
           <input type="text" id="anio_finalizacion_curso_editar" name="anio_finalizacion_curso" required>
       </div>
       <button type="submit"><i class="fas fa-save"></i> Actualizar</button>
   </form>

   <script>
       window.onload = function() {
           // Obtener referencias a los elementos del menú y la sección de consultas
           var cvMenu = document.getElementById('cv');
           var datosPersonalesLink = document.getElementById('datos_personales');
           var educacionLink = document.getElementById('educacion');
           var experienciaLink = document.getElementById('experiencia');
           var habilidadesLink = document.getElementById('habilidades');
           var interesesLink = document.getElementById('intereses');
           var idiomasLink = document.getElementById('idiomas');
           var cursosLink = document.getElementById('cursos');
           var consultaDiv = document.getElementById('consulta');

           // Obtener referencias a los formularios
           var formDatosPersonales = document.getElementById('form_datos_personales');
           var formEducacion = document.getElementById('form_educacion');
           var formExperiencia = document.getElementById('form_experiencia');
           var formHabilidades = document.getElementById('form_habilidades');
           var formIntereses = document.getElementById('form_intereses');
           var formIdiomas = document.getElementById('form_idiomas');
           var formCursos = document.getElementById('form_cursos');

           var formEditarDatosPersonales = document.getElementById('form_editar_datos_personales');
           var formEditarEducacion = document.getElementById('form_editar_educacion');
           var formEditarExperiencia = document.getElementById('form_editar_experiencia');
           var formEditarHabilidades = document.getElementById('form_editar_habilidades');
           var formEditarIntereses = document.getElementById('form_editar_intereses');
           var formEditarIdiomas = document.getElementById('form_editar_idiomas');
           var formEditarCursos = document.getElementById('form_editar_cursos');
           
           // Manejar el cambio en el select de licenciatura para mostrar el campo personalizado
           var licenciaturaSelect = document.getElementById('licenciatura_datos');
           var otraLicenciaturaDiv = document.getElementById('otra_licenciatura_div');
           var otraLicenciaturaInput = document.getElementById('otra_licenciatura');
           
           licenciaturaSelect.addEventListener('change', function() {
               if (this.value === 'other') {
                   otraLicenciaturaDiv.style.display = 'block';
                   otraLicenciaturaInput.required = true;
               } else {
                   otraLicenciaturaDiv.style.display = 'none';
                   otraLicenciaturaInput.required = false;
               }
           });
           
           // Lo mismo para el formulario de edición
           var licenciaturaEditarSelect = document.getElementById('licenciatura_datos_editar');
           var otraLicenciaturaEditarDiv = document.getElementById('otra_licenciatura_editar_div');
           var otraLicenciaturaEditarInput = document.getElementById('otra_licenciatura_editar');
           
           licenciaturaEditarSelect.addEventListener('change', function() {
               if (this.value === 'other') {
                   otraLicenciaturaEditarDiv.style.display = 'block';
                   otraLicenciaturaEditarInput.required = true;
               } else {
                   otraLicenciaturaEditarDiv.style.display = 'none';
                   otraLicenciaturaEditarInput.required = false;
               }
           });

           // Función para ocultar todos los formularios
           function ocultarFormularios() {
               formDatosPersonales.style.display = 'none';
               formEducacion.style.display = 'none';
               formExperiencia.style.display = 'none';
               formHabilidades.style.display = 'none';
               formIntereses.style.display = 'none';
               formIdiomas.style.display = 'none';
               formCursos.style.display = 'none';
               formEditarDatosPersonales.style.display = 'none';
               formEditarEducacion.style.display = 'none';
               formEditarExperiencia.style.display = 'none';
               formEditarHabilidades.style.display = 'none';
               formEditarIntereses.style.display = 'none';
               formEditarIdiomas.style.display = 'none';
               formEditarCursos.style.display = 'none';
           }

           // Función para mostrar el formulario de edición con los datos actuales
           function mostrarFormularioEdicion(formulario, datos) {
               for (var campo in datos) {
                   var elemento = formulario.querySelector('[name="' + campo + '"]');
                   if (elemento) {
                       elemento.value = datos[campo];
                   }
               }
               
               // Si estamos editando datos personales y la licenciatura no está en la lista
               if (formulario.id === 'form_editar_datos_personales') {
                   var licenciaturaEncontrada = false;
                   var licenciaturaValue = datos.licenciatura_datos;
                   
                   for (var i = 0; i < licenciaturaEditarSelect.options.length; i++) {
                       if (licenciaturaEditarSelect.options[i].value === licenciaturaValue) {
                           licenciaturaEncontrada = true;
                           break;
                       }
                   }
                   
                   if (!licenciaturaEncontrada && licenciaturaValue) {
                       licenciaturaEditarSelect.value = 'other';
                       otraLicenciaturaEditarDiv.style.display = 'block';
                       otraLicenciaturaEditarInput.value = licenciaturaValue;
                       otraLicenciaturaEditarInput.required = true;
                   }
               }
               
               formulario.style.display = 'block';
           }

           // Función para mostrar la pestaña CV por defecto al cargar la página
           function cargarCVPorDefecto() {
               ocultarFormularios();
               var cvOptions = `
                   <h2><i class="fas fa-file-alt"></i> Tipos de CV</h2>
                   <div class="cv-container">
                       <div class="cv-card">
                           <h3>Harvard</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/Harvard.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Harvard (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/HarvardEn.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Mistli</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/Mistli.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Mistli (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/MistliE.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Kaxtil</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/Kaxtil.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/Kaxtil1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/Kaxtil2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Kaxtil (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/KaxtilE.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/KaxtilE1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/KaxtilE2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Amichin</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/Amichin.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/Amichin1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/Amichin2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Amichin (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/AmichinE.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/AmichinE1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/AmichinE2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                   </div>
               `;
               consultaDiv.innerHTML = cvOptions;
           }

           // Cargar la pestaña CV por defecto al iniciar
           cargarCVPorDefecto();

           // Agregar eventos de clic para cada opción del menú
           cvMenu.addEventListener('click', function() {
               ocultarFormularios();
               var cvOptions = `
                   <h2><i class="fas fa-file-alt"></i> Tipos de CV</h2>
                   <div class="cv-container">
                       <div class="cv-card">
                           <h3>Harvard</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/Harvard.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Harvard (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/HarvardEn.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Mistli</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/Mistli.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Mistli (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" onclick="window.location.href='CV/MistliE.php'"><i class="fas fa-eye"></i> Visualizar</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Kaxtil</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/Kaxtil.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/Kaxtil1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/Kaxtil2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Kaxtil (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/KaxtilE.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/KaxtilE1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/KaxtilE2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Amichin</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/Amichin.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/Amichin1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/Amichin2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                       <div class="cv-card">
                           <h3>Amichin (English)</h3>
                           <div class="cv-buttons">
                               <button class="view" style="background-color: #ffeded; color: #c02727;" onclick="window.location.href='CV/AmichinE.php'"><i class="fas fa-eye"></i> Rojo</button>
                               <button class="view" style="background-color: #edf6ff; color: #0066cc;" onclick="window.location.href='CV/AmichinE1.php'"><i class="fas fa-eye"></i> Azul</button>
                               <button class="view" style="background-color: #edffef; color: #28a745;" onclick="window.location.href='CV/AmichinE2.php'"><i class="fas fa-eye"></i> Verde</button>
                           </div>
                       </div>
                   </div>
               `;
               consultaDiv.innerHTML = cvOptions;
           });

           datosPersonalesLink.addEventListener('click', function() {
               ocultarFormularios();
               formDatosPersonales.style.display = 'block';
               // Consulta para obtener los datos personales del usuario
               <?php
               $sql = "SELECT * FROM DatosPersonales WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar los datos personales como una lista
               var datosPersonales = "<h2><i class='fas fa-user'></i> Datos Personales</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "datosPersonales += '<div class=\"data-item\">';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-user-circle\"></i> Nombre:</strong> " . $row["nombre_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-graduation-cap\"></i> Licenciatura:</strong> " . $row["licenciatura_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-id-card\"></i> Matrícula:</strong> " . $row["matricula_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-map-marker-alt\"></i> Ciudad:</strong> " . $row["ciudad_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-envelope\"></i> Correo:</strong> " . $row["correo_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-phone\"></i> Teléfono:</strong> " . $row["telefono_datos"] . "</p>';";
                       echo "datosPersonales += '<p><strong><i class=\"fas fa-chart-pie\"></i> Porcentaje de créditos:</strong> " . $row["porcentaje_creditos"] . "</p>';";
                       echo "datosPersonales += '<div class=\"data-actions\">';";
                       echo "datosPersonales += \"<form method='POST' action='Eliminar/EliminarDatosPersonales.php' style='display:inline; margin: 0;'>\";";
                       echo "datosPersonales += \"<input type='hidden' name='id_datos' value='" . $row["id_datos"] . "'>\";";
                       echo "datosPersonales += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "datosPersonales += \"</form>\";";
                       echo "datosPersonales += '<button class=\"edit\" onclick=\'editarDatosPersonales(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "datosPersonales += '</div>';";
                       echo "datosPersonales += '</div>';";
                   }
               } else {
                   echo "datosPersonales += '<div class=\"data-item\"><p>No se encontraron datos personales.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = datosPersonales;
               formDatosPersonales.style.display = 'block';
           });

           educacionLink.addEventListener('click', function() {
               ocultarFormularios();
               formEducacion.style.display = 'block';
               // Consulta para obtener la educación del usuario
               <?php
               $sql = "SELECT * FROM Educacion WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar la educación como una lista
               var educacion = "<h2><i class='fas fa-graduation-cap'></i> Educación</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "educacion += '<div class=\"data-item\">';";
                       echo "educacion += '<p><strong><i class=\"fas fa-university\"></i> Nombre de la Institución:</strong> " . $row["nombre_institucion"] . "</p>';";
                       echo "educacion += '<p><strong><i class=\"fas fa-layer-group\"></i> Nivel:</strong> " . $row["nivel_institucion"] . "</p>';";
                       echo "educacion += '<p><strong><i class=\"fas fa-book\"></i> Especialidad:</strong> " . $row["especialidad_institucion"] . "</p>';";
                       echo "educacion += '<p><strong><i class=\"fas fa-calendar-alt\"></i> Fecha:</strong> " . $row["mes_inicio_institucion"] . " " . $row["anio_inicio_institucion"] . " - " . $row["mes_finalizacion_institucion"] . " " . $row["anio_finalizacion_institucion"] . "</p>';";
                       echo "educacion += '<div class=\"data-actions\">';";
                       echo "educacion += \"<form method='POST' action='Eliminar/EliminarEducacion.php' style='display:inline; margin: 0;'>\";";
                       echo "educacion += \"<input type='hidden' name='id_educacion' value='" . $row["id_educacion"] . "'>\";";
                       echo "educacion += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "educacion += \"</form>\";";
                       echo "educacion += '<button class=\"edit\" onclick=\'editarEducacion(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "educacion += '</div>';";
                       echo "educacion += '</div>';";
                   }
               } else {
                   echo "educacion += '<div class=\"data-item\"><p>No se encontraron datos de educación.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = educacion;
               formEducacion.style.display = 'block';
           });

           experienciaLink.addEventListener('click', function() {
               ocultarFormularios();
               formExperiencia.style.display = 'block';
               // Consulta para obtener la experiencia del usuario
               <?php
               $sql = "SELECT * FROM ExperienciaL WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar la experiencia como una lista
               var experiencia = "<h2><i class='fas fa-briefcase'></i> Experiencia</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "experiencia += '<div class=\"data-item\">';";
                       echo "experiencia += '<p><strong><i class=\"fas fa-building\"></i> Nombre Empresa:</strong> " . $row["nombre_empresa"] . "</p>';";
                       echo "experiencia += '<p><strong><i class=\"fas fa-user-tie\"></i> Puesto:</strong> " . $row["puesto_empresa"] . "</p>';";
                       echo "experiencia += '<p><strong><i class=\"fas fa-calendar-alt\"></i> Fecha:</strong> " . $row["mes_inicio_empresa"] . " " . $row["anio_inicio_empresa"] . " - " . $row["mes_finalizacion_empresa"] . " " . $row["anio_finalizacion_empresa"] . "</p>';";
                       echo "experiencia += '<p><strong><i class=\"fas fa-tasks\"></i> Descripción:</strong> " . $row["descripcion_empresa"] . "</p>';";
                       echo "experiencia += '<div class=\"data-actions\">';";
                       echo "experiencia += \"<form method='POST' action='Eliminar/EliminarExperiencia.php' style='display:inline; margin: 0;'>\";";
                       echo "experiencia += \"<input type='hidden' name='id_experiencia' value='" . $row["id_experiencia"] . "'>\";";
                       echo "experiencia += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "experiencia += \"</form>\";";
                       echo "experiencia += '<button class=\"edit\" onclick=\'editarExperiencia(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "experiencia += '</div>';";
                       echo "experiencia += '</div>';";
                   }
               } else {
                   echo "experiencia += '<div class=\"data-item\"><p>No se encontraron datos de experiencia.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = experiencia;
               formExperiencia.style.display = 'block';
           });

           habilidadesLink.addEventListener('click', function() {
               ocultarFormularios();
               formHabilidades.style.display = 'block';
               // Consulta para obtener las habilidades del usuario
               <?php
               $sql = "SELECT * FROM Habilidades WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar las habilidades como una lista
               var habilidades = "<h2><i class='fas fa-chart-bar'></i> Habilidades</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "habilidades += '<div class=\"data-item\">';";
                       echo "habilidades += '<p><strong><i class=\"fas fa-star\"></i> Habilidad:</strong> " . $row["habilidad"] . "</p>';";
                       echo "habilidades += '<div class=\"data-actions\">';";
                       echo "habilidades += \"<form method='POST' action='Eliminar/EliminarHabilidades.php' style='display:inline; margin: 0;'>\";";
                       echo "habilidades += \"<input type='hidden' name='id_habilidades' value='" . $row["id_habilidades"] . "'>\";";
                       echo "habilidades += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "habilidades += \"</form>\";";
                       echo "habilidades += '<button class=\"edit\" onclick=\'editarHabilidad(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "habilidades += '</div>';";
                       echo "habilidades += '</div>';";
                   }
               } else {
                   echo "habilidades += '<div class=\"data-item\"><p>No se encontraron datos de habilidades.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = habilidades;
               formHabilidades.style.display = 'block';
           });

           interesesLink.addEventListener('click', function() {
               ocultarFormularios();
               formIntereses.style.display = 'block';
               // Consulta para obtener los intereses personales del usuario
               <?php
               $sql = "SELECT * FROM InteresesPersonales WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar los intereses personales como una lista
               var intereses = "<h2><i class='fas fa-heart'></i> Intereses Personales</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "intereses += '<div class=\"data-item\">';";
                       echo "intereses += '<p><strong><i class=\"fas fa-thumbs-up\"></i> Interés:</strong> " . $row["interes"] . "</p>';";
                       echo "intereses += '<div class=\"data-actions\">';";
                       echo "intereses += \"<form method='POST' action='Eliminar/EliminarIntereses.php' style='display:inline; margin: 0;'>\";";
                       echo "intereses += \"<input type='hidden' name='id_interes' value='" . $row["id_interes"] . "'>\";";
                       echo "intereses += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "intereses += \"</form>\";";
                       echo "intereses += '<button class=\"edit\" onclick=\'editarInteres(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "intereses += '</div>';";
                       echo "intereses += '</div>';";
                   }
               } else {
                   echo "intereses += '<div class=\"data-item\"><p>No se encontraron datos de intereses personales.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = intereses;
               formIntereses.style.display = 'block';
           });

           idiomasLink.addEventListener('click', function() {
               ocultarFormularios();
               formIdiomas.style.display = 'block';
               // Consulta para obtener los idiomas del usuario
               <?php
               $sql = "SELECT * FROM Idiomas WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar los idiomas como una lista
               var idiomas = "<h2><i class='fas fa-language'></i> Idiomas</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "idiomas += '<div class=\"data-item\">';";
                       echo "idiomas += '<p><strong><i class=\"fas fa-globe\"></i> Idioma:</strong> " . $row["nombre_idioma"] . "</p>';";
                       echo "idiomas += '<p><strong><i class=\"fas fa-signal\"></i> Nivel:</strong> " . $row["nivel_idioma"] . "</p>';";
                       echo "idiomas += '<div class=\"data-actions\">';";
                       echo "idiomas += \"<form method='POST' action='Eliminar/EliminarIdiomas.php' style='display:inline; margin: 0;'>\";";
                       echo "idiomas += \"<input type='hidden' name='id_idioma' value='" . $row["id_idioma"] . "'>\";";
                       echo "idiomas += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "idiomas += \"</form>\";";
                       echo "idiomas += '<button class=\"edit\" onclick=\'editarIdioma(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "idiomas += '</div>';";
                       echo "idiomas += '</div>';";
                   }
               } else {
                   echo "idiomas += '<div class=\"data-item\"><p>No se encontraron datos de idiomas.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = idiomas;
               formIdiomas.style.display = 'block';
           });

           cursosLink.addEventListener('click', function() {
               ocultarFormularios();
               formCursos.style.display = 'block';
               // Consulta para obtener los cursos del usuario
               <?php
               $sql = "SELECT * FROM Cursos WHERE id_usuario = $id_usuario";
               $result = $conexion->query($sql);
               ?>
               // Mostrar los cursos como una lista 
               var cursos = "<h2><i class='fas fa-certificate'></i> Cursos</h2>";
               <?php
               if ($result->num_rows > 0) {
                   while($row = $result->fetch_assoc()) {
                       $rowJSON = json_encode($row, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
                       echo "cursos += '<div class=\"data-item\">';";
                       echo "cursos += '<p><strong><i class=\"fas fa-award\"></i> Nombre del Curso:</strong> " . $row["nombre_curso"] . "</p>';";
                       echo "cursos += '<p><strong><i class=\"fas fa-university\"></i> Institución:</strong> " . $row["institucion_curso"] . "</p>';";
                       echo "cursos += '<p><strong><i class=\"fas fa-clock\"></i> Duración:</strong> " . $row["duracion_curso"] . "</p>';";
                       echo "cursos += '<p><strong><i class=\"fas fa-calendar-check\"></i> Finalización:</strong> " . $row["mes_finalizacion_curso"] . " " . $row["anio_finalizacion_curso"] . "</p>';";
                       echo "cursos += '<div class=\"data-actions\">';";
                       echo "cursos += \"<form method='POST' action='Eliminar/EliminarCursos.php' style='display:inline; margin: 0;'>\";";
                       echo "cursos += \"<input type='hidden' name='id_curso' value='" . $row["id_curso"] . "'>\";";
                       echo "cursos += \"<button type='submit' class='delete'><i class='fas fa-trash-alt'></i> Eliminar</button>\";";
                       echo "cursos += \"</form>\";";
                       echo "cursos += '<button class=\"edit\" onclick=\'editarCurso(" . $rowJSON . ")\'><i class=\"fas fa-edit\"></i> Editar</button>';";
                       echo "cursos += '</div>';";
                       echo "cursos += '</div>';";
                   }
               } else {
                   echo "cursos += '<div class=\"data-item\"><p>No se encontraron datos de cursos.</p></div>';";
               }
               ?>
               consultaDiv.innerHTML = cursos;
               formCursos.style.display = 'block';
           });

           // Funciones para editar cada sección
           window.editarDatosPersonales = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarDatosPersonales, datos);
           }

           window.editarEducacion = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarEducacion, datos);
           }

           window.editarExperiencia = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarExperiencia, datos);
           }

           window.editarHabilidad = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarHabilidades, datos);
           }

           window.editarInteres = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarIntereses, datos);
           }

           window.editarIdioma = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarIdiomas, datos);
           }

           window.editarCurso = function(datos) {
               ocultarFormularios();
               mostrarFormularioEdicion(formEditarCursos, datos);
           }
           
           // Función para guardar la licenciatura correctamente
           document.getElementById('form_datos_personales').addEventListener('submit', function(e) {
               if (licenciaturaSelect.value === 'other') {
                   e.preventDefault();
                   var otraLicenciatura = document.getElementById('otra_licenciatura').value;
                   if (otraLicenciatura.trim() !== '') {
                       // Creamos un campo oculto con el valor real a enviar
                       var hiddenField = document.createElement('input');
                       hiddenField.type = 'hidden';
                       hiddenField.name = 'licenciatura_datos';
                       hiddenField.value = otraLicenciatura;
                       this.appendChild(hiddenField);
                       this.submit();
                   }
               }
           });
           
           // Función para guardar la licenciatura correctamente en el formulario de edición
           document.getElementById('form_editar_datos_personales').addEventListener('submit', function(e) {
               if (licenciaturaEditarSelect.value === 'other') {
                   e.preventDefault();
                   var otraLicenciatura = document.getElementById('otra_licenciatura_editar').value;
                   if (otraLicenciatura.trim() !== '') {
                       // Creamos un campo oculto con el valor real a enviar
                       var hiddenField = document.createElement('input');
                       hiddenField.type = 'hidden';
                       hiddenField.name = 'licenciatura_datos';
                       hiddenField.value = otraLicenciatura;
                       this.appendChild(hiddenField);
                       this.submit();
                   }
               }
           });
       }
   </script>

</body>
</html>

<?php 
} else {
   header('location: ../Login/Index.php');
}
?>