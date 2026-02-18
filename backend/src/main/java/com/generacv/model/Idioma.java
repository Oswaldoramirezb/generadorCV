package com.generacv.model;

import jakarta.persistence.*;

/**
 * Tabla: idiomas
 * Campos: id_idioma, nombre_idioma, nivel_idioma, id_usuario
 */
@Entity
@Table(name = "idiomas")
public class Idioma {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_idioma")
    private Integer idIdioma;

    @Column(name = "nombre_idioma", length = 30)
    private String nombreIdioma;

    @Column(name = "nivel_idioma", length = 50)
    private String nivelIdioma;

    @Column(name = "id_usuario")
    private Integer idUsuario;

    public Idioma() {
    }

    public Integer getIdIdioma() {
        return idIdioma;
    }

    public void setIdIdioma(Integer idIdioma) {
        this.idIdioma = idIdioma;
    }

    public String getNombreIdioma() {
        return nombreIdioma;
    }

    public void setNombreIdioma(String nombreIdioma) {
        this.nombreIdioma = nombreIdioma;
    }

    public String getNivelIdioma() {
        return nivelIdioma;
    }

    public void setNivelIdioma(String nivelIdioma) {
        this.nivelIdioma = nivelIdioma;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }
}
