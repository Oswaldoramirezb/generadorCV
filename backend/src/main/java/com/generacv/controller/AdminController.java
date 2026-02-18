package com.generacv.controller;

import com.generacv.dto.CvCompletoDto;
import com.generacv.dto.UsuarioResponseDto;
import com.generacv.service.AdminService;
import com.generacv.service.CvService;
import jakarta.servlet.http.HttpSession;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;
import java.util.Map;

/**
 * Controlador REST para operaciones de administrador.
 * Todos los endpoints requieren rol_usuario = 1.
 *
 * GET /api/admin/usuarios → lista todos los usuarios
 * PUT /api/admin/usuarios/{id}/rol → cambia el rol de un usuario
 * DELETE /api/admin/usuarios/{id} → elimina un usuario
 * GET /api/admin/usuarios/{id}/cv → obtiene el CV completo de un usuario
 */
@RestController
@RequestMapping("/api/admin")
public class AdminController {

    private final AdminService adminService;
    private final CvService cvService;

    public AdminController(AdminService adminService, CvService cvService) {
        this.adminService = adminService;
        this.cvService = cvService;
    }

    @GetMapping("/usuarios")
    public ResponseEntity<List<UsuarioResponseDto>> listarUsuarios(HttpSession session) {
        AuthController.requireAdmin(session);
        return ResponseEntity.ok(adminService.listarUsuarios());
    }

    @PutMapping("/usuarios/{id}/rol")
    public ResponseEntity<UsuarioResponseDto> cambiarRol(
            @PathVariable Integer id,
            @RequestBody Map<String, Integer> body,
            HttpSession session) {
        AuthController.requireAdmin(session);
        UsuarioResponseDto admin = AuthController.getSessionUser(session);
        Integer nuevoRol = body.get("rolUsuario");
        if (nuevoRol == null) {
            nuevoRol = body.get("rol_usuario");
        }

        if (nuevoRol == null) {
            throw new RuntimeException("El campo 'rolUsuario' o 'rol_usuario' es requerido");
        }
        return ResponseEntity.ok(adminService.cambiarRol(id, nuevoRol, admin.getIdUsuario()));
    }

    @DeleteMapping("/usuarios/{id}")
    public ResponseEntity<Map<String, String>> eliminarUsuario(
            @PathVariable Integer id,
            HttpSession session) {
        AuthController.requireAdmin(session);
        UsuarioResponseDto admin = AuthController.getSessionUser(session);
        adminService.eliminarUsuario(id, admin.getIdUsuario());
        return ResponseEntity.ok(Map.of("message", "Usuario eliminado correctamente"));
    }

    @GetMapping("/usuarios/{id}/cv")
    public ResponseEntity<CvCompletoDto> getCvUsuario(
            @PathVariable Integer id,
            HttpSession session) {
        AuthController.requireAdmin(session);
        return ResponseEntity.ok(cvService.getCvCompleto(id));
    }
}
