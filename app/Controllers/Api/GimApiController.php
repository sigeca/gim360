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
     * GET /api/perfilnutricional
     */
    public function getPerfilesNutricionales()
    {
        $search = $this->request->getGet('q');
        $idpersona = $this->request->getGet('idpersona');

        $pnModel = new \App\Models\PerfilNutricionalModel();
        if (!empty($idpersona)) {
            $perfiles = $pnModel->getPerfilesByPersona((int)$idpersona);
        } else {
            $perfiles = $pnModel->getPerfilesWithPersona($search);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Controles nutricionales obtenidos correctamente',
            'data'    => $perfiles,
            'total'   => count($perfiles),
        ]);
    }

    /**
     * GET /api/perfilnutricional/{id}
     */
    public function getPerfilNutricionalDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de perfil nutricional no proporcionado');
        }

        $pnModel = new \App\Models\PerfilNutricionalModel();
        $perfil = $pnModel->getPerfilWithDetails((int)$id);

        if (!$perfil) {
            return $this->failNotFound("Perfil nutricional no encontrado con ID: {$id}");
        }

        $perfil['historial'] = $pnModel->getPerfilesByPersona((int)$perfil['idpersona']);

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del perfil nutricional obtenido correctamente',
            'data'    => $perfil,
        ]);
    }

    /**
     * GET /api/persona/{id}/nutricion
     */
    public function getPersonaNutricion($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de persona no proporcionado');
        }

        $pnModel = new \App\Models\PerfilNutricionalModel();
        $perfiles = $pnModel->getPerfilesByPersona((int)$id);
        $ultimo = !empty($perfiles) ? $perfiles[0] : null;

        return $this->respond([
            'status'        => 200,
            'message'       => 'Historial nutricional obtenido correctamente',
            'ultimo_perfil' => $ultimo,
            'historial'     => $perfiles,
            'total'         => count($perfiles),
        ]);
    }

    /**
     * POST /api/perfilnutricional
     */
    public function guardarPerfilNutricional()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $pnModel = new \App\Models\PerfilNutricionalModel();
        if (!$pnModel->validate($json)) {
            return $this->failValidationErrors($pnModel->errors());
        }

        $id = $pnModel->insert([
            'idpersona'         => (int)$json['idpersona'],
            'peso_kg'           => (float)$json['peso_kg'],
            'estatura_cm'       => (float)$json['estatura_cm'],
            'fechamedicion'     => $json['fechamedicion'] ?? date('Y-m-d'),
            'porcentajegrasa'   => isset($json['porcentajegrasa']) && $json['porcentajegrasa'] !== '' ? (float)$json['porcentajegrasa'] : null,
            'porcentajemusculo' => isset($json['porcentajemusculo']) && $json['porcentajemusculo'] !== '' ? (float)$json['porcentajemusculo'] : null,
            'observaciones'     => $json['observaciones'] ?? null,
        ]);

        $nuevo = $pnModel->getPerfilWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Control nutricional registrado exitosamente',
            'data'    => $nuevo,
        ]);
    }

    /**
     * GET /api/componentesnutricionales
     * GET /api/componentenutricional
     */
    public function getComponentesNutricionales()
    {
        $search = $this->request->getGet('q');
        $componenteModel = new \App\Models\ComponenteNutricionalModel();
        $componentes = $componenteModel->getComponentes($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Componentes nutricionales obtenidos correctamente',
            'data'    => $componentes,
            'total'   => count($componentes),
        ]);
    }

    /**
     * GET /api/componentenutricional/{id}
     */
    public function getComponenteNutricionalDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de componente nutricional no proporcionado');
        }

        $componenteModel = new \App\Models\ComponenteNutricionalModel();
        $componente = $componenteModel->find($id);

        if (!$componente) {
            return $this->failNotFound('Componente nutricional no encontrado');
        }

        $componente['alimentos'] = $componenteModel->getAlimentosByComponente((int)$id);
        $componente['recetas']   = $componenteModel->getRecetasByComponente((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del componente nutricional obtenido',
            'data'    => $componente,
        ]);
    }

    /**
     * GET /api/alimentocomponentenutricional
     */
    public function getAlimentosComponentesNutricionales()
    {
        $search       = $this->request->getGet('q');
        $idalimento   = $this->request->getGet('idalimento');
        $idcomponente = $this->request->getGet('idcomponente');
        $model        = new \App\Models\AlimentoComponenteNutricionalModel();
        $list         = $model->getRecordsWithDetails($search, $idalimento ? (int)$idalimento : null, $idcomponente ? (int)$idcomponente : null);

        return $this->respond([
            'status'  => 200,
            'message' => 'Componentes por alimento obtenidos correctamente',
            'data'    => $list,
            'total'   => count($list),
        ]);
    }

    /**
     * GET /api/alimentocomponentenutricional/{id}
     */
    public function getAlimentoComponenteNutricionalDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }
        $model = new \App\Models\AlimentoComponenteNutricionalModel();
        $record = $model->getRecordWithDetails((int)$id);
        if (!$record) {
            return $this->failNotFound('Registro no encontrado');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle obtenido',
            'data'    => $record,
        ]);
    }

    /**
     * GET /api/imagenes
     * GET /api/imagen
     */
    public function getImagenes()
    {
        $search = $this->request->getGet('q');
        $imagenModel = new \App\Models\ImagenModel();
        $imagenes = $imagenModel->getImagenes($search);

        foreach ($imagenes as &$img) {
            $dirRuta = !empty($img['directorio_ruta']) ? trim($img['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $filePath = ROOTPATH . $dirRuta . '/' . ($img['nombre'] ?? '');
            $fallbackPath = ROOTPATH . 'repositorio/imagen/' . ($img['nombre'] ?? '');
            $img['archivoExiste'] = !empty($img['nombre']) && (file_exists($filePath) || file_exists($fallbackPath));
            $img['urlImagen']     = !empty($img['nombre']) ? base_url($dirRuta . '/' . $img['nombre']) : null;
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Imágenes obtenidas correctamente',
            'data'    => $imagenes,
            'total'   => count($imagenes),
        ]);
    }

    /**
     * GET /api/imagen/{id}
     */
    public function getImagenDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de imagen no proporcionado');
        }

        $imagenModel = new \App\Models\ImagenModel();
        $imagen = $imagenModel->getImagenWithDetails((int)$id);

        if (!$imagen) {
            return $this->failNotFound('Imagen no encontrada');
        }

        $dirRuta = !empty($imagen['directorio_ruta']) ? trim($imagen['directorio_ruta'], '/\\') : 'repositorio/imagen';
        $filePath = ROOTPATH . $dirRuta . '/' . ($imagen['nombre'] ?? '');
        $fallbackPath = ROOTPATH . 'repositorio/imagen/' . ($imagen['nombre'] ?? '');
        $imagen['archivoExiste'] = !empty($imagen['nombre']) && (file_exists($filePath) || file_exists($fallbackPath));
        $imagen['urlImagen']     = !empty($imagen['nombre']) ? base_url($dirRuta . '/' . $imagen['nombre']) : null;

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle de la imagen obtenido',
            'data'    => $imagen,
        ]);
    }

    /**
     * GET /api/alimento/{id}/componentes
     */
    public function getComponentesPorAlimento($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de alimento no proporcionado');
        }
        $model = new \App\Models\AlimentoComponenteNutricionalModel();
        $componentes = $model->getComponentesByAlimento((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Componentes del alimento obtenidos',
            'data'    => $componentes,
            'total'   => count($componentes),
        ]);
    }

    /**
     * GET /api/recetacomponentenutricional
     */
    public function getRecetasComponentesNutricionales()
    {
        $search       = $this->request->getGet('q');
        $idreceta     = $this->request->getGet('idreceta');
        $idcomponente = $this->request->getGet('idcomponente');
        $model        = new \App\Models\RecetaComponenteNutricionalModel();
        $list         = $model->getRecordsWithDetails($search, $idreceta ? (int)$idreceta : null, $idcomponente ? (int)$idcomponente : null);

        return $this->respond([
            'status'  => 200,
            'message' => 'Componentes por receta obtenidos correctamente',
            'data'    => $list,
            'total'   => count($list),
        ]);
    }

    /**
     * GET /api/recetacomponentenutricional/{id}
     */
    public function getRecetaComponenteNutricionalDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }
        $model = new \App\Models\RecetaComponenteNutricionalModel();
        $record = $model->getRecordWithDetails((int)$id);
        if (!$record) {
            return $this->failNotFound('Registro no encontrado');
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle obtenido',
            'data'    => $record,
        ]);
    }

    /**
     * GET /api/receta/{id}/componentes
     */
    public function getComponentesPorReceta($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de receta no proporcionado');
        }
        $model = new \App\Models\RecetaComponenteNutricionalModel();
        $componentes = $model->getComponentesByReceta((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Componentes de la receta obtenidos',
            'data'    => $componentes,
            'total'   => count($componentes),
        ]);
    }

    /**
     * GET /api/gruposalimentos
     */
    public function getGruposAlimentos()
    {
        $search = $this->request->getGet('q');
        $grupoModel = new \App\Models\GrupoAlimentoModel();
        $grupos = $grupoModel->getGrupos($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Grupos de alimentos obtenidos correctamente',
            'data'    => $grupos,
            'total'   => count($grupos),
        ]);
    }

    /**
     * GET /api/grupoalimento/{id}
     */
    public function getGrupoAlimentoDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de grupo de alimento no proporcionado');
        }

        $grupoModel = new \App\Models\GrupoAlimentoModel();
        $grupo = $grupoModel->find($id);

        if (!$grupo) {
            return $this->failNotFound("Grupo de alimento no encontrado con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del grupo de alimento obtenido correctamente',
            'data'    => $grupo,
        ]);
    }

    /**
     * GET /api/alimentos
     */
    public function getAlimentos()
    {
        $search = $this->request->getGet('q');
        $idgrupo = $this->request->getGet('idgrupo');
        $idgrupo = (!empty($idgrupo) && is_numeric($idgrupo)) ? (int)$idgrupo : null;

        $alimentoModel = new \App\Models\AlimentoModel();
        $alimentos = $alimentoModel->getAlimentos($search, $idgrupo);

        return $this->respond([
            'status'  => 200,
            'message' => 'Alimentos obtenidos correctamente',
            'data'    => $alimentos,
            'total'   => count($alimentos),
        ]);
    }

    /**
     * GET /api/alimento/{id}
     */
    public function getAlimentoDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de alimento no proporcionado');
        }

        $alimentoModel = new \App\Models\AlimentoModel();
        $alimento = $alimentoModel->getAlimentoWithDetails((int)$id);

        if (!$alimento) {
            return $this->failNotFound("Alimento no encontrado con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del alimento obtenido correctamente',
            'data'    => $alimento,
        ]);
    }

    /**
     * GET /api/grupoalimento/{id}/alimentos
     */
    public function getAlimentosPorGrupo($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de grupo de alimento no proporcionado');
        }

        $grupoModel = new \App\Models\GrupoAlimentoModel();
        $grupo = $grupoModel->find($id);

        if (!$grupo) {
            return $this->failNotFound("Grupo de alimento no encontrado con ID: {$id}");
        }

        $alimentoModel = new \App\Models\AlimentoModel();
        $alimentos = $alimentoModel->where('idgrupo', (int)$id)->orderBy('nombre', 'ASC')->findAll();

        return $this->respond([
            'status'  => 200,
            'message' => 'Alimentos del grupo obtenidos correctamente',
            'grupo'   => $grupo,
            'data'    => $alimentos,
            'total'   => count($alimentos),
        ]);
    }

    /**
     * GET /api/planesalimentacion
     */
    public function getPlanesAlimentacion()
    {
        $search    = $this->request->getGet('q');
        $idpersona = $this->request->getGet('idpersona');
        $idpersona = (!empty($idpersona) && is_numeric($idpersona)) ? (int)$idpersona : null;

        $planModel = new \App\Models\PlanAlimentacionModel();
        $planes = $planModel->getPlanesWithPersona($search, $idpersona);

        return $this->respond([
            'status'  => 200,
            'message' => 'Planes de alimentación obtenidos correctamente',
            'data'    => $planes,
            'total'   => count($planes),
        ]);
    }

    /**
     * GET /api/planalimentacion/{id}
     */
    public function getPlanAlimentacionDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de plan de alimentación no proporcionado');
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        $plan = $planModel->getPlanWithDetails((int)$id);

        if (!$plan) {
            return $this->failNotFound("Plan de alimentación no encontrado con ID: {$id}");
        }

        $comidaModel = new \App\Models\ComidaModel();
        $comidas = $comidaModel->getComidasByPlan((int)$id);
        $arModel = new \App\Models\AlimentoRecetaModel();
        foreach ($comidas as &$c) {
            $c['ingredientes'] = $arModel->getIngredientesByReceta((int)$c['idreceta']);
        }
        $plan['comidas'] = $comidas;

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del plan de alimentación obtenido correctamente',
            'data'    => $plan,
        ]);
    }

    /**
     * GET /api/persona/{id}/planesalimentacion
     */
    public function getPersonaPlanesAlimentacion($idpersona = null)
    {
        if (empty($idpersona)) {
            return $this->failNotFound('ID de persona no proporcionado');
        }

        $personaModel = new \App\Models\PersonaModel();
        $persona = $personaModel->find($idpersona);

        if (!$persona) {
            return $this->failNotFound("Persona no encontrada con ID: {$idpersona}");
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        $planes = $planModel->getPlanesByPersona((int)$idpersona);

        return $this->respond([
            'status'  => 200,
            'message' => 'Planes de alimentación de la persona obtenidos correctamente',
            'persona' => [
                'idpersona' => $persona['idpersona'],
                'cedula'    => $persona['cedula'],
                'nombres'   => $persona['nombres'],
                'apellidos' => $persona['apellidos'],
            ],
            'data'    => $planes,
            'total'   => count($planes),
        ]);
    }

    /**
     * POST /api/planalimentacion
     */
    public function guardarPlanAlimentacion()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        if (!$planModel->validate($json)) {
            return $this->failValidationErrors($planModel->errors());
        }

        $fechaInicio = $json['fechainicio'] ?? date('Y-m-d');
        $fechaFin    = !empty($json['fechafin']) ? trim($json['fechafin']) : null;

        if (!empty($fechaFin) && $fechaFin < $fechaInicio) {
            return $this->failValidationErrors([
                'fechafin' => 'La fecha de fin no puede ser anterior a la fecha de inicio.'
            ]);
        }

        $id = $planModel->insert([
            'idpersona'   => (int)$json['idpersona'],
            'nombre'      => trim($json['nombre']),
            'fechainicio' => $fechaInicio,
            'fechafin'    => $fechaFin,
            'objetivo'    => isset($json['objetivo']) ? (trim($json['objetivo']) ?: null) : null,
        ]);

        $nuevo = $planModel->getPlanWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Plan de alimentación registrado exitosamente',
            'data'    => $nuevo,
        ]);
    }

    /**
     * PUT /api/planalimentacion/{id}
     */
    public function actualizarPlanAlimentacion($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de plan de alimentación no proporcionado');
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        $plan = $planModel->find($id);
        if (!$plan) {
            return $this->failNotFound("Plan no encontrado con ID: {$id}");
        }

        $json = $this->request->getJSON(true) ?: $this->request->getRawInput();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $data = [];
        if (isset($json['nombre'])) $data['nombre'] = trim($json['nombre']);
        if (isset($json['fechainicio'])) $data['fechainicio'] = trim($json['fechainicio']);
        if (array_key_exists('fechafin', $json)) $data['fechafin'] = !empty($json['fechafin']) ? trim($json['fechafin']) : null;
        if (array_key_exists('objetivo', $json)) $data['objetivo'] = !empty($json['objetivo']) ? trim($json['objetivo']) : null;

        if (empty($data)) {
            return $this->failValidationErrors('No hay datos para actualizar');
        }

        $planModel->update($id, $data);
        $actualizado = $planModel->getPlanWithDetails($id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Plan de alimentación actualizado exitosamente',
            'data'    => $actualizado,
        ]);
    }

    /**
     * DELETE /api/planalimentacion/{id}
     */
    public function eliminarPlanAlimentacion($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de plan de alimentación no proporcionado');
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        $plan = $planModel->find($id);
        if (!$plan) {
            return $this->failNotFound("Plan no encontrado con ID: {$id}");
        }

        $planModel->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Plan de alimentación eliminado exitosamente',
            'data'    => ['idplanalimentacion' => $id],
        ]);
    }

    /**
     * GET /api/recetas
     */
    public function getRecetas()
    {
        $search = $this->request->getGet('q');
        $recetaModel = new \App\Models\RecetaModel();
        $recetas = $recetaModel->getRecetas($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Recetas obtenidas correctamente',
            'data'    => $recetas,
            'total'   => count($recetas),
        ]);
    }

    /**
     * GET /api/receta/{id}
     */
    public function getRecetaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de receta no proporcionado');
        }

        $recetaModel = new \App\Models\RecetaModel();
        $receta = $recetaModel->getRecetaWithDetails((int)$id);

        if (!$receta) {
            return $this->failNotFound("Receta no encontrada con ID: {$id}");
        }

        $arModel = new \App\Models\AlimentoRecetaModel();
        $receta['ingredientes'] = $arModel->getIngredientesByReceta((int)$id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle de la receta obtenido correctamente',
            'data'    => $receta,
        ]);
    }

    /**
     * POST /api/receta
     */
    public function guardarReceta()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $recetaModel = new \App\Models\RecetaModel();
        if (!$recetaModel->validate($json)) {
            return $this->failValidationErrors($recetaModel->errors());
        }

        $porciones = isset($json['porciones']) && is_numeric($json['porciones']) ? (int)$json['porciones'] : 1;
        $tiempo    = isset($json['tiempopreparacion']) && is_numeric($json['tiempopreparacion']) ? (int)$json['tiempopreparacion'] : null;

        $id = $recetaModel->insert([
            'nombre'            => trim($json['nombre']),
            'instrucciones'     => isset($json['instrucciones']) ? (trim($json['instrucciones']) ?: null) : null,
            'porciones'         => $porciones,
            'tiempopreparacion' => $tiempo,
        ]);

        $nueva = $recetaModel->getRecetaWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Receta registrada exitosamente',
            'data'    => $nueva,
        ]);
    }

    /**
     * GET /api/unidadesalimento
     */
    public function getUnidadesAlimento()
    {
        $search = $this->request->getGet('q');
        $unidadModel = new \App\Models\UnidadAlimentoModel();
        $unidades = $unidadModel->getUnidades($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Unidades de medida obtenidas correctamente',
            'data'    => $unidades,
            'total'   => count($unidades),
        ]);
    }

    /**
     * GET /api/unidadalimento/{id}
     */
    public function getUnidadAlimentoDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de unidad no proporcionado');
        }

        $unidadModel = new \App\Models\UnidadAlimentoModel();
        $unidad = $unidadModel->find($id);

        if (!$unidad) {
            return $this->failNotFound("Unidad no encontrada con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle de la unidad obtenido correctamente',
            'data'    => $unidad,
        ]);
    }

    /**
     * POST /api/unidadalimento
     */
    public function guardarUnidadAlimento()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $unidadModel = new \App\Models\UnidadAlimentoModel();
        if (!$unidadModel->validate($json)) {
            return $this->failValidationErrors($unidadModel->errors());
        }

        $id = $unidadModel->insert([
            'nombre'      => trim($json['nombre']),
            'abreviatura' => trim($json['abreviatura']),
        ]);

        $nueva = $unidadModel->find($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Unidad de medida registrada exitosamente',
            'data'    => $nueva,
        ]);
    }

    /**
     * GET /api/receta/{id}/ingredientes
     */
    public function getRecetaIngredientes($idreceta = null)
    {
        if (empty($idreceta)) {
            return $this->failNotFound('ID de receta no proporcionado');
        }

        $recetaModel = new \App\Models\RecetaModel();
        $receta = $recetaModel->find($idreceta);

        if (!$receta) {
            return $this->failNotFound("Receta no encontrada con ID: {$idreceta}");
        }

        $arModel = new \App\Models\AlimentoRecetaModel();
        $ingredientes = $arModel->getIngredientesByReceta((int)$idreceta);

        return $this->respond([
            'status'  => 200,
            'message' => 'Ingredientes de la receta obtenidos correctamente',
            'receta'  => $receta,
            'data'    => $ingredientes,
            'total'   => count($ingredientes),
        ]);
    }

    /**
     * GET /api/alimentoreceta
     */
    public function getAlimentosReceta()
    {
        $search     = $this->request->getGet('q');
        $idreceta   = $this->request->getGet('idreceta');
        $idalimento = $this->request->getGet('idalimento');

        $idreceta   = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;
        $idalimento = (!empty($idalimento) && is_numeric($idalimento)) ? (int)$idalimento : null;

        $arModel = new \App\Models\AlimentoRecetaModel();
        $registros = $arModel->getRecordsWithDetails($search, $idreceta, $idalimento);

        return $this->respond([
            'status'  => 200,
            'message' => 'Relaciones alimento-receta obtenidas correctamente',
            'data'    => $registros,
            'total'   => count($registros),
        ]);
    }

    /**
     * GET /api/alimentoreceta/{id}
     */
    public function getAlimentoRecetaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de registro no proporcionado');
        }

        $arModel = new \App\Models\AlimentoRecetaModel();
        $record = $arModel->getRecordWithDetails((int)$id);

        if (!$record) {
            return $this->failNotFound("Registro no encontrado con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del ingrediente obtenido correctamente',
            'data'    => $record,
        ]);
    }

    /**
     * POST /api/alimentoreceta
     */
    public function guardarAlimentoReceta()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $arModel = new \App\Models\AlimentoRecetaModel();
        if (!$arModel->validate($json)) {
            return $this->failValidationErrors($arModel->errors());
        }

        $id = $arModel->insert([
            'idreceta'         => (int)$json['idreceta'],
            'idalimento'       => (int)$json['idalimento'],
            'cantidad'         => (float)$json['cantidad'],
            'idunidadalimento' => (int)$json['idunidadalimento'],
        ]);

        $nuevo = $arModel->getRecordWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Ingrediente asignado exitosamente a la receta',
            'data'    => $nuevo,
        ]);
    }

    /**
     * DELETE /api/alimentoreceta/{id}
     */
    public function eliminarAlimentoReceta($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }

        $arModel = new \App\Models\AlimentoRecetaModel();
        $existente = $arModel->find($id);

        if (!$existente) {
            return $this->failNotFound("Registro no encontrado con ID: {$id}");
        }

        $arModel->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Ingrediente removido de la receta exitosamente',
            'data'    => ['idalimentoreceta' => $id],
        ]);
    }

    /**
     * GET /api/tiposcomida
     */
    public function getTiposComida()
    {
        $search = $this->request->getGet('q');
        $tipoModel = new \App\Models\TipoComidaModel();
        $tipos = $tipoModel->getTiposComida($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Tipos de comida obtenidos correctamente',
            'data'    => $tipos,
            'total'   => count($tipos),
        ]);
    }

    /**
     * GET /api/tipocomida/{id}
     */
    public function getTipoComidaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de tipo de comida no proporcionado');
        }

        $tipoModel = new \App\Models\TipoComidaModel();
        $tipo = $tipoModel->find($id);

        if (!$tipo) {
            return $this->failNotFound("Tipo de comida no encontrado con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del tipo de comida obtenido correctamente',
            'data'    => $tipo,
        ]);
    }

    /**
     * POST /api/tipocomida
     */
    public function guardarTipoComida()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $tipoModel = new \App\Models\TipoComidaModel();
        if (!$tipoModel->validate($json)) {
            return $this->failValidationErrors($tipoModel->errors());
        }

        $id = $tipoModel->insert([
            'nombre' => trim($json['nombre']),
        ]);

        $nuevo = $tipoModel->find($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Tipo de comida registrado exitosamente',
            'data'    => $nuevo,
        ]);
    }

    /**
     * GET /api/diassemana
     */
    public function getDiasSemana()
    {
        $search = $this->request->getGet('q');
        $diaModel = new \App\Models\DiaSemanaModel();
        $dias = $diaModel->getDiasSemana($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Días de la semana obtenidos correctamente',
            'data'    => $dias,
            'total'   => count($dias),
        ]);
    }

    /**
     * GET /api/diasemana/{id}
     */
    public function getDiaSemanaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de día no proporcionado');
        }

        $diaModel = new \App\Models\DiaSemanaModel();
        $dia = $diaModel->find($id);

        if (!$dia) {
            return $this->failNotFound("Día de la semana no encontrado con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del día obtenido correctamente',
            'data'    => $dia,
        ]);
    }

    /**
     * POST /api/diasemana
     */
    public function guardarDiaSemana()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $diaModel = new \App\Models\DiaSemanaModel();
        if (!$diaModel->validate($json)) {
            return $this->failValidationErrors($diaModel->errors());
        }

        $id = $diaModel->insert([
            'nombre' => trim($json['nombre']),
        ]);

        $nuevo = $diaModel->find($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Día de la semana registrado exitosamente',
            'data'    => $nuevo,
        ]);
    }

    /**
     * GET /api/comidas
     */
    public function getComidas()
    {
        $search       = $this->request->getGet('q');
        $idplan       = $this->request->getGet('idplanalimentacion');
        $idtipocomida = $this->request->getGet('idtipocomida');
        $idreceta     = $this->request->getGet('idreceta');

        $idplan       = (!empty($idplan) && is_numeric($idplan)) ? (int)$idplan : null;
        $idtipocomida = (!empty($idtipocomida) && is_numeric($idtipocomida)) ? (int)$idtipocomida : null;
        $idreceta     = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;

        $comidaModel = new \App\Models\ComidaModel();
        $comidas = $comidaModel->getRecordsWithDetails($search, $idplan, $idtipocomida, $idreceta);

        return $this->respond([
            'status'  => 200,
            'message' => 'Comidas obtenidas correctamente',
            'data'    => $comidas,
            'total'   => count($comidas),
        ]);
    }

    /**
     * GET /api/comida/{id}
     */
    public function getComidaDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de comida no proporcionado');
        }

        $comidaModel = new \App\Models\ComidaModel();
        $comida = $comidaModel->getRecordWithDetails((int)$id);

        if (!$comida) {
            return $this->failNotFound("Comida no encontrada con ID: {$id}");
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle de la comida obtenido correctamente',
            'data'    => $comida,
        ]);
    }

    /**
     * GET /api/planalimentacion/{id}/comidas
     */
    public function getPlanComidas($idplan = null)
    {
        if (empty($idplan)) {
            return $this->failNotFound('ID de plan de alimentación no proporcionado');
        }

        $planModel = new \App\Models\PlanAlimentacionModel();
        $plan = $planModel->getPlanWithDetails((int)$idplan);

        if (!$plan) {
            return $this->failNotFound("Plan no encontrado con ID: {$idplan}");
        }

        $comidaModel = new \App\Models\ComidaModel();
        $comidas = $comidaModel->getComidasByPlan((int)$idplan);
        $arModel = new \App\Models\AlimentoRecetaModel();
        foreach ($comidas as &$c) {
            $c['ingredientes'] = $arModel->getIngredientesByReceta((int)$c['idreceta']);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Comidas del plan obtenidas correctamente',
            'plan'    => $plan,
            'data'    => $comidas,
            'total'   => count($comidas),
        ]);
    }

    /**
     * POST /api/comida
     */
    public function guardarComida()
    {
        $json = $this->request->getJSON(true) ?: $this->request->getPost();
        if (empty($json)) {
            return $this->failValidationErrors('Datos no proporcionados');
        }

        $comidaModel = new \App\Models\ComidaModel();
        if (!$comidaModel->validate($json)) {
            return $this->failValidationErrors($comidaModel->errors());
        }

        $id = $comidaModel->insert([
            'idplanalimentacion' => (int)$json['idplanalimentacion'],
            'idtipocomida'       => (int)$json['idtipocomida'],
            'idreceta'           => (int)$json['idreceta'],
            'horarecomendada'    => isset($json['horarecomendada']) ? (trim($json['horarecomendada']) ?: null) : null,
        ]);

        $nueva = $comidaModel->getRecordWithDetails($id);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Comida programada exitosamente en el plan',
            'data'    => $nueva,
        ]);
    }

    /**
     * DELETE /api/comida/{id}
     */
    public function eliminarComida($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }

        $comidaModel = new \App\Models\ComidaModel();
        $existente = $comidaModel->find($id);

        if (!$existente) {
            return $this->failNotFound("Comida no encontrada con ID: {$id}");
        }

        $comidaModel->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Comida eliminada del plan exitosamente',
            'data'    => ['idcomida' => $id],
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
     * GET /api/trenesmusculares
     */
    public function getTrenesMusculares()
    {
        $search = $this->request->getGet('q');
        $trenModel = new \App\Models\TrenMuscularModel();
        $trenes = $trenModel->getTrenes($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Trenes musculares obtenidos correctamente',
            'data'    => $trenes,
        ]);
    }

    /**
     * GET /api/trenmuscular/{id}
     */
    public function getTrenMuscularDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de tren muscular no proporcionado');
        }

        $trenModel = new \App\Models\TrenMuscularModel();
        $tren = $trenModel->getTrenWithCounts((int)$id);

        if (!$tren) {
            return $this->failNotFound("Tren muscular no encontrado con ID: {$id}");
        }

        $tren['musculos']   = $trenModel->getMusculosByTren((int)$id);
        $tren['ejercicios'] = $trenModel->getEjerciciosByTren((int)$id);
        $tren['programas']  = $trenModel->getProgramasByTren((int)$id);

        foreach ($tren['musculos'] as &$m) {
            $m['imagen_url'] = $this->getImageUrl('musculo/imagen', $m['imagen'] ?? null);
        }
        foreach ($tren['ejercicios'] as &$ej) {
            $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['imagen'] ?? null);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del tren muscular obtenido correctamente',
            'data'    => $tren,
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
        $idtren = $this->request->getGet('idtrenmuscular') ?: $this->request->getGet('idtren');
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 25);
        $offset = ($page - 1) * $limit;

        $ejercicioModel = new EjercicioModel();
        $builder = $ejercicioModel->select('ejercicio.*, ejercicio.nombreespanol AS nombre, trenmuscular.nombre AS tren_nombre')
                                  ->join('trenmuscular', 'trenmuscular.idtrenmuscular = ejercicio.idtrenmuscular', 'left');

        if (!empty($idtren)) {
            $builder->where('ejercicio.idtrenmuscular', (int)$idtren);
        }

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
        $ejercicio = $ejercicioModel->getEjercicioWithDetails($id);
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

        $db = \Config\Database::connect();
        $ejerciciosCounts = $db->table('musculoejercicio')
                               ->select('idmusculo, COUNT(idejercicio) as total_ejercicios')
                               ->groupBy('idmusculo')
                               ->get()
                               ->getResultArray();
        $ejerciciosMap = array_column($ejerciciosCounts, 'total_ejercicios', 'idmusculo');

        $equiposCounts = $db->table('equipomusculo')
                            ->select('idmusculo, COUNT(idequipo) as total_equipos')
                            ->groupBy('idmusculo')
                            ->get()
                            ->getResultArray();
        $equiposMap = array_column($equiposCounts, 'total_equipos', 'idmusculo');

        foreach ($musculos as &$m) {
            $idM = (int)$m['idmusculo'];
            $m['imagen_url'] = $this->getImageUrl('musculo/imagen', $m['imagen'] ?? null);
            $m['total_ejercicios'] = (int)($ejerciciosMap[$idM] ?? 0);
            $m['total_equipos'] = (int)($equiposMap[$idM] ?? 0);
        }

        return $this->respond([
            'status' => 200,
            'data'   => $musculos,
        ]);
    }

    /**
     * GET /api/musculo/{id}
     * Detalle completo de un músculo con sus ejercicios y máquinas
     */
    public function getMusculoDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de músculo no proporcionado');
        }

        $musculoModel = new MusculoModel();
        $musculo = $musculoModel->getMusculoWithDetails((int)$id);

        if (!$musculo) {
            return $this->failNotFound('Músculo no encontrado');
        }

        $musculo['imagen_url'] = $this->getImageUrl('musculo/imagen', $musculo['imagen'] ?? null);

        // 1. Ejercicios que entrenan este músculo (musculoejercicio)
        $meModel = new \App\Models\MusculoEjercicioModel();
        $ejercicios = $meModel->getEjerciciosByMusculo((int)$id);
        foreach ($ejercicios as &$ej) {
            $ej['nombre'] = $ej['ejercicio_nombre'] ?? $ej['nombreespanol'] ?? '';
            $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['ejercicio_imagen'] ?? $ej['imagen'] ?? null);
        }
        $musculo['ejercicios'] = $ejercicios;
        $musculo['total_ejercicios'] = count($ejercicios);

        // 2. Máquinas y equipos que permiten ejercitar este músculo (equipomusculo)
        $emModel = new \App\Models\EquipoMusculoModel();
        $equipos = $emModel->getEquiposByMusculo((int)$id);
        foreach ($equipos as &$eq) {
            $eq['idequipo'] = (int)$eq['idequipo'];
            $eq['id_equipo'] = (int)$eq['idequipo'];
            $eq['nombre'] = $eq['equipo_nombre'] ?? '';
            $eq['codigo'] = $eq['equipo_codigo'] ?? '';
            $eq['modelo'] = $eq['equipo_modelo'] ?? '';
            $eq['imagen'] = $eq['equipo_imagen'] ?? null;
            $eq['imagen_url'] = $this->getImageUrl('equipos/imagen', $eq['equipo_imagen'] ?? null);
        }
        $musculo['equipos'] = $equipos;
        $musculo['total_equipos'] = count($equipos);

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del músculo obtenido correctamente',
            'data'    => $musculo,
        ]);
    }

    /**
     * GET /api/equipos
     */
    public function getEquipos()
    {
        $search = $this->request->getGet('q');
        $idDisp = $this->request->getGet('iddisponibilidad') ?: $this->request->getGet('iddisponibilidadequipo');

        $equipoModel = new EquipoModel();
        $equipos = $equipoModel->getEquiposWithDetails($search, $idDisp ? (int)$idDisp : null);
        $baseUrl = base_url();

        $tipos = EquipoModel::getTipos();
        $marcas = EquipoModel::getMarcas();
        $ubicaciones = EquipoModel::getUbicaciones();
        $estados = EquipoModel::getEstados();

        $db = \Config\Database::connect();
        $musculosCounts = $db->table('equipomusculo')
                             ->select('idequipo, COUNT(idmusculo) as total_musculos')
                             ->groupBy('idequipo')
                             ->get()
                             ->getResultArray();
        $musculosMap = array_column($musculosCounts, 'total_musculos', 'idequipo');

        $ejerciciosCounts = $db->table('ejercicioequipo')
                               ->select('idequipo, COUNT(idejercicio) as total_ejercicios')
                               ->groupBy('idequipo')
                               ->get()
                               ->getResultArray();
        $ejerciciosMap = array_column($ejerciciosCounts, 'total_ejercicios', 'idequipo');

        foreach ($equipos as &$eq) {
            $idEq = (int)$eq['idequipo'];
            $eq['id_equipo'] = $idEq;
            $eq['video'] = $eq['video'] ?? null;
            $eq['video_url'] = $eq['video'] ?? null;
            $eq['imagen_url'] = $this->getImageUrl('equipos/imagen', $eq['imagen'] ?? null);
            $eq['tipo_nombre'] = $tipos[$eq['id_tipo']] ?? null;
            $eq['marca_nombre'] = $marcas[$eq['id_marca']] ?? null;
            $eq['ubicacion_nombre'] = $ubicaciones[$eq['id_ubicacion']] ?? null;
            $eq['estado_nombre'] = $estados[$eq['id_estado']] ?? null;
            $eq['total_musculos'] = (int)($musculosMap[$idEq] ?? 0);
            $eq['total_ejercicios'] = (int)($ejerciciosMap[$idEq] ?? 0);
        }

        return $this->respond([
            'status' => 200,
            'data'   => $equipos,
        ]);
    }

    /**
     * GET /api/equipo/{id} o /api/equipos/{id}
     * Detalle completo de una máquina o equipo, incluyendo músculos trabajados y ejercicios vinculados
     */
    public function getEquipoDetail($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de equipo no proporcionado');
        }

        $equipoModel = new EquipoModel();
        $equipo = $equipoModel->select('equipo.*, de.nombre AS disponibilidad_nombre')
                              ->join('disponibilidadequipo de', 'de.iddisponibilidadequipo = equipo.iddisponibilidadequipo', 'left')
                              ->where('equipo.idequipo', (int)$id)
                              ->first();

        if (!$equipo) {
            return $this->failNotFound('Equipo o máquina no encontrada');
        }

        $equipo['id_equipo'] = (int)$equipo['idequipo'];
        $equipo['video'] = $equipo['video'] ?? null;
        $equipo['video_url'] = $equipo['video'] ?? null;
        $equipo['youtube_embed_url'] = null;
        if (!empty($equipo['video'])) {
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/\s]{11})%i', $equipo['video'], $match)) {
                $equipo['youtube_embed_url'] = 'https://www.youtube.com/embed/' . $match[1];
            }
        }
        $equipo['imagen_url'] = $this->getImageUrl('equipos/imagen', $equipo['imagen'] ?? null);

        $tipos = EquipoModel::getTipos();
        $marcas = EquipoModel::getMarcas();
        $ubicaciones = EquipoModel::getUbicaciones();
        $estados = EquipoModel::getEstados();

        $equipo['tipo_nombre'] = $tipos[$equipo['id_tipo']] ?? null;
        $equipo['marca_nombre'] = $marcas[$equipo['id_marca']] ?? null;
        $equipo['ubicacion_nombre'] = $ubicaciones[$equipo['id_ubicacion']] ?? null;
        $equipo['estado_nombre'] = $estados[$equipo['id_estado']] ?? null;

        // Músculos que se ejercitan directamente con este equipo (equipomusculo)
        $equipoMusculoModel = new \App\Models\EquipoMusculoModel();
        $musculos = $equipoMusculoModel->getMusculosByEquipo((int)$id);

        // Fallback: si aún no tiene registros en equipomusculo, obtenerlos mediante sus ejercicios asociados
        if (empty($musculos)) {
            $db = \Config\Database::connect();
            $musculos = $db->table('ejercicioequipo ee')
                           ->select('m.idmusculo, m.nombre, m.imagen')
                           ->join('musculoejercicio me', 'me.idejercicio = ee.idejercicio', 'inner')
                           ->join('musculo m', 'm.idmusculo = me.idmusculo', 'inner')
                           ->where('ee.idequipo', (int)$id)
                           ->groupBy('m.idmusculo')
                           ->orderBy('m.nombre', 'ASC')
                           ->get()
                           ->getResultArray();
        }

        foreach ($musculos as &$m) {
            $m['imagen_url'] = $this->getImageUrl('musculo/imagen', $m['imagen'] ?? null);
        }
        $equipo['musculos'] = $musculos;

        // Ejercicios que se realizan con este equipo (ejercicioequipo)
        $ejercicioEquipoModel = new \App\Models\EjercicioEquipoModel();
        $ejercicios = $ejercicioEquipoModel->getEjerciciosByEquipo((int)$id);
        foreach ($ejercicios as &$ej) {
            $ej['nombre'] = $ej['ejercicio_nombre'] ?? $ej['nombreespanol'] ?? '';
            $ej['imagen_url'] = $this->getImageUrl('ejercicio/imagen', $ej['ejercicio_imagen'] ?? null);
        }
        $equipo['ejercicios'] = $ejercicios;
        $equipo['total_ejercicios'] = count($ejercicios);
        $equipo['total_musculos'] = count($musculos);

        return $this->respond([
            'status'  => 200,
            'message' => 'Detalle del equipo obtenido correctamente',
            'data'    => $equipo,
        ]);
    }

    /**
     * GET /api/disponibilidadequipo
     */
    public function getDisponibilidadEquipo()
    {
        $dispModel = new \App\Models\DisponibilidadEquipoModel();
        $estados = $dispModel->orderBy('iddisponibilidadequipo', 'ASC')->findAll();

        return $this->respond([
            'status' => 200,
            'data'   => $estados,
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

        $duracionSemana = !empty($input['duracionsemana']) ? (int)$input['duracionsemana'] : (!empty($input['duracionsemanas']) ? (int)$input['duracionsemanas'] : 4);

        // Particularizar: clonar el programa modelo hacia las tablas personalizadas del cliente
        try {
            $idProgPersonalizado = $progClienteModel->clonarProgramaModeloACliente(
                $idPrograma, 
                $idCliente, 
                null, 
                $fechaInicio, 
                $duracionSemana
            );
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

        $fechaInicioPlan = !empty($input['fechainicio']) ? $input['fechainicio'] : (!empty($input['fecha_inicio']) ? $input['fecha_inicio'] : date('Y-m-d'));
        $duracionSemanaPlan = !empty($input['duracionsemana']) ? (int)$input['duracionsemana'] : (!empty($input['duracionsemanas']) ? (int)$input['duracionsemanas'] : (!empty($input['duracion_semanas']) ? (int)$input['duracion_semanas'] : 4));

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
                'fechainicio'    => $fechaInicioPlan,
                'duracionsemana' => $duracionSemanaPlan,
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
        if (!empty($input['fechainicio'])) {
            $updateData['fechainicio'] = $input['fechainicio'];
        } elseif (!empty($input['fecha_inicio'])) {
            $updateData['fechainicio'] = $input['fecha_inicio'];
        }
        if (isset($input['duracionsemana']) && $input['duracionsemana'] !== '') {
            $updateData['duracionsemana'] = (int)$input['duracionsemana'];
        } elseif (isset($input['duracionsemanas']) && $input['duracionsemanas'] !== '') {
            $updateData['duracionsemana'] = (int)$input['duracionsemanas'];
        } elseif (isset($input['duracion_semanas']) && $input['duracion_semanas'] !== '') {
            $updateData['duracionsemana'] = (int)$input['duracion_semanas'];
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
