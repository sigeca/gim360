<?php

namespace App\Models;

use CodeIgniter\Model;

class CumplimientoPlanAlimentacionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'cumplimientoplanalimentacion';
    protected $primaryKey       = 'idcumplimientoplanalimentacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idplanalimentacion',
        'idcomida',
        'fechahora',
    ];

    protected $validationRules = [
        'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
        'idcomida'           => 'required|is_natural_no_zero|is_not_unique[comida.idcomida]',
        'fechahora'          => 'required',
    ];

    protected $validationMessages = [
        'idplanalimentacion' => [
            'required'           => 'Debe seleccionar un plan de alimentación.',
            'is_natural_no_zero' => 'Seleccione un plan válido.',
            'is_not_unique'      => 'El plan de alimentación seleccionado no existe.',
        ],
        'idcomida' => [
            'required'           => 'Debe seleccionar una comida programada.',
            'is_natural_no_zero' => 'Seleccione una comida válida.',
            'is_not_unique'      => 'La comida seleccionada no existe.',
        ],
        'fechahora' => [
            'required' => 'La fecha y hora de cumplimiento son obligatorias.',
        ],
    ];

    /**
     * Obtiene un registro individual con todos sus detalles relacionados
     */
    public function getCumplimientoWithDetails(int $id): ?array
    {
        return $this->select('cumplimientoplanalimentacion.*, 
                              pa.nombre AS plan_nombre, 
                              pa.fechainicio AS plan_fechainicio, 
                              pa.fechafin AS plan_fechafin, 
                              p.idpersona, 
                              p.cedula, 
                              p.nombres, 
                              p.apellidos, 
                              c.idtipocomida, 
                              c.idreceta, 
                              c.horarecomendada, 
                              tc.nombre AS tipocomida_nombre, 
                              r.nombre AS receta_nombre, 
                              r.porciones, 
                              r.tiempopreparacion, 
                              r.instrucciones')
                    ->join('planalimentacion pa', 'pa.idplanalimentacion = cumplimientoplanalimentacion.idplanalimentacion', 'left')
                    ->join('persona p', 'p.idpersona = pa.idpersona', 'left')
                    ->join('comida c', 'c.idcomida = cumplimientoplanalimentacion.idcomida', 'left')
                    ->join('tipocomida tc', 'tc.idtipocomida = c.idtipocomida', 'left')
                    ->join('receta r', 'r.idreceta = c.idreceta', 'left')
                    ->where('cumplimientoplanalimentacion.idcumplimientoplanalimentacion', $id)
                    ->first();
    }

    /**
     * Obtiene el listado de cumplimientos con filtros
     */
    public function getCumplimientosWithDetails(?string $search = null, ?int $idplan = null, ?int $idcomida = null, ?string $fecha = null): array
    {
        $builder = $this->select('cumplimientoplanalimentacion.*, 
                                  pa.nombre AS plan_nombre, 
                                  p.cedula, 
                                  p.nombres, 
                                  p.apellidos, 
                                  c.horarecomendada, 
                                  tc.nombre AS tipocomida_nombre, 
                                  r.nombre AS receta_nombre, 
                                  r.porciones')
                        ->join('planalimentacion pa', 'pa.idplanalimentacion = cumplimientoplanalimentacion.idplanalimentacion', 'left')
                        ->join('persona p', 'p.idpersona = pa.idpersona', 'left')
                        ->join('comida c', 'c.idcomida = cumplimientoplanalimentacion.idcomida', 'left')
                        ->join('tipocomida tc', 'tc.idtipocomida = c.idtipocomida', 'left')
                        ->join('receta r', 'r.idreceta = c.idreceta', 'left')
                        ->orderBy('cumplimientoplanalimentacion.fechahora', 'DESC')
                        ->orderBy('cumplimientoplanalimentacion.idcumplimientoplanalimentacion', 'DESC');

        if (!empty($idplan)) {
            $builder->where('cumplimientoplanalimentacion.idplanalimentacion', $idplan);
        }

        if (!empty($idcomida)) {
            $builder->where('cumplimientoplanalimentacion.idcomida', $idcomida);
        }

        if (!empty($fecha)) {
            $builder->like('cumplimientoplanalimentacion.fechahora', $fecha, 'after');
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('pa.nombre', $search)
                    ->orLike('tc.nombre', $search)
                    ->orLike('r.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('p.cedula', $search);
            if (is_numeric($search)) {
                $builder->orWhere('cumplimientoplanalimentacion.idcumplimientoplanalimentacion', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene los cumplimientos registrados para un plan específico
     */
    public function getCumplimientosByPlan(int $idplan): array
    {
        return $this->select('cumplimientoplanalimentacion.*, 
                              c.idtipocomida, 
                              c.idreceta, 
                              c.horarecomendada, 
                              tc.nombre AS tipocomida_nombre, 
                              r.nombre AS receta_nombre, 
                              r.porciones, 
                              r.tiempopreparacion')
                    ->join('comida c', 'c.idcomida = cumplimientoplanalimentacion.idcomida', 'left')
                    ->join('tipocomida tc', 'tc.idtipocomida = c.idtipocomida', 'left')
                    ->join('receta r', 'r.idreceta = c.idreceta', 'left')
                    ->where('cumplimientoplanalimentacion.idplanalimentacion', $idplan)
                    ->orderBy('cumplimientoplanalimentacion.fechahora', 'DESC')
                    ->findAll();
    }

    /**
     * Cuenta cumplimientos por plan
     */
    public function contarPorPlan(int $idplan): int
    {
        return $this->where('idplanalimentacion', $idplan)->countAllResults();
    }
}
