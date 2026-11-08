<?php

namespace App\Models;

use CodeIgniter\Model;

class MiMedicacionMedicamentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mimedicacionmedicamento';
    protected $primaryKey       = 'idmimedicacionmedicamento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmimedicacion',
        'idmedicamento',
        'dosis',
        'frecuencia',
        'instrucciones',
    ];

    protected $validationRules = [
        'idmimedicacion' => 'required|is_natural_no_zero',
        'idmedicamento'  => 'required|is_natural_no_zero',
        'dosis'          => 'permit_empty|max_length[150]',
        'frecuencia'     => 'permit_empty|max_length[150]',
        'instrucciones'  => 'permit_empty',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        AfeccionModel::ensureMedicationTables();

        return $this->select('mimedicacionmedicamento.*,
                              mm.nombre AS mimedicacion_nombre, mm.estado AS mimedicacion_estado,
                              p.idpersona, p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              a.nombre AS afeccion_nombre,
                              med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion,
                              med.presentacion, med.laboratorio, med.indicaciones, med.contraindicaciones')
                    ->join('mimedicacion mm', 'mm.idmimedicacion = mimedicacionmedicamento.idmimedicacion', 'inner')
                    ->join('persona p', 'p.idpersona = mm.idpersona', 'inner')
                    ->join('afeccion a', 'a.idafeccion = mm.idafeccion', 'left')
                    ->join('medicamento med', 'med.idmedicamento = mimedicacionmedicamento.idmedicamento', 'inner')
                    ->where('mimedicacionmedicamento.idmimedicacionmedicamento', $id)
                    ->first();
    }

    public function getMedicamentosByMiMedicacion(int $idmimedicacion): array
    {
        AfeccionModel::ensureMedicationTables();

        return $this->select('mimedicacionmedicamento.*,
                              med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion,
                              med.presentacion, med.laboratorio, med.indicaciones, med.contraindicaciones')
                    ->join('medicamento med', 'med.idmedicamento = mimedicacionmedicamento.idmedicamento', 'inner')
                    ->where('mimedicacionmedicamento.idmimedicacion', $idmimedicacion)
                    ->orderBy('med.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmimedicacion = null, ?int $idmedicamento = null): array
    {
        AfeccionModel::ensureMedicationTables();

        $builder = $this->select('mimedicacionmedicamento.*,
                                  mm.nombre AS mimedicacion_nombre,
                                  p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion, med.presentacion')
                        ->join('mimedicacion mm', 'mm.idmimedicacion = mimedicacionmedicamento.idmimedicacion', 'inner')
                        ->join('persona p', 'p.idpersona = mm.idpersona', 'inner')
                        ->join('medicamento med', 'med.idmedicamento = mimedicacionmedicamento.idmedicamento', 'inner')
                        ->orderBy('mm.nombre', 'ASC')
                        ->orderBy('med.nombre', 'ASC');

        if (!empty($idmimedicacion)) {
            $builder->where('mimedicacionmedicamento.idmimedicacion', $idmimedicacion);
        }

        if (!empty($idmedicamento)) {
            $builder->where('mimedicacionmedicamento.idmedicamento', $idmedicamento);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('mm.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('med.nombre', $search)
                    ->orLike('med.principioactivo', $search)
                    ->orLike('mimedicacionmedicamento.dosis', $search)
                    ->orLike('mimedicacionmedicamento.frecuencia', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mimedicacionmedicamento.idmimedicacionmedicamento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
