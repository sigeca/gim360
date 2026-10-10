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
use App\Models\EjercicioClienteModel;
use App\Models\VisitasGimModel;
use App\Models\MusculoModel;
use App\Models\EquipoModel;
use App\Models\MusculoEjercicioModel;
use App\Models\EjercicioEquipoModel;

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
        return $base . '/index.php/' . $segment . '/' . $filename;
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

            // Total workouts / exercises
            $ejerciciosCount = $db->table('ejerciciocliente')
                                  ->where('idcliente', $idcliente)
                                  ->countAllResults();
            $c['total_ejercicios'] = $ejerciciosCount;

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

        $ejClienteModel = new EjercicioClienteModel();
        $ultimosEjercicios = $ejClienteModel->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.imagen AS ejercicio_imagen')
                                            ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                                            ->where('ejerciciocliente.idcliente', $id)
                                            ->orderBy('ejerciciocliente.fecha', 'DESC')
                                            ->orderBy('ejerciciocliente.idejerciciocliente', 'DESC')
                                            ->findAll(5);

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
        $programas = $progModel->select('programacliente.*, programaentrenamiento.nombre as programa_nombre, motivoentrenamiento.nombre as motivo_nombre, motivoentrenamiento.objetivo as motivo_objetivo, estadoprogramacliente.nombre as estado_nombre')
                               ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                               ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                               ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                               ->where('programacliente.idcliente', $id)
                               ->orderBy('programacliente.fechainicio', 'DESC')
                               ->findAll();

        $rutinaProgModel = new RutinaProgramaModel();
        $baseUrl = base_url();

        foreach ($programas as &$prog) {
            $idProgEntrenamiento = (int)$prog['idprogramaentrenamiento'];
            $rutinas = $rutinaProgModel->getRutinasByPrograma($idProgEntrenamiento);

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
        $builder = $ejercicioModel->select('ejercicio.*');

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
                    ->like('ejercicio.nombre', $search)
                    ->orLike('ejercicio.descripcion', $search)
                    ->groupEnd();
        }

        $total = $builder->countAllResults(false);
        $ejercicios = $builder->orderBy('ejercicio.nombre', 'ASC')
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
     * Get completed workouts history for client
     */
    public function getClienteEjercicios($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de cliente no proporcionado');
        }

        $ejClienteModel = new EjercicioClienteModel();
        $ejercicios = $ejClienteModel->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.descripcion, ejercicio.imagen AS ejercicio_imagen, ejercicio.urlvideo')
                                     ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                                     ->where('ejerciciocliente.idcliente', (int)$id)
                                     ->orderBy('ejerciciocliente.fecha', 'DESC')
                                     ->orderBy('ejerciciocliente.idejerciciocliente', 'DESC')
                                     ->findAll();

        $baseUrl = base_url();
        foreach ($ejercicios as &$ej) {
            $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['ejercicio_imagen'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Historial de ejercicios obtenido correctamente',
            'data'    => $ejercicios,
            'total'   => count($ejercicios),
        ]);
    }

    /**
     * POST /api/ejercicios-cliente
     * Log a completed exercise for a client
     */
    public function registrarEjercicioCliente()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $rules = [
            'idcliente'       => 'required|is_natural_no_zero',
            'idejercicio'     => 'required|is_natural_no_zero',
            'fecha'           => 'required|valid_date[Y-m-d]',
            'duracionminutos' => 'required|is_natural_no_zero|greater_than[0]|less_than_equal_to[1440]',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $ejClienteModel = new EjercicioClienteModel();
        $data = [
            'idcliente'       => (int)$input['idcliente'],
            'idejercicio'     => (int)$input['idejercicio'],
            'fecha'           => $input['fecha'],
            'duracionminutos' => (int)$input['duracionminutos'],
        ];

        $id = $ejClienteModel->insert($data);
        if (!$id) {
            return $this->failServerError('No se pudo registrar el ejercicio.');
        }

        $created = $ejClienteModel->getEjercicioClienteWithDetails($id);
        $baseUrl = base_url();
        if ($created && !empty($created['ejercicio_imagen'])) {
            $created['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $created['ejercicio_imagen']);
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Ejercicio registrado en tu historial de entrenamiento',
            'data'    => $created,
        ]);
    }

    /**
     * GET /api/cliente/{id}/progreso
     * Comprehensive progress, effort metrics and statistics for visitor
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

        // Total workouts count and minutes
        $workoutStats = $db->table('ejerciciocliente')
                           ->select('COUNT(*) as total_sesiones, SUM(duracionminutos) as total_minutos, COUNT(DISTINCT fecha) as dias_entrenados')
                           ->where('idcliente', (int)$id)
                           ->get()
                           ->getRowArray();

        $totalSesiones = (int)($workoutStats['total_sesiones'] ?? 0);
        $totalMinutos = (int)($workoutStats['total_minutos'] ?? 0);
        $diasEntrenados = (int)($workoutStats['dias_entrenados'] ?? 0);

        // Total visits to gym
        $visitasCount = $db->table('visitasgim')
                           ->where('idcliente', (int)$id)
                           ->countAllResults();

        // Workouts in the last 7 days and 30 days
        $hoy = date('Y-m-d');
        $hace7Dias = date('Y-m-d', strtotime('-7 days'));
        $hace30Dias = date('Y-m-d', strtotime('-30 days'));

        $sesiones7Dias = $db->table('ejerciciocliente')
                            ->where('idcliente', (int)$id)
                            ->where('fecha >=', $hace7Dias)
                            ->countAllResults();

        $sesiones30Dias = $db->table('ejerciciocliente')
                             ->where('idcliente', (int)$id)
                             ->where('fecha >=', $hace30Dias)
                             ->countAllResults();

        // History grouped by date for weekly chart (last 14 days)
        $hace14Dias = date('Y-m-d', strtotime('-14 days'));
        $historialDiario = $db->table('ejerciciocliente')
                              ->select('fecha, COUNT(*) as ejercicios, SUM(duracionminutos) as minutos')
                              ->where('idcliente', (int)$id)
                              ->where('fecha >=', $hace14Dias)
                              ->groupBy('fecha')
                              ->orderBy('fecha', 'ASC')
                              ->get()
                              ->getResultArray();

        // Top muscles worked
        $musculosTrabajados = $db->table('ejerciciocliente')
                                 ->select('musculo.nombre as musculo, COUNT(*) as veces')
                                 ->join('musculoejercicio', 'musculoejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                                 ->join('musculo', 'musculo.idmusculo = musculoejercicio.idmusculo', 'inner')
                                 ->where('ejerciciocliente.idcliente', (int)$id)
                                 ->groupBy('musculo.nombre')
                                 ->orderBy('veces', 'DESC')
                                 ->limit(6)
                                 ->get()
                                 ->getResultArray();

        // Recent exercise records with exercise details
        $ejClienteModel = new EjercicioClienteModel();
        $recientes = $ejClienteModel->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.imagen AS ejercicio_imagen')
                                    ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                                    ->where('ejerciciocliente.idcliente', (int)$id)
                                    ->orderBy('ejerciciocliente.fecha', 'DESC')
                                    ->orderBy('ejerciciocliente.idejerciciocliente', 'DESC')
                                    ->findAll(10);

        $baseUrl = base_url();
        foreach ($recientes as &$r) {
            $r['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $r['ejercicio_imagen'] ?? null);
        }

        // Active training program summary
        $progModel = new ProgramaClienteModel();
        $programaActivo = $progModel->select('programacliente.*, programaentrenamiento.nombre as programa_nombre, motivoentrenamiento.nombre as motivo_nombre, estadoprogramacliente.nombre as estado_nombre')
                                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                                    ->where('programacliente.idcliente', (int)$id)
                                    ->where('estadoprogramacliente.nombre', 'Activo')
                                    ->orderBy('programacliente.idprogramacliente', 'DESC')
                                    ->first();

        return $this->respond([
            'status'  => 200,
            'message' => 'Estadísticas de progreso y esfuerzo calculadas correctamente',
            'data'    => [
                'total_sesiones'       => $totalSesiones,
                'total_minutos'        => $totalMinutos,
                'dias_entrenados'      => $diasEntrenados,
                'total_visitas_gim'    => $visitasCount,
                'sesiones_ultimos_7d'  => $sesiones7Dias,
                'sesiones_ultimos_30d' => $sesiones30Dias,
                'historial_diario'     => $historialDiario,
                'musculos_trabajados'  => $musculosTrabajados,
                'programa_activo'      => $programaActivo,
                'ejercicios_recientes' => $recientes,
            ],
        ]);
    }
}
