<?php

namespace App\Controllers;

use App\Models\Cita;
use Core\Request;
use Core\Response;
use PDO;

class CitaController
{
    private Cita $cita;

    public function __construct(PDO $db)
    {
        $this->cita = new Cita($db);
    }

    public function index(): void
    {
        Response::success(
            $this->cita->obtenerTodos(),
            'Citas obtenidos correctamente'
        );
    }

    public function show(int $id): void
    {
        $cita = $this->cita->obtenerPorId($id);

        if (empty(!$cita)) {
            Response::error('Cita no encontrada', 404);
        }

        Response::success($cita);
    }

    // POST /api/cita

    public function store(): void
    {
        // Obtener los datos JSON de la petición
            $data = Request::body();

        // Validación de campos obligatorios (Error 400)
        if (empty($data['fecha_hora']) || empty($data['id_mascota']) || empty($data['id_veterinario']) || empty($data['id_servicio']) || empty($data['id_sede'])) {
            Response::error('Faltan campos obligatorios o llaves foraneas', 422);
            return;
              } 
        try {
            $id = $this->cita->crear($data);
            Response::success(['id_cita' => $id], 'Cita registrada correctamente', 201);
        } catch (\PDOException $e) {
            // Si intentan poner un ID de mascota/veterinario que no existe, salta este error
            Response::error('Error de integridad: Verifique que la mascota, veterinario, servicio y sede existan.', 400);
        }
        }

    // PUT /api/cita/{id}
    
        public function update(int $id): void
    {
        // Primero verificamos si existe (Error 404)
        if (!$this->cita->obtenerPorId($id)) {
            Response::error('Cita no encontrada', 404);
            return;
        }

            $data = Request::body();

    try {
            $this->cita->actualizar($id, $data);
            Response::success(null, 'Cita actualizada correctamente');
        } catch (\PDOException $e) {
            Response::error('Error de integridad al actualizar', 400);
        }
    }

    // DELETE /api/cita/{id}
    public function destroy(int $id): void
    {
        // Verificamos si existe antes de borrar (Error 404)
        if (!$this->cita->obtenerPorId($id)) {
            Response::error('Cita no encontrada', 404);
            return;
        }
        $this->cita->eliminar($id);
        Response::success(null, 'Cita eliminada correctamente');
        }
    }

    