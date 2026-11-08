<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicamentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'medicamento';
    protected $primaryKey       = 'idmedicamento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'principioactivo',
        'concentracion',
        'presentacion',
        'laboratorio',
        'descripcion',
        'indicaciones',
        'contraindicaciones',
    ];

    protected $validationRules = [
        'nombre'             => 'required|min_length[2]|max_length[150]',
        'principioactivo'    => 'permit_empty|max_length[150]',
        'concentracion'      => 'permit_empty|max_length[100]',
        'presentacion'       => 'permit_empty|max_length[100]',
        'laboratorio'        => 'permit_empty|max_length[150]',
        'descripcion'        => 'permit_empty',
        'indicaciones'       => 'permit_empty',
        'contraindicaciones' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre comercial o genérico del medicamento es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public function getMedicamentosWithCounts(?string $search = null): array
    {
        AfeccionModel::ensureMedicationTables();

        $builder = $this->select('medicamento.*,
                                  (SELECT COUNT(*) FROM medicacionmedicamento mm WHERE mm.idmedicamento = medicamento.idmedicamento) AS total_medicaciones,
                                  (SELECT COUNT(*) FROM mimedicacionmedicamento mmm WHERE mmm.idmedicamento = medicamento.idmedicamento) AS total_usos_personalizados')
                        ->orderBy('medicamento.nombre', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('medicamento.nombre', $search)
                    ->orLike('medicamento.principioactivo', $search)
                    ->orLike('medicamento.concentracion', $search)
                    ->orLike('medicamento.presentacion', $search)
                    ->orLike('medicamento.laboratorio', $search)
                    ->orLike('medicamento.indicaciones', $search);
            if (is_numeric($search)) {
                $builder->orWhere('medicamento.idmedicamento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getMedicamentoWithDetails(int $id): ?array
    {
        AfeccionModel::ensureMedicationTables();

        $med = $this->find($id);
        if (!$med) {
            return null;
        }

        $med['medicaciones'] = (new MedicacionMedicamentoModel())->getMedicacionesByMedicamento($id);
        return $med;
    }
}
