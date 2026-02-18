package com.generacv.model;

import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;

/**
 * Tabla: experiencial (nota: el nombre de la tabla en la BD es "experiencial")
 * Campos: id_experiencia, nombre_empresa, puesto_empresa,
 * mes_inicio_empresa, anio_inicio_empresa,
 * mes_finalizacion_empresa, anio_finalizacion_empresa,
 * descripcion_empresa, id_usuario
 */
@Entity
@Table(name = "experiencial")
public class Experiencia {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_experiencia")
    @JsonProperty("id_experiencia")
    private Integer idExperiencia;

    @Column(name = "nombre_empresa", length = 100)
    @JsonProperty("nombre_empresa")
    private String nombreEmpresa;

    @Column(name = "puesto_empresa", length = 100)
    @JsonProperty("puesto_empresa")
    private String puestoEmpresa;

    @Column(name = "mes_inicio_empresa", length = 12)
    @JsonProperty("mes_inicio_empresa")
    private String mesInicioEmpresa;

    @Column(name = "anio_inicio_empresa", length = 5)
    @JsonProperty("anio_inicio_empresa")
    private String anioInicioEmpresa;

    @Column(name = "mes_finalizacion_empresa", length = 17)
    @JsonProperty("mes_finalizacion_empresa")
    private String mesFinalizacionEmpresa;

    @Column(name = "anio_finalizacion_empresa", length = 5)
    @JsonProperty("anio_finalizacion_empresa")
    private String anioFinalizacionEmpresa;

    @Column(name = "descripcion_empresa", length = 1000)
    @JsonProperty("descripcion_empresa")
    private String descripcionEmpresa;

    @Column(name = "id_usuario")
    @JsonProperty("id_usuario")
    private Integer idUsuario;

    // ── Constructores ──────────────────────────────────────────────────────────

    public Experiencia() {
    }

    // ── Getters y Setters ──────────────────────────────────────────────────────

    public Integer getIdExperiencia() {
        return idExperiencia;
    }

    public void setIdExperiencia(Integer idExperiencia) {
        this.idExperiencia = idExperiencia;
    }

    public String getNombreEmpresa() {
        return nombreEmpresa;
    }

    public void setNombreEmpresa(String nombreEmpresa) {
        this.nombreEmpresa = nombreEmpresa;
    }

    public String getPuestoEmpresa() {
        return puestoEmpresa;
    }

    public void setPuestoEmpresa(String puestoEmpresa) {
        this.puestoEmpresa = puestoEmpresa;
    }

    public String getMesInicioEmpresa() {
        return mesInicioEmpresa;
    }

    public void setMesInicioEmpresa(String mesInicioEmpresa) {
        this.mesInicioEmpresa = mesInicioEmpresa;
    }

    public String getAnioInicioEmpresa() {
        return anioInicioEmpresa;
    }

    public void setAnioInicioEmpresa(String anioInicioEmpresa) {
        this.anioInicioEmpresa = anioInicioEmpresa;
    }

    public String getMesFinalizacionEmpresa() {
        return mesFinalizacionEmpresa;
    }

    public void setMesFinalizacionEmpresa(String mesFinalizacionEmpresa) {
        this.mesFinalizacionEmpresa = mesFinalizacionEmpresa;
    }

    public String getAnioFinalizacionEmpresa() {
        return anioFinalizacionEmpresa;
    }

    public void setAnioFinalizacionEmpresa(String anioFinalizacionEmpresa) {
        this.anioFinalizacionEmpresa = anioFinalizacionEmpresa;
    }

    public String getDescripcionEmpresa() {
        return descripcionEmpresa;
    }

    public void setDescripcionEmpresa(String descripcionEmpresa) {
        this.descripcionEmpresa = descripcionEmpresa;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
