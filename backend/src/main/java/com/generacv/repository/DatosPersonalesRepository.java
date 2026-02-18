package com.generacv.repository;

import com.generacv.model.DatosPersonales;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.Optional;

@Repository
public interface DatosPersonalesRepository extends JpaRepository<DatosPersonales, Integer> {
    Optional<DatosPersonales> findByIdUsuario(Integer idUsuario);
}
