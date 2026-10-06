<?php

namespace App\Models;

use CodeIgniter\Model;

class CorreoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'correo';
    protected $primaryKey       = 'idcorreo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona', 'correo', 'fechaoptencion'];

    protected $validationRules = [
        'idpersona'      => 'required|is_natural_no_zero',
        'correo'         => 'required|valid_email|max_length[150]',
        'fechaoptencion' => 'permit_empty|valid_date',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'Debe seleccionar una persona.',
        ],
        'correo' => [
            'required'    => 'El correo electrónico es obligatorio.',
            'valid_email' => 'Ingrese una dirección de correo válida.',
        ],
    ];

    public function getCorreosWithPersona($search = null)
    {
        $builder = $this->select('correo.*, persona.cedula, persona.nombres AS persona_nombres')
                        ->join('persona', 'persona.idpersona = correo.idpersona', 'inner')
                        ->orderBy('correo.idcorreo', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('correo.correo', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getCorreosByPersona($idpersona)
    {
        return $this->where('idpersona', $idpersona)
                    ->orderBy('idcorreo', 'ASC')
                    ->findAll();
    }
}
