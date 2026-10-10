<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadoProgramaClienteModel extends Model
{
    use NavigableTrait;

    protected $table            = 'estadoprogramacliente';
    protected $primaryKey       = 'idestadoprogramacliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[50]|is_unique[estadoprogramacliente.nombre,idestadoprogramacliente,{idestadoprogramacliente}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del estado es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede exceder los 50 caracteres.',
            'is_unique'  => 'Ya existe un estado de programa con este nombre.',
        ],
    ];

    public function getEstados(?string $search = null)
    {
        $builder = $this->orderBy('idestadoprogramacliente', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        return $builder->findAll();
    }
}
