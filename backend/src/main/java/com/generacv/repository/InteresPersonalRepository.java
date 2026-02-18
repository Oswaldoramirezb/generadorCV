package com.generacv.repository;

import com.generacv.model.InteresPersonal;
import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.stereotype.Repository;
import java.util.List;

@Repository
public interface InteresPersonalRepository extends JpaRepository<InteresPersonal, Integer> {
    List<InteresPersonal> findByIdUsuario(Integer idUsuario);
}
