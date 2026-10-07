<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaEntrenamientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'programaentrenamiento';
    protected $primaryKey       = 'idprogramaentrenamiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmotivoentrenamiento',
        'idrutinaejercicio',
        'idejercicio',
    ];

    protected $validationRules = [
        'idmotivoentrenamiento' => 'required|is_natural_no_zero',
        'idrutinaejercicio'     => 'required|is_natural_no_zero',
        'idejercicio'           => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idmotivoentrenamiento' => [
            'required'           => 'Debe seleccionar un motivo de entrenamiento.',
            'is_natural_no_zero' => 'Debe seleccionar un motivo válido.',
        ],
        'idrutinaejercicio' => [
            'required'           => 'Debe seleccionar una rutina de ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar una rutina válida.',
        ],
        'idejercicio' => [
            'required'           => 'Debe seleccionar un ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar un ejercicio válido.',
        ],
    ];

    public function getProgramaWithDetails($id)
    {
        return $this->select('programaentrenamiento.*, 
                              motivoentrenamiento.nombre AS motivo_nombre, 
                              motivoentrenamiento.objetivo AS motivo_objetivo,
                              rutinaejecicio.nombre AS rutina_nombre, 
                              ejercicio.nombre AS ejercicio_nombre, 
                              ejercicio.descripcion AS ejercicio_descripcion, 
                              ejercicio.urlvideo AS ejercicio_urlvideo, 
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = programaentrenamiento.idrutinaejercicio', 'inner')
                    ->join('ejercicio', 'ejercicio.idejercicio = programaentrenamiento.idejercicio', 'inner')
                    ->where('programaentrenamiento.idprogramaentrenamiento', $id)
                    ->first();
    }

    public function getProgramasWithDetails(?string $search = null)
    {
        $builder = $this->select('programaentrenamiento.*, 
                                  motivoentrenamiento.nombre AS motivo_nombre, 
                                  rutinaejecicio.nombre AS rutina_nombre, 
                                  ejercicio.nombre AS ejercicio_nombre, 
                                  ejercicio.imagen AS ejercicio_imagen')
                        ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                        ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = programaentrenamiento.idrutinaejercicio', 'inner')
                        ->join('ejercicio', 'ejercicio.idejercicio = programaentrenamiento.idejercicio', 'inner')
                        ->orderBy('programaentrenamiento.idprogramaentrenamiento', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('motivoentrenamiento.nombre', $search)
                    ->orLike('rutinaejecicio.nombre', $search)
                    ->orLike('ejercicio.nombre', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
