package com.generacv.repository;

import com.generacv.model.Experiencia;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface ExperienciaRepository extends JpaRepository<Experiencia, Integer> {
    List<Experiencia> findByIdUsuario(Integer idUsuario);
}
