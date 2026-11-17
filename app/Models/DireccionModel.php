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
    protected $allowedFields    = ['idpersona', 'idpais', 'direccion'];

    protected $validationRules = [
        'idpersona' => 'required|is_natural_no_zero',
        'idpais'    => 'permit_empty|is_natural_no_zero',
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
        $builder = $this->select('direccion.*, persona.cedula, persona.nombres AS persona_nombres, pais.nombre AS pais_nombre')
                        ->join('persona', 'persona.idpersona = direccion.idpersona', 'inner')
                        ->join('pais', 'pais.idpais = direccion.idpais', 'left')
                        ->orderBy('direccion.iddireccion', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('direccion.direccion', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('pais.nombre', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getDireccionesByPersona($idpersona)
    {
        return $this->select('direccion.*, pais.nombre AS pais_nombre')
                    ->join('pais', 'pais.idpais = direccion.idpais', 'left')
                    ->where('direccion.idpersona', $idpersona)
                    ->orderBy('direccion.iddireccion', 'ASC')
                    ->findAll();
    }
}
