/**
 * Servicio de API - Capa de comunicación HTTP con el backend
 * Wrapper genérico de fetch() con manejo de errores y autenticación
 */
const ApiService = {

    /**
     * Realiza una petición HTTP genérica
     */
    async request(endpoint, method = 'GET', body = null) {
        const url = `${API_CONFIG.BASE_URL}${endpoint}`;
        const options = {
            method,
            headers: { ...API_CONFIG.HEADERS },
            credentials: 'include' // Para cookies de sesión
        };

        if (body) {
            options.body = JSON.stringify(body);
        }

        try {
            const response = await fetch(url, options);

            if (response.status === 401) {
                // No autenticado - redirigir al login
                AuthService.clearSession();
                Helpers.redirect('index.html');
                return null;
            }

            if (response.status === 403) {
                throw new Error('No tienes permisos para realizar esta acción');
            }

            if (!response.ok) {
                const errorData = await response.json().catch(() => ({}));
                throw new Error(errorData.message || `Error ${response.status}`);
            }

            // Si no hay contenido (204 No Content)
            if (response.status === 204) return null;

            return await response.json();

        } catch (error) {
            if (error.name === 'TypeError' && error.message.includes('fetch')) {
                throw new Error('No se puede conectar con el servidor. Verifica que el backend esté corriendo en http://localhost:8081');
            }
            throw error;
        }
    },

    get(endpoint) {
        return this.request(endpoint, 'GET');
    },

    post(endpoint, body) {
        return this.request(endpoint, 'POST', body);
    },

    put(endpoint, body) {
        return this.request(endpoint, 'PUT', body);
    },

    delete(endpoint) {
        return this.request(endpoint, 'DELETE');
    }
};
