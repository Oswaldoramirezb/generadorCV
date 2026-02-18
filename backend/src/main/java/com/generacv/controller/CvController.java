package com.generacv.controller;

import com.generacv.dto.CvCompletoDto;
import com.generacv.dto.UsuarioResponseDto;
import com.generacv.model.*;
import com.generacv.service.CvService;
import jakarta.servlet.http.HttpSession;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;
import java.util.Optional;

/**
 * Controlador REST para todas las secciones del CV.
 * Todos los endpoints requieren sesión activa.
 *
 * GET /api/cv/completo → CV completo del usuario en sesión
 *
 * GET /api/datos-personales → datos personales
 * POST /api/datos-personales → guardar/actualizar datos personales
 * DELETE /api/datos-personales/{id} → eliminar
 *
 * GET /api/educacion → lista de educación
 * POST /api/educacion → agregar
 * PUT /api/educacion/{id} → actualizar
 * DELETE /api/educacion/{id} → eliminar
 *
 * (mismo patrón para experiencia, habilidades, intereses, idiomas, cursos)
 */
@RestController
public class CvController {

    private final CvService cvService;

    public CvController(CvService cvService) {
        this.cvService = cvService;
    }

    private void checkGuest(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        if (usuario.getRolUsuario() == 3) {
            throw new com.generacv.exception.ForbiddenException(
                    "Registro obligatorio: Los invitados no pueden guardar información.");
        }
    }

    // ── CV Completo ────────────────────────────────────────────────────────────

    @GetMapping("/api/cv/completo")
    public ResponseEntity<CvCompletoDto> getCvCompleto(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getCvCompleto(usuario.getIdUsuario()));
    }

    // ── Datos Personales ───────────────────────────────────────────────────────

    @GetMapping("/api/datos-personales")
    public ResponseEntity<Optional<DatosPersonales>> getDatosPersonales(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getDatosPersonales(usuario.getIdUsuario()));
    }

    @PostMapping("/api/datos-personales")
    public ResponseEntity<DatosPersonales> saveDatosPersonales(
            @RequestBody DatosPersonales datos, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveDatosPersonales(datos, usuario.getIdUsuario()));
    }

    @PutMapping("/api/datos-personales/{id}")
    public ResponseEntity<DatosPersonales> updateDatosPersonales(
            @PathVariable Integer id,
            @RequestBody DatosPersonales datos, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        datos.setIdDatos(id);
        return ResponseEntity.ok(cvService.saveDatosPersonales(datos, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/datos-personales/{id}")
    public ResponseEntity<Map<String, String>> deleteDatosPersonales(
            @PathVariable Integer id, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteDatosPersonales(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Datos personales eliminados"));
    }

    // ── Educación ──────────────────────────────────────────────────────────────

    @GetMapping("/api/educacion")
    public ResponseEntity<List<Educacion>> getEducacion(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getEducacion(usuario.getIdUsuario()));
    }

    @PostMapping("/api/educacion")
    public ResponseEntity<Educacion> saveEducacion(
            @RequestBody Educacion educacion, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveEducacion(educacion, usuario.getIdUsuario()));
    }

    @PutMapping("/api/educacion/{id}")
    public ResponseEntity<Educacion> updateEducacion(
            @PathVariable Integer id,
            @RequestBody Educacion educacion, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateEducacion(id, educacion, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/educacion/{id}")
    public ResponseEntity<Map<String, String>> deleteEducacion(
            @PathVariable Integer id, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteEducacion(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Educación eliminada"));
    }

    // ── Experiencia ────────────────────────────────────────────────────────────

    @GetMapping("/api/experiencia")
    public ResponseEntity<List<Experiencia>> getExperiencia(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getExperiencia(usuario.getIdUsuario()));
    }

    @PostMapping("/api/experiencia")
    public ResponseEntity<Experiencia> saveExperiencia(
            @RequestBody Experiencia experiencia, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveExperiencia(experiencia, usuario.getIdUsuario()));
    }

    @PutMapping("/api/experiencia/{id}")
    public ResponseEntity<Experiencia> updateExperiencia(
            @PathVariable Integer id,
            @RequestBody Experiencia experiencia, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateExperiencia(id, experiencia, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/experiencia/{id}")
    public ResponseEntity<Map<String, String>> deleteExperiencia(
            @PathVariable Integer id, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteExperiencia(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Experiencia eliminada"));
    }

    // ── Habilidades ────────────────────────────────────────────────────────────

    @GetMapping("/api/habilidades")
    public ResponseEntity<List<Habilidad>> getHabilidades(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getHabilidades(usuario.getIdUsuario()));
    }

    @PostMapping("/api/habilidades")
    public ResponseEntity<Habilidad> saveHabilidad(
            @RequestBody Habilidad habilidad, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveHabilidad(habilidad, usuario.getIdUsuario()));
    }

    @PutMapping("/api/habilidades/{id}")
    public ResponseEntity<Habilidad> updateHabilidad(
            @PathVariable Integer id,
            @RequestBody Habilidad habilidad, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateHabilidad(id, habilidad, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/habilidades/{id}")
    public ResponseEntity<Map<String, String>> deleteHabilidad(
            @PathVariable Integer id, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteHabilidad(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Habilidad eliminada"));
    }

    // ── Intereses Personales ───────────────────────────────────────────────────

    @GetMapping("/api/intereses")
    public ResponseEntity<List<InteresPersonal>> getIntereses(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getIntereses(usuario.getIdUsuario()));
    }

    @PostMapping("/api/intereses")
    public ResponseEntity<InteresPersonal> saveInteres(
            @RequestBody InteresPersonal interes, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveInteres(interes, usuario.getIdUsuario()));
    }

    @PutMapping("/api/intereses/{id}")
    public ResponseEntity<InteresPersonal> updateInteres(
            @PathVariable Integer id,
            @RequestBody InteresPersonal interes, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateInteres(id, interes, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/intereses/{id}")
    public ResponseEntity<Map<String, String>> deleteInteres(
            @PathVariable Integer id, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteInteres(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Interés eliminado"));
    }

    // ── Idiomas ────────────────────────────────────────────────────────────────

    @GetMapping("/api/idiomas")
    public ResponseEntity<List<Idioma>> getIdiomas(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getIdiomas(usuario.getIdUsuario()));
    }

    @PostMapping("/api/idiomas")
    public ResponseEntity<Idioma> saveIdioma(
            @RequestBody Idioma idioma, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveIdioma(idioma, usuario.getIdUsuario()));
    }

    @PutMapping("/api/idiomas/{id}")
    public ResponseEntity<Idioma> updateIdioma(
            @PathVariable Integer id,
            @RequestBody Idioma idioma, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateIdioma(id, idioma, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/idiomas/{id}")
    public ResponseEntity<Map<String, String>> deleteIdioma(
            @PathVariable Integer id, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteIdioma(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Idioma eliminado"));
    }

    // ── Cursos ─────────────────────────────────────────────────────────────────

    @GetMapping("/api/cursos")
    public ResponseEntity<List<Curso>> getCursos(HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.getCursos(usuario.getIdUsuario()));
    }

    @PostMapping("/api/cursos")
    public ResponseEntity<Curso> saveCurso(
            @RequestBody Curso curso, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.saveCurso(curso, usuario.getIdUsuario()));
    }

    @PutMapping("/api/cursos/{id}")
    public ResponseEntity<Curso> updateCurso(
            @PathVariable Integer id,
            @RequestBody Curso curso, HttpSession session) {
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        return ResponseEntity.ok(cvService.updateCurso(id, curso, usuario.getIdUsuario()));
    }

    @DeleteMapping("/api/cursos/{id}")
    public ResponseEntity<Map<String, String>> deleteCurso(
            @PathVariable Integer id, HttpSession session) {
        checkGuest(session);
        UsuarioResponseDto usuario = AuthController.getSessionUser(session);
        cvService.deleteCurso(id, usuario.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Curso eliminado"));
    }
}
