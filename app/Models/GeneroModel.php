<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneroModel extends Model
{
    use NavigableTrait;

    protected $table            = 'genero';
    protected $primaryKey       = 'idgenero';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[50]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del género es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 50 caracteres.',
        ],
    ];
}
