<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenadorModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ordenador';
    protected $primaryKey       = 'idordenador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    public function getOrdenadores(): array
    {
        return $this->orderBy('idordenador', 'ASC')->findAll();
    }
}
