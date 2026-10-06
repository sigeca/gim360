<?php

namespace App\Models;

use CodeIgniter\Model;

class EjercicioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ejercicio';
    protected $primaryKey       = 'idejercicio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'descripcion', 'urlvideo', 'imagen'];

    protected $validationRules = [
        'nombre'      => 'required|min_length[3]|max_length[150]',
        'descripcion' => 'permit_empty',
        'urlvideo'    => 'permit_empty|max_length[255]',
        'imagen'      => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del ejercicio es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public function getEjercicios($search = null, $perPage = 20)
    {
        $builder = $this->orderBy('idejercicio', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('descripcion', $search)
                    ->orLike('imagen', $search)
                    ->groupEnd();
        }

        if ($perPage > 0) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
