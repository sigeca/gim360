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
    'ejerciciocliente'   => 'EjercicioCliente',
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
