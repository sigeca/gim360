<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicacionMedicamentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'medicacionmedicamento';
    protected $primaryKey       = 'idmedicacionmedicamento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmedicacion',
        'idmedicamento',
        'dosis',
        'frecuencia',
        'instrucciones',
    ];

    protected $validationRules = [
        'idmedicacion'  => 'required|is_natural_no_zero',
        'idmedicamento' => 'required|is_natural_no_zero',
        'dosis'         => 'permit_empty|max_length[150]',
        'frecuencia'    => 'permit_empty|max_length[150]',
        'instrucciones' => 'permit_empty',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        AfeccionModel::ensureMedicationTables();

        return $this->select('medicacionmedicamento.*,
                              m.nombre AS medicacion_nombre, m.duracion AS medicacion_duracion,
                              a.idafeccion, a.nombre AS afeccion_nombre,
                              med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion,
                              med.presentacion, med.laboratorio, med.indicaciones, med.contraindicaciones')
                    ->join('medicacion m', 'm.idmedicacion = medicacionmedicamento.idmedicacion', 'inner')
                    ->join('afeccion a', 'a.idafeccion = m.idafeccion', 'inner')
                    ->join('medicamento med', 'med.idmedicamento = medicacionmedicamento.idmedicamento', 'inner')
                    ->where('medicacionmedicamento.idmedicacionmedicamento', $id)
                    ->first();
    }

    public function getMedicamentosByMedicacion(int $idmedicacion): array
    {
        AfeccionModel::ensureMedicationTables();

        return $this->select('medicacionmedicamento.*,
                              med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion,
                              med.presentacion, med.laboratorio, med.indicaciones, med.contraindicaciones')
                    ->join('medicamento med', 'med.idmedicamento = medicacionmedicamento.idmedicamento', 'inner')
                    ->where('medicacionmedicamento.idmedicacion', $idmedicacion)
                    ->orderBy('med.nombre', 'ASC')
                    ->findAll();
    }

    public function getMedicacionesByMedicamento(int $idmedicamento): array
    {
        AfeccionModel::ensureMedicationTables();

        return $this->select('medicacionmedicamento.*,
                              m.nombre AS medicacion_nombre, m.duracion AS medicacion_duracion,
                              a.idafeccion, a.nombre AS afeccion_nombre')
                    ->join('medicacion m', 'm.idmedicacion = medicacionmedicamento.idmedicacion', 'inner')
                    ->join('afeccion a', 'a.idafeccion = m.idafeccion', 'inner')
                    ->where('medicacionmedicamento.idmedicamento', $idmedicamento)
                    ->orderBy('m.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmedicacion = null, ?int $idmedicamento = null): array
    {
        AfeccionModel::ensureMedicationTables();

        $builder = $this->select('medicacionmedicamento.*,
                                  m.nombre AS medicacion_nombre,
                                  a.nombre AS afeccion_nombre,
                                  med.nombre AS medicamento_nombre, med.principioactivo, med.concentracion, med.presentacion')
                        ->join('medicacion m', 'm.idmedicacion = medicacionmedicamento.idmedicacion', 'inner')
                        ->join('afeccion a', 'a.idafeccion = m.idafeccion', 'inner')
                        ->join('medicamento med', 'med.idmedicamento = medicacionmedicamento.idmedicamento', 'inner')
                        ->orderBy('m.nombre', 'ASC')
                        ->orderBy('med.nombre', 'ASC');

        if (!empty($idmedicacion)) {
            $builder->where('medicacionmedicamento.idmedicacion', $idmedicacion);
        }

        if (!empty($idmedicamento)) {
            $builder->where('medicacionmedicamento.idmedicamento', $idmedicamento);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('m.nombre', $search)
                    ->orLike('a.nombre', $search)
                    ->orLike('med.nombre', $search)
                    ->orLike('med.principioactivo', $search)
                    ->orLike('medicacionmedicamento.dosis', $search)
                    ->orLike('medicacionmedicamento.frecuencia', $search);
            if (is_numeric($search)) {
                $builder->orWhere('medicacionmedicamento.idmedicacionmedicamento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
