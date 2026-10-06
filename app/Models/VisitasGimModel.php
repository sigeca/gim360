<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitasGimModel extends Model
{
    use NavigableTrait;

    protected $table            = 'visitasgim';
    protected $primaryKey       = 'idvisitasgim';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idcliente', 'fecha', 'horaingreso', 'horasalida'];

    protected $validationRules = [
        'idcliente'   => 'required|is_natural_no_zero',
        'fecha'       => 'required|valid_date[Y-m-d]',
        'horaingreso' => 'required',
        'horasalida'  => 'permit_empty',
    ];

    protected $validationMessages = [
        'idcliente' => [
            'required' => 'Debe seleccionar un cliente.',
        ],
        'fecha' => [
            'required'   => 'La fecha de la visita es obligatoria.',
            'valid_date' => 'La fecha no tiene un formato válido (AAAA-MM-DD).',
        ],
        'horaingreso' => [
            'required' => 'La hora de ingreso es obligatoria.',
        ],
    ];

    public function getVisitaWithDetails($id)
    {
        return $this->select('visitasgim.*, persona.cedula, persona.nombres AS cliente_nombres, persona.idpersona')
                    ->join('cliente', 'cliente.idcliente = visitasgim.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->where('visitasgim.idvisitasgim', $id)
                    ->first();
    }

    public function getVisitasWithDetails($search = null)
    {
        $builder = $this->select('visitasgim.*, persona.cedula, persona.nombres AS cliente_nombres, persona.idpersona')
                        ->join('cliente', 'cliente.idcliente = visitasgim.idcliente', 'inner')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->orderBy('visitasgim.fecha', 'DESC')
                        ->orderBy('visitasgim.horaingreso', 'DESC')
                        ->orderBy('visitasgim.idvisitasgim', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('visitasgim.fecha', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getVisitasByCliente($idcliente)
    {
        return $this->where('idcliente', $idcliente)
                    ->orderBy('fecha', 'DESC')
                    ->orderBy('horaingreso', 'DESC')
                    ->findAll();
    }
}
