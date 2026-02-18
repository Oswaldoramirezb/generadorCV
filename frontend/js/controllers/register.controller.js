/**
 * Controlador de Registro
 */
const RegisterController = {

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

        const form = document.getElementById('register-form');
        if (form) {
            form.addEventListener('submit', (e) => this.handleRegister(e));
        }
    },

    async handleRegister(e) {
        e.preventDefault();
        Helpers.clearMessages('msg-container');

        const correo = document.getElementById('correo').value.trim();
        const contrasena = document.getElementById('contrasena').value;
        const rcontrasena = document.getElementById('rcontrasena').value;

        // Validaciones
        if (Helpers.isEmpty(correo) || Helpers.isEmpty(contrasena) || Helpers.isEmpty(rcontrasena)) {
            Helpers.showError('msg-container', 'Todos los campos son requeridos');
            return;
        }

        if (!Helpers.isValidEmail(correo)) {
            Helpers.showError('msg-container', 'El correo electrónico no es válido');
            return;
        }

        if (contrasena !== rcontrasena) {
            Helpers.showError('msg-container', 'Las contraseñas no coinciden');
            return;
        }

        if (contrasena.length < 6) {
            Helpers.showError('msg-container', 'La contraseña debe tener al menos 6 caracteres');
            return;
        }

        const btn = document.getElementById('btn-register');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Creando cuenta...';

        try {
            await AuthService.register(correo, contrasena);
            Helpers.showSuccess('msg-container', 'Cuenta creada exitosamente. Ahora puedes iniciar sesión.');
            document.getElementById('register-form').reset();
            setTimeout(() => Helpers.redirect('index.html'), 2000);
        } catch (error) {
            Helpers.showError('msg-container', error.message || 'Error al crear la cuenta. El correo puede ya estar registrado.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-user-plus"></i> Crear Cuenta';
        }
    }
};

document.addEventListener('DOMContentLoaded', () => RegisterController.init());
