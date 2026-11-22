<?php

namespace App\Models;

use PDO;

class Mascota
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function obtenerTodos(): array
    {
        $sql = "
            SELECT
                id_mascota,
                nombre,
                especie,
                raza,
                sexo,
                fecha_nacimiento,
                peso
            FROM mascotas
            ORDER BY nombre
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

     public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM mascotas
            WHERE id_mascota = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // POST: Crear una nueva mascota
    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO mascotas (nombre, especie, raza, sexo, fecha_nacimiento, peso, id_dueno) 
                VALUES (:nombre, :especie, :raza, :sexo, :fecha_nacimiento, :peso, :id_dueno)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre'],
            ':especie' => $datos['especie'],
            ':raza' => $datos['raza'] ?? null,
            ':sexo' => $datos['sexo'] ?? null,
            ':fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            ':peso' => $datos['peso'] ?? null,
            ':id_dueno' => $datos['id_dueno']
        ]);

        return (int) $this->db->lastInsertId();
    }


    // PUT: Actualizar una mascota existente
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE mascotas 
                SET nombre = :nombre, especie = :especie, raza = :raza, sexo = :sexo, 
                    fecha_nacimiento = :fecha_nacimiento, peso = :peso, id_dueno = :id_dueno 
                WHERE id_mascota = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':nombre' => $datos['nombre'],
            ':especie' => $datos['especie'],
            ':raza' => $datos['raza'] ?? null,
            ':sexo' => $datos['sexo'] ?? null,
            ':fecha_nacimiento' => $datos['fecha_nacimiento'] ?? null,
            ':peso' => $datos['peso'] ?? null,
            ':id_dueno' => $datos['id_dueno']
        ]);
    }


    // DELETE: Eliminar una mascota
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM mascotas WHERE id_mascota = :id");
        return $stmt->execute([':id' => $id]);
    }
 }