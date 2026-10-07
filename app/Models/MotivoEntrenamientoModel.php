<?php

namespace App\Models;

use CodeIgniter\Model;

class MotivoEntrenamientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'motivoentrenamiento';
    protected $primaryKey       = 'idmotivoentrenamiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'objetivo'];

    protected $validationRules = [
        'nombre'   => 'required|min_length[2]|max_length[100]',
        'objetivo' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del motivo de entrenamiento es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
        ],
    ];

    public function getMotivos(?string $search = null)
    {
        $builder = $this->orderBy($this->primaryKey, 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('objetivo', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
