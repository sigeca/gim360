<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Dashboard
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

$modulos = [
    'persona'            => 'Persona',
    'cliente'            => 'Cliente',
    'correo'             => 'Correo',
    'direccion'          => 'Direccion',
    'sexo'               => 'Sexo',
    'estadocivil'        => 'EstadoCivil',
    'genero'             => 'Genero',
    'estadocivilpersona' => 'EstadoCivilPersona',
    'generopersona'      => 'GeneroPersona',
    'visitasgim'         => 'VisitasGim',
    'equipos'            => 'Equipos',
    'ejercicio'          => 'Ejercicio',
    'motivoentrenamiento'  => 'MotivoEntrenamiento',
    'rutinaejecicio'       => 'RutinaEjecicio',
    'rutinaejercicio'      => 'RutinaEjecicio',
    'planejercicio'        => 'PlanEjercicio',
    'rutinaplan'           => 'RutinaPlan',
    'rutina-plan'          => 'RutinaPlan',
    'musculo'              => 'Musculo',
    'musculos'             => 'Musculo',
    'musculoejercicio'     => 'MusculoEjercicio',
    'musculo-ejercicio'    => 'MusculoEjercicio',
    'programaentrenamiento'=> 'ProgramaEntrenamiento',
    'estadoprogramacliente'=> 'EstadoProgramaCliente',
    'estado-programa-cliente' => 'EstadoProgramaCliente',
    'programacliente'      => 'ProgramaCliente',
    'programa-cliente'     => 'ProgramaCliente',
    'ejercicioequipo'      => 'EjercicioEquipo',
    'ejercicio-equipo'     => 'EjercicioEquipo',
    'rutinaprograma'       => 'RutinaPrograma',
    'rutina-programa'      => 'RutinaPrograma',
];

foreach ($modulos as $slug => $controller) {
    $routes->group($slug, static function ($routes) use ($controller) {
        $routes->get('/', "{$controller}::index");
        $routes->get('elprimero', "{$controller}::elprimero");
        $routes->get('elultimo', "{$controller}::elultimo");
        $routes->get('siguiente/(:num)', "{$controller}::siguiente/$1");
        $routes->get('anterior/(:num)', "{$controller}::anterior/$1");
        $routes->get('actual/(:num)', "{$controller}::actual/$1");
        $routes->get('show/(:num)', "{$controller}::actual/$1");
        $routes->get('listar', "{$controller}::listar");
        $routes->get('add', "{$controller}::add");
        $routes->get('new', "{$controller}::add");
        $routes->post('save', "{$controller}::save");
        $routes->post('create', "{$controller}::save");
        $routes->get('edit/(:num)', "{$controller}::edit/$1");
        $routes->post('update/(:num)', "{$controller}::update/$1");
        $routes->post('delete/(:num)', "{$controller}::delete/$1");
        $routes->post('quitar/(:num)', "{$controller}::delete/$1");

        // Rutas adicionales para persona
        if ($controller === 'Persona') {
            $routes->post('toggleCliente/(:num)', 'Persona::toggleCliente/$1');
        }

        // Rutas adicionales para ejercicio
        if ($controller === 'Ejercicio') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'Ejercicio::imagen/$1');
            $routes->post('asignarMusculo/(:num)', 'Ejercicio::asignarMusculo/$1');
            $routes->post('quitarMusculo/(:num)/(:num)', 'Ejercicio::quitarMusculo/$1/$2');
            $routes->post('asignarEquipo/(:num)', 'Ejercicio::asignarEquipo/$1');
            $routes->post('quitarEquipo/(:num)/(:num)', 'Ejercicio::quitarEquipo/$1/$2');
        }

        // Rutas adicionales para equipos
        if ($controller === 'Equipos') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'Equipos::imagen/$1');
        }

        // Rutas adicionales para musculo
        if ($controller === 'Musculo') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'Musculo::imagen/$1');
            $routes->get('galeria', 'Musculo::galeria');
        }
    });
}

// --------------------------------------------------------------------
// RUTAS API REST PARA LA APLICACIÓN MÓVIL GIM360
// --------------------------------------------------------------------
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    // Manejo de CORS preflight
    $routes->options('(:any)', 'GimApiController::options');
    $routes->options('/', 'GimApiController::options');

    // Catálogos
    $routes->get('catalogos', 'PersonaController::catalogos');

    // Personas CRUD
    $routes->get('persona', 'PersonaController::index');
    $routes->get('persona/(:num)', 'PersonaController::show/$1');
    $routes->post('persona', 'PersonaController::create');
    $routes->put('persona/(:num)', 'PersonaController::update/$1');
    $routes->post('persona/(:num)', 'PersonaController::update/$1');
    $routes->post('persona/update/(:num)', 'PersonaController::update/$1');
    $routes->delete('persona/(:num)', 'PersonaController::delete/$1');

    // Sexo CRUD API
    $routes->get('sexo', 'SexoApiController::index');
    $routes->get('sexo/(:num)', 'SexoApiController::show/$1');
    $routes->post('sexo', 'SexoApiController::create');
    $routes->put('sexo/(:num)', 'SexoApiController::update/$1');
    $routes->post('sexo/(:num)', 'SexoApiController::update/$1');
    $routes->delete('sexo/(:num)', 'SexoApiController::delete/$1');

    // Estado Civil CRUD API
    $routes->get('estadocivil', 'EstadoCivilApiController::index');
    $routes->get('estadocivil/(:num)', 'EstadoCivilApiController::show/$1');
    $routes->post('estadocivil', 'EstadoCivilApiController::create');
    $routes->put('estadocivil/(:num)', 'EstadoCivilApiController::update/$1');
    $routes->post('estadocivil/(:num)', 'EstadoCivilApiController::update/$1');
    $routes->delete('estadocivil/(:num)', 'EstadoCivilApiController::delete/$1');

    // Correo CRUD API
    $routes->get('correo', 'CorreoApiController::index');
    $routes->get('correo/(:num)', 'CorreoApiController::show/$1');
    $routes->get('persona/(:num)/correos', 'CorreoApiController::index/$1');
    $routes->post('correo', 'CorreoApiController::create');
    $routes->put('correo/(:num)', 'CorreoApiController::update/$1');
    $routes->post('correo/(:num)', 'CorreoApiController::update/$1');
    $routes->delete('correo/(:num)', 'CorreoApiController::delete/$1');

    // Clientes y Visitantes
    $routes->get('cliente', 'GimApiController::getClientes');
    $routes->get('cliente/(:num)', 'GimApiController::getClienteDetail/$1');
    $routes->get('cliente/(:num)/programas', 'GimApiController::getClienteProgramas/$1');
    $routes->get('cliente/(:num)/visitas', 'GimApiController::getClienteVisitas/$1');
    $routes->get('cliente/(:num)/ejercicios', 'GimApiController::getClienteEjercicios/$1');
    $routes->get('cliente/(:num)/progreso', 'GimApiController::getClienteProgreso/$1');

    // Programas y Rutinas de Entrenamiento
    $routes->get('programas', 'GimApiController::getProgramas');
    $routes->get('programa/(:num)', 'GimApiController::getProgramaDetail/$1');
    $routes->get('rutinas', 'GimApiController::getRutinas');
    $routes->get('rutina/(:num)', 'GimApiController::getRutinaDetail/$1');

    // Catálogo de Ejercicios, Músculos y Equipos
    $routes->get('ejercicios', 'GimApiController::getEjercicios');
    $routes->get('ejercicio/(:num)', 'GimApiController::getEjercicioDetail/$1');
    $routes->get('musculos', 'GimApiController::getMusculos');
    $routes->get('equipos', 'GimApiController::getEquipos');

    // Registro de esfuerzo y visitas
    $routes->post('visitas', 'GimApiController::registrarVisita');
    $routes->post('visitas/(:num)/checkout', 'GimApiController::checkoutVisita/$1');
});

