<?php

namespace App\Models;

use PDO;

class Servicio
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM servicios";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

     public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM servicios
            WHERE id_servicio = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // POST: Crear un nuevo servicio
    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO servicios (nombre_servicio, descripcion, precio, duracion_minutos) 
                VALUES (:nombre, :descripcion, :precio, :duracion)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
           ':nombre' => $datos['nombre_servicio'],
            ':descripcion' => $datos['descripcion'] ?? null,
            ':precio' => $datos['precio'],
            ':duracion' => $datos['duracion_minutos'] ?? 30
        ]);

        return (int) $this->db->lastInsertId();
    }


    // PUT: Actualizar un servicio existente
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


    // DELETE: Eliminar un servicio
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM servicios WHERE id_servicio = :id");
        return $stmt->execute([':id' => $id]);
    }
 }