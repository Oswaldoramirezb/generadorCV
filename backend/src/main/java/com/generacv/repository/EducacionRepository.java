package com.generacv.repository;

import com.generacv.model.Educacion;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface EducacionRepository extends JpaRepository<Educacion, Integer> {
    List<Educacion> findByIdUsuario(Integer idUsuario);

    void deleteByIdAndIdUsuario(Integer id, Integer idUsuario);
}
