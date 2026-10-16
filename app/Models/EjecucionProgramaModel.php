<?php

namespace App\Models;

use CodeIgniter\Model;

class EjecucionProgramaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ejecucionprograma';
    protected $primaryKey       = 'idejecucionprograma';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramacliente',
        'idejercicio',
        'fecha',
        'horainicio',
        'horafin',
    ];

    protected $validationRules = [
        'idprogramacliente' => 'required|is_natural_no_zero',
        'idejercicio'       => 'required|is_natural_no_zero',
        'fecha'             => 'required|valid_date[Y-m-d]',
        'horainicio'        => 'required',
        'horafin'           => 'permit_empty',
    ];

    protected $validationMessages = [
        'idprogramacliente' => [
            'required'           => 'Debe seleccionar un programa asignado al cliente.',
            'is_natural_no_zero' => 'El programa de cliente seleccionado no es válido.',
        ],
        'idejercicio' => [
            'required'           => 'Debe seleccionar un ejercicio.',
            'is_natural_no_zero' => 'El ejercicio seleccionado no es válido.',
        ],
        'fecha' => [
            'required'   => 'La fecha de ejecución es obligatoria.',
            'valid_date' => 'La fecha debe tener un formato válido (AAAA-MM-DD).',
        ],
        'horainicio' => [
            'required' => 'La hora de inicio es obligatoria.',
        ],
    ];

    public function getEjecucionWithDetails($id)
    {
        return $this->select('ejecucionprograma.*,
                              programacliente.idcliente,
                              programacliente.idprogramaentrenamiento,
                              programacliente.fechainicio AS programa_fechainicio,
                              estadoprogramacliente.nombre AS estado_nombre,
                              cliente.idpersona,
                              persona.cedula AS cliente_cedula,
                              persona.nombres AS cliente_nombres,
                              persona.apellidos AS cliente_apellidos,
                              programaentrenamiento.nombre AS programa_nombre,
                              ejercicio.nombreespanol AS ejercicio_nombreespanol,
                              ejercicio.nombreingles AS ejercicio_nombreingles,
                              ejercicio.nombreespanol AS ejercicio_nombre,
                              ejercicio.imagen AS ejercicio_imagen,
                              ejercicio.descripcion AS ejercicio_descripcion')
                    ->join('programacliente', 'programacliente.idprogramacliente = ejecucionprograma.idprogramacliente', 'inner')
                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'left')
                    ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                    ->join('ejercicio', 'ejercicio.idejercicio = ejecucionprograma.idejercicio', 'inner')
                    ->where('ejecucionprograma.idejecucionprograma', $id)
                    ->first();
    }

    public function getEjecucionesWithDetails(?string $search = null): array
    {
        $builder = $this->select('ejecucionprograma.*,
                                  programacliente.idcliente,
                                  programacliente.idprogramaentrenamiento,
                                  estadoprogramacliente.nombre AS estado_nombre,
                                  cliente.idpersona,
                                  persona.cedula AS cliente_cedula,
                                  persona.nombres AS cliente_nombres,
                                  persona.apellidos AS cliente_apellidos,
                                  programaentrenamiento.nombre AS programa_nombre,
                                  ejercicio.nombreespanol AS ejercicio_nombreespanol,
                                  ejercicio.nombreingles AS ejercicio_nombreingles,
                                  ejercicio.nombreespanol AS ejercicio_nombre,
                                  ejercicio.imagen AS ejercicio_imagen')
                        ->join('programacliente', 'programacliente.idprogramacliente = ejecucionprograma.idprogramacliente', 'inner')
                        ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'left')
                        ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                        ->join('ejercicio', 'ejercicio.idejercicio = ejecucionprograma.idejercicio', 'inner')
                        ->orderBy('ejecucionprograma.fecha', 'DESC')
                        ->orderBy('ejecucionprograma.horainicio', 'DESC')
                        ->orderBy('ejecucionprograma.idejecucionprograma', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('persona.apellidos', $search)
                    ->orLike('programaentrenamiento.nombre', $search)
                    ->orLike('ejercicio.nombreespanol', $search)
                    ->orLike('ejercicio.nombreingles', $search)
                    ->orLike('ejecucionprograma.fecha', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getEjecucionesByProgramaCliente(int $idprogramacliente): array
    {
        return $this->select('ejecucionprograma.*,
                              ejercicio.nombreespanol AS ejercicio_nombreespanol,
                              ejercicio.nombreingles AS ejercicio_nombreingles,
                              ejercicio.nombreespanol AS ejercicio_nombre,
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('ejercicio', 'ejercicio.idejercicio = ejecucionprograma.idejercicio', 'inner')
                    ->where('ejecucionprograma.idprogramacliente', $idprogramacliente)
                    ->orderBy('ejecucionprograma.fecha', 'DESC')
                    ->orderBy('ejecucionprograma.horainicio', 'DESC')
                    ->orderBy('ejecucionprograma.idejecucionprograma', 'DESC')
                    ->findAll();
    }
}
