package com.generacv.repository;

import com.generacv.model.Idioma;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface IdiomaRepository extends JpaRepository<Idioma, Integer> {
    List<Idioma> findByIdUsuario(Integer idUsuario);
}
