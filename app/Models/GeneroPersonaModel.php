<?php

namespace App\Models;

use CodeIgniter\Model;

class GeneroPersonaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'generopersona';
    protected $primaryKey       = 'idgeneropersona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona', 'idgenero'];

    protected $validationRules = [
        'idpersona' => 'required|is_natural_no_zero',
        'idgenero'  => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'Debe seleccionar una persona.',
        ],
        'idgenero' => [
            'required' => 'Debe seleccionar un género.',
        ],
    ];

    public function getGeneroPersonasWithDetails($search = null)
    {
        $builder = $this->select('generopersona.*, persona.cedula, persona.nombres AS persona_nombres, genero.nombre AS genero_nombre')
                        ->join('persona', 'persona.idpersona = generopersona.idpersona', 'inner')
                        ->join('genero', 'genero.idgenero = generopersona.idgenero', 'inner')
                        ->orderBy('generopersona.idgeneropersona', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('genero.nombre', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getGenerosByPersona($idpersona)
    {
        return $this->select('generopersona.*, genero.nombre AS genero_nombre')
                    ->join('genero', 'genero.idgenero = generopersona.idgenero', 'inner')
                    ->where('generopersona.idpersona', $idpersona)
                    ->orderBy('generopersona.idgeneropersona', 'ASC')
                    ->findAll();
    }
}
