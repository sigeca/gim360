<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjetivoNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'objetivonutricional';
    protected $primaryKey       = 'idobjetivonutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[3]|max_length[500]|is_unique[objetivonutricional.nombre,idobjetivonutricional,{idobjetivonutricional}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del objetivo nutricional es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 500 caracteres.',
            'is_unique'  => 'Ya existe un objetivo nutricional registrado con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los objetivos con buscador opcional
     */
    public function getObjetivos(?string $search = null): array
    {
        $builder = $this->orderBy('idobjetivonutricional', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idobjetivonutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->findAll();

        // Contabilizar planes de alimentación asociados
        $db = \Config\Database::connect();
        foreach ($records as &$rec) {
            $countRow = $db->table('planalimentacion')
                           ->where('idobjetivonutricional', (int)$rec['idobjetivonutricional'])
                           ->countAllResults();
            $rec['total_planes'] = $countRow;
        }

        return $records;
    }

    /**
     * Obtiene los planes de alimentación que tienen asignado este objetivo
     */
    public function getPlanesByObjetivo(int $idobjetivo): array
    {
        return $this->db->table('planalimentacion pa')
            ->select('pa.*, p.nombres, p.apellidos, p.cedula')
            ->join('persona p', 'p.idpersona = pa.idpersona', 'inner')
            ->where('pa.idobjetivonutricional', $idobjetivo)
            ->orderBy('pa.fechainicio', 'DESC')
            ->get()
            ->getResultArray();
    }
}
