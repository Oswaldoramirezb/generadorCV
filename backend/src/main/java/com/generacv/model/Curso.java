package com.generacv.model;

import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;

/**
 * Tabla: cursos
 * Campos: id_curso, nombre_curso, institucion_curso, duracion_curso,
 * mes_finalizacion_curso, anio_finalizacion_curso, id_usuario
 */
@Entity
@Table(name = "cursos")
public class Curso {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_curso")
    @JsonProperty("id_curso")
    private Integer idCurso;

    @Column(name = "nombre_curso", length = 120)
    @JsonProperty("nombre_curso")
    private String nombreCurso;

    @Column(name = "institucion_curso", length = 100)
    @JsonProperty("institucion_curso")
    private String institucionCurso;

    @Column(name = "duracion_curso", length = 20)
    @JsonProperty("duracion_curso")
    private String duracionCurso;

    @Column(name = "mes_finalizacion_curso", length = 12)
    @JsonProperty("mes_finalizacion_curso")
    private String mesFinalizacionCurso;

    @Column(name = "anio_finalizacion_curso", length = 5)
    @JsonProperty("anio_finalizacion_curso")
    private String anioFinalizacionCurso;

    @Column(name = "id_usuario")
    @JsonProperty("id_usuario")
    private Integer idUsuario;

    public Curso() {
    }

    public Integer getIdCurso() {
        return idCurso;
    }

    public void setIdCurso(Integer idCurso) {
        this.idCurso = idCurso;
    }

    public String getNombreCurso() {
        return nombreCurso;
    }

    public void setNombreCurso(String nombreCurso) {
        this.nombreCurso = nombreCurso;
    }

    public String getInstitucionCurso() {
        return institucionCurso;
    }

    public void setInstitucionCurso(String institucionCurso) {
        this.institucionCurso = institucionCurso;
    }

    public String getDuracionCurso() {
        return duracionCurso;
    }

    public void setDuracionCurso(String duracionCurso) {
        this.duracionCurso = duracionCurso;
    }

    public String getMesFinalizacionCurso() {
        return mesFinalizacionCurso;
    }

    public void setMesFinalizacionCurso(String mesFinalizacionCurso) {
        this.mesFinalizacionCurso = mesFinalizacionCurso;
    }

    public String getAnioFinalizacionCurso() {
        return anioFinalizacionCurso;
    }

    public void setAnioFinalizacionCurso(String anioFinalizacionCurso) {
        this.anioFinalizacionCurso = anioFinalizacionCurso;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
