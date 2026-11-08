<?php

namespace App\Models;

use CodeIgniter\Model;

class MiMedicacionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mimedicacion';
    protected $primaryKey       = 'idmimedicacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idpersona',
        'idafeccion',
        'idmedicacion',
        'nombre',
        'descripcion',
        'fechainicio',
        'fechafin',
        'medicotratante',
        'estado',
    ];

    protected $validationRules = [
        'idpersona'      => 'required|is_natural_no_zero',
        'idafeccion'     => 'permit_empty|is_natural_no_zero',
        'idmedicacion'   => 'permit_empty|is_natural_no_zero',
        'nombre'         => 'required|min_length[2]|max_length[150]',
        'descripcion'    => 'permit_empty',
        'fechainicio'    => 'permit_empty|valid_date',
        'fechafin'       => 'permit_empty|valid_date',
        'medicotratante' => 'permit_empty|max_length[150]',
        'estado'         => 'permit_empty|max_length[50]',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'La persona a quien pertenece la medicación es obligatoria.',
        ],
        'nombre' => [
            'required'   => 'El nombre del tratamiento de Mi Medicación es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede exceder los 150 caracteres.',
        ],
    ];

    public function getMisMedicacionesWithDetails(?string $search = null, ?int $idpersona = null, ?int $idafeccion = null): array
    {
        AfeccionModel::ensureMedicationTables();

        $builder = $this->select('mimedicacion.*,
                                  p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  a.nombre AS afeccion_nombre,
                                  med.nombre AS base_medicacion_nombre,
                                  (SELECT COUNT(*) FROM mimedicacionmedicamento mmm WHERE mmm.idmimedicacion = mimedicacion.idmimedicacion) AS total_medicamentos')
                        ->join('persona p', 'p.idpersona = mimedicacion.idpersona', 'inner')
                        ->join('afeccion a', 'a.idafeccion = mimedicacion.idafeccion', 'left')
                        ->join('medicacion med', 'med.idmedicacion = mimedicacion.idmedicacion', 'left')
                        ->orderBy('mimedicacion.idmimedicacion', 'DESC');

        if (!empty($idpersona)) {
            $builder->where('mimedicacion.idpersona', $idpersona);
        }

        if (!empty($idafeccion)) {
            $builder->where('mimedicacion.idafeccion', $idafeccion);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('mimedicacion.nombre', $search)
                    ->orLike('mimedicacion.descripcion', $search)
                    ->orLike('mimedicacion.medicotratante', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('p.cedula', $search)
                    ->orLike('a.nombre', $search)
                    ->orLike('med.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mimedicacion.idmimedicacion', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getMiMedicacionWithDetails(int $id): ?array
    {
        AfeccionModel::ensureMedicationTables();

        $item = $this->select('mimedicacion.*,
                               p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                               a.nombre AS afeccion_nombre, a.sintomas AS afeccion_sintomas, a.descripcion AS afeccion_descripcion,
                               med.nombre AS base_medicacion_nombre, med.descripcion AS base_medicacion_descripcion, med.duracion AS base_medicacion_duracion, med.recomendaciones AS base_medicacion_recomendaciones')
                     ->join('persona p', 'p.idpersona = mimedicacion.idpersona', 'inner')
                     ->join('afeccion a', 'a.idafeccion = mimedicacion.idafeccion', 'left')
                     ->join('medicacion med', 'med.idmedicacion = mimedicacion.idmedicacion', 'left')
                     ->where('mimedicacion.idmimedicacion', $id)
                     ->first();

        if (!$item) {
            return null;
        }

        $item['medicamentos'] = (new MiMedicacionMedicamentoModel())->getMedicamentosByMiMedicacion($id);
        return $item;
    }

    /**
     * Clona una medicación base hacia la tabla mimedicacion para una persona,
     * copiando todos sus medicamentos configurados junto con sus dosis e instrucciones.
     */
    public function clonarDesdeMedicacion(int $idmedicacion, int $idpersona, ?string $nombrePersonalizado = null, ?string $descripcionPersonalizada = null): int
    {
        AfeccionModel::ensureMedicationTables();

        $medModel = new MedicacionModel();
        $base = $medModel->find($idmedicacion);
        if (!$base) {
            throw new \RuntimeException("La medicación base #{$idmedicacion} no existe.");
        }

        $nombre = !empty($nombrePersonalizado) ? trim($nombrePersonalizado) : ('Mi ' . $base['nombre'] . ' (Personalizada)');
        $descripcion = !empty($descripcionPersonalizada) ? trim($descripcionPersonalizada) : ($base['descripcion'] ?? 'Personalizado a partir de ' . $base['nombre']);

        $idMi = (int)$this->insert([
            'idpersona'      => $idpersona,
            'idafeccion'     => (int)$base['idafeccion'],
            'idmedicacion'   => $idmedicacion,
            'nombre'         => $nombre,
            'descripcion'    => $descripcion,
            'fechainicio'    => date('Y-m-d'),
            'medicotratante' => 'Prescripción Gim360 / Médico Tratante',
            'estado'         => 'Activa',
        ]);

        if (!$idMi) {
            throw new \RuntimeException("No se pudo registrar en mimedicacion.");
        }

        // Copiar medicamentos configurados
        $db = \Config\Database::connect();
        $items = $db->table('medicacionmedicamento')->where('idmedicacion', $idmedicacion)->get()->getResultArray();
        $mmmModel = new MiMedicacionMedicamentoModel();
        foreach ($items as $item) {
            try {
                $mmmModel->ignore(true)->insert([
                    'idmimedicacion' => $idMi,
                    'idmedicamento'  => (int)$item['idmedicamento'],
                    'dosis'          => $item['dosis'] ?? null,
                    'frecuencia'     => $item['frecuencia'] ?? null,
                    'instrucciones'  => $item['instrucciones'] ?? null,
                ]);
            } catch (\Throwable $e) {}
        }

        return $idMi;
    }
}
