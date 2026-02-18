package com.generacv.repository;

import com.generacv.model.Habilidad;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface HabilidadRepository extends JpaRepository<Habilidad, Integer> {
    List<Habilidad> findByIdUsuario(Integer idUsuario);
}
