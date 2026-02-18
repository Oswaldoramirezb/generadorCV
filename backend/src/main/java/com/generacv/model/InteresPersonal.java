package com.generacv.model;

import jakarta.persistence.*;

/**
 * Tabla: interesespersonales
 * Campos: id_interes, interes, id_usuario
 */
@Entity
@Table(name = "interesespersonales")
public class InteresPersonal {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_interes")
    private Integer idInteres;

    @Column(name = "interes", length = 180)
    private String interes;

    @Column(name = "id_usuario")
    private Integer idUsuario;

    public InteresPersonal() {
    }

    public Integer getIdInteres() {
        return idInteres;
    }

    public void setIdInteres(Integer idInteres) {
        this.idInteres = idInteres;
    }

    public String getInteres() {
        return interes;
    }

    public void setInteres(String interes) {
        this.interes = interes;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
