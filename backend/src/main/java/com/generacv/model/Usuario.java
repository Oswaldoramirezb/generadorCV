package com.generacv.model;

import jakarta.persistence.*;

/**
 * Tabla: usuarios
 * Campos: id_usuario, correo_usuario, contrasena_usuario, rol_usuario
 * rol_usuario: 1 = Administrador, 2 = Usuario normal
 */
@Entity
@Table(name = "usuarios")
public class Usuario {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_usuario")
    private Integer idUsuario;

    @Column(name = "correo_usuario", unique = true, length = 50)
    private String correoUsuario;

    @Column(name = "contrasena_usuario", length = 30)
    private String contrasenaUsuario;

    @Column(name = "rol_usuario")
    private Integer rolUsuario;

    // ── Constructores ──────────────────────────────────────────────────────────

    public Usuario() {
    }

    public Usuario(String correoUsuario, String contrasenaUsuario, Integer rolUsuario) {
        this.correoUsuario = correoUsuario;
        this.contrasenaUsuario = contrasenaUsuario;
        this.rolUsuario = rolUsuario;
    }

    // ── Getters y Setters ──────────────────────────────────────────────────────

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

    public String getContrasenaUsuario() {
        return contrasenaUsuario;
    }

    public void setContrasenaUsuario(String contrasenaUsuario) {
        this.contrasenaUsuario = contrasenaUsuario;
    }

    public Integer getRolUsuario() {
        return rolUsuario;
    }

    public void setRolUsuario(Integer rolUsuario) {
        this.rolUsuario = rolUsuario;
    }
}
