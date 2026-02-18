package com.generacv.dto;

import com.fasterxml.jackson.annotation.JsonProperty;

/**
 * DTO para la respuesta de login/sesión.
 * Usa snake_case para que el frontend JS pueda leer data.id_usuario,
 * data.rol_usuario, etc.
 * Se anotan getters para asegurar que Jackson use estos nombres en la
 * serialización.
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

    @JsonProperty("id_usuario")
    public Integer getIdUsuario() {
        return idUsuario;
    }

    @JsonProperty("id_usuario")
    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }

    @JsonProperty("correo_usuario")
    public String getCorreoUsuario() {
        return correoUsuario;
    }

    @JsonProperty("correo_usuario")
    public void setCorreoUsuario(String correoUsuario) {
        this.correoUsuario = correoUsuario;
    }

    @JsonProperty("rol_usuario")
    public Integer getRolUsuario() {
        return rolUsuario;
    }

    @JsonProperty("rol_usuario")
    public void setRolUsuario(Integer rolUsuario) {
        this.rolUsuario = rolUsuario;
    }
}
