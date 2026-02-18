/**
 * Servicio de CV - CRUD completo para todas las secciones del CV
 */
const CvService = {

    // ─── Datos Personales ───────────────────────────────────────────────────

    async getDatosPersonales() {
        return await ApiService.get('/datos-personales');
    },
    async saveDatosPersonales(data) {
        return await ApiService.post('/datos-personales', data);
    },
    async updateDatosPersonales(id, data) {
        return await ApiService.put(`/datos-personales/${id}`, data);
    },
    async deleteDatosPersonales(id) {
        return await ApiService.delete(`/datos-personales/${id}`);
    },

    // ─── Educación ──────────────────────────────────────────────────────────

    async getEducacion() {
        return await ApiService.get('/educacion');
    },
    async saveEducacion(data) {
        return await ApiService.post('/educacion', data);
    },
    async updateEducacion(id, data) {
        return await ApiService.put(`/educacion/${id}`, data);
    },
    async deleteEducacion(id) {
        return await ApiService.delete(`/educacion/${id}`);
    },

    // ─── Experiencia ────────────────────────────────────────────────────────

    async getExperiencia() {
        return await ApiService.get('/experiencia');
    },
    async saveExperiencia(data) {
        return await ApiService.post('/experiencia', data);
    },
    async updateExperiencia(id, data) {
        return await ApiService.put(`/experiencia/${id}`, data);
    },
    async deleteExperiencia(id) {
        return await ApiService.delete(`/experiencia/${id}`);
    },

    // ─── Habilidades ────────────────────────────────────────────────────────

    async getHabilidades() {
        return await ApiService.get('/habilidades');
    },
    async saveHabilidad(data) {
        return await ApiService.post('/habilidades', data);
    },
    async updateHabilidad(id, data) {
        return await ApiService.put(`/habilidades/${id}`, data);
    },
    async deleteHabilidad(id) {
        return await ApiService.delete(`/habilidades/${id}`);
    },

    // ─── Intereses ──────────────────────────────────────────────────────────

    async getIntereses() {
        return await ApiService.get('/intereses');
    },
    async saveInteres(data) {
        return await ApiService.post('/intereses', data);
    },
    async updateInteres(id, data) {
        return await ApiService.put(`/intereses/${id}`, data);
    },
    async deleteInteres(id) {
        return await ApiService.delete(`/intereses/${id}`);
    },

    // ─── Idiomas ────────────────────────────────────────────────────────────

    async getIdiomas() {
        return await ApiService.get('/idiomas');
    },
    async saveIdioma(data) {
        return await ApiService.post('/idiomas', data);
    },
    async updateIdioma(id, data) {
        return await ApiService.put(`/idiomas/${id}`, data);
    },
    async deleteIdioma(id) {
        return await ApiService.delete(`/idiomas/${id}`);
    },

    // ─── Cursos ─────────────────────────────────────────────────────────────

    async getCursos() {
        return await ApiService.get('/cursos');
    },
    async saveCurso(data) {
        return await ApiService.post('/cursos', data);
    },
    async updateCurso(id, data) {
        return await ApiService.put(`/cursos/${id}`, data);
    },
    async deleteCurso(id) {
        return await ApiService.delete(`/cursos/${id}`);
    },

    // ─── CV completo (para plantillas) ──────────────────────────────────────

    async getCvCompleto(userId = null) {
        const endpoint = userId ? `/cv/completo/${userId}` : '/cv/completo';
        return await ApiService.get(endpoint);
    }
};
