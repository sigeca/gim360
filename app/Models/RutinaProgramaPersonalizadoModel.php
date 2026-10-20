<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaProgramaPersonalizadoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rutinaprogramapersonalizado';
    protected $primaryKey       = 'idrutinaprogramapersonalizado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramapersonalizado',
        'idrutinapersonalizada',
    ];

    protected $validationRules = [
        'idprogramapersonalizado' => 'required|is_natural_no_zero',
        'idrutinapersonalizada'   => 'required|is_natural_no_zero',
    ];
}
