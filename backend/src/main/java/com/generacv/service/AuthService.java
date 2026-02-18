package com.generacv.service;

import com.generacv.dto.AuthRequestDto;
import com.generacv.dto.UsuarioResponseDto;
import com.generacv.exception.UnauthorizedException;
import com.generacv.model.Usuario;
import com.generacv.repository.UsuarioRepository;
import org.springframework.stereotype.Service;

/**
 * Servicio de autenticación.
 * Maneja login, registro y logout usando sesiones HTTP.
 * La contraseña se almacena en texto plano (igual que el PHP original).
 */
@Service
public class AuthService {

    private final UsuarioRepository usuarioRepository;

    public AuthService(UsuarioRepository usuarioRepository) {
        this.usuarioRepository = usuarioRepository;
    }

    /**
     * Autentica al usuario con correo y contraseña.
     * 
     * @return UsuarioResponseDto con id, correo y rol (sin contraseña)
     */
    public UsuarioResponseDto login(AuthRequestDto request) {
        if (request.getCorreoUsuario() == null || request.getCorreoUsuario().isBlank()) {
            throw new UnauthorizedException("El correo es requerido");
        }
        if (request.getContrasenaUsuario() == null || request.getContrasenaUsuario().isBlank()) {
            throw new UnauthorizedException("La contraseña es requerida");
        }

        Usuario usuario = usuarioRepository
                .findByCorreoUsuario(request.getCorreoUsuario().trim())
                .orElseThrow(() -> new UnauthorizedException("Usuario o contraseña incorrectos"));

        // Comparación directa (texto plano, igual que el PHP original)
        if (!usuario.getContrasenaUsuario().equals(request.getContrasenaUsuario())) {
            throw new UnauthorizedException("Usuario o contraseña incorrectos");
        }

        return new UsuarioResponseDto(
                usuario.getIdUsuario(),
                usuario.getCorreoUsuario(),
                usuario.getRolUsuario());
    }

    /**
     * Registra un nuevo usuario con rol 2 (usuario normal).
     */
    public UsuarioResponseDto register(AuthRequestDto request) {
        if (request.getCorreoUsuario() == null || request.getCorreoUsuario().isBlank()) {
            throw new RuntimeException("El correo es requerido");
        }
        if (request.getContrasenaUsuario() == null || request.getContrasenaUsuario().isBlank()) {
            throw new RuntimeException("La contraseña es requerida");
        }
        if (request.getContrasenaUsuario().length() < 6) {
            throw new RuntimeException("La contraseña debe tener al menos 6 caracteres");
        }

        String correo = request.getCorreoUsuario().trim().toLowerCase();

        if (usuarioRepository.existsByCorreoUsuario(correo)) {
            throw new RuntimeException("Ya existe una cuenta con ese correo electrónico");
        }

        Usuario nuevo = new Usuario(correo, request.getContrasenaUsuario(), 2);
        Usuario guardado = usuarioRepository.save(nuevo);

        return new UsuarioResponseDto(
                guardado.getIdUsuario(),
                guardado.getCorreoUsuario(),
                guardado.getRolUsuario());
    }
}
