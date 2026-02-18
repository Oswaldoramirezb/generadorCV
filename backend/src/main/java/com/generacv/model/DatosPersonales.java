package com.generacv.model;

import jakarta.persistence.*;

/**
 * Tabla: datospersonales
 * Campos: id_datos, nombre_datos, licenciatura_datos, matricula_datos,
 * ciudad_datos, telefono_datos, correo_datos, porcentaje_creditos, id_usuario
 */
@Entity
@Table(name = "datospersonales")
public class DatosPersonales {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_datos")
    private Integer idDatos;

    @Column(name = "nombre_datos", length = 100)
    private String nombreDatos;

    @Column(name = "licenciatura_datos", length = 70)
    private String licenciaturaDatos;

    @Column(name = "matricula_datos", length = 10)
    private String matriculaDatos;

    @Column(name = "ciudad_datos", length = 40)
    private String ciudadDatos;

    @Column(name = "telefono_datos", length = 15)
    private String telefonoDatos;

    @Column(name = "correo_datos", length = 70)
    private String correoDatos;

    @Column(name = "porcentaje_creditos", length = 6)
    private String porcentajeCreditos;

    @Column(name = "id_usuario")
    private Integer idUsuario;

    // ── Constructores ──────────────────────────────────────────────────────────

    public DatosPersonales() {
    }

    // ── Getters y Setters ──────────────────────────────────────────────────────

    public Integer getIdDatos() {
        return idDatos;
    }

    public void setIdDatos(Integer idDatos) {
        this.idDatos = idDatos;
    }

    public String getNombreDatos() {
        return nombreDatos;
    }

    public void setNombreDatos(String nombreDatos) {
        this.nombreDatos = nombreDatos;
    }

    public String getLicenciaturaDatos() {
        return licenciaturaDatos;
    }

    public void setLicenciaturaDatos(String licenciaturaDatos) {
        this.licenciaturaDatos = licenciaturaDatos;
    }

    public String getMatriculaDatos() {
        return matriculaDatos;
    }

    public void setMatriculaDatos(String matriculaDatos) {
        this.matriculaDatos = matriculaDatos;
    }

    public String getCiudadDatos() {
        return ciudadDatos;
    }

    public void setCiudadDatos(String ciudadDatos) {
        this.ciudadDatos = ciudadDatos;
    }

    public String getTelefonoDatos() {
        return telefonoDatos;
    }

    public void setTelefonoDatos(String telefonoDatos) {
        this.telefonoDatos = telefonoDatos;
    }

    public String getCorreoDatos() {
        return correoDatos;
    }

    public void setCorreoDatos(String correoDatos) {
        this.correoDatos = correoDatos;
    }

    public String getPorcentajeCreditos() {
        return porcentajeCreditos;
    }

    public void setPorcentajeCreditos(String porcentajeCreditos) {
        this.porcentajeCreditos = porcentajeCreditos;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
