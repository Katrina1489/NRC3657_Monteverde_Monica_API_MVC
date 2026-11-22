<?php

namespace App\Controllers;

use App\Models\Producto;
use Core\Request;
use Core\Response;
use PDO;

class ProductoController
{
    private Producto $producto;

    public function __construct(PDO $db)
    {
        $this->producto = new Producto($db);
    }

    public function index(): void
    {
        Response::success(
            $this->producto->obtenerTodos(),
            'Productos obtenidos correctamente'
        );
    }

    public function show(int $id): void
    {
        $producto = $this->producto->obtenerPorId($id);

        if (!$producto) {
            Response::error('Producto no encontrado', 404);
        }

        Response::success($producto);
    }

    // POST /api/productos

    public function store(): void
    {
        // Obtener los datos JSON de la petición
            $data = Request::body();

        // Validación de campos obligatorios (Error 400)
        if (empty($data['nombre_producto']) || empty($data['precio'])) {
            Response::error('El nombre y el precio son obligatorios', 422);
            return;
        }

        if ($this->producto->crear($data)) {
            Response::success(null, 'Producto creado exitosamente', 201); // 201 Created
        } else {
            Response::error('Error al crear producto en la base de datos', 500); // 500 Internal Server Error
        }
    }

    // PUT /api/producto/{id}
    public function update(int $id): void
    {
        // Primero verificamos si existe (Error 404)
        if (!$this->producto->obtenerPorId($id)) {
            Response::error('Producto no encontrado', 404);
            return;
        }


        $this->producto->actualizar($id, Request::body());
            Response::success(null, 'Producto actualizado correctamente');

    }

    // DELETE /api/productos/{id}
    public function destroy(int $id): void
    {
        // Verificamos si existe antes de borrar (Error 404)
        if (!$this->producto->obtenerPorId($id)) {
            Response::error('Producto no encontrado', 404);
            return;
        }

        if ($this->producto->eliminar($id)) {
            Response::success(null, 'Producto eliminado correctamente');
        } else {
            Response::error('Error al eliminar producto', 500);
        }
    }

      }