<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanPersonalizadoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'planejerciciopersonalizado';
    protected $primaryKey       = 'idplanpersonalizado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idplanejerciciomodelo',
        'nombre',
        'idejercicio',
        'diassemanas',
        'repeticiones',
        'series',
        'tiempodescanso',
        'peso',
        'fechainicio',
        'duracionsemana',
    ];

    protected $validationRules = [
        'nombre'         => 'permit_empty|min_length[3]|max_length[150]',
        'idejercicio'    => 'required|is_natural_no_zero',
        'diassemanas'    => 'permit_empty|is_natural_no_zero',
        'repeticiones'   => 'permit_empty|is_natural_no_zero',
        'series'         => 'permit_empty|is_natural_no_zero',
        'tiempodescanso' => 'permit_empty|is_natural',
        'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
        'fechainicio'    => 'permit_empty|valid_date[Y-m-d]',
        'duracionsemana' => 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idejercicio' => [
            'required'           => 'Debe seleccionar un ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar un ejercicio válido.',
        ],
        'fechainicio' => [
            'valid_date' => 'La fecha de inicio debe tener un formato de fecha válido (YYYY-MM-DD).',
        ],
        'duracionsemana' => [
            'is_natural_no_zero' => 'La duración en semanas debe ser un número entero mayor a cero.',
        ],
    ];

    public function getPlanWithDetails(int $id)
    {
        $plan = $this->select('planejerciciopersonalizado.*,
                              planejerciciopersonalizado.idplanpersonalizado AS idplanejercicio,
                              ejercicio.nombreespanol AS ejercicio_nombre,
                              ejercicio.nombreespanol AS ejercicio_nombreespanol,
                              ejercicio.nombreingles AS ejercicio_nombreingles,
                              ejercicio.descripcion AS ejercicio_descripcion,
                              ejercicio.urlvideo AS ejercicio_urlvideo,
                              ejercicio.imagen AS ejercicio_imagen,
                              rutinaejerciciopersonalizado.nombre AS rutina_nombre,
                              rutinaejerciciopersonalizado.idrutinapersonalizada,
                              persona.nombres AS cliente_nombres,
                              persona.cedula AS cliente_cedula,
                              cliente.idcliente,
                              programaentrenamientopersonalizado.nombre AS programa_nombre')
                    ->join('ejercicio', 'ejercicio.idejercicio = planejerciciopersonalizado.idejercicio', 'inner')
                    ->join('rutinaplanpersonalizado', 'rutinaplanpersonalizado.idplanpersonalizado = planejerciciopersonalizado.idplanpersonalizado', 'left')
                    ->join('rutinaejerciciopersonalizado', 'rutinaejerciciopersonalizado.idrutinapersonalizada = rutinaplanpersonalizado.idrutinapersonalizada', 'left')
                    ->join('rutinaprogramapersonalizado', 'rutinaprogramapersonalizado.idrutinapersonalizada = rutinaejerciciopersonalizado.idrutinapersonalizada', 'left')
                    ->join('programaentrenamientopersonalizado', 'programaentrenamientopersonalizado.idprogramapersonalizado = rutinaprogramapersonalizado.idprogramapersonalizado', 'left')
                    ->join('cliente', 'cliente.idcliente = rutinaejerciciopersonalizado.idcliente OR cliente.idcliente = programaentrenamientopersonalizado.idcliente', 'left')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'left')
                    ->where('planejerciciopersonalizado.idplanpersonalizado', $id)
                    ->first();

        return $plan;
    }

    public function getPlanesPersonalizadosWithDetails(?string $search = null): array
    {
        $builder = $this->select('planejerciciopersonalizado.*,
                                  ejercicio.nombreespanol AS ejercicio_nombre,
                                  ejercicio.nombreespanol AS ejercicio_nombreespanol,
                                  ejercicio.nombreingles AS ejercicio_nombreingles,
                                  ejercicio.imagen AS ejercicio_imagen,
                                  rutinaejerciciopersonalizado.nombre AS rutina_nombre,
                                  rutinaejerciciopersonalizado.idrutinapersonalizada,
                                  persona.nombres AS cliente_nombres,
                                  persona.cedula AS cliente_cedula,
                                  cliente.idcliente,
                                  programaentrenamientopersonalizado.nombre AS programa_nombre')
                        ->join('ejercicio', 'ejercicio.idejercicio = planejerciciopersonalizado.idejercicio', 'inner')
                        ->join('rutinaplanpersonalizado', 'rutinaplanpersonalizado.idplanpersonalizado = planejerciciopersonalizado.idplanpersonalizado', 'left')
                        ->join('rutinaejerciciopersonalizado', 'rutinaejerciciopersonalizado.idrutinapersonalizada = rutinaplanpersonalizado.idrutinapersonalizada', 'left')
                        ->join('rutinaprogramapersonalizado', 'rutinaprogramapersonalizado.idrutinapersonalizada = rutinaejerciciopersonalizado.idrutinapersonalizada', 'left')
                        ->join('programaentrenamientopersonalizado', 'programaentrenamientopersonalizado.idprogramapersonalizado = rutinaprogramapersonalizado.idprogramapersonalizado', 'left')
                        ->join('cliente', 'cliente.idcliente = rutinaejerciciopersonalizado.idcliente OR cliente.idcliente = programaentrenamientopersonalizado.idcliente', 'left')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'left')
                        ->orderBy('planejerciciopersonalizado.idplanpersonalizado', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('planejerciciopersonalizado.nombre', $search)
                    ->orLike('ejercicio.nombreespanol', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('rutinaejerciciopersonalizado.nombre', $search)
                    ->orLike('programaentrenamientopersonalizado.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('planejerciciopersonalizado.idplanpersonalizado', (int)$search)
                        ->orWhere('planejerciciopersonalizado.duracionsemana', (int)$search)
                        ->orWhere('planejerciciopersonalizado.diassemanas', (int)$search)
                        ->orWhere('planejerciciopersonalizado.repeticiones', (int)$search)
                        ->orWhere('planejerciciopersonalizado.series', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getPlanesByRutinaPersonalizada(int $idRutinaPersonalizada): array
    {
        $db = \Config\Database::connect();
        return $db->table('rutinaplanpersonalizado rplp')
                  ->select('rplp.idrutinaplanpersonalizado,
                            rplp.idrutinaplanpersonalizado AS id_rutina_plan,
                            rplp.idrutinapersonalizada,
                            rplp.idrutinapersonalizada AS idrutinaejercicio,
                            pep.idplanpersonalizado,
                            pep.idplanpersonalizado AS idplanejercicio,
                            pep.idplanejerciciomodelo,
                            pep.nombre,
                            pep.diassemanas,
                            pep.diassemanas AS plan_diassemanas,
                            pep.repeticiones,
                            pep.repeticiones AS plan_repeticiones,
                            pep.series,
                            pep.series AS plan_series,
                            pep.tiempodescanso,
                            pep.tiempodescanso AS plan_tiempodescanso,
                            pep.peso,
                            pep.peso AS plan_peso,
                            pep.fechainicio,
                            pep.fechainicio AS plan_fechainicio,
                            pep.duracionsemana,
                            pep.duracionsemana AS plan_duracionsemana,
                            ej.idejercicio,
                            ej.nombreespanol AS ejercicio_nombre,
                            ej.nombreespanol AS ejercicio_nombreespanol,
                            ej.nombreingles AS ejercicio_nombreingles,
                            ej.descripcion AS ejercicio_descripcion,
                            ej.urlvideo AS ejercicio_urlvideo,
                            ej.imagen AS ejercicio_imagen')
                  ->join('planejerciciopersonalizado pep', 'pep.idplanpersonalizado = rplp.idplanpersonalizado', 'inner')
                  ->join('ejercicio ej', 'ej.idejercicio = pep.idejercicio', 'inner')
                  ->where('rplp.idrutinapersonalizada', $idRutinaPersonalizada)
                  ->orderBy('rplp.idrutinaplanpersonalizado', 'ASC')
                  ->get()
                  ->getResultArray();
    }
}
