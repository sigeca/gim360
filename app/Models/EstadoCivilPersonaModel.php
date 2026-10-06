<?php

namespace App\Models;

use CodeIgniter\Model;

class EstadoCivilPersonaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'estadocivilpersona';
    protected $primaryKey       = 'idestadocivilpersona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona', 'idestadocivil'];

    protected $validationRules = [
        'idpersona'     => 'required|is_natural_no_zero',
        'idestadocivil' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'Debe seleccionar una persona.',
        ],
        'idestadocivil' => [
            'required' => 'Debe seleccionar un estado civil.',
        ],
    ];

    public function getEstadoCivilPersonasWithDetails($search = null)
    {
        $builder = $this->select('estadocivilpersona.*, persona.cedula, persona.nombres AS persona_nombres, estadocivil.nombre AS estadocivil_nombre')
                        ->join('persona', 'persona.idpersona = estadocivilpersona.idpersona', 'inner')
                        ->join('estadocivil', 'estadocivil.idestadocivil = estadocivilpersona.idestadocivil', 'inner')
                        ->orderBy('estadocivilpersona.idestadocivilpersona', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('estadocivil.nombre', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getEstadosCivilesByPersona($idpersona)
    {
        return $this->select('estadocivilpersona.*, estadocivil.nombre AS estadocivil_nombre')
                    ->join('estadocivil', 'estadocivil.idestadocivil = estadocivilpersona.idestadocivil', 'inner')
                    ->where('estadocivilpersona.idpersona', $idpersona)
                    ->orderBy('estadocivilpersona.idestadocivilpersona', 'ASC')
                    ->findAll();
    }
}
