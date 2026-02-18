package com.generacv.model;

import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;

/**
 * Tabla: educacion
 * Campos: id_educacion, nombre_institucion, nivel_institucion,
 * especialidad_institucion,
 * mes_inicio_institucion, anio_inicio_institucion,
 * mes_finalizacion_institucion, anio_finalizacion_institucion, id_usuario
 */
@Entity
@Table(name = "educacion")
public class Educacion {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_educacion")
    @JsonProperty("id_educacion")
    private Integer idEducacion;

    @Column(name = "nombre_institucion", length = 100)
    @JsonProperty("nombre_institucion")
    private String nombreInstitucion;

    @Column(name = "nivel_institucion", length = 50)
    @JsonProperty("nivel_institucion")
    private String nivelInstitucion;

    @Column(name = "especialidad_institucion", length = 100)
    @JsonProperty("especialidad_institucion")
    private String especialidadInstitucion;

    @Column(name = "mes_inicio_institucion", length = 12)
    @JsonProperty("mes_inicio_institucion")
    private String mesInicioInstitucion;

    @Column(name = "anio_inicio_institucion", length = 5)
    @JsonProperty("anio_inicio_institucion")
    private String anioInicioInstitucion;

    @Column(name = "mes_finalizacion_institucion", length = 17)
    @JsonProperty("mes_finalizacion_institucion")
    private String mesFinalizacionInstitucion;

    @Column(name = "anio_finalizacion_institucion", length = 5)
    @JsonProperty("anio_finalizacion_institucion")
    private String anioFinalizacionInstitucion;

    @Column(name = "id_usuario")
    @JsonProperty("id_usuario")
    private Integer idUsuario;

    // ── Constructores ──────────────────────────────────────────────────────────

    public Educacion() {
    }

    // ── Getters y Setters ──────────────────────────────────────────────────────

    public Integer getIdEducacion() {
        return idEducacion;
    }

    public void setIdEducacion(Integer idEducacion) {
        this.idEducacion = idEducacion;
    }

    public String getNombreInstitucion() {
        return nombreInstitucion;
    }

    public void setNombreInstitucion(String nombreInstitucion) {
        this.nombreInstitucion = nombreInstitucion;
    }

    public String getNivelInstitucion() {
        return nivelInstitucion;
    }

    public void setNivelInstitucion(String nivelInstitucion) {
        this.nivelInstitucion = nivelInstitucion;
    }

    public String getEspecialidadInstitucion() {
        return especialidadInstitucion;
    }

    public void setEspecialidadInstitucion(String especialidadInstitucion) {
        this.especialidadInstitucion = especialidadInstitucion;
    }

    public String getMesInicioInstitucion() {
        return mesInicioInstitucion;
    }

    public void setMesInicioInstitucion(String mesInicioInstitucion) {
        this.mesInicioInstitucion = mesInicioInstitucion;
    }

    public String getAnioInicioInstitucion() {
        return anioInicioInstitucion;
    }

    public void setAnioInicioInstitucion(String anioInicioInstitucion) {
        this.anioInicioInstitucion = anioInicioInstitucion;
    }

    public String getMesFinalizacionInstitucion() {
        return mesFinalizacionInstitucion;
    }

    public void setMesFinalizacionInstitucion(String mesFinalizacionInstitucion) {
        this.mesFinalizacionInstitucion = mesFinalizacionInstitucion;
    }

    public String getAnioFinalizacionInstitucion() {
        return anioFinalizacionInstitucion;
    }

    public void setAnioFinalizacionInstitucion(String anioFinalizacionInstitucion) {
        this.anioFinalizacionInstitucion = anioFinalizacionInstitucion;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
