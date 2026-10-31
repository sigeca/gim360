<?php

namespace App\Models;

use CodeIgniter\Model;

class FormatoImagenModel extends Model
{
    use NavigableTrait;

    protected $table            = 'formatoimagen';
    protected $primaryKey       = 'idformatoimagen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
    ];

    public function getFormatos(): array
    {
        return $this->orderBy('idformatoimagen', 'ASC')->findAll();
    }
}
