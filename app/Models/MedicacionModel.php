<?php

namespace App\Models;

use CodeIgniter\Model;

class MedicacionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'medicacion';
    protected $primaryKey       = 'idmedicacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idafeccion',
        'nombre',
        'descripcion',
        'duracion',
        'recomendaciones',
    ];

    protected $validationRules = [
        'idafeccion'      => 'required|is_natural_no_zero',
        'nombre'          => 'required|min_length[2]|max_length[150]',
        'descripcion'     => 'permit_empty',
        'duracion'        => 'permit_empty|max_length[100]',
        'recomendaciones' => 'permit_empty',
    ];

    protected $validationMessages = [
        'idafeccion' => [
            'required' => 'Debe asociar la medicación a una afección médica.',
        ],
        'nombre' => [
            'required'   => 'El nombre de la medicación/tratamiento es obligatorio.',
            'min_length' => 'Debe contener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 150 caracteres.',
        ],
    ];

    public function getMedicacionesWithDetails(?string $search = null, ?int $idafeccion = null): array
    {
        AfeccionModel::ensureMedicationTables();

        $builder = $this->select('medicacion.*,
                                  a.nombre AS afeccion_nombre, a.sintomas AS afeccion_sintomas,
                                  (SELECT COUNT(*) FROM medicacionmedicamento mm WHERE mm.idmedicacion = medicacion.idmedicacion) AS total_medicamentos,
                                  (SELECT COUNT(*) FROM mimedicacion mim WHERE mim.idmedicacion = medicacion.idmedicacion) AS total_personalizaciones')
                        ->join('afeccion a', 'a.idafeccion = medicacion.idafeccion', 'inner')
                        ->orderBy('medicacion.idmedicacion', 'DESC');

        if (!empty($idafeccion)) {
            $builder->where('medicacion.idafeccion', $idafeccion);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('medicacion.nombre', $search)
                    ->orLike('medicacion.descripcion', $search)
                    ->orLike('medicacion.recomendaciones', $search)
                    ->orLike('a.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('medicacion.idmedicacion', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getMedicacionWithDetails(int $id): ?array
    {
        AfeccionModel::ensureMedicationTables();

        $med = $this->select('medicacion.*,
                              a.nombre AS afeccion_nombre, a.descripcion AS afeccion_descripcion, a.sintomas AS afeccion_sintomas')
                    ->join('afeccion a', 'a.idafeccion = medicacion.idafeccion', 'inner')
                    ->where('medicacion.idmedicacion', $id)
                    ->first();

        if (!$med) {
            return null;
        }

        $med['medicamentos'] = (new MedicacionMedicamentoModel())->getMedicamentosByMedicacion($id);
        return $med;
    }
}
