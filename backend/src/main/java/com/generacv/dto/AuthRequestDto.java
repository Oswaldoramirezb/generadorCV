package com.generacv.dto;

/**
 * DTO para login y registro.
 */
public class AuthRequestDto {
    private String correoUsuario;
    private String contrasenaUsuario;

    public AuthRequestDto() {
    }

    public String getCorreoUsuario() {
        return correoUsuario;
    }

    public void setCorreoUsuario(String correoUsuario) {
        this.correoUsuario = correoUsuario;
    }

    public String getContrasenaUsuario() {
        return contrasenaUsuario;
    }

    public void setContrasenaUsuario(String contrasenaUsuario) {
        this.contrasenaUsuario = contrasenaUsuario;
    }
}
