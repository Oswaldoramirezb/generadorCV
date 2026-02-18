/**
 * Controlador del Panel de Administrador
 * Gestión de usuarios: listar, cambiar rol, eliminar, ver CV
 */
const AdminController = {

    init() {
        // Proteger la página - solo rol 1 (admin)
        if (!AuthService.requireAuth(1)) return;

        this.setupMenu();
        this.loadUsuarios();
    },

    setupMenu() {
        const menuLogout = document.getElementById('menu-logout');
        if (menuLogout) {
            menuLogout.addEventListener('click', (e) => {
                e.preventDefault();
                AuthService.logout();
            });
        }
    },

    async loadUsuarios() {
        const container = document.getElementById('usuarios-container');
        if (!container) return;

        Helpers.showLoading('usuarios-container');

        try {
            const usuarios = await ApiService.get('/admin/usuarios');
            this.renderUsuarios(container, usuarios);
        } catch (error) {
            container.innerHTML = `<div class="error-message"><i class="fas fa-exclamation-circle"></i> ${error.message}</div>`;
        }
    },

    renderUsuarios(container, usuarios) {
        if (!usuarios || usuarios.length === 0) {
            container.innerHTML = '<p style="color:#777;">No hay usuarios registrados.</p>';
            return;
        }

        let html = `
            <table class="users-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
        `;

        usuarios.forEach(u => {
            const rolBadge = u.rol_usuario === 1
                ? '<span class="badge badge-admin">Administrador</span>'
                : '<span class="badge badge-user">Usuario</span>';

            const nuevoRol = u.rol_usuario === 1 ? 2 : 1;
            const rolLabel = u.rol_usuario === 1 ? 'Hacer Usuario' : 'Hacer Admin';

            html += `
                <tr>
                    <td>${u.id_usuario}</td>
                    <td>${Helpers.sanitize(u.correo_usuario)}</td>
                    <td>${rolBadge}</td>
                    <td>
                        <div class="data-actions">
                            <button class="btn btn-info" onclick="AdminController.cambiarRol(${u.id_usuario}, ${nuevoRol})">
                                <i class="fas fa-user-tag"></i> ${rolLabel}
                            </button>
                            <button class="btn btn-success" onclick="AdminController.verCV(${u.id_usuario})">
                                <i class="fas fa-file-alt"></i> Ver CV
                            </button>
                            <button class="btn btn-danger" onclick="AdminController.eliminarUsuario(${u.id_usuario}, '${Helpers.sanitize(u.correo_usuario)}')">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        html += '</tbody></table>';
        container.innerHTML = html;
    },

    async cambiarRol(userId, nuevoRol) {
        const rolNombre = nuevoRol === 1 ? 'Administrador' : 'Usuario';
        if (!Helpers.confirm(`¿Cambiar el rol de este usuario a ${rolNombre}?`)) return;

        try {
            await ApiService.put(`/admin/usuarios/${userId}/rol`, { rol_usuario: nuevoRol });
            this.loadUsuarios();
        } catch (error) {
            alert('Error al cambiar rol: ' + error.message);
        }
    },

    async eliminarUsuario(userId, correo) {
        if (!Helpers.confirm(`¿Estás seguro de que deseas eliminar al usuario "${correo}"? Esta acción eliminará también todos sus datos de CV.`)) return;

        try {
            await ApiService.delete(`/admin/usuarios/${userId}`);
            this.loadUsuarios();
        } catch (error) {
            alert('Error al eliminar usuario: ' + error.message);
        }
    },

    verCV(userId) {
        // Abrir el selector de CV del usuario en nueva pestaña
        window.open(`cv/harvard.html?userId=${userId}`, '_blank');
    }
};

document.addEventListener('DOMContentLoaded', () => AdminController.init());
