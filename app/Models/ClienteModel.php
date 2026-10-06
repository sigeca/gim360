<?php

namespace App\Models;

use CodeIgniter\Model;

class ClienteModel extends Model
{
    use NavigableTrait;

    protected $table            = 'cliente';
    protected $primaryKey       = 'idcliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona'];

    protected $validationRules = [
        'idpersona' => 'required|is_natural_no_zero|is_unique[cliente.idpersona,idcliente,{idcliente}]',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required'  => 'Debe seleccionar una persona.',
            'is_unique' => 'Esta persona ya se encuentra registrada como cliente.',
        ],
    ];

    public function getClientesWithPersona($search = null)
    {
        $builder = $this->select('cliente.*, persona.cedula, persona.nombres AS persona_nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                        ->orderBy('cliente.idcliente', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
