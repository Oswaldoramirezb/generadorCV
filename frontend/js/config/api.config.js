/**
 * Configuración global de la API
 * Cambia BASE_URL cuando el backend Spring Boot esté corriendo
 */
const API_CONFIG = {
    BASE_URL: 'http://localhost:8080/api',
    TIMEOUT: 10000,
    HEADERS: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    }
};
