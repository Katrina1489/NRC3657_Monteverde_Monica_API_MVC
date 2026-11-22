<?php

namespace App\Controllers;

use App\Models\Dueno;
use Core\Request;
use Core\Response;
use PDO;

class DuenoController
{
    private Dueno $dueno;

    public function __construct(PDO $db)
    {
        $this->dueno = new Dueno($db);
    }

    public function index(): void
    {
        Response::success(
            $this->dueno->obtenerTodos(),
            'Duenos obtenidos correctamente'
        );
    }

    public function show(int $id): void
    {
        $dueno = $this->dueno->obtenerPorId($id);

        if (!$dueno) {
            Response::error('Dueno no encontrado', 404);
        }

        Response::success($dueno);
    }

    // POST /api/dueno

    public function store(): void
    {
        // Obtener los datos JSON de la petición
            $data = Request::body();

        // Validación de campos obligatorios (Error 400)
        if (empty($data['nombres']) || empty($data['apellidos']) || empty($data['dni'])) {
            Response::error('Los campos nombres , apellidos y DNI son obligatorios', 422);
            return;
        }

        if ($this->dueno->crear($data)) {
            Response::success(null, 'Dueno registrado exitosamente', 201); // 201 Created
        } else {
            Response::error('Error al crear el dueno en la base de datos', 500); // 500 Internal Server Error
        }
    }

    // PUT /api/dueno/{id}
    
    public function update(int $id): void
    {
        // Primero verificamos si existe (Error 404)
        if (!$this->dueno->obtenerPorId($id)) {
            Response::error('Dueno no encontrado', 404);
            return;
        }

            $data = Request::body();

        if (empty($data['nombres']) || empty($data['apellidos']) || empty($data['dni'])) {
            Response::error('Los campos nombre, apellidos y DNI son obligatorios', 422);
            return;
        }

        if ($this->dueno->actualizar($id, $data)) {
            Response::success(null, 'Dueno actualizado correctamente');
        } else {
            Response::error('Error al actualizar dueno', 500);
        }
    }

    // DELETE /api/dueno/{id}
    public function destroy(int $id): void
    {
        // Verificamos si existe antes de borrar (Error 404)
        if (!$this->dueno->obtenerPorId($id)) {
            Response::error('Dueno no encontrado', 404);
            return;
        }
      try {
            $this->dueno->eliminar($id);
            Response::success(null, 'Dueño eliminado correctamente');
        } catch (\PDOException $e) {
            // Si intentan borrar un dueño con mascotas, devolvemos un 400
            Response::error('No se puede eliminar el dueño porque tiene mascotas registradas a su nombre.', 400);
        }
    }

      }