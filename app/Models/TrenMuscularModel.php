<?php

namespace App\Models;

use CodeIgniter\Model;

class TrenMuscularModel extends Model
{
    use NavigableTrait;

    protected $table            = 'trenmuscular';
    protected $primaryKey       = 'idtrenmuscular';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[50]|is_unique[trenmuscular.nombre,idtrenmuscular,{idtrenmuscular}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del tren muscular es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 50 caracteres.',
            'is_unique'  => 'Ya existe un tren muscular con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los trenes musculares con estadísticas de músculos, ejercicios y programas
     */
    public function getTrenes(?string $search = null)
    {
        $builder = $this->select('trenmuscular.*,
                                  (SELECT COUNT(*) FROM musculo m WHERE m.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_musculos,
                                  (SELECT COUNT(*) FROM ejercicio e WHERE e.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_ejercicios,
                                  (SELECT COUNT(*) FROM programaentrenamiento pe WHERE pe.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_programas')
                        ->orderBy('trenmuscular.idtrenmuscular', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('trenmuscular.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('trenmuscular.idtrenmuscular', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene un tren muscular con sus conteos asociados
     */
    public function getTrenWithCounts(int $id)
    {
        return $this->select('trenmuscular.*,
                              (SELECT COUNT(*) FROM musculo m WHERE m.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_musculos,
                              (SELECT COUNT(*) FROM ejercicio e WHERE e.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_ejercicios,
                              (SELECT COUNT(*) FROM programaentrenamiento pe WHERE pe.idtrenmuscular = trenmuscular.idtrenmuscular) AS total_programas')
                    ->where('trenmuscular.idtrenmuscular', $id)
                    ->first();
    }

    /**
     * Músculos asociados a este tren muscular
     */
    public function getMusculosByTren(int $idtrenmuscular): array
    {
        return $this->db->table('musculo m')
                        ->select('m.*')
                        ->where('m.idtrenmuscular', $idtrenmuscular)
                        ->orderBy('m.nombre', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    /**
     * Ejercicios asociados a este tren muscular
     */
    public function getEjerciciosByTren(int $idtrenmuscular): array
    {
        return $this->db->table('ejercicio e')
                        ->select('e.*')
                        ->where('e.idtrenmuscular', $idtrenmuscular)
                        ->orderBy('e.nombreespanol', 'ASC')
                        ->get()
                        ->getResultArray();
    }

    /**
     * Programas de entrenamiento asociados a este tren muscular
     */
    public function getProgramasByTren(int $idtrenmuscular): array
    {
        return $this->db->table('programaentrenamiento pe')
                        ->select('pe.*, me.nombre AS motivo_nombre, re.nombre AS rango_nombre,
                                  (SELECT COUNT(*) FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = pe.idprogramaentrenamiento) AS total_rutinas')
                        ->join('motivoentrenamiento me', 'me.idmotivoentrenamiento = pe.idmotivoentrenamiento', 'inner')
                        ->join('rangoedad re', 're.idrangoedad = pe.idrangoedad', 'left')
                        ->where('pe.idtrenmuscular', $idtrenmuscular)
                        ->orderBy('pe.idprogramaentrenamiento', 'ASC')
                        ->get()
                        ->getResultArray();
    }
}
