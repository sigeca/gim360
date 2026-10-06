<?php

namespace App\Models;

use CodeIgniter\Model;

class DireccionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'direccion';
    protected $primaryKey       = 'iddireccion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona', 'direccion'];

    protected $validationRules = [
        'idpersona' => 'required|is_natural_no_zero',
        'direccion' => 'required|min_length[3]|max_length[255]',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'Debe seleccionar una persona.',
        ],
        'direccion' => [
            'required'   => 'La dirección es obligatoria.',
            'min_length' => 'Debe tener al menos 3 caracteres.',
            'max_length' => 'No puede superar los 255 caracteres.',
        ],
    ];

    public function getDireccionesWithPersona($search = null)
    {
        $builder = $this->select('direccion.*, persona.cedula, persona.nombres AS persona_nombres')
                        ->join('persona', 'persona.idpersona = direccion.idpersona', 'inner')
                        ->orderBy('direccion.iddireccion', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('direccion.direccion', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getDireccionesByPersona($idpersona)
    {
        return $this->where('idpersona', $idpersona)
                    ->orderBy('iddireccion', 'ASC')
                    ->findAll();
    }
}
