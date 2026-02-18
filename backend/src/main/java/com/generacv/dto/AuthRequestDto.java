package com.generacv.dto;

import com.fasterxml.jackson.annotation.JsonAlias;

/**
 * DTO para login y registro.
 * El frontend envía { correo, contrasena }.
 * 
 * @JsonAlias permite aceptar también correoUsuario/contrasenaUsuario por
 *            compatibilidad.
 */
public class AuthRequestDto {

    @JsonAlias({ "correoUsuario", "correo" })
    private String correo;

    @JsonAlias({ "contrasenaUsuario", "contrasena" })
    private String contrasena;

    public AuthRequestDto() {
    }

    public String getCorreoUsuario() {
        return correo;
    }

    public void setCorreoUsuario(String correo) {
        this.correo = correo;
    }

    public String getContrasenaUsuario() {
        return contrasena;
    }

    public void setContrasenaUsuario(String contrasena) {
        this.contrasena = contrasena;
    }

    // Setters para @JsonAlias
    public void setCorreo(String correo) {
        this.correo = correo;
    }

    public void setContrasena(String contrasena) {
        this.contrasena = contrasena;
    }
}
