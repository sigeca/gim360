<?php

namespace App\Models;

use CodeIgniter\Model;

class DiaSemanaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'diasemana';
    protected $primaryKey       = 'iddiasemana';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[4]|max_length[30]|is_unique[diasemana.nombre,iddiasemana,{iddiasemana}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del día de la semana es obligatorio.',
            'min_length' => 'Debe tener al menos 4 caracteres.',
            'max_length' => 'No puede superar los 30 caracteres.',
            'is_unique'  => 'Ya existe un día registrado con este nombre.',
        ],
    ];

    /**
     * Obtiene los días de la semana ordenados secuencialmente
     */
    public function getDiasSemana(?string $search = null): array
    {
        $builder = $this->orderBy('iddiasemana', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('iddiasemana', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
