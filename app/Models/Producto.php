<?php

namespace App\Models;

use PDO;

class Producto
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function obtenerTodos(): array
    {
        $sql = "SELECT * FROM productos";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

     public function obtenerPorId(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM productos
            WHERE id_producto = :id
        ");

        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch();
    }

    // POST: Crear un nuevo producto
    public function crear(array $datos): bool
    {
        $sql = "INSERT INTO productos (nombre_producto, categoria, precio, stock) 
                VALUES (:nombre, :categoria, :precio, :stock)";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':nombre' => $datos['nombre_producto'],
            ':categoria' => $datos['categoria'] ?? null,
            ':precio' => $datos['precio'],
            ':stock' => $datos['stock'] ?? 0
        ]);

        return (int) $this->db->lastInsertId();
    }


    // PUT: Actualizar una producto existente
    public function actualizar(int $id, array $datos): bool
    {
        $sql = "UPDATE productos
                SET nombre_producto = :nombre, categoria = :categoria, precio = :precio, stock = :stock  
                WHERE id_producto = :id";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
             ':id' => $id, 
            ':nombre' => $datos['nombre_producto'], 
            ':categoria' => $datos['categoria'] ?? null,
            ':precio' => $datos['precio'], 
            ':stock' => $datos['stock'] ?? 0
        ]);
    }


    // DELETE: Eliminar un producto
    public function eliminar(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id_producto = :id");
        return $stmt->execute([':id' => $id]);
    }
 }