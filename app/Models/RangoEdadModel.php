<?php

namespace App\Models;

use CodeIgniter\Model;

class RangoEdadModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rangoedad';
    protected $primaryKey       = 'idrangoedad';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'edadminima',
        'edadmaxima',
    ];

    protected $validationRules = [
        'nombre'     => 'required|min_length[2]|max_length[100]',
        'edadminima' => 'required|is_natural',
        'edadmaxima' => 'required|is_natural',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del rango de edad es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
        ],
        'edadminima' => [
            'required'   => 'La edad mínima es obligatoria.',
            'is_natural' => 'La edad mínima debe ser un número entero mayor o igual a 0.',
        ],
        'edadmaxima' => [
            'required'   => 'La edad máxima es obligatoria.',
            'is_natural' => 'La edad máxima debe ser un número entero mayor o igual a 0.',
        ],
    ];

    /**
     * Obtiene todos los rangos con buscador opcional
     */
    public function getRangos(?string $search = null)
    {
        $builder = $this->select('rangoedad.*, 
                                  (SELECT COUNT(*) FROM programaentrenamiento pe WHERE pe.idrangoedad = rangoedad.idrangoedad) AS total_programas')
                        ->orderBy('edadminima', 'ASC')
                        ->orderBy('edadmaxima', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idrangoedad', (int)$search)
                        ->orWhere('edadminima', (int)$search)
                        ->orWhere('edadmaxima', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene los programas de entrenamiento asignados a este rango de edad
     */
    public function getProgramasByRango(int $idrangoedad): array
    {
        $db = \Config\Database::connect();
        return $db->table('programaentrenamiento pe')
                  ->select('pe.*, me.nombre AS motivo_nombre,
                            (SELECT COUNT(*) FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = pe.idprogramaentrenamiento) AS total_rutinas')
                  ->join('motivoentrenamiento me', 'me.idmotivoentrenamiento = pe.idmotivoentrenamiento', 'inner')
                  ->where('pe.idrangoedad', $idrangoedad)
                  ->orderBy('pe.idprogramaentrenamiento', 'ASC')
                  ->get()
                  ->getResultArray();
    }
}
