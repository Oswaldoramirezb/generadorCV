/**
 * Controlador del Dashboard de Usuario (Home)
 * Maneja todas las secciones del CV: Datos Personales, Educación,
 * Experiencia, Habilidades, Intereses, Idiomas, Cursos
 */
const HomeController = {

    currentSection: null,

    init() {
        // Proteger la página - solo rol 2 (usuario)
        if (!AuthService.requireAuth(2)) return;

        this.setupMenu();
        this.setupForms();
        this.loadSection('cv'); // Cargar CV por defecto
    },

    // ─── Menú ────────────────────────────────────────────────────────────────

    setupMenu() {
        const menuItems = {
            'menu-cv': () => this.loadSection('cv'),
            'menu-datos': () => this.loadSection('datos_personales'),
            'menu-educacion': () => this.loadSection('educacion'),
            'menu-experiencia': () => this.loadSection('experiencia'),
            'menu-habilidades': () => this.loadSection('habilidades'),
            'menu-intereses': () => this.loadSection('intereses'),
            'menu-idiomas': () => this.loadSection('idiomas'),
            'menu-cursos': () => this.loadSection('cursos'),
            'menu-logout': () => AuthService.logout()
        };

        for (const [id, handler] of Object.entries(menuItems)) {
            const el = document.getElementById(id);
            if (el) el.addEventListener('click', (e) => { e.preventDefault(); handler(); });
        }
    },

    setActiveMenu(sectionId) {
        document.querySelectorAll('#menu a').forEach(a => a.classList.remove('active'));
        const active = document.getElementById(`menu-${sectionId}`);
        if (active) active.classList.add('active');
    },

    // ─── Secciones ───────────────────────────────────────────────────────────

    async loadSection(section) {
        this.currentSection = section;
        this.setActiveMenu(section);
        this.hideAllForms();

        const consulta = document.getElementById('consulta');

        if (section === 'cv') {
            this.renderCvOptions(consulta);
            return;
        }

        Helpers.showLoading('consulta');

        try {
            switch (section) {
                case 'datos_personales': await this.loadDatosPersonales(consulta); break;
                case 'educacion': await this.loadEducacion(consulta); break;
                case 'experiencia': await this.loadExperiencia(consulta); break;
                case 'habilidades': await this.loadHabilidades(consulta); break;
                case 'intereses': await this.loadIntereses(consulta); break;
                case 'idiomas': await this.loadIdiomas(consulta); break;
                case 'cursos': await this.loadCursos(consulta); break;
            }
        } catch (error) {
            consulta.innerHTML = `<div class="error-message"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
        }
    },

    hideAllForms() {
        document.querySelectorAll('.form-section').forEach(f => f.style.display = 'none');
    },

    showForm(formId) {
        this.hideAllForms();
        document.getElementById('consulta').innerHTML = '';
        const form = document.getElementById(formId);
        if (form) form.style.display = 'block';
    },

    // ─── CV ──────────────────────────────────────────────────────────────────

    renderCvOptions(container) {
        container.innerHTML = `
            <h2><i class="fas fa-file-alt"></i> Tipos de CV</h2>
            <div class="cv-container">
                <div class="cv-card">
                    <h3>Harvard</h3>
                    <div class="cv-buttons">
                        <button class="btn btn-success" onclick="window.open('cv/harvard.html','_blank')"><i class="fas fa-eye"></i> Visualizar</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Harvard (English)</h3>
                    <div class="cv-buttons">
                        <button class="btn btn-success" onclick="window.open('cv/harvard-en.html','_blank')"><i class="fas fa-eye"></i> Visualizar</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Mistli</h3>
                    <div class="cv-buttons">
                        <button class="btn btn-success" onclick="window.open('cv/mistli.html','_blank')"><i class="fas fa-eye"></i> Visualizar</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Mistli (English)</h3>
                    <div class="cv-buttons">
                        <button class="btn btn-success" onclick="window.open('cv/mistli-en.html','_blank')"><i class="fas fa-eye"></i> Visualizar</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Kaxtil</h3>
                    <div class="cv-buttons">
                        <button class="btn" style="background:#ffeded;color:#c02727;border-color:#c02727;" onclick="window.open('cv/kaxtil.html?color=rojo','_blank')"><i class="fas fa-eye"></i> Rojo</button>
                        <button class="btn" style="background:#edf6ff;color:#0066cc;border-color:#0066cc;" onclick="window.open('cv/kaxtil.html?color=azul','_blank')"><i class="fas fa-eye"></i> Azul</button>
                        <button class="btn" style="background:#edffef;color:#28a745;border-color:#28a745;" onclick="window.open('cv/kaxtil.html?color=verde','_blank')"><i class="fas fa-eye"></i> Verde</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Kaxtil (English)</h3>
                    <div class="cv-buttons">
                        <button class="btn" style="background:#ffeded;color:#c02727;border-color:#c02727;" onclick="window.open('cv/kaxtil-en.html?color=rojo','_blank')"><i class="fas fa-eye"></i> Rojo</button>
                        <button class="btn" style="background:#edf6ff;color:#0066cc;border-color:#0066cc;" onclick="window.open('cv/kaxtil-en.html?color=azul','_blank')"><i class="fas fa-eye"></i> Azul</button>
                        <button class="btn" style="background:#edffef;color:#28a745;border-color:#28a745;" onclick="window.open('cv/kaxtil-en.html?color=verde','_blank')"><i class="fas fa-eye"></i> Verde</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Amichin</h3>
                    <div class="cv-buttons">
                        <button class="btn" style="background:#ffeded;color:#c02727;border-color:#c02727;" onclick="window.open('cv/amichin.html?color=rojo','_blank')"><i class="fas fa-eye"></i> Rojo</button>
                        <button class="btn" style="background:#edf6ff;color:#0066cc;border-color:#0066cc;" onclick="window.open('cv/amichin.html?color=azul','_blank')"><i class="fas fa-eye"></i> Azul</button>
                        <button class="btn" style="background:#edffef;color:#28a745;border-color:#28a745;" onclick="window.open('cv/amichin.html?color=verde','_blank')"><i class="fas fa-eye"></i> Verde</button>
                    </div>
                </div>
                <div class="cv-card">
                    <h3>Amichin (English)</h3>
                    <div class="cv-buttons">
                        <button class="btn" style="background:#ffeded;color:#c02727;border-color:#c02727;" onclick="window.open('cv/amichin-en.html?color=rojo','_blank')"><i class="fas fa-eye"></i> Rojo</button>
                        <button class="btn" style="background:#edf6ff;color:#0066cc;border-color:#0066cc;" onclick="window.open('cv/amichin-en.html?color=azul','_blank')"><i class="fas fa-eye"></i> Azul</button>
                        <button class="btn" style="background:#edffef;color:#28a745;border-color:#28a745;" onclick="window.open('cv/amichin-en.html?color=verde','_blank')"><i class="fas fa-eye"></i> Verde</button>
                    </div>
                </div>
            </div>
        `;
    },

    // ─── Datos Personales ────────────────────────────────────────────────────

    async loadDatosPersonales(container) {
        const data = await CvService.getDatosPersonales();
        let html = `<h2><i class="fas fa-user"></i> Datos Personales</h2>`;

        // Normalizar los datos: el backend devuelve un objeto único o null
        // El frontend original esperaba un array. Soportamos ambos.
        const items = data ? (Array.isArray(data) ? data : [data]) : [];

        if (items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay datos personales registrados.</p>`;
            html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('datos_personales')"><i class="fas fa-plus"></i> Agregar</button>`;
        } else {
            items.forEach(d => {
                html += `
                <div class="data-item">
                    <p><strong>Nombre:</strong> ${Helpers.sanitize(d.nombre_datos)}</p>
                    <p><strong>Licenciatura:</strong> ${Helpers.sanitize(d.licenciatura_datos)}</p>
                    <p><strong>Matrícula:</strong> ${Helpers.sanitize(d.matricula_datos)}</p>
                    <p><strong>Ciudad:</strong> ${Helpers.sanitize(d.ciudad_datos)}</p>
                    <p><strong>Teléfono:</strong> ${Helpers.sanitize(d.telefono_datos)}</p>
                    <p><strong>Correo:</strong> ${Helpers.sanitize(d.correo_datos)}</p>
                    <p><strong>% Créditos:</strong> ${Helpers.sanitize(d.porcentaje_creditos)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('datos_personales', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('datos_personales', ${d.id_datos})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
            // En datos personales solo permitimos uno por ahora según la estructura 1-a-1 del backend
            // html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('datos_personales')"><i class="fas fa-plus"></i> Agregar otro</button>`;
        }
        container.innerHTML = html;
    },

    // ─── Educación ───────────────────────────────────────────────────────────

    async loadEducacion(container) {
        const items = await CvService.getEducacion();
        let html = `<h2><i class="fas fa-graduation-cap"></i> Educación</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay educación registrada.</p>`;
        } else {
            items.forEach(d => {
                const fin = d.mes_finalizacion_institucion
                    ? `${d.mes_finalizacion_institucion} ${d.anio_finalizacion_institucion || ''}`.trim()
                    : 'Actual';
                html += `
                <div class="data-item">
                    <p><strong>Institución:</strong> ${Helpers.sanitize(d.nombre_institucion)}</p>
                    <p><strong>Nivel:</strong> ${Helpers.sanitize(d.nivel_institucion)}</p>
                    <p><strong>Especialidad:</strong> ${Helpers.sanitize(d.especialidad_institucion)}</p>
                    <p><strong>Período:</strong> ${Helpers.sanitize(d.mes_inicio_institucion)} ${d.anio_inicio_institucion} — ${Helpers.sanitize(fin)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('educacion', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('educacion', ${d.id_educacion})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('educacion')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Experiencia ─────────────────────────────────────────────────────────

    async loadExperiencia(container) {
        const items = await CvService.getExperiencia();
        let html = `<h2><i class="fas fa-briefcase"></i> Experiencia</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay experiencia registrada.</p>`;
        } else {
            items.forEach(d => {
                const fin = d.mes_finalizacion_empresa
                    ? `${d.mes_finalizacion_empresa} ${d.anio_finalizacion_empresa || ''}`.trim()
                    : 'Actual';
                html += `
                <div class="data-item">
                    <p><strong>Empresa:</strong> ${Helpers.sanitize(d.nombre_empresa)}</p>
                    <p><strong>Puesto:</strong> ${Helpers.sanitize(d.puesto_empresa)}</p>
                    <p><strong>Período:</strong> ${Helpers.sanitize(d.mes_inicio_empresa)} ${d.anio_inicio_empresa} — ${Helpers.sanitize(fin)}</p>
                    <p><strong>Descripción:</strong> ${Helpers.sanitize(d.descripcion_empresa)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('experiencia', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('experiencia', ${d.id_experiencia})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('experiencia')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Habilidades ─────────────────────────────────────────────────────────

    async loadHabilidades(container) {
        const items = await CvService.getHabilidades();
        let html = `<h2><i class="fas fa-chart-bar"></i> Habilidades</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay habilidades registradas.</p>`;
        } else {
            items.forEach(d => {
                html += `
                <div class="data-item">
                    <p><strong>Habilidad:</strong> ${Helpers.sanitize(d.habilidad)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('habilidades', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('habilidades', ${d.id_habilidades})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('habilidades')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Intereses ───────────────────────────────────────────────────────────

    async loadIntereses(container) {
        const items = await CvService.getIntereses();
        let html = `<h2><i class="fas fa-heart"></i> Intereses Personales</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay intereses registrados.</p>`;
        } else {
            items.forEach(d => {
                html += `
                <div class="data-item">
                    <p><strong>Interés:</strong> ${Helpers.sanitize(d.interes)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('intereses', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('intereses', ${d.id_interes})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('intereses')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Idiomas ─────────────────────────────────────────────────────────────

    async loadIdiomas(container) {
        const items = await CvService.getIdiomas();
        let html = `<h2><i class="fas fa-language"></i> Idiomas</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay idiomas registrados.</p>`;
        } else {
            items.forEach(d => {
                html += `
                <div class="data-item">
                    <p><strong>Idioma:</strong> ${Helpers.sanitize(d.nombre_idioma)}</p>
                    <p><strong>Nivel:</strong> ${Helpers.sanitize(d.nivel_idioma)}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('idiomas', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('idiomas', ${d.id_idioma})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('idiomas')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Cursos ──────────────────────────────────────────────────────────────

    async loadCursos(container) {
        const items = await CvService.getCursos();
        let html = `<h2><i class="fas fa-certificate"></i> Cursos</h2>`;

        if (!items || items.length === 0) {
            html += `<p style="color:#777;margin-bottom:15px;">No hay cursos registrados.</p>`;
        } else {
            items.forEach(d => {
                html += `
                <div class="data-item">
                    <p><strong>Curso:</strong> ${Helpers.sanitize(d.nombre_curso)}</p>
                    <p><strong>Institución:</strong> ${Helpers.sanitize(d.institucion_curso)}</p>
                    <p><strong>Duración:</strong> ${Helpers.sanitize(d.duracion_curso)}</p>
                    <p><strong>Finalización:</strong> ${Helpers.sanitize(d.mes_finalizacion_curso)} ${d.anio_finalizacion_curso}</p>
                    <div class="data-actions">
                        <button class="btn btn-info" onclick="HomeController.showEditForm('cursos', ${JSON.stringify(d).replace(/"/g, '&quot;')})"><i class="fas fa-edit"></i> Editar</button>
                        <button class="btn btn-danger" onclick="HomeController.deleteItem('cursos', ${d.id_curso})"><i class="fas fa-trash"></i> Eliminar</button>
                    </div>
                </div>`;
            });
        }
        html += `<button class="btn btn-primary" onclick="HomeController.showAddForm('cursos')"><i class="fas fa-plus"></i> Agregar</button>`;
        container.innerHTML = html;
    },

    // ─── Mostrar formularios ─────────────────────────────────────────────────

    showAddForm(section) {
        this.showForm(`form-add-${section}`);
        const form = document.getElementById(`form-add-${section}`);
        if (form) form.reset();
    },

    showEditForm(section, data) {
        this.showForm(`form-edit-${section}`);
        const form = document.getElementById(`form-edit-${section}`);
        if (!form) return;

        // Rellenar campos con los datos existentes
        for (const [key, value] of Object.entries(data)) {
            const el = form.querySelector(`[name="${key}"]`);
            if (el) el.value = value || '';
        }

        // Manejar caso especial de licenciatura personalizada
        if (section === 'datos_personales') {
            const select = form.querySelector('[name="licenciatura_datos"]');
            const otraDiv = document.getElementById('edit-otra-licenciatura-div');
            const otraInput = document.getElementById('edit-otra-licenciatura');
            if (select && otraDiv && otraInput) {
                const opciones = Array.from(select.options).map(o => o.value);
                if (!opciones.includes(data.licenciatura_datos) && data.licenciatura_datos) {
                    select.value = 'other';
                    otraDiv.style.display = 'block';
                    otraInput.value = data.licenciatura_datos;
                }
            }
        }
    },

    // ─── CRUD ────────────────────────────────────────────────────────────────

    async deleteItem(section, id) {
        if (!Helpers.confirm('¿Estás seguro de que deseas eliminar este registro?')) return;

        try {
            switch (section) {
                case 'datos_personales': await CvService.deleteDatosPersonales(id); break;
                case 'educacion': await CvService.deleteEducacion(id); break;
                case 'experiencia': await CvService.deleteExperiencia(id); break;
                case 'habilidades': await CvService.deleteHabilidad(id); break;
                case 'intereses': await CvService.deleteInteres(id); break;
                case 'idiomas': await CvService.deleteIdioma(id); break;
                case 'cursos': await CvService.deleteCurso(id); break;
            }
            this.loadSection(section);
        } catch (error) {
            alert('Error al eliminar: ' + error.message);
        }
    },

    // ─── Setup de formularios ─────────────────────────────────────────────────

    setupForms() {
        this.setupDatosPersonalesForm();
        this.setupEducacionForm();
        this.setupExperienciaForm();
        this.setupHabilidadesForm();
        this.setupInteresesForm();
        this.setupIdiomasForm();
        this.setupCursosForm();
        this.setupLicenciaturaToggle();
    },

    setupLicenciaturaToggle() {
        // Para formulario de agregar
        const addSelect = document.getElementById('add-licenciatura');
        const addOtraDiv = document.getElementById('add-otra-licenciatura-div');
        const addOtraInput = document.getElementById('add-otra-licenciatura');
        if (addSelect) {
            addSelect.addEventListener('change', function () {
                if (this.value === 'other') {
                    addOtraDiv.style.display = 'flex';
                    addOtraInput.required = true;
                } else {
                    addOtraDiv.style.display = 'none';
                    addOtraInput.required = false;
                }
            });
        }

        // Para formulario de editar
        const editSelect = document.getElementById('edit-licenciatura');
        const editOtraDiv = document.getElementById('edit-otra-licenciatura-div');
        const editOtraInput = document.getElementById('edit-otra-licenciatura');
        if (editSelect) {
            editSelect.addEventListener('change', function () {
                if (this.value === 'other') {
                    editOtraDiv.style.display = 'flex';
                    editOtraInput.required = true;
                } else {
                    editOtraDiv.style.display = 'none';
                    editOtraInput.required = false;
                }
            });
        }
    },

    getLicenciaturaValue(formPrefix) {
        const select = document.getElementById(`${formPrefix}-licenciatura`);
        if (!select) return '';
        if (select.value === 'other') {
            return document.getElementById(`${formPrefix}-otra-licenciatura`).value.trim();
        }
        return select.value;
    },

    setupDatosPersonalesForm() {
        const addForm = document.getElementById('form-add-datos_personales');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const licenciatura = this.getLicenciaturaValue('add');
                const data = {
                    nombre_datos: Helpers.ucwords(addForm.querySelector('[name="nombre_datos"]').value),
                    licenciatura_datos: licenciatura,
                    matricula_datos: addForm.querySelector('[name="matricula_datos"]').value.trim(),
                    ciudad_datos: Helpers.ucwords(addForm.querySelector('[name="ciudad_datos"]').value),
                    telefono_datos: addForm.querySelector('[name="telefono_datos"]').value.trim(),
                    correo_datos: addForm.querySelector('[name="correo_datos"]').value.trim(),
                    porcentaje_creditos: addForm.querySelector('[name="porcentaje_creditos"]').value.trim()
                };
                await this.submitForm(() => CvService.saveDatosPersonales(data), 'datos_personales', 'form-msg-datos_personales');
            });
        }

        const editForm = document.getElementById('form-edit-datos_personales');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_datos"]').value;
                const licenciatura = this.getLicenciaturaValue('edit');
                const data = {
                    nombre_datos: Helpers.ucwords(editForm.querySelector('[name="nombre_datos"]').value),
                    licenciatura_datos: licenciatura,
                    matricula_datos: editForm.querySelector('[name="matricula_datos"]').value.trim(),
                    ciudad_datos: Helpers.ucwords(editForm.querySelector('[name="ciudad_datos"]').value),
                    telefono_datos: editForm.querySelector('[name="telefono_datos"]').value.trim(),
                    correo_datos: editForm.querySelector('[name="correo_datos"]').value.trim(),
                    porcentaje_creditos: editForm.querySelector('[name="porcentaje_creditos"]').value.trim()
                };
                await this.submitForm(() => CvService.updateDatosPersonales(id, data), 'datos_personales', 'form-msg-edit-datos_personales');
            });
        }
    },

    setupEducacionForm() {
        const addForm = document.getElementById('form-add-educacion');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['nombre_institucion', 'nivel_institucion', 'especialidad_institucion', 'mes_inicio_institucion', 'anio_inicio_institucion', 'mes_finalizacion_institucion', 'anio_finalizacion_institucion']);
                await this.submitForm(() => CvService.saveEducacion(data), 'educacion', 'form-msg-educacion');
            });
        }
        const editForm = document.getElementById('form-edit-educacion');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_educacion"]').value;
                const data = this.getFormData(editForm, ['nombre_institucion', 'nivel_institucion', 'especialidad_institucion', 'mes_inicio_institucion', 'anio_inicio_institucion', 'mes_finalizacion_institucion', 'anio_finalizacion_institucion']);
                await this.submitForm(() => CvService.updateEducacion(id, data), 'educacion', 'form-msg-edit-educacion');
            });
        }
    },

    setupExperienciaForm() {
        const addForm = document.getElementById('form-add-experiencia');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['nombre_empresa', 'puesto_empresa', 'mes_inicio_empresa', 'anio_inicio_empresa', 'mes_finalizacion_empresa', 'anio_finalizacion_empresa', 'descripcion_empresa']);
                await this.submitForm(() => CvService.saveExperiencia(data), 'experiencia', 'form-msg-experiencia');
            });
        }
        const editForm = document.getElementById('form-edit-experiencia');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_experiencia"]').value;
                const data = this.getFormData(editForm, ['nombre_empresa', 'puesto_empresa', 'mes_inicio_empresa', 'anio_inicio_empresa', 'mes_finalizacion_empresa', 'anio_finalizacion_empresa', 'descripcion_empresa']);
                await this.submitForm(() => CvService.updateExperiencia(id, data), 'experiencia', 'form-msg-edit-experiencia');
            });
        }
    },

    setupHabilidadesForm() {
        const addForm = document.getElementById('form-add-habilidades');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['habilidad']);
                await this.submitForm(() => CvService.saveHabilidad(data), 'habilidades', 'form-msg-habilidades');
            });
        }
        const editForm = document.getElementById('form-edit-habilidades');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_habilidades"]').value;
                const data = this.getFormData(editForm, ['habilidad']);
                await this.submitForm(() => CvService.updateHabilidad(id, data), 'habilidades', 'form-msg-edit-habilidades');
            });
        }
    },

    setupInteresesForm() {
        const addForm = document.getElementById('form-add-intereses');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['interes']);
                await this.submitForm(() => CvService.saveInteres(data), 'intereses', 'form-msg-intereses');
            });
        }
        const editForm = document.getElementById('form-edit-intereses');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_interes"]').value;
                const data = this.getFormData(editForm, ['interes']);
                await this.submitForm(() => CvService.updateInteres(id, data), 'intereses', 'form-msg-edit-intereses');
            });
        }
    },

    setupIdiomasForm() {
        const addForm = document.getElementById('form-add-idiomas');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['nombre_idioma', 'nivel_idioma']);
                await this.submitForm(() => CvService.saveIdioma(data), 'idiomas', 'form-msg-idiomas');
            });
        }
        const editForm = document.getElementById('form-edit-idiomas');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_idioma"]').value;
                const data = this.getFormData(editForm, ['nombre_idioma', 'nivel_idioma']);
                await this.submitForm(() => CvService.updateIdioma(id, data), 'idiomas', 'form-msg-edit-idiomas');
            });
        }
    },

    setupCursosForm() {
        const addForm = document.getElementById('form-add-cursos');
        if (addForm) {
            addForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const data = this.getFormData(addForm, ['nombre_curso', 'institucion_curso', 'duracion_curso', 'mes_finalizacion_curso', 'anio_finalizacion_curso']);
                await this.submitForm(() => CvService.saveCurso(data), 'cursos', 'form-msg-cursos');
            });
        }
        const editForm = document.getElementById('form-edit-cursos');
        if (editForm) {
            editForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = editForm.querySelector('[name="id_curso"]').value;
                const data = this.getFormData(editForm, ['nombre_curso', 'institucion_curso', 'duracion_curso', 'mes_finalizacion_curso', 'anio_finalizacion_curso']);
                await this.submitForm(() => CvService.updateCurso(id, data), 'cursos', 'form-msg-edit-cursos');
            });
        }
    },

    // ─── Helpers de formulario ───────────────────────────────────────────────

    getFormData(form, fields) {
        const data = {};
        fields.forEach(field => {
            const el = form.querySelector(`[name="${field}"]`);
            data[field] = el ? el.value.trim() : '';
        });
        return data;
    },

    async submitForm(apiCall, sectionName, msgContainerId) {
        Helpers.clearMessages(msgContainerId);

        // Bloqueo para invitados (Rol 3)
        if (AuthService.isGuest()) {
            const html = `
                <div class="info-message animated pulse">
                    <i class="fas fa-info-circle"></i> <strong>Registro Obligatorio:</strong> 
                    Estás navegando como invitado. Para guardar tu información y generar tu CV, 
                    debes <a href="register.html" style="color:var(--primary-color); font-weight:bold; text-decoration:underline;">registrarte aquí</a>.
                </div>
            `;
            const container = document.getElementById(msgContainerId);
            if (container) {
                container.innerHTML = html;
                container.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                alert('Registro obligatorio: Los invitados no pueden guardar información.');
            }
            return;
        }

        try {
            await apiCall();
            Helpers.showSuccess(msgContainerId, '¡Datos guardados correctamente!');
            setTimeout(() => this.loadSection(sectionName), 1500);
        } catch (error) {
            Helpers.showError(msgContainerId, error.message);
        }
    }
};

document.addEventListener('DOMContentLoaded', () => HomeController.init());
