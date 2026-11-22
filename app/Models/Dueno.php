<?php

namespace App\Models;

use PDO;

class Dueno
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
                id_dueno,
                nombres,
                apellidos,
                dni,
                telefono,
                direccion,
                fecha_registro
            FROM duenos
            ORDER BY apellidos
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

     public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM duenos
            WHERE id_dueno = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // POST: Crear una nuevo dueno
    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO duenos (nombres, apellidos, dni, telefono, correo, direccion) 
                VALUES (:nombres, :apellidos, :dni, :telefono, :correo, :direccion)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombres' => $datos['nombres'],
            ':apellidos' => $datos['apellidos'],
            ':dni' => $datos['dni'],
            ':telefono' => $datos['telefono'],
            ':correo' => $datos['correo'] ?? null,
            ':direccion' => $datos['direccion'] ?? null
        ]);

        return (int) $this->db->lastInsertId();
    }


    // PUT: Actualizar un dueno existente
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE duenos 
                SET nombres=:nombres, apellidos=:apellidos, dni=:dni, telefono=:telefono, correo=:correo, direccion=:direccion 
                WHERE id_dueno=:id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id, ':nombres' => $datos['nombres'], ':apellidos' => $datos['apellidos'],
            ':dni' => $datos['dni'], ':telefono' => $datos['telefono'],
            ':correo' => $datos['correo'] ?? null, ':direccion' => $datos['direccion'] ?? null
        ]);
    }


    // DELETE: Eliminar un dueno 
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM duenos WHERE id_dueno = :id");
        return $stmt->execute([':id' => $id]);
    }
 }