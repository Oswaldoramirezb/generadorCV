/**
 * Controlador de Login
 */
const LoginController = {

    init() {
        // Si ya hay sesión activa, redirigir
        const session = AuthService.getSession();
        if (session) {
            if (session.rol_usuario === 1) {
                Helpers.redirect('home-admin.html');
            } else {
                Helpers.redirect('home.html');
            }
            return;
        }

        // Mostrar error desde URL si viene de redirección
        const error = Helpers.getQueryParam('error');
        if (error) {
            Helpers.showError('msg-container', error);
        }

        // Manejar submit del formulario
        const form = document.getElementById('login-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleLogin(e));
        }
    },

    async handleLogin(e) {
        e.preventDefault();
        Helpers.clearMessages('msg-container');

        const correo = document.getElementById('correo').value.trim();
        const contrasena = document.getElementById('contrasena').value;

        // Validaciones básicas
        if (Helpers.isEmpty(correo) || Helpers.isEmpty(contrasena)) {
            Helpers.showError('msg-container', 'El correo y la contraseña son requeridos');
            return;
        }

        const btn = document.getElementById('btn-login');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Ingresando...';

        try {
            const userData = await AuthService.login(correo, contrasena);
            if (userData) {
                if (userData.rol_usuario === 1) {
                    Helpers.redirect('home-admin.html');
                } else {
                    Helpers.redirect('home.html');
                }
            }
        } catch (error) {
            Helpers.showError('msg-container', error.message || 'Usuario o contraseña incorrecta');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-sign-in-alt"></i> Ingresar';
        }
    }
};

document.addEventListener('DOMContentLoaded', () => LoginController.init());
