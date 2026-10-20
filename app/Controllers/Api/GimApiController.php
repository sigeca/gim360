<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\ClienteModel;
use App\Models\PersonaModel;
use App\Models\ProgramaClienteModel;
use App\Models\ProgramaEntrenamientoModel;
use App\Models\RutinaEjecicioModel;
use App\Models\RutinaProgramaModel;
use App\Models\RutinaPlanModel;
use App\Models\PlanEjercicioModel;
use App\Models\EjercicioModel;
use App\Models\VisitasGimModel;
use App\Models\MusculoModel;
use App\Models\EquipoModel;
use App\Models\MusculoEjercicioModel;
use App\Models\EjercicioEquipoModel;
use App\Models\EjecucionProgramaModel;

class GimApiController extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        // Support CORS for all clients (Flutter Web, Mobile, Desktop)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    /**
     * Preflight CORS handler
     */
    public function options()
    {
        return $this->response->setStatusCode(200);
    }

    protected function getImageUrl(string $segment, ?string $filename): ?string
    {
        if (empty($filename)) return null;
        $base = rtrim(base_url(), '/');
        if (substr($base, -9) === 'index.php') {
            $base = substr($base, 0, -9);
            $base = rtrim($base, '/');
        }
        $targetFile = $filename;
        if ($segment === 'ejercicio/imagen') {
            $baseSlug = preg_replace('/-(start|peak|main)\.webp$/', '', $filename);
            $baseSlug = preg_replace('/\.webp$/', '', $baseSlug);
            $candidate = $baseSlug . '.webp';
            $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
            if (file_exists($baseDir . '/repositorio/ejercicios/' . $candidate) || file_exists($baseDir . '/repositorio/ejercicios/repdb-free/images/flat/' . $candidate)) {
                $targetFile = $candidate;
            }
        }
        return $base . '/index.php/' . $segment . '/' . $targetFile;
    }

    /**
     * GET /api/cliente
     * List all clients with their persona data
     */
    public function getClientes()
    {
        $search = $this->request->getGet('q');
        $clienteModel = new ClienteModel();
        $clientes = $clienteModel->getClientesWithPersona($search);

        // Enhance with summary counts
        $db = \Config\Database::connect();
        foreach ($clientes as &$c) {
            $idcliente = (int)$c['idcliente'];
            
            // Total visits
            $visitasCount = $db->table('visitasgim')
                               ->where('idcliente', $idcliente)
                               ->countAllResults();
            $c['total_visitas'] = $visitasCount;

            // Total exercises through assigned training programs
            $ejRow = $db->table('programacliente pc')
                        ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento')
                        ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rp.idrutinaejercicio')
                        ->join('planejercicio pe', 'pe.idplanejercicio = rpl.idplanejercicio')
                        ->where('pc.idcliente', $idcliente)
                        ->select('COUNT(DISTINCT pe.idejercicio) as total')
                        ->get()
                        ->getRowArray();
            $c['total_ejercicios'] = (int)($ejRow['total'] ?? 0);

            // Active program
            $activeProg = $db->table('programacliente')
                             ->select('programaentrenamiento.nombre as programa_nombre, programacliente.fechainicio, estadoprogramacliente.nombre as estado_nombre')
                             ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento')
                             ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente')
                             ->where('programacliente.idcliente', $idcliente)
                             ->where('estadoprogramacliente.nombre', 'Activo')
                             ->orderBy('programacliente.idprogramacliente', 'DESC')
                             ->get()
                             ->getRowArray();
            $c['programa_activo'] = $activeProg ? $activeProg['programa_nombre'] : 'Sin programa activo';
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Clientes obtenidos correctamente',
            'data'    => $clientes,
            'total'   => count($clientes),
        ]);
    }

    /**
     * GET /api/cliente/{id}
     * Get single client detail with active programs and stats
     */
    public function getClienteDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->select('cliente.*, persona.cedula, persona.apellidos, persona.nombres, persona.fechanacimiento, persona.idsexo, sexo.nombre AS sexo_nombre')
                                ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                                ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                                ->where('cliente.idcliente', $id)
                                ->first();

        if (!$cliente) {
            return $this->failNotFound("Cliente no encontrado con ID: {$id}");
        }

        $progModel = new ProgramaClienteModel();
        $programas = $progModel->select('programacliente.*, programaentrenamiento.nombre as programa_nombre, motivoentrenamiento.nombre as motivo_nombre, estadoprogramacliente.nombre as estado_nombre')
                               ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                               ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                               ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                               ->where('programacliente.idcliente', $id)
                               ->orderBy('programacliente.idprogramacliente', 'DESC')
                               ->findAll();

        $visitasModel = new VisitasGimModel();
        $ultimasVisitas = $visitasModel->where('idcliente', $id)
                                       ->orderBy('fecha', 'DESC')
                                       ->orderBy('horaingreso', 'DESC')
                                       ->findAll(5);

        $db = \Config\Database::connect();
        $ultimosEjercicios = $db->table('programacliente pc')
                                ->select('ejercicio.idejercicio, ejercicio.nombreespanol AS ejercicio_nombre, ejercicio.nombreespanol, ejercicio.nombreingles, ejercicio.imagen AS ejercicio_imagen, plane.series, plane.repeticiones, plane.peso, plane.tiempodescanso, rutina.nombre AS rutina_nombre, prog.nombre AS programa_nombre')
                                ->join('programaentrenamiento prog', 'prog.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                                ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = prog.idprogramaentrenamiento', 'inner')
                                ->join('rutinaejecicio rutina', 'rutina.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                                ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rutina.idrutinaejercicio', 'inner')
                                ->join('planejercicio plane', 'plane.idplanejercicio = rpl.idplanejercicio', 'inner')
                                ->join('ejercicio', 'ejercicio.idejercicio = plane.idejercicio', 'inner')
                                ->where('pc.idcliente', (int)$id)
                                ->groupBy('ejercicio.idejercicio, plane.idplanejercicio')
                                ->limit(5)
                                ->get()
                                ->getResultArray();

        foreach ($ultimosEjercicios as &$ue) {
            $ue['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ue['ejercicio_imagen'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del cliente obtenido correctamente',
            'data'    => [
                'cliente'            => $cliente,
                'programas'          => $programas,
                'ultimas_visitas'    => $ultimasVisitas,
                'ultimos_ejercicios' => $ultimosEjercicios,
            ],
        ]);
    }

    /**
     * GET /api/cliente/{id}/programas
     * Programs assigned to a client with all routines and exercise details
     */
    public function getClienteProgramas($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $progModel = new ProgramaClienteModel();
        $programas = $progModel->select('programacliente.*, programaentrenamiento.nombre as programa_nombre, motivoentrenamiento.nombre as motivo_nombre, motivoentrenamiento.objetivo as motivo_objetivo, estadoprogramacliente.nombre as estado_nombre, rangoedad.nombre as rango_nombre, rangoedad.edadminima as rango_edadminima, rangoedad.edadmaxima as rango_edadmaxima')
                               ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                               ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                               ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                               ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                               ->where('programacliente.idcliente', $id)
                               ->orderBy('programacliente.fechainicio', 'DESC')
                               ->findAll();

        $rutinaProgModel = new RutinaProgramaModel();
        $rutinaPersModel = new \App\Models\RutinaPersonalizadaModel();
        $db = \Config\Database::connect();

        foreach ($programas as &$prog) {
            $idProgPersonalizado = !empty($prog['idprogramapersonalizado']) ? (int)$prog['idprogramapersonalizado'] : null;
            $idProgEntrenamiento = (int)$prog['idprogramaentrenamiento'];
            $idProgCliente = (int)$prog['idprogramacliente'];

            if ($idProgPersonalizado) {
                $rutinas = $rutinaPersModel->getRutinasByProgramaPersonalizado($idProgPersonalizado);
            } else {
                $rutinas = $rutinaProgModel->getRutinasByPrograma($idProgEntrenamiento);
            }

            // Enhance exercises with image URL and musculo/equipo
            foreach ($rutinas as &$rutina) {
                if (!empty($rutina['planes'])) {
                    foreach ($rutina['planes'] as &$plan) {
                        if (!empty($plan['ejercicio_imagen'])) {
                            $plan['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $plan['ejercicio_imagen']);
                        } else {
                            $plan['imagen_url'] = null;
                        }
                    }
                }
            }

            $prog['rutinas'] = $rutinas;
            $prog['total_ejecuciones'] = $db->table('ejecucionprograma')
                                            ->where('idprogramacliente', $idProgCliente)
                                            ->countAllResults();
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Programas del cliente obtenidos correctamente',
            'data'    => $programas,
            'total'   => count($programas),
        ]);
    }

    /**
     * GET /api/programas
     * List all training programs
     */
    public function getProgramas()
    {
        $progModel = new ProgramaEntrenamientoModel();
        $programas = $progModel->getProgramasWithDetails($this->request->getGet('q'));

        return $this->respond([
            'status'  => 200,
            'message' => 'Programas obtenidos correctamente',
            'data'    => $programas,
            'total'   => count($programas),
        ]);
    }

    /**
     * GET /api/programa/{id}
     * Get single training program with all routines and exercise plans
     */
    public function getProgramaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de programa no proporcionado');
        }

        $progModel = new ProgramaEntrenamientoModel();
        $programa = $progModel->getProgramaWithDetails($id);
        if (!$programa) {
            return $this->failNotFound("Programa no encontrado con ID: {$id}");
        }

        $rutinaProgModel = new RutinaProgramaModel();
        $rutinas = $rutinaProgModel->getRutinasByPrograma((int)$id);
        $baseUrl = base_url();

        foreach ($rutinas as &$rutina) {
            if (!empty($rutina['planes'])) {
                foreach ($rutina['planes'] as &$plan) {
                    if (!empty($plan['ejercicio_imagen'])) {
                        $plan['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $plan['ejercicio_imagen']);
                    } else {
                        $plan['imagen_url'] = null;
                    }
                }
            }
        }

        $programa['rutinas'] = $rutinas;

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del programa obtenido correctamente',
            'data'    => $programa,
        ]);
    }

    /**
     * GET /api/rutinas
     * List all routines
     */
    public function getRutinas()
    {
        $rutinaModel = new RutinaEjecicioModel();
        $rutinas = $rutinaModel->getRutinas($this->request->getGet('q'));

        $rutinaPlanModel = new RutinaPlanModel();
        foreach ($rutinas as &$rutina) {
            $idrutina = (int)$rutina['idrutinaejercicio'];
            $planes = $rutinaPlanModel->getPlanesByRutina($idrutina);
            $rutina['total_ejercicios'] = count($planes);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Rutinas obtenidas correctamente',
            'data'    => $rutinas,
            'total'   => count($rutinas),
        ]);
    }

    /**
     * GET /api/rutina/{id}
     * Routine detail with exercise plans
     */
    public function getRutinaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de rutina no proporcionado');
        }

        $rutinaModel = new RutinaEjecicioModel();
        $rutina = $rutinaModel->find($id);
        if (!$rutina) {
            return $this->failNotFound("Rutina no encontrada con ID: {$id}");
        }

        $rutinaPlanModel = new RutinaPlanModel();
        $planes = $rutinaPlanModel->getPlanesByRutina((int)$id);
        $baseUrl = base_url();

        foreach ($planes as &$plan) {
            if (!empty($plan['ejercicio_imagen'])) {
                $plan['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $plan['ejercicio_imagen']);
            } else {
                $plan['imagen_url'] = null;
            }
        }

        $rutina['planes'] = $planes;

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle de la rutina obtenido correctamente',
            'data'    => $rutina,
        ]);
    }

    /**
     * GET /api/ejercicios
     * Exercise catalog with search, filter, pagination
     */
    public function getEjercicios()
    {
        $search = $this->request->getGet('q');
        $idmusculo = $this->request->getGet('idmusculo');
        $idequipo = $this->request->getGet('idequipo');
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 25);
        $offset = ($page - 1) * $limit;

        $ejercicioModel = new EjercicioModel();
        $builder = $ejercicioModel->select('ejercicio.*, ejercicio.nombreespanol AS nombre');

        if (!empty($idmusculo)) {
            $builder->join('musculoejercicio', 'musculoejercicio.idejercicio = ejercicio.idejercicio', 'inner')
                    ->where('musculoejercicio.idmusculo', (int)$idmusculo);
        }

        if (!empty($idequipo)) {
            $builder->join('ejercicioequipo', 'ejercicioequipo.idejercicio = ejercicio.idejercicio', 'inner')
                    ->where('ejercicioequipo.idequipo', (int)$idequipo);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ejercicio.nombreespanol', $search)
                    ->orLike('ejercicio.nombreingles', $search)
                    ->orLike('ejercicio.descripcion', $search)
                    ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $ejercicios = $builder->orderBy('ejercicio.nombreespanol', 'ASC')
                              ->limit($limit, $offset)
                              ->get()
                              ->getResultArray();

        $baseUrl = base_url();
        foreach ($ejercicios as &$ej) {
            if (!empty($ej['imagen'])) {
                $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['imagen']);
            } else {
                $ej['imagen_url'] = null;
            }
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejercicios obtenidos correctamente',
            'data'    => $ejercicios,
            'total'   => $total,
            'page'    => $page,
            'limit'   => $limit,
        ]);
    }

    /**
     * GET /api/ejercicio/{id}
     * Exercise detail with muscles and equipment
     */
    public function getEjercicioDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de ejercicio no proporcionado');
        }

        $ejercicioModel = new EjercicioModel();
        $ejercicio = $ejercicioModel->find($id);
        if (!$ejercicio) {
            return $this->failNotFound("Ejercicio no encontrado con ID: {$id}");
        }

        $baseUrl = base_url();
        $ejercicio['nombre'] = $ejercicio['nombreespanol'] ?? '';
        $ejercicio['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ejercicio['imagen'] ?? null);
        $ejercicio['musculos'] = $ejercicioModel->getMusculos((int)$id);
        $ejercicio['equipos'] = $ejercicioModel->getEquipos((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejercicio obtenido correctamente',
            'data'    => $ejercicio,
        ]);
    }

    /**
     * GET /api/musculos
     */
    public function getMusculos()
    {
        $musculoModel = new MusculoModel();
        $musculos = $musculoModel->getMusculos($this->request->getGet('q'));
        $baseUrl = base_url();

        foreach ($musculos as &$m) {
            $m['imagen_url'] = $this->getImageUrl('musculo/imagen', $m['imagen'] ?? null);
        }

        return $this->respond([
            'status' => 200,
            'data'   => $musculos,
        ]);
    }

    /**
     * GET /api/equipos
     */
    public function getEquipos()
    {
        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->getEquiposWithDetails($this->request->getGet('q'));
        $baseUrl = base_url();

        foreach ($equipos as &$eq) {
            $eq['imagen_url'] = $this->getImageUrl('equipos/imagen', $eq['imagen'] ?? null);
        }

        return $this->respond([
            'status' => 200,
            'data'   => $equipos,
        ]);
    }

    /**
     * GET /api/cliente/{id}/visitas
     */
    public function getClienteVisitas($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $visitasModel = new VisitasGimModel();
        $visitas = $visitasModel->getVisitasByCliente((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Visitas obtenidas correctamente',
            'data'    => $visitas,
            'total'   => count($visitas),
        ]);
    }

    /**
     * POST /api/visitas
     * Register a new gym visit (check-in)
     */
    public function registrarVisita()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $rules = [
            'idcliente'   => 'required|is_natural_no_zero',
            'fecha'       => 'required|valid_date[Y-m-d]',
            'horaingreso' => 'required',
            'horasalida'  => 'permit_empty',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $visitasModel = new VisitasGimModel();
        $data = [
            'idcliente'   => (int)$input['idcliente'],
            'fecha'       => $input['fecha'],
            'horaingreso' => $input['horaingreso'],
            'horasalida'  => !empty($input['horasalida']) ? $input['horasalida'] : null,
        ];

        $id = $visitasModel->insert($data);
        if (!$id) {
            return $this->failServerError('No se pudo registrar la visita.');
        }

        $created = $visitasModel->getVisitaWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Visita al gimnasio registrada correctamente',
            'data'    => $created,
        ]);
    }

    /**
     * POST /api/visitas/{id}/checkout
     * Register check-out time for a gym visit
     */
    public function checkoutVisita($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de visita no proporcionado');
        }

        $visitasModel = new VisitasGimModel();
        $visita = $visitasModel->find($id);
        if (!$visita) {
            return $this->failNotFound("Visita no encontrada con ID: {$id}");
        }

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $horasalida = !empty($input['horasalida']) ? $input['horasalida'] : date('H:i:s');

        $visitasModel->update($id, ['horasalida' => $horasalida]);
        $updated = $visitasModel->getVisitaWithDetails($id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Salida del gimnasio registrada correctamente',
            'data'    => $updated,
        ]);
    }

    /**
     * GET /api/cliente/{id}/ejercicios
     * Get exercises prescribed for client through their assigned training programs
     */
    public function getClienteEjercicios($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);
        if (!$cliente) {
            return $this->failNotFound("Cliente no encontrado con ID: {$id}");
        }

        $db = \Config\Database::connect();
        $pcs = $db->table('programacliente pc')
                  ->where('pc.idcliente', (int)$id)
                  ->orderBy('pc.idprogramacliente', 'DESC')
                  ->get()
                  ->getResultArray();

        $rutinaPersModel = new \App\Models\RutinaPersonalizadaModel();
        $rutinaProgModel = new RutinaProgramaModel();
        $ejercicios = [];

        foreach ($pcs as $pc) {
            $idProgPers = !empty($pc['idprogramapersonalizado']) ? (int)$pc['idprogramapersonalizado'] : null;
            if ($idProgPers) {
                $rutinas = $rutinaPersModel->getRutinasByProgramaPersonalizado($idProgPers);
            } else {
                $rutinas = $rutinaProgModel->getRutinasByPrograma((int)$pc['idprogramaentrenamiento']);
            }
            foreach ($rutinas as $r) {
                if (!empty($r['planes'])) {
                    foreach ($r['planes'] as $pl) {
                        $ejercicios[] = [
                            'idejercicio'            => (int)$pl['idejercicio'],
                            'ejercicio_nombre'       => $pl['ejercicio_nombre'] ?? ($pl['nombre'] ?? ''),
                            'nombreespanol'          => $pl['nombreespanol'] ?? ($pl['ejercicio_nombre'] ?? ''),
                            'nombreingles'           => $pl['nombreingles'] ?? '',
                            'descripcion'            => $pl['descripcion'] ?? ($pl['ejercicio_descripcion'] ?? ''),
                            'ejercicio_imagen'       => $pl['ejercicio_imagen'] ?? null,
                            'imagen_url'             => $this->getImageUrl('ejercicio/imagen', $pl['ejercicio_imagen'] ?? null),
                            'urlvideo'               => $pl['urlvideo'] ?? ($pl['ejercicio_urlvideo'] ?? ''),
                            'idplanejercicio'        => (int)($pl['idplanejercicio'] ?? $pl['idplanpersonalizado']),
                            'diassemanas'            => $pl['diassemanas'] ?? null,
                            'repeticiones'           => $pl['repeticiones'] ?? null,
                            'series'                 => $pl['series'] ?? null,
                            'tiempodescanso'         => $pl['tiempodescanso'] ?? null,
                            'peso'                   => $pl['peso'] ?? null,
                            'idrutinaejercicio'      => (int)($r['idrutinaejercicio'] ?? $r['idrutinapersonalizada']),
                            'rutina_nombre'          => $r['rutina_nombre'] ?? ($r['nombre'] ?? ''),
                            'idprogramaentrenamiento'=> (int)$pc['idprogramaentrenamiento'],
                            'idprogramacliente'      => (int)$pc['idprogramacliente'],
                        ];
                    }
                }
            }
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejercicios asignados al cliente obtenidos a través de su programa de entrenamiento',
            'data'    => $ejercicios,
            'total'   => count($ejercicios),
        ]);
    }

    /**
     * GET /api/ejecucionprograma
     * List all program executions
     */
    public function getEjecuciones()
    {
        $ejecModel = new EjecucionProgramaModel();
        $ejecuciones = $ejecModel->getEjecucionesWithDetails($this->request->getGet('q'));

        foreach ($ejecuciones as &$e) {
            $e['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $e['ejercicio_imagen'] ?? null);
            $e['duracionminutos'] = $this->calcMinutes($e['horainicio'] ?? null, $e['horafin'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejecuciones de programa obtenidas correctamente',
            'data'    => $ejecuciones,
            'total'   => count($ejecuciones),
        ]);
    }

    /**
     * GET /api/cliente/{id}/ejecuciones
     * List all exercise executions for a specific client
     */
    public function getClienteEjecuciones($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $db = \Config\Database::connect();
        $ejecuciones = $db->table('ejecucionprograma ep')
                          ->select('ep.*,
                                    pc.idcliente,
                                    pc.idprogramaentrenamiento,
                                    prog.nombre AS programa_nombre,
                                    ejercicio.nombreespanol AS ejercicio_nombre,
                                    ejercicio.nombreespanol,
                                    ejercicio.nombreingles,
                                    ejercicio.imagen AS ejercicio_imagen')
                          ->join('programacliente pc', 'pc.idprogramacliente = ep.idprogramacliente', 'inner')
                          ->join('programaentrenamiento prog', 'prog.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                          ->join('ejercicio', 'ejercicio.idejercicio = ep.idejercicio', 'inner')
                          ->where('pc.idcliente', (int)$id)
                          ->orderBy('ep.fecha', 'DESC')
                          ->orderBy('ep.horainicio', 'DESC')
                          ->orderBy('ep.idejecucionprograma', 'DESC')
                          ->get()
                          ->getResultArray();

        foreach ($ejecuciones as &$e) {
            $e['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $e['ejercicio_imagen'] ?? null);
            $e['duracionminutos'] = $this->calcMinutes($e['horainicio'] ?? null, $e['horafin'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejecuciones del cliente obtenidas correctamente',
            'data'    => $ejecuciones,
            'total'   => count($ejecuciones),
        ]);
    }

    /**
     * POST /api/ejecucionprograma (also aliased at /api/ejercicios-cliente)
     * Record a completed or started exercise execution in ejecucionprograma
     */
    public function registrarEjecucionPrograma()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $idProgramaCliente = !empty($input['idprogramacliente']) ? (int)$input['idprogramacliente'] : 0;
        $idCliente = !empty($input['idcliente']) ? (int)$input['idcliente'] : 0;
        $idEjercicio = !empty($input['idejercicio']) ? (int)$input['idejercicio'] : 0;

        if ($idEjercicio <= 0) {
            return $this->failValidationErrors(['idejercicio' => 'Debe seleccionar un ejercicio válido.']);
        }

        $db = \Config\Database::connect();

        // Resolve idprogramacliente if only idcliente was passed
        if ($idProgramaCliente <= 0 && $idCliente > 0) {
            $activeRow = $db->table('programacliente pc')
                            ->join('estadoprogramacliente epc', 'epc.idestadoprogramacliente = pc.idestadoprogramacliente', 'left')
                            ->where('pc.idcliente', $idCliente)
                            ->orderBy('epc.nombre = "Activo"', 'DESC', false)
                            ->orderBy('pc.idprogramacliente', 'DESC')
                            ->get()
                            ->getRowArray();

            if ($activeRow) {
                $idProgramaCliente = (int)$activeRow['idprogramacliente'];
            } else {
                // Auto-assign first available training program if client has none yet
                $firstProg = $db->table('programaentrenamiento')->orderBy('idprogramaentrenamiento', 'ASC')->get()->getRowArray();
                if ($firstProg) {
                    $progClienteModel = new ProgramaClienteModel();
                    $idProgramaCliente = (int)$progClienteModel->insert([
                        'idcliente'               => $idCliente,
                        'idprogramaentrenamiento' => (int)$firstProg['idprogramaentrenamiento'],
                        'fechainicio'             => date('Y-m-d'),
                        'idestadoprogramacliente' => 1,
                    ]);
                }
            }
        }

        if ($idProgramaCliente <= 0) {
            return $this->failValidationErrors(['idprogramacliente' => 'El cliente no tiene un programa asignado para registrar la ejecución.']);
        }

        $fecha = !empty($input['fecha']) ? $input['fecha'] : date('Y-m-d');
        $duracionMinutos = !empty($input['duracionminutos']) ? max(1, (int)$input['duracionminutos']) : 5;

        if (!empty($input['horainicio'])) {
            $horaInicio = $input['horainicio'];
            $horaFin = !empty($input['horafin']) ? $input['horafin'] : null;
        } else {
            $nowTs = time();
            $horaFin = date('H:i:s', $nowTs);
            $horaInicio = date('H:i:s', $nowTs - ($duracionMinutos * 60));
        }

        $ejecModel = new EjecucionProgramaModel();
        $id = $ejecModel->insert([
            'idprogramacliente' => $idProgramaCliente,
            'idejercicio'       => $idEjercicio,
            'fecha'             => $fecha,
            'horainicio'        => $horaInicio,
            'horafin'           => $horaFin,
        ]);

        if (!$id) {
            return $this->failServerError('No se pudo registrar la ejecución del ejercicio.');
        }

        $created = $ejecModel->getEjecucionWithDetails($id);
        if ($created) {
            $created['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $created['ejercicio_imagen'] ?? null);
            $created['duracionminutos'] = $this->calcMinutes($created['horainicio'] ?? null, $created['horafin'] ?? null);
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Ejecución de ejercicio registrada correctamente',
            'data'    => $created,
        ]);
    }

    /**
     * POST /api/ejecucionprograma/{id}/finalizar
     */
    public function finalizarEjecucionPrograma($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de ejecución no proporcionado');
        }

        $ejecModel = new EjecucionProgramaModel();
        $item = $ejecModel->find($id);
        if (!$item) {
            return $this->failNotFound("Ejecución no encontrada con ID: {$id}");
        }

        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $horaFin = !empty($input['horafin']) ? $input['horafin'] : date('H:i:s');

        $ejecModel->update($id, ['horafin' => $horaFin]);
        $updated = $ejecModel->getEjecucionWithDetails($id);
        if ($updated) {
            $updated['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $updated['ejercicio_imagen'] ?? null);
            $updated['duracionminutos'] = $this->calcMinutes($updated['horainicio'] ?? null, $updated['horafin'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejecución de ejercicio finalizada correctamente',
            'data'    => $updated,
        ]);
    }

    /**
     * POST /api/programacliente
     * Assign a training program to a client
     */
    public function asignarProgramaCliente()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $idCliente = !empty($input['idcliente']) ? (int)$input['idcliente'] : 0;
        $idPrograma = !empty($input['idprogramaentrenamiento']) ? (int)$input['idprogramaentrenamiento'] : 0;
        $fechaInicio = !empty($input['fechainicio']) ? $input['fechainicio'] : date('Y-m-d');
        $idEstado = !empty($input['idestadoprogramacliente']) ? (int)$input['idestadoprogramacliente'] : 1;

        if ($idCliente <= 0 || $idPrograma <= 0) {
            return $this->failValidationErrors('Debe proporcionar idcliente e idprogramaentrenamiento válidos.');
        }

        $progClienteModel = new ProgramaClienteModel();

        // Particularizar: clonar el programa modelo hacia las tablas personalizadas del cliente
        try {
            $idProgPersonalizado = $progClienteModel->clonarProgramaModeloACliente($idPrograma, $idCliente);
        } catch (\Exception $e) {
            return $this->failServerError('Error al particularizar el programa de entrenamiento: ' . $e->getMessage());
        }

        $id = $progClienteModel->insert([
            'idcliente'               => $idCliente,
            'idprogramaentrenamiento' => $idPrograma,
            'idprogramapersonalizado' => $idProgPersonalizado,
            'fechainicio'             => $fechaInicio,
            'idestadoprogramacliente' => $idEstado,
        ]);

        if (!$id) {
            return $this->failServerError('No se pudo asignar el programa al cliente.');
        }

        $created = $progClienteModel->getProgramaClienteWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Programa de entrenamiento particularizado y asignado correctamente al cliente',
            'data'    => $created,
        ]);
    }

    protected function calcMinutes(?string $horaInicio, ?string $horaFin): int
    {
        if (empty($horaInicio)) {
            return 5;
        }
        if (empty($horaFin)) {
            return 5;
        }
        $t1 = strtotime($horaInicio);
        $t2 = strtotime($horaFin);
        if ($t1 === false || $t2 === false) {
            return 5;
        }
        $diff = (int)round(($t2 - $t1) / 60);
        return $diff > 0 ? $diff : 5;
    }

    /**
     * GET /api/cliente/{id}/progreso
     * Comprehensive progress, effort metrics and statistics for client
     */
    public function getClienteProgreso($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->find($id);
        if (!$cliente) {
            return $this->failNotFound("Cliente no encontrado con ID: {$id}");
        }

        $db = \Config\Database::connect();
        $idCliente = (int)$id;

        // Total visits to gym
        $visitasCount = $db->table('visitasgim')
                           ->where('idcliente', $idCliente)
                           ->countAllResults();

        // Total executions in ejecucionprograma
        $ejecucionesRows = $db->table('ejecucionprograma ep')
                              ->select('ep.*,
                                        prog.nombre AS programa_nombre,
                                        ejercicio.nombreespanol AS ejercicio_nombre,
                                        ejercicio.nombreespanol,
                                        ejercicio.nombreingles,
                                        ejercicio.imagen AS ejercicio_imagen')
                              ->join('programacliente pc', 'pc.idprogramacliente = ep.idprogramacliente', 'inner')
                              ->join('programaentrenamiento prog', 'prog.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                              ->join('ejercicio', 'ejercicio.idejercicio = ep.idejercicio', 'inner')
                              ->where('pc.idcliente', $idCliente)
                              ->orderBy('ep.fecha', 'DESC')
                              ->orderBy('ep.horainicio', 'DESC')
                              ->orderBy('ep.idejecucionprograma', 'DESC')
                              ->get()
                              ->getResultArray();

        $totalEjecuciones = count($ejecucionesRows);
        $totalMinutosEjecucion = 0;
        $fechasEntrenadasSet = [];

        foreach ($ejecucionesRows as &$er) {
            $mins = $this->calcMinutes($er['horainicio'] ?? null, $er['horafin'] ?? null);
            $er['duracionminutos'] = $mins;
            $er['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $er['ejercicio_imagen'] ?? null);
            $totalMinutosEjecucion += $mins;
            if (!empty($er['fecha'])) {
                $fechasEntrenadasSet[$er['fecha']] = true;
            }
        }

        // Also include dates and minutes from visitasgim
        $visitasRows = $db->table('visitasgim')
                          ->where('idcliente', $idCliente)
                          ->get()
                          ->getResultArray();
        $totalMinutosVisitas = 0;
        foreach ($visitasRows as $vr) {
            if (!empty($vr['fecha'])) {
                $fechasEntrenadasSet[$vr['fecha']] = true;
            }
            if (!empty($vr['horaingreso']) && !empty($vr['horasalida'])) {
                $totalMinutosVisitas += $this->calcMinutes($vr['horaingreso'], $vr['horasalida']);
            }
        }

        $diasEntrenados = count($fechasEntrenadasSet);
        $totalMinutos = $totalMinutosEjecucion > 0 ? $totalMinutosEjecucion : $totalMinutosVisitas;

        // Visits & Executions in the last 7 days and 30 days
        $hace7Dias = date('Y-m-d', strtotime('-7 days'));
        $hace30Dias = date('Y-m-d', strtotime('-30 days'));

        $visitas7d = $db->table('visitasgim')
                        ->where('idcliente', $idCliente)
                        ->where('fecha >=', $hace7Dias)
                        ->countAllResults();
        $ejec7d = $db->table('ejecucionprograma ep')
                     ->join('programacliente pc', 'pc.idprogramacliente = ep.idprogramacliente', 'inner')
                     ->where('pc.idcliente', $idCliente)
                     ->where('ep.fecha >=', $hace7Dias)
                     ->countAllResults();
        $sesiones7Dias = max($visitas7d, $ejec7d);

        $visitas30d = $db->table('visitasgim')
                         ->where('idcliente', $idCliente)
                         ->where('fecha >=', $hace30Dias)
                         ->countAllResults();
        $ejec30d = $db->table('ejecucionprograma ep')
                      ->join('programacliente pc', 'pc.idprogramacliente = ep.idprogramacliente', 'inner')
                      ->where('pc.idcliente', $idCliente)
                      ->where('ep.fecha >=', $hace30Dias)
                      ->countAllResults();
        $sesiones30Dias = max($visitas30d, $ejec30d);

        // History grouped by date (last 14 days) combining ejecucionprograma and visitasgim
        $hace14Dias = date('Y-m-d', strtotime('-14 days'));
        $dailyMap = [];

        foreach ($ejecucionesRows as $er) {
            $f = $er['fecha'] ?? '';
            if ($f >= $hace14Dias) {
                if (!isset($dailyMap[$f])) {
                    $dailyMap[$f] = ['fecha' => $f, 'visitas' => 0, 'ejercicios' => 0, 'minutos' => 0];
                }
                $dailyMap[$f]['ejercicios'] += 1;
                $dailyMap[$f]['minutos'] += (int)$er['duracionminutos'];
            }
        }

        foreach ($visitasRows as $vr) {
            $f = $vr['fecha'] ?? '';
            if ($f >= $hace14Dias) {
                if (!isset($dailyMap[$f])) {
                    $dailyMap[$f] = ['fecha' => $f, 'visitas' => 0, 'ejercicios' => 0, 'minutos' => 0];
                }
                $dailyMap[$f]['visitas'] += 1;
                if ($dailyMap[$f]['minutos'] == 0) {
                    $dailyMap[$f]['minutos'] += !empty($vr['horasalida'])
                        ? $this->calcMinutes($vr['horaingreso'], $vr['horasalida'])
                        : 45;
                }
            }
        }

        ksort($dailyMap);
        $historialDiario = array_values($dailyMap);

        // Total exercises in assigned programs
        $ejRow = $db->table('programacliente pc')
                    ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento')
                    ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rp.idrutinaejercicio')
                    ->join('planejercicio pe', 'pe.idplanejercicio = rpl.idplanejercicio')
                    ->where('pc.idcliente', $idCliente)
                    ->select('COUNT(DISTINCT pe.idejercicio) as total')
                    ->get()
                    ->getRowArray();
        $totalEjerciciosAsignados = (int)($ejRow['total'] ?? 0);

        // Muscles targeted in assigned programs
        $musculosTrabajados = $db->table('programacliente pc')
                                 ->select('musculo.nombre as musculo, COUNT(DISTINCT ejercicio.idejercicio) as veces')
                                 ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                                 ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                                 ->join('planejercicio plane', 'plane.idplanejercicio = rpl.idplanejercicio', 'inner')
                                 ->join('ejercicio', 'ejercicio.idejercicio = plane.idejercicio', 'inner')
                                 ->join('musculoejercicio', 'musculoejercicio.idejercicio = ejercicio.idejercicio', 'inner')
                                 ->join('musculo', 'musculo.idmusculo = musculoejercicio.idmusculo', 'inner')
                                 ->where('pc.idcliente', $idCliente)
                                 ->groupBy('musculo.idmusculo, musculo.nombre')
                                 ->orderBy('veces', 'DESC')
                                 ->limit(6)
                                 ->get()
                                 ->getResultArray();

        // Exercises assigned through current programs
        $ejerciciosAsignados = $db->table('programacliente pc')
                                  ->select('pc.idprogramacliente, pc.fechainicio AS fecha, ejercicio.idejercicio, ejercicio.nombreespanol AS ejercicio_nombre, ejercicio.nombreespanol, ejercicio.nombreingles, ejercicio.imagen AS ejercicio_imagen, plane.series, plane.repeticiones, plane.peso, plane.tiempodescanso, rutina.nombre AS rutina_nombre, prog.nombre AS programa_nombre')
                                  ->join('programaentrenamiento prog', 'prog.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                                  ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                                  ->join('rutinaejecicio rutina', 'rutina.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                                  ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rutina.idrutinaejercicio', 'inner')
                                  ->join('planejercicio plane', 'plane.idplanejercicio = rpl.idplanejercicio', 'inner')
                                  ->join('ejercicio', 'ejercicio.idejercicio = plane.idejercicio', 'inner')
                                  ->where('pc.idcliente', $idCliente)
                                  ->groupBy('ejercicio.idejercicio, plane.idplanejercicio')
                                  ->limit(10)
                                  ->get()
                                  ->getResultArray();

        foreach ($ejerciciosAsignados as &$r) {
            $r['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $r['ejercicio_imagen'] ?? null);
            $r['duracionminutos'] = (int)($r['series'] ?? 3) * 3;
        }

        // Active training program summary
        $progModel = new ProgramaClienteModel();
        $programaActivo = $progModel->select('programacliente.*, programaentrenamiento.nombre as programa_nombre, motivoentrenamiento.nombre as motivo_nombre, estadoprogramacliente.nombre as estado_nombre, rangoedad.nombre as rango_nombre, rangoedad.edadminima as rango_edadminima, rangoedad.edadmaxima as rango_edadmaxima')
                                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                                    ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                                    ->where('programacliente.idcliente', $idCliente)
                                    ->where('estadoprogramacliente.nombre', 'Activo')
                                    ->orderBy('programacliente.idprogramacliente', 'DESC')
                                    ->first();

        $ejecucionesRecientes = array_slice($ejecucionesRows, 0, 15);
        $recientesFinal = !empty($ejecucionesRecientes) ? $ejecucionesRecientes : $ejerciciosAsignados;

        return $this->respond([
            'status'  => 200,
            'message' => 'Estadísticas de progreso y esfuerzo calculadas correctamente',
            'data'    => [
                'total_sesiones'        => $totalEjecuciones > 0 ? $totalEjecuciones : $totalEjerciciosAsignados,
                'total_ejecuciones'     => $totalEjecuciones,
                'total_minutos'         => $totalMinutos,
                'total_visitas_gim'     => $visitasCount,
                'total_ejercicios'      => $totalEjerciciosAsignados,
                'dias_entrenados'       => $diasEntrenados,
                'sesiones_ultimos_7d'   => $sesiones7Dias,
                'sesiones_ultimos_30d'  => $sesiones30Dias,
                'historial_diario'      => $historialDiario,
                'musculos_trabajados'   => $musculosTrabajados,
                'programa_activo'       => $programaActivo,
                'ejecuciones_recientes' => $ejecucionesRecientes,
                'ejercicios_recientes'  => $recientesFinal,
            ],
        ]);
    }

    /**
     * POST /api/rutina/{id}/plan o POST /api/rutina/plan
     * Agrega un nuevo plan de ejercicio a una rutina
     */
    public function agregarPlanRutina($idRutinaParam = null)
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $idRutina = !empty($idRutinaParam) ? (int)$idRutinaParam : (!empty($input['idrutinaejercicio']) ? (int)$input['idrutinaejercicio'] : 0);
        $idEjercicio = !empty($input['idejercicio']) ? (int)$input['idejercicio'] : 0;

        if ($idRutina <= 0 || $idEjercicio <= 0) {
            return $this->failValidationErrors('Debe especificar un ID de rutina válido y un ID de ejercicio válido.');
        }

        $ejercicioModel = new EjercicioModel();
        $ejercicio = $ejercicioModel->find($idEjercicio);
        if (!$ejercicio) {
            return $this->failNotFound("Ejercicio no encontrado con ID: {$idEjercicio}");
        }

        $nombreEj = !empty($ejercicio['nombreespanol']) ? $ejercicio['nombreespanol'] : ($ejercicio['nombreingles'] ?? 'Ejercicio');
        $nombrePlan = !empty($input['nombre']) ? trim($input['nombre']) : "Plan {$nombreEj}";
        if (mb_strlen($nombrePlan) < 3) {
            $nombrePlan = "Plan {$nombreEj}";
        }
        if (mb_strlen($nombrePlan) > 100) {
            $nombrePlan = mb_substr($nombrePlan, 0, 100);
        }

        $series = isset($input['series']) && $input['series'] !== '' ? (int)$input['series'] : 3;
        $repeticiones = isset($input['repeticiones']) && $input['repeticiones'] !== '' ? (int)$input['repeticiones'] : 12;
        $diassemanas = isset($input['diassemanas']) && $input['diassemanas'] !== '' ? (int)$input['diassemanas'] : 3;
        $tiempodescanso = isset($input['tiempodescanso']) && $input['tiempodescanso'] !== '' ? (int)$input['tiempodescanso'] : 60;
        $peso = isset($input['peso']) && $input['peso'] !== '' ? (float)$input['peso'] : 0.0;

        // 1. Verificar si la rutina es una rutina personalizada de cliente
        $rutinaPersModel = new \App\Models\RutinaPersonalizadaModel();
        $rutinaPers = $rutinaPersModel->find($idRutina);
        if ($rutinaPers) {
            $planPersModel = new \App\Models\PlanPersonalizadoModel();
            $idPlan = $planPersModel->insert([
                'nombre'         => $nombrePlan,
                'idejercicio'    => $idEjercicio,
                'diassemanas'    => $diassemanas > 0 ? $diassemanas : 3,
                'repeticiones'   => $repeticiones > 0 ? $repeticiones : 12,
                'series'         => $series > 0 ? $series : 3,
                'tiempodescanso' => $tiempodescanso >= 0 ? $tiempodescanso : 60,
                'peso'           => $peso >= 0 ? $peso : 0.0,
            ]);

            if (!$idPlan) {
                return $this->failServerError('Error al crear el plan personalizado: ' . json_encode($planPersModel->errors()));
            }

            $rplpModel = new \App\Models\RutinaPlanPersonalizadoModel();
            $idRutinaPlan = $rplpModel->insert([
                'idrutinapersonalizada' => $idRutina,
                'idplanpersonalizado'   => $idPlan,
            ]);

            $nuevoPlan = $planPersModel->getPlanWithDetails($idPlan);
            $nuevoPlan['id_rutina_plan'] = $idRutinaPlan;
            $nuevoPlan['idrutinaejercicio'] = $idRutina;
            $nuevoPlan['rutina_nombre'] = $rutinaPers['nombre'];
            if (!empty($nuevoPlan['ejercicio_imagen'])) {
                $nuevoPlan['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $nuevoPlan['ejercicio_imagen']);
            }

            return $this->respondCreated([
                'status'  => 201,
                'message' => 'Ejercicio agregado exitosamente a la rutina personalizada',
                'data'    => $nuevoPlan,
            ]);
        }

        // 2. Si no es personalizada, es una rutina modelo estándar
        $rutinaModel = new RutinaEjecicioModel();
        $rutina = $rutinaModel->find($idRutina);
        if (!$rutina) {
            return $this->failNotFound("Rutina no encontrada con ID: {$idRutina}");
        }

        $planModel = new PlanEjercicioModel();
        $idPlan = $planModel->insert([
            'nombre'         => $nombrePlan,
            'idejercicio'    => $idEjercicio,
            'diassemanas'    => $diassemanas > 0 ? $diassemanas : 3,
            'repeticiones'   => $repeticiones > 0 ? $repeticiones : 12,
            'series'         => $series > 0 ? $series : 3,
            'tiempodescanso' => $tiempodescanso >= 0 ? $tiempodescanso : 60,
            'peso'           => $peso >= 0 ? $peso : 0.0,
        ]);

        if (!$idPlan) {
            return $this->failServerError('Error al crear el plan de ejercicio: ' . json_encode($planModel->errors()));
        }

        $rutinaPlanModel = new RutinaPlanModel();
        $idRutinaPlan = $rutinaPlanModel->insert([
            'idrutinaejercicio' => $idRutina,
            'idplanejercicio'   => $idPlan,
        ]);

        if (!$idRutinaPlan) {
            $planModel->delete($idPlan);
            return $this->failServerError('Error al asociar el plan a la rutina: ' . json_encode($rutinaPlanModel->errors()));
        }

        $nuevoPlan = $rutinaPlanModel->getRutinaPlanWithDetails($idRutinaPlan);
        if (!empty($nuevoPlan['ejercicio_imagen'])) {
            $nuevoPlan['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $nuevoPlan['ejercicio_imagen']);
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Ejercicio agregado exitosamente a la rutina',
            'data'    => $nuevoPlan,
        ]);
    }

    /**
     * PUT|POST /api/planejercicio/{id}
     * Modifica los datos de un plan de ejercicio existente (ejercicio, series, repeticiones, días, descanso, peso)
     */
    public function actualizarPlanEjercicio($idPlanParam = null)
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $idPlan = !empty($idPlanParam) ? (int)$idPlanParam : (!empty($input['idplanejercicio']) ? (int)$input['idplanejercicio'] : 0);

        if ($idPlan <= 0) {
            return $this->failValidationErrors('ID de plan de ejercicio no válido.');
        }

        $updateData = [];

        // Cambiar ejercicio si viene especificado
        if (!empty($input['idejercicio'])) {
            $nuevoIdEjercicio = (int)$input['idejercicio'];
            $ejercicioModel = new EjercicioModel();
            $ej = $ejercicioModel->find($nuevoIdEjercicio);
            if (!$ej) {
                return $this->failNotFound("Ejercicio no encontrado con ID: {$nuevoIdEjercicio}");
            }
            $updateData['idejercicio'] = $nuevoIdEjercicio;

            // Actualizar nombre del plan si no se proporciona uno explícito
            if (empty($input['nombre'])) {
                $nombreEj = !empty($ej['nombreespanol']) ? $ej['nombreespanol'] : ($ej['nombreingles'] ?? 'Ejercicio');
                $updateData['nombre'] = mb_substr("Plan {$nombreEj}", 0, 100);
            }
        }

        if (!empty($input['nombre'])) {
            $updateData['nombre'] = mb_substr(trim($input['nombre']), 0, 100);
        }

        if (isset($input['series']) && $input['series'] !== '') {
            $updateData['series'] = (int)$input['series'];
        }
        if (isset($input['repeticiones']) && $input['repeticiones'] !== '') {
            $updateData['repeticiones'] = (int)$input['repeticiones'];
        }
        if (isset($input['diassemanas']) && $input['diassemanas'] !== '') {
            $updateData['diassemanas'] = (int)$input['diassemanas'];
        }
        if (isset($input['tiempodescanso']) && $input['tiempodescanso'] !== '') {
            $updateData['tiempodescanso'] = (int)$input['tiempodescanso'];
        }
        if (isset($input['peso']) && $input['peso'] !== '') {
            $updateData['peso'] = (float)$input['peso'];
        }

        // 1. Verificar si el plan pertenece a las tablas personalizadas del cliente
        $planPersModel = new \App\Models\PlanPersonalizadoModel();
        $planPers = $planPersModel->find($idPlan);
        if ($planPers) {
            if (!empty($updateData)) {
                $planPersModel->update($idPlan, $updateData);
            }
            $planActualizado = $planPersModel->getPlanWithDetails($idPlan);
            if ($planActualizado && !empty($planActualizado['ejercicio_imagen'])) {
                $planActualizado['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $planActualizado['ejercicio_imagen']);
            }
            return $this->respond([
                'status'  => 200,
                'message' => 'Plan de ejercicio personalizado actualizado correctamente',
                'data'    => $planActualizado,
            ]);
        }

        // 2. Si no es personalizado, verificar en planes modelo
        $planModel = new PlanEjercicioModel();
        $planExistente = $planModel->find($idPlan);
        if (!$planExistente) {
            return $this->failNotFound("Plan de ejercicio no encontrado con ID: {$idPlan}");
        }

        if (!empty($updateData)) {
            $updated = $planModel->update($idPlan, $updateData);
            if (!$updated) {
                return $this->failServerError('Error al actualizar el plan de ejercicio: ' . json_encode($planModel->errors()));
            }
        }

        $planActualizado = $planModel->getPlanWithDetails($idPlan);
        if ($planActualizado && !empty($planActualizado['ejercicio_imagen'])) {
            $planActualizado['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $planActualizado['ejercicio_imagen']);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Plan de ejercicio actualizado correctamente',
            'data'    => $planActualizado,
        ]);
    }

    /**
     * DELETE /api/rutinaplan/{id} o /api/rutina/{id}/plan/{idplan}
     * Elimina un plan de ejercicio de la rutina
     */
    public function eliminarPlanRutina($idRutinaPlanParam = null)
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $idRutinaPlan = !empty($idRutinaPlanParam) ? (int)$idRutinaPlanParam : (!empty($input['id_rutina_plan']) ? (int)$input['id_rutina_plan'] : 0);

        // 1. Verificar si corresponde a una asignación en rutinaplanpersonalizado
        $rplpModel = new \App\Models\RutinaPlanPersonalizadoModel();
        $regPers = null;

        if ($idRutinaPlan > 0) {
            $regPers = $rplpModel->find($idRutinaPlan);
        }

        if (!$regPers && !empty($input['idrutinaejercicio']) && !empty($input['idplanejercicio'])) {
            $regPers = $rplpModel->where('idrutinapersonalizada', (int)$input['idrutinaejercicio'])
                                 ->where('idplanpersonalizado', (int)$input['idplanejercicio'])
                                 ->first();
            if ($regPers) {
                $idRutinaPlan = (int)$regPers['idrutinaplanpersonalizado'];
            }
        }

        if ($regPers) {
            $idPlanPers = (int)$regPers['idplanpersonalizado'];
            $rplpModel->delete($idRutinaPlan);

            $otrosUsos = $rplpModel->where('idplanpersonalizado', $idPlanPers)->countAllResults();
            if ($otrosUsos === 0) {
                $planPersModel = new \App\Models\PlanPersonalizadoModel();
                $planPersModel->delete($idPlanPers);
            }

            return $this->respond([
                'status'  => 200,
                'message' => 'Ejercicio removido de la rutina personalizada correctamente',
                'data'    => ['id_rutina_plan' => $idRutinaPlan, 'idplanejercicio' => $idPlanPers],
            ]);
        }

        // 2. Si no es personalizado, operar sobre las tablas estándar
        $rutinaPlanModel = new RutinaPlanModel();
        
        // Si no se pasó id_rutina_plan, verificar si viene por idrutina y idplan
        if ($idRutinaPlan <= 0 && !empty($input['idrutinaejercicio']) && !empty($input['idplanejercicio'])) {
            $rp = $rutinaPlanModel->where('idrutinaejercicio', (int)$input['idrutinaejercicio'])
                                  ->where('idplanejercicio', (int)$input['idplanejercicio'])
                                  ->first();
            if ($rp) {
                $idRutinaPlan = (int)$rp['id_rutina_plan'];
            }
        }

        if ($idRutinaPlan <= 0) {
            return $this->failValidationErrors('ID de rutina_plan no válido.');
        }

        $registro = $rutinaPlanModel->find($idRutinaPlan);
        if (!$registro) {
            return $this->failNotFound("Registro de rutina_plan no encontrado con ID: {$idRutinaPlan}");
        }

        $idPlan = (int)$registro['idplanejercicio'];

        // Eliminar vínculo en rutinaplan
        $rutinaPlanModel->delete($idRutinaPlan);

        // Si el plan no está asociado a ninguna otra rutina, limpiarlo
        $otrosUsos = $rutinaPlanModel->where('idplanejercicio', $idPlan)->countAllResults();
        if ($otrosUsos === 0) {
            $planModel = new PlanEjercicioModel();
            $planModel->delete($idPlan);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejercicio removido de la rutina correctamente',
            'data'    => ['id_rutina_plan' => $idRutinaPlan, 'idplanejercicio' => $idPlan],
        ]);
    }

    /**
     * GET /api/rangos-edad
     * List all age ranges
     */
    public function getRangosEdad()
    {
        $rangoModel = new \App\Models\RangoEdadModel();
        $rangos = $rangoModel->getRangos($this->request->getGet('q'));

        return $this->respond([
            'status'  => 200,
            'message' => 'Rangos de edad obtenidos correctamente',
            'data'    => $rangos,
            'total'   => count($rangos),
        ]);
    }
}
