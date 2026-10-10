<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanEjercicioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'planejercicio';
    protected $primaryKey       = 'idplanejercicio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idejercicio',
        'diassemanas',
        'repeticiones',
        'series',
        'tiempodescanso',
        'peso',
    ];

    protected $validationRules = [
        'idejercicio'    => 'required|is_natural_no_zero',
        'diassemanas'    => 'permit_empty|is_natural_no_zero',
        'repeticiones'   => 'permit_empty|is_natural_no_zero',
        'series'         => 'permit_empty|is_natural_no_zero',
        'tiempodescanso' => 'permit_empty|is_natural',
        'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
    ];

    protected $validationMessages = [
        'idejercicio' => [
            'required'           => 'Debe seleccionar un ejercicio.',
            'is_natural_no_zero' => 'Debe seleccionar un ejercicio válido.',
        ],
        'diassemanas' => [
            'is_natural_no_zero' => 'El número de días por semana debe ser un número entero mayor a cero.',
        ],
        'repeticiones' => [
            'is_natural_no_zero' => 'El número de repeticiones debe ser un número entero mayor a cero.',
        ],
        'series' => [
            'is_natural_no_zero' => 'El número de series debe ser un número entero mayor a cero.',
        ],
        'tiempodescanso' => [
            'is_natural' => 'El tiempo de descanso debe ser un número entero en segundos (cero o mayor).',
        ],
        'peso' => [
            'numeric'               => 'El peso debe ser un número decimal válido.',
            'greater_than_equal_to' => 'El peso no puede ser negativo.',
        ],
    ];

    public function getPlanWithDetails($id)
    {
        return $this->select('planejercicio.*, 
                              ejercicio.nombre AS ejercicio_nombre, 
                              ejercicio.descripcion AS ejercicio_descripcion, 
                              ejercicio.urlvideo AS ejercicio_urlvideo, 
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('ejercicio', 'ejercicio.idejercicio = planejercicio.idejercicio', 'inner')
                    ->where('planejercicio.idplanejercicio', $id)
                    ->first();
    }

    public function getPlanesWithDetails(?string $search = null)
    {
        $builder = $this->select('planejercicio.*, 
                                  ejercicio.nombre AS ejercicio_nombre, 
                                  ejercicio.imagen AS ejercicio_imagen')
                        ->join('ejercicio', 'ejercicio.idejercicio = planejercicio.idejercicio', 'inner')
                        ->orderBy('planejercicio.idplanejercicio', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ejercicio.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('planejercicio.idplanejercicio', (int)$search)
                        ->orWhere('planejercicio.diassemanas', (int)$search)
                        ->orWhere('planejercicio.repeticiones', (int)$search)
                        ->orWhere('planejercicio.series', (int)$search)
                        ->orWhere('planejercicio.tiempodescanso', (int)$search)
                        ->orWhere('planejercicio.peso', (float)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
