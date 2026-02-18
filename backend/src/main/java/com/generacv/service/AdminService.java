package com.generacv.service;

import com.generacv.dto.UsuarioResponseDto;
import com.generacv.exception.ForbiddenException;
import com.generacv.exception.NotFoundException;
import com.generacv.model.Usuario;
import com.generacv.repository.UsuarioRepository;
import org.springframework.stereotype.Service;

import java.util.List;
import java.util.stream.Collectors;

/**
 * Servicio para operaciones de administrador.
 * Solo accesible por usuarios con rol_usuario = 1.
 */
@Service
public class AdminService {

    private final UsuarioRepository usuarioRepository;

    public AdminService(UsuarioRepository usuarioRepository) {
        this.usuarioRepository = usuarioRepository;
    }

    /**
     * Lista todos los usuarios (sin contraseñas).
     */
    public List<UsuarioResponseDto> listarUsuarios() {
        return usuarioRepository.findAll().stream()
                .map(u -> new UsuarioResponseDto(u.getIdUsuario(), u.getCorreoUsuario(), u.getRolUsuario()))
                .collect(Collectors.toList());
    }

    /**
     * Cambia el rol de un usuario (1=admin, 2=usuario).
     */
    public UsuarioResponseDto cambiarRol(Integer idUsuario, Integer nuevoRol, Integer idAdmin) {
        if (idUsuario.equals(idAdmin)) {
            throw new ForbiddenException("No puedes cambiar tu propio rol");
        }
        if (nuevoRol != 1 && nuevoRol != 2) {
            throw new RuntimeException("Rol inválido. Debe ser 1 (admin) o 2 (usuario)");
        }

        Usuario usuario = usuarioRepository.findById(idUsuario)
                .orElseThrow(() -> new NotFoundException("Usuario no encontrado"));

        usuario.setRolUsuario(nuevoRol);
        Usuario actualizado = usuarioRepository.save(usuario);

        return new UsuarioResponseDto(
                actualizado.getIdUsuario(),
                actualizado.getCorreoUsuario(),
                actualizado.getRolUsuario());
    }

    /**
     * Elimina un usuario por ID.
     */
    public void eliminarUsuario(Integer idUsuario, Integer idAdmin) {
        if (idUsuario.equals(idAdmin)) {
            throw new ForbiddenException("No puedes eliminar tu propia cuenta");
        }

        Usuario usuario = usuarioRepository.findById(idUsuario)
                .orElseThrow(() -> new NotFoundException("Usuario no encontrado"));

        usuarioRepository.delete(usuario);
    }
}
