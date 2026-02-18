/**
 * Utilidades generales del frontend
 */

const Helpers = {

    /**
     * Convierte la primera letra de cada palabra a mayúscula (equivalente a ucwords de PHP)
     */
    ucwords(str) {
        if (!str) return '';
        return str.toLowerCase().replace(/\b\w/g, c => c.toUpperCase());
    },

    /**
     * Sanitiza texto para evitar XSS (equivalente a htmlspecialchars de PHP)
     */
    sanitize(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    },

    /**
     * Valida que un campo no esté vacío
     */
    isEmpty(value) {
        return !value || value.trim() === '';
    },

    /**
     * Valida formato de correo electrónico
     */
    isValidEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    },

    /**
     * Muestra un mensaje de error en un contenedor
     */
    showError(containerId, message) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = `
            <div class="error-message">
                <i class="fas fa-exclamation-circle"></i> ${this.sanitize(message)}
            </div>
        `;
    },

    /**
     * Muestra un mensaje de éxito en un contenedor
     */
    showSuccess(containerId, message) {
        const container = document.getElementById(containerId);
        if (!container) return;
        container.innerHTML = `
            <div class="success-message">
                <i class="fas fa-check-circle"></i> ${this.sanitize(message)}
            </div>
        `;
    },

    /**
     * Limpia mensajes de error/éxito
     */
    clearMessages(containerId) {
        const container = document.getElementById(containerId);
        if (container) container.innerHTML = '';
    },

    /**
     * Obtiene parámetros de la URL
     */
    getQueryParam(name) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(name);
    },

    /**
     * Redirige a una URL
     */
    redirect(url) {
        window.location.href = url;
    },

    /**
     * Formatea fecha mes/año
     */
    formatPeriod(mes, anio) {
        if (!mes) return '';
        if (!anio) return mes;
        return `${mes} ${anio}`;
    },

    /**
     * Muestra un spinner de carga en un elemento
     */
    showLoading(elementId) {
        const el = document.getElementById(elementId);
        if (el) el.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Cargando...</div>';
    },

    /**
     * Confirma una acción destructiva
     */
    confirm(message) {
        return window.confirm(message);
    }
};
