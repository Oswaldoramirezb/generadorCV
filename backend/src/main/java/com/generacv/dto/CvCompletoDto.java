package com.generacv.dto;

import java.util.List;

/**
 * DTO que agrupa todo el CV de un usuario para las plantillas.
 */
public class CvCompletoDto {
    private Object datosPersonales;
    private List<?> educacion;
    private List<?> experiencia;
    private List<?> habilidades;
    private List<?> intereses;
    private List<?> idiomas;
    private List<?> cursos;

    public CvCompletoDto() {
    }

    public Object getDatosPersonales() {
        return datosPersonales;
    }

    public void setDatosPersonales(Object datosPersonales) {
        this.datosPersonales = datosPersonales;
    }

    public List<?> getEducacion() {
        return educacion;
    }

    public void setEducacion(List<?> educacion) {
        this.educacion = educacion;
    }

    public List<?> getExperiencia() {
        return experiencia;
    }

    public void setExperiencia(List<?> experiencia) {
        this.experiencia = experiencia;
    }

    public List<?> getHabilidades() {
        return habilidades;
    }

    public void setHabilidades(List<?> habilidades) {
        this.habilidades = habilidades;
    }

    public List<?> getIntereses() {
        return intereses;
    }

    public void setIntereses(List<?> intereses) {
        this.intereses = intereses;
    }

    public List<?> getIdiomas() {
        return idiomas;
    }

    public void setIdiomas(List<?> idiomas) {
        this.idiomas = idiomas;
    }

    public List<?> getCursos() {
        return cursos;
    }

    public void setCursos(List<?> cursos) {
        this.cursos = cursos;
    }
}
