<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaClienteModel extends Model
{
    use NavigableTrait;

    protected $table            = 'programacliente';
    protected $primaryKey       = 'idprogramacliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramaentrenamiento',
        'idprogramapersonalizado',
        'idcliente',
        'fechainicio',
        'idestadoprogramacliente',
    ];

    protected $validationRules = [
        'idprogramaentrenamiento' => 'required|is_natural_no_zero',
        'idcliente'               => 'required|is_natural_no_zero',
        'fechainicio'             => 'required|valid_date[Y-m-d]',
        'idestadoprogramacliente' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idprogramaentrenamiento' => [
            'required'           => 'Debe seleccionar un programa de entrenamiento.',
            'is_natural_no_zero' => 'El programa de entrenamiento seleccionado no es válido.',
        ],
        'idcliente' => [
            'required'           => 'Debe seleccionar un cliente.',
            'is_natural_no_zero' => 'El cliente seleccionado no es válido.',
        ],
        'fechainicio' => [
            'required'   => 'La fecha de inicio es obligatoria.',
            'valid_date' => 'La fecha de inicio debe tener el formato AAAA-MM-DD.',
        ],
        'idestadoprogramacliente' => [
            'required'           => 'Debe seleccionar un estado para el programa.',
            'is_natural_no_zero' => 'El estado seleccionado no es válido.',
        ],
    ];

    /**
     * Clona un programa de entrenamiento modelo a las tablas personalizadas de un cliente
     */
    public function clonarProgramaModeloACliente(int $idProgramaModelo, int $idCliente, ?string $nombrePersonalizado = null): int
    {
        $db = \Config\Database::connect();
        
        $modelo = $db->table('programaentrenamiento')
                     ->where('idprogramaentrenamiento', $idProgramaModelo)
                     ->get()
                     ->getRowArray();

        if (!$modelo) {
            throw new \RuntimeException("Programa modelo no encontrado con ID: {$idProgramaModelo}");
        }

        $nombreProg = !empty($nombrePersonalizado) ? trim($nombrePersonalizado) : $modelo['nombre'];

        // 1. Crear Programa Personalizado
        $db->table('programaentrenamientopersonalizado')->insert([
            'idprogramaentrenamientomodelo' => $idProgramaModelo,
            'idcliente'                     => $idCliente,
            'nombre'                        => $nombreProg,
            'idmotivoentrenamiento'         => (int)$modelo['idmotivoentrenamiento'],
            'idrangoedad'                   => !empty($modelo['idrangoedad']) ? (int)$modelo['idrangoedad'] : null,
            'fechacreacion'                 => date('Y-m-d H:i:s'),
        ]);
        $idProgPers = (int)$db->insertID();

        // 2. Obtener y clonar rutinas del modelo
        $rutinasModelo = $db->table('rutinaprograma rp')
                            ->select('rp.*, r.nombre')
                            ->join('rutinaejecicio r', 'r.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                            ->where('rp.idprogramaentrenamiento', $idProgramaModelo)
                            ->get()
                            ->getResultArray();

        foreach ($rutinasModelo as $rm) {
            $idRutinaModelo = (int)$rm['idrutinaejercicio'];

            $db->table('rutinaejerciciopersonalizado')->insert([
                'idrutinaejerciciomodelo' => $idRutinaModelo,
                'idcliente'               => $idCliente,
                'nombre'                  => $rm['nombre'],
                'fechacreacion'           => date('Y-m-d H:i:s'),
            ]);
            $idRutinaPers = (int)$db->insertID();

            $db->table('rutinaprogramapersonalizado')->insert([
                'idprogramapersonalizado' => $idProgPers,
                'idrutinapersonalizada'   => $idRutinaPers,
            ]);

            // 3. Obtener y clonar planes de ejercicio de la rutina
            $planesModelo = $db->table('rutinaplan rpl')
                               ->select('rpl.*, p.*')
                               ->join('planejercicio p', 'p.idplanejercicio = rpl.idplanejercicio', 'inner')
                               ->where('rpl.idrutinaejercicio', $idRutinaModelo)
                               ->get()
                               ->getResultArray();

            foreach ($planesModelo as $pm) {
                $idPlanModelo = (int)$pm['idplanejercicio'];

                $db->table('planejerciciopersonalizado')->insert([
                    'idplanejerciciomodelo' => $idPlanModelo,
                    'nombre'                => $pm['nombre'],
                    'idejercicio'           => (int)$pm['idejercicio'],
                    'diassemanas'           => isset($pm['diassemanas']) ? (int)$pm['diassemanas'] : null,
                    'repeticiones'          => isset($pm['repeticiones']) ? (int)$pm['repeticiones'] : null,
                    'series'                => isset($pm['series']) ? (int)$pm['series'] : null,
                    'tiempodescanso'        => isset($pm['tiempodescanso']) ? (int)$pm['tiempodescanso'] : null,
                    'peso'                  => isset($pm['peso']) ? (float)$pm['peso'] : 0.0,
                ]);
                $idPlanPers = (int)$db->insertID();

                $db->table('rutinaplanpersonalizado')->insert([
                    'idrutinapersonalizada' => $idRutinaPers,
                    'idplanpersonalizado'   => $idPlanPers,
                ]);
            }
        }

        return $idProgPers;
    }

    public function getProgramaClienteWithDetails($id)
    {
        $pc = $this->select('programacliente.*, 
                             cliente.idpersona, 
                             persona.cedula AS cliente_cedula, 
                             persona.nombres AS cliente_nombres, 
                             persona.fechanacimiento AS cliente_fechanacimiento,
                             programaentrenamiento.nombre AS programa_nombre,
                             programaentrenamiento.idmotivoentrenamiento,
                             programaentrenamiento.idrangoedad,
                             rangoedad.nombre AS rango_nombre,
                             rangoedad.edadminima AS rango_edadminima,
                             rangoedad.edadmaxima AS rango_edadmaxima,
                             motivoentrenamiento.nombre AS motivo_nombre, 
                             motivoentrenamiento.objetivo AS motivo_objetivo,
                             estadoprogramacliente.nombre AS estado_nombre')
                    ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                    ->where('programacliente.idprogramacliente', $id)
                    ->first();

        if ($pc) {
            $idProgPersonalizado = !empty($pc['idprogramapersonalizado']) ? (int)$pc['idprogramapersonalizado'] : null;

            if ($idProgPersonalizado) {
                $rutinaPersModel = new RutinaPersonalizadaModel();
                $pc['rutinas'] = $rutinaPersModel->getRutinasByProgramaPersonalizado($idProgPersonalizado);
            } else {
                $pc['rutinas'] = (new RutinaProgramaModel())->getRutinasByPrograma((int)$pc['idprogramaentrenamiento']);
            }
            
            // Recolectar todos los planes/ejercicios de todas las rutinas asignadas al programa
            $allPlanes = [];
            foreach ($pc['rutinas'] as $rutina) {
                if (!empty($rutina['planes'])) {
                    foreach ($rutina['planes'] as $pl) {
                        $pl['rutina_nombre'] = $rutina['rutina_nombre'] ?? ($rutina['nombre'] ?? '');
                        $allPlanes[] = $pl;
                    }
                }
            }
            $pc['planes'] = $allPlanes;
            $pc['ejecuciones'] = (new EjecucionProgramaModel())->getEjecucionesByProgramaCliente((int)$pc['idprogramacliente']);
        }

        return $pc;
    }

    public function getProgramasClientesWithDetails(?string $search = null)
    {
        $builder = $this->select('programacliente.*, 
                                  cliente.idpersona, 
                                  persona.cedula AS cliente_cedula, 
                                  persona.nombres AS cliente_nombres, 
                                  programaentrenamiento.nombre AS programa_nombre,
                                  motivoentrenamiento.nombre AS motivo_nombre, 
                                  rangoedad.nombre AS rango_nombre,
                                  rangoedad.edadminima AS rango_edadminima,
                                  rangoedad.edadmaxima AS rango_edadmaxima,
                                  estadoprogramacliente.nombre AS estado_nombre,
                                  (SELECT COUNT(*) FROM rutinaprograma WHERE rutinaprograma.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento) AS total_rutinas,
                                  (SELECT COUNT(*) FROM rutinaplan WHERE rutinaplan.idrutinaejercicio IN (SELECT rp.idrutinaejercicio FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento)) AS total_planes')
                        ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                        ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                        ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                        ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                        ->orderBy('programacliente.idprogramacliente', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.nombres', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('programaentrenamiento.nombre', $search)
                    ->orLike('motivoentrenamiento.nombre', $search)
                    ->orLike('estadoprogramacliente.nombre', $search)
                    ->orLike('programacliente.fechainicio', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getProgramasByCliente(int $idcliente): array
    {
        return $this->select('programacliente.*, 
                              programaentrenamiento.nombre AS programa_nombre,
                              motivoentrenamiento.nombre AS motivo_nombre, 
                              rangoedad.nombre AS rango_nombre,
                              rangoedad.edadminima AS rango_edadminima,
                              rangoedad.edadmaxima AS rango_edadmaxima,
                              estadoprogramacliente.nombre AS estado_nombre,
                              (SELECT COUNT(*) FROM rutinaprograma WHERE rutinaprograma.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento) AS total_rutinas,
                              (SELECT COUNT(*) FROM rutinaplan WHERE rutinaplan.idrutinaejercicio IN (SELECT rp.idrutinaejercicio FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento)) AS total_planes')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                    ->where('programacliente.idcliente', $idcliente)
                    ->orderBy('programacliente.fechainicio', 'DESC')
                    ->orderBy('programacliente.idprogramacliente', 'DESC')
                    ->findAll();
    }
}
