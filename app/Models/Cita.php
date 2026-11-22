<?php

namespace App\Models;

use PDO;

class Cita
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function obtenerTodos(): array
    {
        $sql = "SELECT c.*,m.nombre as mascota_nombre,v.nombres as veterinario_nombre,s.nombre_servicio
            FROM citas c
            INNER JOIN mascotas m ON c.id_mascota = m.id_mascota
            INNER JOIN veterinarios v ON c.id_veterinario = v.id_veterinario
            INNER JOIN servicios s ON c.id_servicio = s.id_servicio
            ORDER BY c.fecha_hora DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

     public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM citas
            WHERE id_cita = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // POST: Crear nueva cita

    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO citas (fecha_hora, estado, observaciones, id_mascota, id_veterinario, id_servicio, id_sede) 
                VALUES (:fecha_hora, :estado, :observaciones, :id_mascota, :id_veterinario, :id_servicio, :id_sede)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
           ':fecha_hora' => $datos['fecha_hora'],
            ':estado' => $datos['estado'] ?? 'Pendiente',
            ':observaciones' => $datos['observaciones'] ?? null,
            ':id_mascota' => $datos['id_mascota'],
            ':id_veterinario' => $datos['id_veterinario'],
            ':id_servicio' => $datos['id_servicio'],
            ':id_sede' => $datos['id_sede']
        ]);

        return (int) $this->db->lastInsertId();
    }


    // PUT: Actualizar una cita existente
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE citas
                SET fecha_hora = :fecha_hora, estado = :estado, observaciones = :observaciones, 
                    id_mascota = :id_mascota, id_veterinario = :id_veterinario, id_servicio = :id_servicio, id_sede = :id_sede
                WHERE id_cita = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id, 
            ':fecha_hora' => $datos['fecha_hora'], 
            ':estado' => $datos['estado'] ?? 'Pendiente',
            ':observaciones' => $datos['observaciones'] ?? null, 
            ':id_mascota' => $datos['id_mascota'],
            ':id_veterinario' => $datos['id_veterinario'], 
            ':id_servicio' => $datos['id_servicio'], 
            ':id_sede' => $datos['id_sede']
        ]);
    }


    // DELETE: Eliminar una cita
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM citas WHERE id_cita = :id");
        return $stmt->execute([':id' => $id]);
    }
 }