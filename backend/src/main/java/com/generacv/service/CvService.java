package com.generacv.service;

import com.generacv.dto.CvCompletoDto;
import com.generacv.exception.ForbiddenException;
import com.generacv.exception.NotFoundException;
import com.generacv.model.*;
import com.generacv.repository.*;
import org.springframework.stereotype.Service;
import org.springframework.transaction.annotation.Transactional;

import java.util.List;
import java.util.Optional;

/**
 * Servicio para todas las operaciones CRUD del CV.
 * Cada método verifica que el recurso pertenezca al usuario en sesión.
 */
@Service
public class CvService {

    private final DatosPersonalesRepository datosPersonalesRepo;
    private final EducacionRepository educacionRepo;
    private final ExperienciaRepository experienciaRepo;
    private final HabilidadRepository habilidadRepo;
    private final InteresPersonalRepository interesRepo;
    private final IdiomaRepository idiomaRepo;
    private final CursoRepository cursoRepo;

    public CvService(DatosPersonalesRepository datosPersonalesRepo,
            EducacionRepository educacionRepo,
            ExperienciaRepository experienciaRepo,
            HabilidadRepository habilidadRepo,
            InteresPersonalRepository interesRepo,
            IdiomaRepository idiomaRepo,
            CursoRepository cursoRepo) {
        this.datosPersonalesRepo = datosPersonalesRepo;
        this.educacionRepo = educacionRepo;
        this.experienciaRepo = experienciaRepo;
        this.habilidadRepo = habilidadRepo;
        this.interesRepo = interesRepo;
        this.idiomaRepo = idiomaRepo;
        this.cursoRepo = cursoRepo;
    }

    // ── CV Completo ────────────────────────────────────────────────────────────

    public CvCompletoDto getCvCompleto(Integer idUsuario) {
        CvCompletoDto cv = new CvCompletoDto();
        cv.setDatosPersonales(datosPersonalesRepo.findByIdUsuario(idUsuario).orElse(null));
        cv.setEducacion(educacionRepo.findByIdUsuario(idUsuario));
        cv.setExperiencia(experienciaRepo.findByIdUsuario(idUsuario));
        cv.setHabilidades(habilidadRepo.findByIdUsuario(idUsuario));
        cv.setIntereses(interesRepo.findByIdUsuario(idUsuario));
        cv.setIdiomas(idiomaRepo.findByIdUsuario(idUsuario));
        cv.setCursos(cursoRepo.findByIdUsuario(idUsuario));
        return cv;
    }

    // ── Datos Personales ───────────────────────────────────────────────────────

    public Optional<DatosPersonales> getDatosPersonales(Integer idUsuario) {
        return datosPersonalesRepo.findByIdUsuario(idUsuario);
    }

    public DatosPersonales saveDatosPersonales(DatosPersonales datos, Integer idUsuario) {
        datos.setIdUsuario(idUsuario);
        // Si ya existe, actualizar; si no, crear
        Optional<DatosPersonales> existing = datosPersonalesRepo.findByIdUsuario(idUsuario);
        if (existing.isPresent()) {
            datos.setIdDatos(existing.get().getIdDatos());
        }
        return datosPersonalesRepo.save(datos);
    }

    @Transactional
    public void deleteDatosPersonales(Integer id, Integer idUsuario) {
        DatosPersonales datos = datosPersonalesRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Datos personales no encontrados"));
        if (!datos.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        datosPersonalesRepo.delete(datos);
    }

    // ── Educación ──────────────────────────────────────────────────────────────

    public List<Educacion> getEducacion(Integer idUsuario) {
        return educacionRepo.findByIdUsuario(idUsuario);
    }

    public Educacion saveEducacion(Educacion educacion, Integer idUsuario) {
        educacion.setIdUsuario(idUsuario);
        return educacionRepo.save(educacion);
    }

    public Educacion updateEducacion(Integer id, Educacion educacion, Integer idUsuario) {
        Educacion existing = educacionRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Educación no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        educacion.setIdEducacion(id);
        educacion.setIdUsuario(idUsuario);
        return educacionRepo.save(educacion);
    }

    @Transactional
    public void deleteEducacion(Integer id, Integer idUsuario) {
        Educacion existing = educacionRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Educación no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        educacionRepo.delete(existing);
    }

    // ── Experiencia ────────────────────────────────────────────────────────────

    public List<Experiencia> getExperiencia(Integer idUsuario) {
        return experienciaRepo.findByIdUsuario(idUsuario);
    }

    public Experiencia saveExperiencia(Experiencia experiencia, Integer idUsuario) {
        experiencia.setIdUsuario(idUsuario);
        return experienciaRepo.save(experiencia);
    }

    public Experiencia updateExperiencia(Integer id, Experiencia experiencia, Integer idUsuario) {
        Experiencia existing = experienciaRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Experiencia no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        experiencia.setIdExperiencia(id);
        experiencia.setIdUsuario(idUsuario);
        return experienciaRepo.save(experiencia);
    }

    @Transactional
    public void deleteExperiencia(Integer id, Integer idUsuario) {
        Experiencia existing = experienciaRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Experiencia no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        experienciaRepo.delete(existing);
    }

    // ── Habilidades ────────────────────────────────────────────────────────────

    public List<Habilidad> getHabilidades(Integer idUsuario) {
        return habilidadRepo.findByIdUsuario(idUsuario);
    }

    public Habilidad saveHabilidad(Habilidad habilidad, Integer idUsuario) {
        habilidad.setIdUsuario(idUsuario);
        return habilidadRepo.save(habilidad);
    }

    public Habilidad updateHabilidad(Integer id, Habilidad habilidad, Integer idUsuario) {
        Habilidad existing = habilidadRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Habilidad no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        habilidad.setIdHabilidades(id);
        habilidad.setIdUsuario(idUsuario);
        return habilidadRepo.save(habilidad);
    }

    @Transactional
    public void deleteHabilidad(Integer id, Integer idUsuario) {
        Habilidad existing = habilidadRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Habilidad no encontrada"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        habilidadRepo.delete(existing);
    }

    // ── Intereses Personales ───────────────────────────────────────────────────

    public List<InteresPersonal> getIntereses(Integer idUsuario) {
        return interesRepo.findByIdUsuario(idUsuario);
    }

    public InteresPersonal saveInteres(InteresPersonal interes, Integer idUsuario) {
        interes.setIdUsuario(idUsuario);
        return interesRepo.save(interes);
    }

    public InteresPersonal updateInteres(Integer id, InteresPersonal interes, Integer idUsuario) {
        InteresPersonal existing = interesRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Interés no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        interes.setIdInteres(id);
        interes.setIdUsuario(idUsuario);
        return interesRepo.save(interes);
    }

    @Transactional
    public void deleteInteres(Integer id, Integer idUsuario) {
        InteresPersonal existing = interesRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Interés no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        interesRepo.delete(existing);
    }

    // ── Idiomas ────────────────────────────────────────────────────────────────

    public List<Idioma> getIdiomas(Integer idUsuario) {
        return idiomaRepo.findByIdUsuario(idUsuario);
    }

    public Idioma saveIdioma(Idioma idioma, Integer idUsuario) {
        idioma.setIdUsuario(idUsuario);
        return idiomaRepo.save(idioma);
    }

    public Idioma updateIdioma(Integer id, Idioma idioma, Integer idUsuario) {
        Idioma existing = idiomaRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Idioma no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        idioma.setIdIdioma(id);
        idioma.setIdUsuario(idUsuario);
        return idiomaRepo.save(idioma);
    }

    @Transactional
    public void deleteIdioma(Integer id, Integer idUsuario) {
        Idioma existing = idiomaRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Idioma no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        idiomaRepo.delete(existing);
    }

    // ── Cursos ─────────────────────────────────────────────────────────────────

    public List<Curso> getCursos(Integer idUsuario) {
        return cursoRepo.findByIdUsuario(idUsuario);
    }

    public Curso saveCurso(Curso curso, Integer idUsuario) {
        curso.setIdUsuario(idUsuario);
        return cursoRepo.save(curso);
    }

    public Curso updateCurso(Integer id, Curso curso, Integer idUsuario) {
        Curso existing = cursoRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Curso no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        curso.setIdCurso(id);
        curso.setIdUsuario(idUsuario);
        return cursoRepo.save(curso);
    }

    @Transactional
    public void deleteCurso(Integer id, Integer idUsuario) {
        Curso existing = cursoRepo.findById(id)
                .orElseThrow(() -> new NotFoundException("Curso no encontrado"));
        if (!existing.getIdUsuario().equals(idUsuario))
            throw new ForbiddenException("Acceso denegado");
        cursoRepo.delete(existing);
    }
}
