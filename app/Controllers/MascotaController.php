<?php

namespace App\Controllers;

use App\Models\Mascota;
use Core\Request;
use Core\Response;
use PDO;

class MascotaController
{
    private Mascota $mascota;

    public function __construct(PDO $db)
    {
        $this->mascota = new Mascota($db);
    }

    public function index(): void
    {
        Response::success(
            $this->mascota->obtenerTodos(),
            'Mascotas obtenidas correctamente'
        );
    }

    public function show(int $id): void
    {
        $mascota = $this->mascota->obtenerPorId($id);

        if (!$mascota) {
            Response::error('Mascota no encontrada', 404);
        }

        Response::success($mascota);
    }

    // POST /api/mascotas

    public function store(): void
    {
        // Obtener los datos JSON de la petición
            $data = Request::body();

        // Validación de campos obligatorios (Error 400)
        if (empty($data['nombre']) || empty($data['especie']) || empty($data['id_dueno'])) {
            Response::error('Los campos nombre, especie e id_dueno son obligatorios', 422);
            return;
        }

        // Validación de tipo de dato (ejemplo: el peso debe ser numérico)
        if (isset($data['peso']) && !is_numeric($data['peso'])) {
            Response::error('El peso debe ser un valor numérico', 422);
            return;
        }

        if ($this->mascota->crear($data)) {
            Response::success(null, 'Mascota creada exitosamente', 201); // 201 Created
        } else {
            Response::error('Error al crear la mascota en la base de datos', 500); // 500 Internal Server Error
        }
    }

    // PUT /api/mascotas/{id}
    public function update(int $id): void
    {
        // Primero verificamos si existe (Error 404)
        if (!$this->mascota->obtenerPorId($id)) {
            Response::error('Mascota no encontrada', 404);
            return;
        }

            $data = Request::body();

        if (empty($data['nombre']) || empty($data['especie']) || empty($data['id_dueno'])) {
            Response::error('Los campos nombre, especie e id_dueno son obligatorios', 422);
            return;
        }

        if ($this->mascota->actualizar($id, $data)) {
            Response::success(null, 'Mascota actualizada correctamente');
        } else {
            Response::error('Error al actualizar la mascota', 500);
        }
    }

    // DELETE /api/mascotas/{id}
    public function destroy(int $id): void
    {
        // Verificamos si existe antes de borrar (Error 404)
        if (!$this->mascota->obtenerPorId($id)) {
            Response::error('Mascota no encontrada', 404);
            return;
        }

        if ($this->mascota->eliminar($id)) {
            Response::success(null, 'Mascota eliminada correctamente');
        } else {
            Response::error('Error al eliminar la mascota', 500);
        }
    }

      }