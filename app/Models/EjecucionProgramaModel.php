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
        'series',
        'repeticiones',
        'tiempodescanso',
        'peso',
    ];

    protected $validationRules = [
        'idprogramacliente' => 'required|is_natural_no_zero',
        'idejercicio'       => 'required|is_natural_no_zero',
        'fecha'             => 'required|valid_date[Y-m-d]',
        'horainicio'        => 'required',
        'horafin'           => 'permit_empty',
        'series'            => 'permit_empty|is_natural',
        'repeticiones'      => 'permit_empty|is_natural',
        'tiempodescanso'    => 'permit_empty|is_natural',
        'peso'              => 'permit_empty|numeric',
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
        'series' => [
            'is_natural' => 'El número de series debe ser un entero positivo o cero.',
        ],
        'repeticiones' => [
            'is_natural' => 'El número de repeticiones debe ser un entero positivo o cero.',
        ],
        'tiempodescanso' => [
            'is_natural' => 'El tiempo de descanso debe ser un número entero en segundos.',
        ],
        'peso' => [
            'numeric' => 'El peso debe ser un valor numérico válido.',
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

    /**
     * Obtiene los valores predeterminados (series, repeticiones, tiempodescanso, peso)
     * del plan de entrenamiento prescrito para un ejercicio dentro de un programa cliente.
     */
    public function getPlanDefaults(int $idprogramacliente, int $idejercicio): ?array
    {
        $db = \Config\Database::connect();
        $progCliente = $db->table('programacliente')
                          ->where('idprogramacliente', $idprogramacliente)
                          ->get()
                          ->getRowArray();
        if (!$progCliente) {
            return null;
        }

        // 1. Buscar en programa personalizado si aplica
        if (!empty($progCliente['idprogramapersonalizado'])) {
            $planPers = $db->table('rutinaplanpersonalizado rplp')
                           ->select('pep.series, pep.repeticiones, pep.tiempodescanso, pep.peso')
                           ->join('rutinapersonalizada rp', 'rp.idrutinapersonalizada = rplp.idrutinapersonalizada', 'inner')
                           ->join('rutinaprogramapersonalizado rpp', 'rpp.idrutinapersonalizada = rp.idrutinapersonalizada', 'inner')
                           ->join('planejerciciopersonalizado pep', 'pep.idplanpersonalizado = rplp.idplanpersonalizado', 'inner')
                           ->where('rpp.idprogramapersonalizado', (int)$progCliente['idprogramapersonalizado'])
                           ->where('pep.idejercicio', $idejercicio)
                           ->get()
                           ->getRowArray();
            if ($planPers) {
                return $planPers;
            }
        }

        // 2. Buscar en programa de entrenamiento estándar
        if (!empty($progCliente['idprogramaentrenamiento'])) {
            $planStd = $db->table('rutinaprograma rp')
                          ->select('pe.series, pe.repeticiones, pe.tiempodescanso, pe.peso')
                          ->join('rutinaplan rpl', 'rpl.idrutinaejercicio = rp.idrutinaejercicio', 'inner')
                          ->join('planejercicio pe', 'pe.idplanejercicio = rpl.idplanejercicio', 'inner')
                          ->where('rp.idprogramaentrenamiento', (int)$progCliente['idprogramaentrenamiento'])
                          ->where('pe.idejercicio', $idejercicio)
                          ->get()
                          ->getRowArray();
            if ($planStd) {
                return $planStd;
            }
        }

        // 3. Fallback: buscar en cualquier planejercicio asociado a este ejercicio
        $anyPlan = $db->table('planejercicio')
                      ->select('series, repeticiones, tiempodescanso, peso')
                      ->where('idejercicio', $idejercicio)
                      ->get()
                      ->getRowArray();
        return $anyPlan ?: null;
    }

    /**
     * Obtiene los ejercicios ejecutados por un cliente en una fecha específica
     */
    public function getEjecucionesByClienteYFecha(int $idcliente, string $fecha): array
    {
        return $this->select('ejecucionprograma.*,
                              ejercicio.idejercicio,
                              ejercicio.nombreespanol,
                              ejercicio.nombreingles,
                              ejercicio.nombreespanol AS ejercicio_nombre,
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('programacliente', 'programacliente.idprogramacliente = ejecucionprograma.idprogramacliente', 'inner')
                    ->join('ejercicio', 'ejercicio.idejercicio = ejecucionprograma.idejercicio', 'inner')
                    ->where('programacliente.idcliente', $idcliente)
                    ->where('ejecucionprograma.fecha', $fecha)
                    ->orderBy('ejecucionprograma.horainicio', 'ASC')
                    ->orderBy('ejecucionprograma.idejecucionprograma', 'ASC')
                    ->findAll();
    }
}
