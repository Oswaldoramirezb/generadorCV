# GeneraCV — Backend Spring Boot

API REST para el generador de CVs de la UAM Azcapotzalco.

## Requisitos

- Java 17+
- Maven 3.8+ (o usar el wrapper `mvnw`)
- MySQL 8.0+ con la base de datos `registro` importada

## Configuración

1. Importar `registro.sql` en MySQL:
   ```sql
   mysql -u root -p < registro.sql
   ```

2. Editar `src/main/resources/application.properties`:
   ```properties
   spring.datasource.username=root
   spring.datasource.password=TU_CONTRASEÑA
   ```

## Ejecutar

```bash
# Con Maven instalado:
mvn spring-boot:run

# Con el wrapper (no requiere Maven instalado):
./mvnw spring-boot:run       # Linux/Mac
mvnw.cmd spring-boot:run     # Windows
```

El servidor arranca en `http://localhost:8080`

## Endpoints REST

### Autenticación
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| POST | `/api/auth/login` | Iniciar sesión |
| POST | `/api/auth/register` | Registrarse |
| POST | `/api/auth/logout` | Cerrar sesión |
| GET | `/api/auth/me` | Usuario en sesión |

### CV (requieren sesión)
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/cv/completo` | CV completo del usuario |
| GET/POST/PUT/DELETE | `/api/datos-personales` | Datos personales |
| GET/POST/PUT/DELETE | `/api/educacion` | Educación |
| GET/POST/PUT/DELETE | `/api/experiencia` | Experiencia |
| GET/POST/PUT/DELETE | `/api/habilidades` | Habilidades |
| GET/POST/PUT/DELETE | `/api/intereses` | Intereses personales |
| GET/POST/PUT/DELETE | `/api/idiomas` | Idiomas |
| GET/POST/PUT/DELETE | `/api/cursos` | Cursos |

### Admin (requieren rol = 1)
| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/admin/usuarios` | Listar usuarios |
| PUT | `/api/admin/usuarios/{id}/rol` | Cambiar rol |
| DELETE | `/api/admin/usuarios/{id}` | Eliminar usuario |
| GET | `/api/admin/usuarios/{id}/cv` | Ver CV de usuario |

## Estructura del proyecto

```
backend/
├── pom.xml
└── src/main/java/com/generacv/
    ├── GeneraCvApplication.java
    ├── config/
    │   └── CorsConfig.java
    ├── controller/
    │   ├── AuthController.java
    │   ├── CvController.java
    │   └── AdminController.java
    ├── service/
    │   ├── AuthService.java
    │   ├── CvService.java
    │   └── AdminService.java
    ├── repository/
    │   ├── UsuarioRepository.java
    │   ├── DatosPersonalesRepository.java
    │   ├── EducacionRepository.java
    │   ├── ExperienciaRepository.java
    │   ├── HabilidadRepository.java
    │   ├── IdiomaRepository.java
    │   ├── InteresPersonalRepository.java
    │   └── CursoRepository.java
    ├── model/
    │   ├── Usuario.java
    │   ├── DatosPersonales.java
    │   ├── Educacion.java
    │   ├── Experiencia.java
    │   ├── Habilidad.java
    │   ├── Idioma.java
    │   ├── InteresPersonal.java
    │   ├── Curso.java
    │   └── AdministradorDatos.java
    ├── dto/
    │   ├── AuthRequestDto.java
    │   ├── UsuarioResponseDto.java
    │   └── CvCompletoDto.java
    └── exception/
        ├── GlobalExceptionHandler.java
        ├── UnauthorizedException.java
        ├── NotFoundException.java
        └── ForbiddenException.java
```

## Notas

- Las contraseñas se almacenan en texto plano (igual que el PHP original).
- La autenticación usa sesiones HTTP (no JWT).
- CORS configurado para `localhost:5500` (Live Server) y `localhost:80` (XAMPP).
