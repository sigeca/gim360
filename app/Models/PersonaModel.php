<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'persona';
    protected $primaryKey       = 'idpersona';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['cedula', 'apellidos', 'nombres', 'fechanacimiento', 'idsexo'];

    protected $validationRules = [
        'cedula'    => 'required|min_length[5]|max_length[20]|is_unique[persona.cedula,idpersona,{idpersona}]',
        'apellidos' => 'required|min_length[2]|max_length[100]',
        'nombres'   => 'required|min_length[2]|max_length[100]',
        'idsexo'    => 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'cedula' => [
            'required'  => 'La cédula es obligatoria.',
            'is_unique' => 'Esta cédula ya está registrada para otra persona.',
        ],
        'apellidos' => [
            'required'   => 'Los apellidos son obligatorios.',
            'min_length' => 'Debe contener al menos 2 caracteres.',
        ],
        'nombres' => [
            'required'   => 'Los nombres son obligatorios.',
            'min_length' => 'Debe contener al menos 2 caracteres.',
        ],
    ];

    /**
     * Obtener listado de personas con datos de sexo y bandera de cliente
     */
    public function getPersonasWithRelations($search = null)
    {
        $builder = $this->select('persona.*, sexo.nombre AS sexo_nombre, cliente.idcliente')
                        ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                        ->join('cliente', 'cliente.idpersona = persona.idpersona', 'left')
                        ->orderBy('persona.idpersona', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.apellidos', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike("CONCAT(persona.apellidos, ' ', persona.nombres)", $search)
                    ->orLike("CONCAT(persona.nombres, ' ', persona.apellidos)", $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtener persona específica con sexo
     */
    public function getPersonaDetail($idpersona)
    {
        return $this->select('persona.*, sexo.nombre AS sexo_nombre, cliente.idcliente')
                    ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                    ->join('cliente', 'cliente.idpersona = persona.idpersona', 'left')
                    ->where('persona.idpersona', $idpersona)
                    ->first();
    }
}
