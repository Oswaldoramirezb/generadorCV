package com.generacv.dto;

/**
 * DTO para la respuesta de login/sesión.
 * Devuelve solo los datos necesarios al frontend (sin contraseña).
 */
public class UsuarioResponseDto {
    private Integer idUsuario;
    private String correoUsuario;
    private Integer rolUsuario;

    public UsuarioResponseDto() {
    }

    public UsuarioResponseDto(Integer idUsuario, String correoUsuario, Integer rolUsuario) {
        this.idUsuario = idUsuario;
        this.correoUsuario = correoUsuario;
        this.rolUsuario = rolUsuario;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }

    public String getCorreoUsuario() {
        return correoUsuario;
    }

    public void setCorreoUsuario(String correoUsuario) {
        this.correoUsuario = correoUsuario;
    }

    public Integer getRolUsuario() {
        return rolUsuario;
    }

    public void setRolUsuario(Integer rolUsuario) {
        this.rolUsuario = rolUsuario;
    }
}
