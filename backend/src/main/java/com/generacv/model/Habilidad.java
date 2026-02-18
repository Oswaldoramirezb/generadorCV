package com.generacv.model;

import com.fasterxml.jackson.annotation.JsonProperty;
import jakarta.persistence.*;

/**
 * Tabla: habilidades
 * Campos: id_habilidades, habilidad, id_usuario
 */
@Entity
@Table(name = "habilidades")
public class Habilidad {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_habilidades")
    @JsonProperty("id_habilidades")
    private Integer idHabilidades;

    @Column(name = "habilidad", length = 180)
    private String habilidad;

    @Column(name = "id_usuario")
    @JsonProperty("id_usuario")
    private Integer idUsuario;

    public Habilidad() {
    }

    public Integer getIdHabilidades() {
        return idHabilidades;
    }

    public void setIdHabilidades(Integer idHabilidades) {
        this.idHabilidades = idHabilidades;
    }

    public String getHabilidad() {
        return habilidad;
    }

    public void setHabilidad(String habilidad) {
        this.habilidad = habilidad;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
