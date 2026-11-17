<?php

namespace App\Models;

use CodeIgniter\Model;

class PaisModel extends Model
{
    use NavigableTrait;

    protected $table            = 'pais';
    protected $primaryKey       = 'idpais';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[150]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del país es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 150 caracteres.',
        ],
    ];
}
