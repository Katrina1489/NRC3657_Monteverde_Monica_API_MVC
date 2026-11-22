<?php

use App\Controllers\MascotaController;
use App\Controllers\DuenoController;
use App\Controllers\CitaController;
use App\Controllers\ServicioController;
use App\Controllers\ProductoController;


// ==========================================================
// INSTANCIAR CONTROLLERS
// ==========================================================

$MascotaController = new MascotaController($db);
$DuenoController = new DuenoController($db);
$CitaController = new CitaController($db);
$ServicioController = new ServicioController($db);
$ProductoController = new ProductoController($db);


// ==========================================================
// MASCOTAS
// ==========================================================

// Listar mascotas
$router->get(
    '/api/mascotas',
    [$MascotaController, 'index']
);

// Listar mascota por ID
$router->get(
    '/api/mascotas/{id}',
    [$MascotaController, 'show']
);

// Crear mascota 

$router->post(
    '/api/mascotas',
    [$MascotaController, 'store']
);

// Actualizar mascota

    $router->put(
    '/api/mascotas/{id}',
    [$MascotaController, 'update']
);

// Eliminar mascota
    $router->delete(
    '/api/mascotas/{id}',
    [$MascotaController, 'destroy']
);


// ==========================================================
// DUENOS
// ==========================================================

// Listar duenos
$router->get(
    '/api/duenos',
    [$DuenoController, 'index']
);

// Listar dueno por ID
$router->get(
    '/api/duenos/{id}',
    [$DuenoController, 'show']
);

// Crear dueno

$router->post(
    '/api/duenos',
    [$DuenoController, 'store']
);

// Actualizar dueno

    $router->put(
    '/api/duenos/{id}',
    [$DuenoController, 'update']
);

// Eliminar dueno
    $router->delete(
    '/api/duenos/{id}',
    [$DuenoController, 'destroy']
);


// ==========================================================
// CITAS
// ==========================================================

// Listar citas
$router->get(
    '/api/citas',
    [$CitaController, 'index']
);

// Listar cita por ID
$router->get(
    '/api/citas/{id}',
    [$CitaController, 'show']
);

// Crear cita

$router->post(
    '/api/citas',
    [$CitaController, 'store']
);

// Actualizar cita

    $router->put(
    '/api/citas/{id}',
    [$CitaController, 'update']
);

// Eliminar Cita
    $router->delete(
    '/api/citas/{id}',
    [$CitaController, 'destroy']
);

// ==========================================================
// SERVICIOS
// ==========================================================

// Listar servicios
$router->get(
    '/api/servicios',
    [$ServicioController, 'index']
);

// Listar servicio por ID
$router->get(
    '/api/servicios/{id}',
    [$ServicioController, 'show']
);

// Crear servicio

$router->post(
    '/api/servicios',
    [$ServicioController, 'store']
);

// Actualizar servicio

    $router->put(
    '/api/servicios/{id}',
    [$ServicioController, 'update']
);

// Eliminar servicio
    $router->delete(
    '/api/servicios/{id}',
    [$ServicioController, 'destroy']
);

// ==========================================================
// PRODUCTOS
// ==========================================================

// Listar productos
$router->get(
    '/api/productos',
    [$ProductoController, 'index']
);

// Listar producto por ID
$router->get(
    '/api/productos/{id}',
    [$ProductoController, 'show']
);

// Crear producto

$router->post(
    '/api/productos',
    [$ProductoController, 'store']
);

// Actualizar producto

    $router->put(
    '/api/productos/{id}',
    [$ProductoController, 'update']
);

// Eliminar producto
    $router->delete(
    '/api/productos/{id}',
    [$ProductoController, 'destroy']
);
