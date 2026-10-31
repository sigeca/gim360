<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Dashboard
$routes->get('/', 'Home::index');
$routes->get('home', 'Home::index');

// Autenticación y Registro
$routes->get('login', 'Auth::login');
$routes->post('login', 'Auth::processLogin');
$routes->get('registro', 'Auth::register');
$routes->post('registro', 'Auth::processRegister');
$routes->get('register', 'Auth::register');
$routes->post('register', 'Auth::processRegister');
$routes->get('logout', 'Auth::logout');

$modulos = [
    'persona'            => 'Persona',
    'cliente'            => 'Cliente',
    'perfilnutricional'  => 'PerfilNutricional',
    'perfil-nutricional' => 'PerfilNutricional',
    'controlnutricional' => 'PerfilNutricional',
    'control-nutricional'=> 'PerfilNutricional',
    'componentenutricional'   => 'ComponenteNutricional',
    'componente-nutricional'  => 'ComponenteNutricional',
    'componentesnutricionales'=> 'ComponenteNutricional',
    'grupoalimento'      => 'GrupoAlimento',
    'grupo-alimento'     => 'GrupoAlimento',
    'gruposalimentos'    => 'GrupoAlimento',
    'alimento'           => 'Alimento',
    'alimentos'          => 'Alimento',
    'planalimentacion'   => 'PlanAlimentacion',
    'plan-alimentacion'  => 'PlanAlimentacion',
    'planesalimentacion' => 'PlanAlimentacion',
    'receta'             => 'Receta',
    'recetas'            => 'Receta',
    'unidadalimento'     => 'UnidadAlimento',
    'unidad-alimento'    => 'UnidadAlimento',
    'unidadesalimento'   => 'UnidadAlimento',
    'alimentoreceta'     => 'AlimentoReceta',
    'alimento-receta'    => 'AlimentoReceta',
    'alimentocomponentenutricional'   => 'AlimentoComponenteNutricional',
    'alimento-componente-nutricional'  => 'AlimentoComponenteNutricional',
    'alimentocomponente'              => 'AlimentoComponenteNutricional',
    'recetacomponentenutricional'     => 'RecetaComponenteNutricional',
    'receta-componente-nutricional'   => 'RecetaComponenteNutricional',
    'recetacomponente'                => 'RecetaComponenteNutricional',
    'tipocomida'         => 'TipoComida',
    'tipo-comida'        => 'TipoComida',
    'tiposcomida'        => 'TipoComida',
    'diasemana'          => 'DiaSemana',
    'dia-semana'         => 'DiaSemana',
    'dias-semana'        => 'DiaSemana',
    'comida'             => 'Comida',
    'comidas'            => 'Comida',
    'correo'             => 'Correo',
    'direccion'          => 'Direccion',
    'sexo'               => 'Sexo',
    'estadocivil'        => 'EstadoCivil',
    'genero'             => 'Genero',
    'estadocivilpersona' => 'EstadoCivilPersona',
    'generopersona'      => 'GeneroPersona',
    'visitasgim'         => 'VisitasGim',
    'equipo'             => 'Equipo',
    'equipos'            => 'Equipo',
    'ejercicio'          => 'Ejercicio',
    'motivoentrenamiento'  => 'MotivoEntrenamiento',
    'rutinaejecicio'       => 'RutinaEjecicio',
    'rutinaejercicio'      => 'RutinaEjecicio',
    'planejercicio'        => 'PlanEjercicio',
    'rutinaplan'           => 'RutinaPlan',
    'rutina-plan'          => 'RutinaPlan',
    'musculo'              => 'Musculo',
    'musculos'             => 'Musculo',
    'trenmuscular'         => 'TrenMuscular',
    'trenmusculo'          => 'TrenMuscular',
    'tren-muscular'        => 'TrenMuscular',
    'musculoejercicio'     => 'MusculoEjercicio',
    'musculo-ejercicio'    => 'MusculoEjercicio',
    'programaentrenamiento'=> 'ProgramaEntrenamiento',
    'estadoprogramacliente'=> 'EstadoProgramaCliente',
    'estado-programa-cliente' => 'EstadoProgramaCliente',
    'programacliente'      => 'ProgramaCliente',
    'programa-cliente'     => 'ProgramaCliente',
    'planpersonalizado'    => 'PlanPersonalizado',
    'plan-personalizado'   => 'PlanPersonalizado',
    'planejerciciopersonalizado' => 'PlanPersonalizado',
    'ejercicioequipo'      => 'EjercicioEquipo',
    'ejercicio-equipo'     => 'EjercicioEquipo',
    'equipomusculo'        => 'EquipoMusculo',
    'equipo-musculo'       => 'EquipoMusculo',
    'disponibilidadequipo' => 'DisponibilidadEquipo',
    'disponibilidad-equipo'=> 'DisponibilidadEquipo',
    'rutinaprograma'       => 'RutinaPrograma',
    'rutina-programa'      => 'RutinaPrograma',
    'rangoedad'            => 'RangoEdad',
    'rango-edad'           => 'RangoEdad',
    'ejecucionprograma'    => 'EjecucionPrograma',
    'ejecucion-programa'   => 'EjecucionPrograma',
    'usuario'              => 'Usuario',
    'imagen'               => 'Imagen',
    'imagenes'             => 'Imagen',
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

        // Rutas adicionales para equipo
        if ($controller === 'Equipo' || $controller === 'Equipos') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', "{$controller}::imagen/$1");
            $routes->post('asignarMusculo/(:num)', "{$controller}::asignarMusculo/$1");
            $routes->post('quitarMusculo/(:num)/(:num)', "{$controller}::quitarMusculo/$1/$2");
        }

        // Rutas adicionales para musculo
        if ($controller === 'Musculo') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'Musculo::imagen/$1');
            $routes->get('galeria', 'Musculo::galeria');
            $routes->post('asignarEquipo/(:num)', 'Musculo::asignarEquipo/$1');
            $routes->post('quitarEquipo/(:num)/(:num)', 'Musculo::quitarEquipo/$1/$2');
            $routes->post('asignarEjercicio/(:num)', 'Musculo::asignarEjercicio/$1');
            $routes->post('quitarEjercicio/(:num)/(:num)', 'Musculo::quitarEjercicio/$1/$2');
        }

        // Rutas adicionales para motivoentrenamiento
        if ($controller === 'MotivoEntrenamiento') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'MotivoEntrenamiento::imagen/$1');
        }

        // Rutas adicionales para imagen
        if ($controller === 'Imagen') {
            $routes->match(['GET', 'HEAD'], 'imagen/(:any)', 'Imagen::imagen/$1');
            $routes->match(['GET', 'HEAD'], 'archivo/(:any)', 'Imagen::archivo/$1');
            $routes->post('upload/(:num)', 'Imagen::upload/$1');
        }
    });
}

// --------------------------------------------------------------------
// RUTAS UNIVERSALES PARA SERVIR ARCHIVOS DEL REPOSITORIO (LOCAL Y NUBE)
// --------------------------------------------------------------------
$routes->match(['GET', 'HEAD'], 'repositorio/(:any)', 'Repositorio::index/$1');
$routes->match(['GET', 'HEAD'], 'public/repositorio/(:any)', 'Repositorio::index/$1');

// --------------------------------------------------------------------
// RUTAS API REST PARA LA APLICACIÓN MÓVIL GIM360
// --------------------------------------------------------------------
$routes->group('api', ['namespace' => 'App\Controllers\Api'], static function ($routes) {
    // Manejo de CORS preflight
    $routes->options('(:any)', 'GimApiController::options');
    $routes->options('/', 'GimApiController::options');

    // Autenticación y Registro Móvil GIM360
    $routes->post('auth/login', 'AuthApiController::login');
    $routes->post('login', 'AuthApiController::login');
    $routes->post('auth/registro', 'AuthApiController::register');
    $routes->post('registro', 'AuthApiController::register');
    $routes->get('auth/verificar-cedula', 'AuthApiController::verificarCedula');
    $routes->post('auth/verificar-cedula', 'AuthApiController::verificarCedula');

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
    $routes->get('cliente/(:num)/ejecuciones', 'GimApiController::getClienteEjecuciones/$1');
    $routes->get('cliente/(:num)/progreso', 'GimApiController::getClienteProgreso/$1');

    // Control Nutricional y Antropométrico
    $routes->get('perfilnutricional', 'GimApiController::getPerfilesNutricionales');
    $routes->get('perfilnutricional/(:num)', 'GimApiController::getPerfilNutricionalDetail/$1');
    $routes->get('persona/(:num)/nutricion', 'GimApiController::getPersonaNutricion/$1');
    $routes->post('perfilnutricional', 'GimApiController::guardarPerfilNutricional');
    $routes->get('componentenutricional', 'GimApiController::getComponentesNutricionales');
    $routes->get('componentesnutricionales', 'GimApiController::getComponentesNutricionales');
    $routes->get('componentenutricional/(:num)', 'GimApiController::getComponenteNutricionalDetail/$1');
    $routes->get('alimentocomponentenutricional', 'GimApiController::getAlimentosComponentesNutricionales');
    $routes->get('alimentocomponentenutricional/(:num)', 'GimApiController::getAlimentoComponenteNutricionalDetail/$1');
    $routes->get('alimento/(:num)/componentes', 'GimApiController::getComponentesPorAlimento/$1');
    $routes->get('recetacomponentenutricional', 'GimApiController::getRecetasComponentesNutricionales');
    $routes->get('recetacomponentenutricional/(:num)', 'GimApiController::getRecetaComponenteNutricionalDetail/$1');
    $routes->get('receta/(:num)/componentes', 'GimApiController::getComponentesPorReceta/$1');
    $routes->get('imagenes', 'GimApiController::getImagenes');
    $routes->get('imagen', 'GimApiController::getImagenes');
    $routes->get('imagen/(:num)', 'GimApiController::getImagenDetail/$1');
    $routes->get('gruposalimentos', 'GimApiController::getGruposAlimentos');
    $routes->get('grupoalimento', 'GimApiController::getGruposAlimentos');
    $routes->get('grupoalimento/(:num)', 'GimApiController::getGrupoAlimentoDetail/$1');
    $routes->get('grupoalimento/(:num)/alimentos', 'GimApiController::getAlimentosPorGrupo/$1');
    $routes->get('alimentos', 'GimApiController::getAlimentos');
    $routes->get('alimento', 'GimApiController::getAlimentos');
    $routes->get('alimento/(:num)', 'GimApiController::getAlimentoDetail/$1');
    $routes->get('planesalimentacion', 'GimApiController::getPlanesAlimentacion');
    $routes->get('planalimentacion', 'GimApiController::getPlanesAlimentacion');
    $routes->get('planalimentacion/(:num)', 'GimApiController::getPlanAlimentacionDetail/$1');
    $routes->get('persona/(:num)/planesalimentacion', 'GimApiController::getPersonaPlanesAlimentacion/$1');
    $routes->post('planalimentacion', 'GimApiController::guardarPlanAlimentacion');
    $routes->put('planalimentacion/(:num)', 'GimApiController::actualizarPlanAlimentacion/$1');
    $routes->delete('planalimentacion/(:num)', 'GimApiController::eliminarPlanAlimentacion/$1');
    $routes->get('recetas', 'GimApiController::getRecetas');
    $routes->get('receta', 'GimApiController::getRecetas');
    $routes->get('receta/(:num)', 'GimApiController::getRecetaDetail/$1');
    $routes->post('receta', 'GimApiController::guardarReceta');
    $routes->get('unidadesalimento', 'GimApiController::getUnidadesAlimento');
    $routes->get('unidadalimento', 'GimApiController::getUnidadesAlimento');
    $routes->get('unidadalimento/(:num)', 'GimApiController::getUnidadAlimentoDetail/$1');
    $routes->post('unidadalimento', 'GimApiController::guardarUnidadAlimento');
    $routes->get('receta/(:num)/ingredientes', 'GimApiController::getRecetaIngredientes/$1');
    $routes->get('alimentoreceta', 'GimApiController::getAlimentosReceta');
    $routes->get('alimentoreceta/(:num)', 'GimApiController::getAlimentoRecetaDetail/$1');
    $routes->post('alimentoreceta', 'GimApiController::guardarAlimentoReceta');
    $routes->delete('alimentoreceta/(:num)', 'GimApiController::eliminarAlimentoReceta/$1');
    $routes->get('tiposcomida', 'GimApiController::getTiposComida');
    $routes->get('tipocomida', 'GimApiController::getTiposComida');
    $routes->get('tipocomida/(:num)', 'GimApiController::getTipoComidaDetail/$1');
    $routes->post('tipocomida', 'GimApiController::guardarTipoComida');
    $routes->get('diassemana', 'GimApiController::getDiasSemana');
    $routes->get('diasemana', 'GimApiController::getDiasSemana');
    $routes->get('diasemana/(:num)', 'GimApiController::getDiaSemanaDetail/$1');
    $routes->post('diasemana', 'GimApiController::guardarDiaSemana');
    $routes->get('comidas', 'GimApiController::getComidas');
    $routes->get('comida', 'GimApiController::getComidas');
    $routes->get('comida/(:num)', 'GimApiController::getComidaDetail/$1');
    $routes->get('planalimentacion/(:num)/comidas', 'GimApiController::getPlanComidas/$1');
    $routes->post('comida', 'GimApiController::guardarComida');
    $routes->delete('comida/(:num)', 'GimApiController::eliminarComida/$1');

    // Programas y Rutinas de Entrenamiento
    $routes->get('programas', 'GimApiController::getProgramas');
    $routes->get('programa/(:num)', 'GimApiController::getProgramaDetail/$1');
    $routes->post('programacliente', 'GimApiController::asignarProgramaCliente');
    $routes->get('rutinas', 'GimApiController::getRutinas');
    $routes->get('rutina/(:num)', 'GimApiController::getRutinaDetail/$1');
    $routes->post('rutina/(:num)/plan', 'GimApiController::agregarPlanRutina/$1');
    $routes->post('rutina/plan', 'GimApiController::agregarPlanRutina');
    $routes->put('planejercicio/(:num)', 'GimApiController::actualizarPlanEjercicio/$1');
    $routes->post('planejercicio/(:num)', 'GimApiController::actualizarPlanEjercicio/$1');
    $routes->post('planejercicio/update/(:num)', 'GimApiController::actualizarPlanEjercicio/$1');
    $routes->delete('rutinaplan/(:num)', 'GimApiController::eliminarPlanRutina/$1');
    $routes->post('rutinaplan/delete/(:num)', 'GimApiController::eliminarPlanRutina/$1');
    $routes->delete('planejercicio/(:num)', 'GimApiController::eliminarPlanRutina/$1');
    $routes->get('rangos-edad', 'GimApiController::getRangosEdad');
    $routes->get('rangoedad', 'GimApiController::getRangosEdad');

    // Catálogo de Ejercicios, Músculos y Equipos
    $routes->get('trenesmusculares', 'GimApiController::getTrenesMusculares');
    $routes->get('trenmuscular', 'GimApiController::getTrenesMusculares');
    $routes->get('trenmuscular/(:num)', 'GimApiController::getTrenMuscularDetail/$1');
    $routes->get('ejercicios', 'GimApiController::getEjercicios');
    $routes->get('ejercicio/(:num)', 'GimApiController::getEjercicioDetail/$1');
    $routes->get('musculos', 'GimApiController::getMusculos');
    $routes->get('musculo/(:num)', 'GimApiController::getMusculoDetail/$1');
    $routes->get('musculos/(:num)', 'GimApiController::getMusculoDetail/$1');
    $routes->get('equipos', 'GimApiController::getEquipos');
    $routes->get('equipo', 'GimApiController::getEquipos');
    $routes->get('equipo/(:num)', 'GimApiController::getEquipoDetail/$1');
    $routes->get('equipos/(:num)', 'GimApiController::getEquipoDetail/$1');
    $routes->get('disponibilidadequipo', 'GimApiController::getDisponibilidadEquipo');
    $routes->get('disponibilidad-equipo', 'GimApiController::getDisponibilidadEquipo');

    // Registro de esfuerzo, ejecuciones de programa y visitas
    $routes->get('ejecucionprograma', 'GimApiController::getEjecuciones');
    $routes->post('ejecucionprograma', 'GimApiController::registrarEjecucionPrograma');
    $routes->post('ejecucionprograma/(:num)/finalizar', 'GimApiController::finalizarEjecucionPrograma/$1');
    $routes->post('ejercicios-cliente', 'GimApiController::registrarEjecucionPrograma');
    $routes->post('visitas', 'GimApiController::registrarVisita');
    $routes->post('visitas/(:num)/checkout', 'GimApiController::checkoutVisita/$1');
});

