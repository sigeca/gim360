<?php

namespace App\Models;

use CodeIgniter\Model;

class EjercicioClienteModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ejerciciocliente';
    protected $primaryKey       = 'idejerciciocliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idejercicio', 'idcliente', 'fecha', 'duracionminutos'];

    protected $validationRules = [
        'idejercicio'     => 'required|is_natural_no_zero',
        'idcliente'       => 'required|is_natural_no_zero',
        'fecha'           => 'required|valid_date[Y-m-d]',
        'duracionminutos' => 'required|is_natural_no_zero|greater_than[0]|less_than_equal_to[1440]',
    ];

    protected $validationMessages = [
        'idejercicio' => [
            'required' => 'Debe seleccionar un ejercicio.',
        ],
        'idcliente' => [
            'required' => 'Debe seleccionar un cliente.',
        ],
        'fecha' => [
            'required'   => 'La fecha del ejercicio es obligatoria.',
            'valid_date' => 'La fecha debe tener un formato válido (AAAA-MM-DD).',
        ],
        'duracionminutos' => [
            'required'             => 'La duración en minutos es obligatoria.',
            'is_natural_no_zero'   => 'La duración debe ser un número entero mayor a cero.',
            'greater_than'         => 'La duración mínima es de 1 minuto.',
            'less_than_equal_to'   => 'La duración máxima permitida es de 1440 minutos (24 horas).',
        ],
    ];

    public function getEjercicioClienteWithDetails($id)
    {
        return $this->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.descripcion AS ejercicio_descripcion, ejercicio.urlvideo, ejercicio.imagen AS ejercicio_imagen, persona.nombres AS cliente_nombres, persona.cedula, persona.idpersona')
                    ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                    ->join('cliente', 'cliente.idcliente = ejerciciocliente.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->where('ejerciciocliente.idejerciciocliente', $id)
                    ->first();
    }

    public function getEjercicioClientesWithDetails($search = null)
    {
        $builder = $this->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.imagen AS ejercicio_imagen, persona.nombres AS cliente_nombres, persona.cedula, persona.idpersona')
                        ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                        ->join('cliente', 'cliente.idcliente = ejerciciocliente.idcliente', 'inner')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->orderBy('ejerciciocliente.fecha', 'DESC')
                        ->orderBy('ejerciciocliente.idejerciciocliente', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.nombres', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('ejercicio.nombre', $search)
                    ->orLike('ejerciciocliente.fecha', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getEjerciciosByCliente($idcliente)
    {
        return $this->select('ejerciciocliente.*, ejercicio.nombre AS ejercicio_nombre, ejercicio.urlvideo')
                    ->join('ejercicio', 'ejercicio.idejercicio = ejerciciocliente.idejercicio', 'inner')
                    ->where('ejerciciocliente.idcliente', $idcliente)
                    ->orderBy('ejerciciocliente.fecha', 'DESC')
                    ->findAll();
    }
}
