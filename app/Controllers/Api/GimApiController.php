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
        $ejercicios = $db->table('programacliente pc')
                         ->select('ejercicio.idejercicio, ejercicio.nombreespanol AS ejercicio_nombre, ejercicio.nombreespanol, ejercicio.nombreingles, ejercicio.descripcion, ejercicio.imagen AS ejercicio_imagen, ejercicio.urlvideo, plane.idplanejercicio, plane.diassemanas, plane.repeticiones, plane.series, plane.tiempodescanso, plane.peso, rutina.idrutinaejercicio, rutina.nombre AS rutina_nombre, prog.idprogramaentrenamiento, prog.nombre AS programa_nombre, estado.nombre AS estado_programa')
                         ->join('programaentrenamiento prog', 'prog.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                         ->join('estadoprogramacliente estado', 'estado.idestadoprogramacliente = pc.idestadoprogramacliente', 'inner')
                         ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = prog.idprogramaentrenamiento', 'inner')
                         ->join('rutinaejecicio rutina', 'rutina.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                         ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rutina.idrutinaejercicio', 'inner')
                         ->join('planejercicio plane', 'plane.idplanejercicio = rpl.idplanejercicio', 'inner')
                         ->join('ejercicio', 'ejercicio.idejercicio = plane.idejercicio', 'inner')
                         ->where('pc.idcliente', (int)$id)
                         ->orderBy('pc.idprogramacliente', 'DESC')
                         ->orderBy('rutina.idrutinaejercicio', 'ASC')
                         ->orderBy('plane.idplanejercicio', 'ASC')
                         ->get()
                         ->getResultArray();

        foreach ($ejercicios as &$ej) {
            $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['ejercicio_imagen'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Ejercicios asignados al cliente obtenidos a través de su programa de entrenamiento',
            'data'    => $ejercicios,
            'total'   => count($ejercicios),
        ]);
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

        // Total visits to gym
        $visitasCount = $db->table('visitasgim')
                           ->where('idcliente', (int)$id)
                           ->countAllResults();

        // Distinct days attended
        $diasEntrenadosRow = $db->table('visitasgim')
                                ->select('COUNT(DISTINCT fecha) as dias')
                                ->where('idcliente', (int)$id)
                                ->get()
                                ->getRowArray();
        $diasEntrenados = (int)($diasEntrenadosRow['dias'] ?? 0);

        // Visits in the last 7 days and 30 days
        $hoy = date('Y-m-d');
        $hace7Dias = date('Y-m-d', strtotime('-7 days'));
        $hace30Dias = date('Y-m-d', strtotime('-30 days'));

        $sesiones7Dias = $db->table('visitasgim')
                            ->where('idcliente', (int)$id)
                            ->where('fecha >=', $hace7Dias)
                            ->countAllResults();

        $sesiones30Dias = $db->table('visitasgim')
                             ->where('idcliente', (int)$id)
                             ->where('fecha >=', $hace30Dias)
                             ->countAllResults();

        // History grouped by date (last 14 days)
        $hace14Dias = date('Y-m-d', strtotime('-14 days'));
        $historialDiario = $db->table('visitasgim')
                              ->select('fecha, COUNT(*) as visitas')
                              ->where('idcliente', (int)$id)
                              ->where('fecha >=', $hace14Dias)
                              ->groupBy('fecha')
                              ->orderBy('fecha', 'ASC')
                              ->get()
                              ->getResultArray();

        // Total exercises in assigned programs
        $ejRow = $db->table('programacliente pc')
                    ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento')
                    ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rp.idrutinaejercicio')
                    ->join('planejercicio pe', 'pe.idplanejercicio = rpl.idplanejercicio')
                    ->where('pc.idcliente', (int)$id)
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
                                 ->where('pc.idcliente', (int)$id)
                                 ->groupBy('musculo.idmusculo, musculo.nombre')
                                 ->orderBy('veces', 'DESC')
                                 ->limit(6)
                                 ->get()
                                 ->getResultArray();

        // Exercises assigned through current programs
        $ejerciciosAsignados = $db->table('programacliente pc')
                                  ->select('ejercicio.idejercicio, ejercicio.nombreespanol AS ejercicio_nombre, ejercicio.nombreespanol, ejercicio.nombreingles, ejercicio.imagen AS ejercicio_imagen, plane.series, plane.repeticiones, plane.peso, plane.tiempodescanso, rutina.nombre AS rutina_nombre')
                                  ->join('rutinaprograma rp', 'rp.idprogramaentrenamiento = pc.idprogramaentrenamiento', 'inner')
                                  ->join('rutinaejecicio rutina', 'rutina.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                                  ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rutina.idrutinaejercicio', 'inner')
                                  ->join('planejercicio plane', 'plane.idplanejercicio = rpl.idplanejercicio', 'inner')
                                  ->join('ejercicio', 'ejercicio.idejercicio = plane.idejercicio', 'inner')
                                  ->where('pc.idcliente', (int)$id)
                                  ->groupBy('ejercicio.idejercicio, plane.idplanejercicio')
                                  ->limit(10)
                                  ->get()
                                  ->getResultArray();

        foreach ($ejerciciosAsignados as &$r) {
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
                'total_visitas_gim'    => $visitasCount,
                'total_ejercicios'     => $totalEjerciciosAsignados,
                'dias_entrenados'      => $diasEntrenados,
                'sesiones_ultimos_7d'  => $sesiones7Dias,
                'sesiones_ultimos_30d' => $sesiones30Dias,
                'historial_diario'     => $historialDiario,
                'musculos_trabajados'  => $musculosTrabajados,
                'programa_activo'      => $programaActivo,
                'ejercicios_recientes' => $ejerciciosAsignados,
            ],
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
