<?php

namespace App\Models;

use CodeIgniter\Model;

class ComidaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'comida';
    protected $primaryKey       = 'idcomida';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idplanalimentacion',
        'iddiasemana',
        'idtipocomida',
        'idreceta',
        'horarecomendada',
    ];

    protected $validationRules = [
        'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
        'iddiasemana'        => 'permit_empty|is_natural_no_zero|is_not_unique[diasemana.iddiasemana]',
        'idtipocomida'       => 'required|is_natural_no_zero|is_not_unique[tipocomida.idtipocomida]',
        'idreceta'           => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
        'horarecomendada'    => 'permit_empty',
    ];

    protected $validationMessages = [
        'idplanalimentacion' => [
            'required'           => 'Debe seleccionar un plan de alimentación.',
            'is_natural_no_zero' => 'Seleccione un plan válido.',
            'is_not_unique'      => 'El plan de alimentación seleccionado no existe.',
        ],
        'iddiasemana' => [
            'is_natural_no_zero' => 'Día de la semana seleccionado no válido.',
            'is_not_unique'      => 'El día de la semana no existe en el sistema.',
        ],
        'idtipocomida' => [
            'required'           => 'Debe seleccionar un tipo de comida.',
            'is_natural_no_zero' => 'Seleccione un tipo de comida válido.',
            'is_not_unique'      => 'El tipo de comida no existe en el sistema.',
        ],
        'idreceta' => [
            'required'           => 'Debe seleccionar una receta culinaria.',
            'is_natural_no_zero' => 'Seleccione una receta válida.',
            'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
        ],
    ];

    /**
     * Obtiene las comidas asignadas a un plan de alimentación específico
     * ordenadas cronológicamente por día de la semana y hora recomendada
     */
    public function getComidasByPlan(int $idplan): array
    {
        return $this->select('comida.*, ds.nombre AS diasemana_nombre, tc.nombre AS tipocomida_nombre, r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion, r.instrucciones, r.video AS receta_video')
                    ->join('diasemana ds', 'ds.iddiasemana = comida.iddiasemana', 'left')
                    ->join('tipocomida tc', 'tc.idtipocomida = comida.idtipocomida', 'left')
                    ->join('receta r', 'r.idreceta = comida.idreceta', 'left')
                    ->where('comida.idplanalimentacion', $idplan)
                    ->orderBy('comida.iddiasemana', 'ASC')
                    ->orderBy('comida.horarecomendada', 'ASC')
                    ->orderBy('comida.idtipocomida', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene una comida específica con todos sus detalles relacionados
     */
    public function getRecordWithDetails(int $id): ?array
    {
        return $this->select('comida.*, ds.nombre AS diasemana_nombre, pa.nombre AS plan_nombre, pa.idpersona, p.cedula, p.nombres, p.apellidos, tc.nombre AS tipocomida_nombre, r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion, r.instrucciones, r.video AS receta_video')
                    ->join('planalimentacion pa', 'pa.idplanalimentacion = comida.idplanalimentacion', 'inner')
                    ->join('persona p', 'p.idpersona = pa.idpersona', 'inner')
                    ->join('diasemana ds', 'ds.iddiasemana = comida.iddiasemana', 'left')
                    ->join('tipocomida tc', 'tc.idtipocomida = comida.idtipocomida', 'left')
                    ->join('receta r', 'r.idreceta = comida.idreceta', 'left')
                    ->where('comida.idcomida', $id)
                    ->first();
    }

    /**
     * Obtiene el listado de comidas con filtros opcionales
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idplan = null, ?int $idtipocomida = null, ?int $idreceta = null, ?int $iddiasemana = null): array
    {
        $builder = $this->select('comida.*, ds.nombre AS diasemana_nombre, pa.nombre AS plan_nombre, p.cedula, p.nombres, p.apellidos, tc.nombre AS tipocomida_nombre, r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion, r.video AS receta_video')
                        ->join('planalimentacion pa', 'pa.idplanalimentacion = comida.idplanalimentacion', 'inner')
                        ->join('persona p', 'p.idpersona = pa.idpersona', 'inner')
                        ->join('diasemana ds', 'ds.iddiasemana = comida.iddiasemana', 'left')
                        ->join('tipocomida tc', 'tc.idtipocomida = comida.idtipocomida', 'left')
                        ->join('receta r', 'r.idreceta = comida.idreceta', 'left')
                        ->orderBy('comida.iddiasemana', 'ASC')
                        ->orderBy('comida.horarecomendada', 'ASC')
                        ->orderBy('comida.idtipocomida', 'ASC');

        if (!empty($idplan)) {
            $builder->where('comida.idplanalimentacion', $idplan);
        }

        if (!empty($iddiasemana)) {
            $builder->where('comida.iddiasemana', $iddiasemana);
        }

        if (!empty($idtipocomida)) {
            $builder->where('comida.idtipocomida', $idtipocomida);
        }

        if (!empty($idreceta)) {
            $builder->where('comida.idreceta', $idreceta);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('pa.nombre', $search)
                    ->orLike('ds.nombre', $search)
                    ->orLike('tc.nombre', $search)
                    ->orLike('r.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('p.cedula', $search);
            if (is_numeric($search)) {
                $builder->orWhere('comida.idcomida', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
