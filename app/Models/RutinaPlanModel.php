<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaPlanModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rutinaplan';
    protected $primaryKey       = 'id_rutina_plan';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idrutinaejercicio',
        'idplanejercicio',
    ];

    protected $validationRules = [
        'idrutinaejercicio' => 'required|is_natural_no_zero',
        'idplanejercicio'   => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idrutinaejercicio' => [
            'required'           => 'Debe seleccionar una rutina de ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar una rutina válida.',
        ],
        'idplanejercicio' => [
            'required'           => 'Debe seleccionar un plan de ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar un plan válido.',
        ],
    ];

    /**
     * Obtiene un registro de RutinaPlan con los detalles completos de la rutina, el plan y el ejercicio.
     */
    public function getRutinaPlanWithDetails($id)
    {
        return $this->select('rutinaplan.*, 
                              rutinaejecicio.nombre AS rutina_nombre, 
                              planejercicio.diassemanas AS plan_dias,
                              planejercicio.diassemanas AS plan_diassemanas,
                              planejercicio.repeticiones AS plan_repeticiones,
                              planejercicio.series AS plan_series,
                              planejercicio.tiempodescanso AS plan_tiempodescanso,
                              planejercicio.peso AS plan_peso,
                              ejercicio.idejercicio,
                              ejercicio.nombre AS ejercicio_nombre, 
                              ejercicio.descripcion AS ejercicio_descripcion, 
                              ejercicio.urlvideo AS ejercicio_urlvideo, 
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = rutinaplan.idrutinaejercicio', 'inner')
                    ->join('planejercicio', 'planejercicio.idplanejercicio = rutinaplan.idplanejercicio', 'inner')
                    ->join('ejercicio', 'ejercicio.idejercicio = planejercicio.idejercicio', 'inner')
                    ->where('rutinaplan.id_rutina_plan', $id)
                    ->first();
    }

    /**
     * Obtiene el listado completo de registros de RutinaPlan con búsqueda opcional.
     */
    public function getRutinaPlanesWithDetails(?string $search = null)
    {
        $builder = $this->select('rutinaplan.*, 
                                  rutinaejecicio.nombre AS rutina_nombre, 
                                  planejercicio.diassemanas AS plan_dias,
                                  planejercicio.diassemanas AS plan_diassemanas,
                                  planejercicio.repeticiones AS plan_repeticiones,
                                  planejercicio.series AS plan_series,
                                  planejercicio.tiempodescanso AS plan_tiempodescanso,
                                  planejercicio.peso AS plan_peso,
                                  ejercicio.idejercicio,
                                  ejercicio.nombre AS ejercicio_nombre, 
                                  ejercicio.imagen AS ejercicio_imagen')
                        ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = rutinaplan.idrutinaejercicio', 'inner')
                        ->join('planejercicio', 'planejercicio.idplanejercicio = rutinaplan.idplanejercicio', 'inner')
                        ->join('ejercicio', 'ejercicio.idejercicio = planejercicio.idejercicio', 'inner')
                        ->orderBy('rutinaplan.id_rutina_plan', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('rutinaejecicio.nombre', $search)
                    ->orLike('ejercicio.nombre', $search);

            if (is_numeric($search)) {
                $builder->orWhere('rutinaplan.id_rutina_plan', (int)$search)
                        ->orWhere('rutinaplan.idrutinaejercicio', (int)$search)
                        ->orWhere('rutinaplan.idplanejercicio', (int)$search)
                        ->orWhere('planejercicio.diassemanas', (int)$search)
                        ->orWhere('planejercicio.repeticiones', (int)$search)
                        ->orWhere('planejercicio.series', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene todos los planes y ejercicios vinculados a una rutina específica.
     */
    public function getPlanesByRutina(int $idrutinaejercicio): array
    {
        return $this->select('rutinaplan.*, 
                              planejercicio.diassemanas AS plan_diassemanas,
                              planejercicio.repeticiones AS plan_repeticiones,
                              planejercicio.series AS plan_series,
                              planejercicio.tiempodescanso AS plan_tiempodescanso,
                              planejercicio.peso AS plan_peso,
                              ejercicio.idejercicio,
                              ejercicio.nombre AS ejercicio_nombre, 
                              ejercicio.descripcion AS ejercicio_descripcion, 
                              ejercicio.urlvideo AS ejercicio_urlvideo, 
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('planejercicio', 'planejercicio.idplanejercicio = rutinaplan.idplanejercicio', 'inner')
                    ->join('ejercicio', 'ejercicio.idejercicio = planejercicio.idejercicio', 'inner')
                    ->where('rutinaplan.idrutinaejercicio', $idrutinaejercicio)
                    ->orderBy('rutinaplan.id_rutina_plan', 'ASC')
                    ->findAll();
    }
}
