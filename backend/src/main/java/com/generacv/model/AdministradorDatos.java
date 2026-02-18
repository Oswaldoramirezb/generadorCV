package com.generacv.model;

import jakarta.persistence.*;

/**
 * Tabla: administradordatos
 * Campos: id_admin, id_usuario, nombre_admin
 */
@Entity
@Table(name = "administradordatos")
public class AdministradorDatos {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    @Column(name = "id_admin")
    private Integer idAdmin;

    @Column(name = "id_usuario")
    private Integer idUsuario;

    @Column(name = "nombre_admin", length = 100)
    private String nombreAdmin;

    public AdministradorDatos() {
    }

    public Integer getIdAdmin() {
        return idAdmin;
    }

    public void setIdAdmin(Integer idAdmin) {
        this.idAdmin = idAdmin;
    }

    public Integer getIdUsuario() {
        return idUsuario;
    }

    public void setIdUsuario(Integer idUsuario) {
        this.idUsuario = idUsuario;
    }

    public String getNombreAdmin() {
        return nombreAdmin;
    }

    public void setNombreAdmin(String nombreAdmin) {
        this.nombreAdmin = nombreAdmin;
    }
}
