<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaPlanPersonalizadoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rutinaplanpersonalizado';
    protected $primaryKey       = 'idrutinaplanpersonalizado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idrutinapersonalizada',
        'idplanpersonalizado',
    ];

    protected $validationRules = [
        'idrutinapersonalizada' => 'required|is_natural_no_zero',
        'idplanpersonalizado'   => 'required|is_natural_no_zero',
    ];
}
