<?php

namespace App\Models;

use CodeIgniter\Model;

class AfeccionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'afeccion';
    protected $primaryKey       = 'idafeccion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'descripcion',
        'sintomas',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'descripcion' => 'permit_empty',
        'sintomas'    => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la afección es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public static function ensureMedicationTables(): void
    {
        static $checked = false;
        if ($checked) {
            return;
        }
        $checked = true;

        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('afeccion') && $db->tableExists('medicamento') && $db->tableExists('medicacion') && $db->tableExists('mimedicacion')) {
                return;
            }
            $sqlFile = ROOTPATH . 'database_migration_medicacion.sql';
            if (!is_file($sqlFile)) {
                $sqlFile = APPPATH . 'Models/sql/database_migration_medicacion.sql';
            }
            if (is_file($sqlFile)) {
                $mysqli = $db->connID;
                if ($mysqli instanceof \mysqli) {
                    $sql = file_get_contents($sqlFile);
                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($res = $mysqli->store_result()) {
                                $res->free();
                            }
                        } while ($mysqli->more_results() && $mysqli->next_result());
                    }
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'AfeccionModel::ensureMedicationTables: ' . $e->getMessage());
        }
    }

    public function getAfeccionesWithCounts(?string $search = null): array
    {
        self::ensureMedicationTables();

        $builder = $this->select('afeccion.*,
                                  (SELECT COUNT(*) FROM medicacion m WHERE m.idafeccion = afeccion.idafeccion) AS total_medicaciones,
                                  (SELECT COUNT(*) FROM mimedicacion mm WHERE mm.idafeccion = afeccion.idafeccion) AS total_pacientes')
                        ->orderBy('afeccion.nombre', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('afeccion.nombre', $search)
                    ->orLike('afeccion.descripcion', $search)
                    ->orLike('afeccion.sintomas', $search);
            if (is_numeric($search)) {
                $builder->orWhere('afeccion.idafeccion', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getAfeccionWithDetails(int $id): ?array
    {
        self::ensureMedicationTables();

        $af = $this->find($id);
        if (!$af) {
            return null;
        }

        $medicacionModel = new MedicacionModel();
        $af['medicaciones'] = $medicacionModel->where('idafeccion', $id)->orderBy('nombre', 'ASC')->findAll();
        foreach ($af['medicaciones'] as &$med) {
            $med['medicamentos'] = (new MedicacionMedicamentoModel())->getMedicamentosByMedicacion((int)$med['idmedicacion']);
        }

        return $af;
    }
}
