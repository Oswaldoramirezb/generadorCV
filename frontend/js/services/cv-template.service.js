/**
 * Servicio compartido para cargar datos del CV en las plantillas
 * Usado por todas las páginas de CV (harvard, mistli, kaxtil, amichin)
 */
const CvTemplateService = {

    /**
     * Carga el CV completo del usuario autenticado (o del userId especificado por admin)
     */
    async loadCvData() {
        const urlParams = new URLSearchParams(window.location.search);
        const userId = urlParams.get('userId');

        // Verificar sesión
        const session = AuthService.getSession();
        if (!session) {
            window.location.href = '../index.html';
            return null;
        }

        try {
            const endpoint = userId ? `/cv/completo/${userId}` : '/cv/completo';
            return await ApiService.get(endpoint);
        } catch (error) {
            document.body.innerHTML = `
                <div style="text-align:center;padding:50px;font-family:Arial,sans-serif;">
                    <h2 style="color:#c02727;">Error al cargar el CV</h2>
                    <p>${error.message}</p>
                    <a href="../home.html" style="color:#c02727;">← Volver al dashboard</a>
                </div>`;
            return null;
        }
    },

    /**
     * Formatea un período mes/año con separador
     */
    formatPeriod(mesInicio, anioInicio, mesFin, anioFin) {
        let result = `${mesInicio || ''} ${anioInicio || ''}`.trim();
        if (mesFin) {
            result += ` - ${mesFin}`;
            if (anioFin) result += ` ${anioFin}`;
        }
        return result;
    },

    /**
     * Escapa HTML para evitar XSS
     */
    esc(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    },

    /**
     * Configura el botón de descarga de PDF
     */
    setupPdfDownload(contentId, filename) {
        const btn = document.getElementById('downloadPDF');
        if (!btn) return;

        btn.addEventListener('click', function () {
            const element = document.getElementById(contentId);
            btn.style.display = 'none';

            const opt = {
                margin: [0.3, 0.3, 0.3, 0.3],
                filename: filename,
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, logging: false },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' },
                pagebreak: { mode: ['avoid-all', 'css', 'legacy'] }
            };

            html2pdf().set(opt).from(element).save().then(function () {
                setTimeout(() => { btn.style.display = 'block'; }, 1000);
            });
        });
    }
};
