<?php

namespace App\Controllers;

use App\Models\Servicio;
use Core\Request;
use Core\Response;
use PDO;

class ServicioController
{
    private Servicio $servicio;

    public function __construct(PDO $db)
    {
        $this->servicio = new Servicio($db);
    }

    public function index(): void
    {
        Response::success(
            $this->servicio->obtenerTodos(),
            'Servicios obtenidos correctamente'
        );
    }

    public function show(int $id): void
    {
        $servicio = $this->servicio->obtenerPorId($id);

        if (!$servicio) {
            Response::error('Servicio no encontrado', 404);
        }

        Response::success($servicio);
    }

    // POST /api/servicios

    public function store(): void
    {
        // Obtener los datos JSON de la petición
            $data = Request::body();

        // Validación de campos obligatorios (Error 400)
        if (empty($data['nombre_servicio']) || empty($data['precio'])) {
            Response::error('El nombre y el precio son obligatorios', 422);
            return;
        }

        // Validación de tipo de dato (ejemplo: el peso debe ser numérico)
        if (isset($data['precio']) && !is_numeric($data['precio'])) {
            Response::error('El precio debe ser un valor numérico', 422);
            return;
        }

        if ($this->servicio->crear($data)) {
            Response::success(null, 'Servicio creado exitosamente', 201); // 201 Created
        } else {
            Response::error('Error al crear el servicio en la base de datos', 500); // 500 Internal Server Error
        }
    }

    // PUT /api/servicios{id}
    public function update(int $id): void
    {
        // Primero verificamos si existe (Error 404)
        if (!$this->servicio->obtenerPorId($id)) {
            Response::error('Servicio no encontrado', 404);
            return;
        }

            $data = Request::body();

        if (empty($data['nombre']) || empty($data['precio'])) {
            Response::error('Los campos nombre, y precio son obligatorios', 422);
            return;
        }

        if ($this->servicio->actualizar($id, $data)) {
            Response::success(null, 'Servicio actualizado correctamente');
        } else {
            Response::error('Error al actualizar servicio', 500);
        }
    }

    // DELETE /api/servicios/{id}
    public function destroy(int $id): void
    {
        // Verificamos si existe antes de borrar (Error 404)
        if (!$this->servicio->obtenerPorId($id)) {
            Response::error('Servicio no encontrado', 404);
            return;
        }

        if ($this->servicio->eliminar($id)) {
            Response::success(null, 'Servicio eliminado correctamente');
        } else {
            Response::error('Error al eliminar servicio', 500);
        }
    }

      }