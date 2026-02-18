/**
 * Servicio de Autenticación
 * Maneja login, registro, logout y estado de sesión
 */
const AuthService = {

    SESSION_KEY: 'generacv_user',

    /**
     * Inicia sesión del usuario
     * @returns {Promise<{id_usuario, correo_usuario, rol_usuario}>}
     */
    async login(correo, contrasena) {
        const data = await ApiService.post('/auth/login', { correo, contrasena });
        if (data) {
            this.saveSession(data);
        }
        return data;
    },

    /**
     * Registra un nuevo usuario
     */
    async register(correo, contrasena) {
        return await ApiService.post('/auth/register', { correo, contrasena });
    },

    /**
     * Cierra la sesión del usuario
     */
    async logout() {
        try {
            await ApiService.post('/auth/logout', {});
        } catch (e) {
            // Ignorar errores al cerrar sesión en el servidor
        } finally {
            this.clearSession();
            Helpers.redirect('index.html');
        }
    },

    /**
     * Guarda la sesión en localStorage
     */
    saveSession(userData) {
        localStorage.setItem(this.SESSION_KEY, JSON.stringify(userData));
    },

    /**
     * Obtiene los datos de la sesión actual
     */
    getSession() {
        const data = localStorage.getItem(this.SESSION_KEY);
        return data ? JSON.parse(data) : null;
    },

    /**
     * Limpia la sesión
     */
    clearSession() {
        localStorage.removeItem(this.SESSION_KEY);
    },

    /**
     * Verifica si hay una sesión activa
     */
    isLoggedIn() {
        return this.getSession() !== null;
    },

    /**
     * Obtiene el rol del usuario actual
     */
    getRole() {
        const session = this.getSession();
        if (!session) return null;
        return session.rol_usuario !== undefined ? session.rol_usuario : session.rolUsuario;
    },

    /**
     * Obtiene el ID del usuario actual
     */
    getUserId() {
        const session = this.getSession();
        if (!session) return null;
        return session.id_usuario !== undefined ? session.id_usuario : session.idUsuario;
    },

    /**
     * Verifica si el usuario es administrador (rol 1)
     */
    isAdmin() {
        return this.getRole() == 1;
    },

    /**
     * Protege una página: redirige si no hay sesión o si el rol no coincide
     * @param {number|null} requiredRole - null = cualquier rol autenticado
     */
    requireAuth(requiredRole = null) {
        if (!this.isLoggedIn()) {
            Helpers.redirect('index.html');
            return false;
        }
        if (requiredRole !== null && this.getRole() != requiredRole) {
            // Redirigir según el rol real (== para tolerar string vs number)
            if (this.isAdmin()) {
                Helpers.redirect('home-admin.html');
            } else {
                Helpers.redirect('home.html');
            }
            return false;
        }
        return true;
    }
};
