package com.generacv.controller;

import com.generacv.dto.AuthRequestDto;
import com.generacv.dto.UsuarioResponseDto;
import com.generacv.exception.UnauthorizedException;
import com.generacv.service.AuthService;
import jakarta.servlet.http.HttpSession;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Map;

/**
 * Controlador REST para autenticación.
 * POST /api/auth/login → inicia sesión
 * POST /api/auth/register → registra nuevo usuario
 * POST /api/auth/logout → cierra sesión
 * GET /api/auth/me → devuelve usuario en sesión
 */
@RestController
@RequestMapping("/api/auth")
public class AuthController {

    private static final String SESSION_KEY = "usuario";

    private final AuthService authService;

    public AuthController(AuthService authService) {
        this.authService = authService;
    }

    @PostMapping("/login")
    public ResponseEntity<UsuarioResponseDto> login(
            @RequestBody AuthRequestDto request,
            HttpSession session) {

        UsuarioResponseDto usuario = authService.login(request);
        session.setAttribute(SESSION_KEY, usuario);
        return ResponseEntity.ok(usuario);
    }

    @PostMapping("/register")
    public ResponseEntity<UsuarioResponseDto> register(
            @RequestBody AuthRequestDto request,
            HttpSession session) {

        UsuarioResponseDto usuario = authService.register(request);
        session.setAttribute(SESSION_KEY, usuario);
        return ResponseEntity.ok(usuario);
    }

    @PostMapping("/guest")
    public ResponseEntity<UsuarioResponseDto> guest(HttpSession session) {
        // ID virtual para el invitado
        UsuarioResponseDto guest = new UsuarioResponseDto(-3, "invitado@generacv.com", 3);
        session.setAttribute(SESSION_KEY, guest);
        return ResponseEntity.ok(guest);
    }

    @PostMapping("/logout")
    public ResponseEntity<Map<String, String>> logout(HttpSession session) {
        session.invalidate();
        return ResponseEntity.ok(Map.of("message", "Sesión cerrada correctamente"));
    }

    @GetMapping("/me")
    public ResponseEntity<UsuarioResponseDto> me(HttpSession session) {
        UsuarioResponseDto usuario = (UsuarioResponseDto) session.getAttribute(SESSION_KEY);
        if (usuario == null) {
            throw new UnauthorizedException("No hay sesión activa");
        }
        return ResponseEntity.ok(usuario);
    }

    // ── Método helper estático para obtener el usuario de la sesión ────────────

    public static UsuarioResponseDto getSessionUser(HttpSession session) {
        UsuarioResponseDto usuario = (UsuarioResponseDto) session.getAttribute(SESSION_KEY);
        if (usuario == null) {
            throw new UnauthorizedException("Debes iniciar sesión para continuar");
        }
        return usuario;
    }

    public static void requireAdmin(HttpSession session) {
        UsuarioResponseDto usuario = getSessionUser(session);
        if (usuario.getRolUsuario() != 1) {
            throw new com.generacv.exception.ForbiddenException("Acceso restringido a administradores");
        }
    }
}
