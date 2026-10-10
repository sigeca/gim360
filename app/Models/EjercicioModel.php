<?php

namespace App\Models;

use CodeIgniter\Model;

class EjercicioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ejercicio';
    protected $primaryKey       = 'idejercicio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'descripcion', 'urlvideo', 'imagen'];

    protected $validationRules = [
        'nombre'      => 'required|min_length[3]|max_length[150]',
        'descripcion' => 'permit_empty',
        'urlvideo'    => 'permit_empty|max_length[255]',
        'imagen'      => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del ejercicio es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public function getEjercicios($search = null, $perPage = 20)
    {
        $builder = $this->orderBy('idejercicio', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('descripcion', $search)
                    ->orLike('imagen', $search)
                    ->groupEnd();
        }

        if ($perPage > 0) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }

    /**
     * Obtiene los músculos asociados a un ejercicio específico
     */
    public function getMusculos(int $idejercicio): array
    {
        return $this->db->table('musculoejercicio me')
            ->select('me.idmusculoejecicio, me.idmusculo, m.nombre, m.imagen')
            ->join('musculo m', 'm.idmusculo = me.idmusculo', 'inner')
            ->where('me.idejercicio', $idejercicio)
            ->orderBy('m.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene en lote los músculos asociados a un conjunto de ejercicios
     */
    public function getMusculosBatch(array $idejercicios): array
    {
        if (empty($idejercicios)) {
            return [];
        }

        $rows = $this->db->table('musculoejercicio me')
            ->select('me.idejercicio, me.idmusculoejecicio, me.idmusculo, m.nombre, m.imagen')
            ->join('musculo m', 'm.idmusculo = me.idmusculo', 'inner')
            ->whereIn('me.idejercicio', $idejercicios)
            ->orderBy('m.nombre', 'ASC')
            ->get()
            ->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['idejercicio']][] = $row;
        }

        return $result;
    }

    /**
     * Obtiene los equipos/máquinas asociados a un ejercicio específico
     */
    public function getEquipos(int $idejercicio): array
    {
        return $this->db->table('ejercicioequipo ee')
            ->select('ee.idejercicioequipo, ee.idejercicio, ee.idequipo, 
                      eq.codigo, eq.nombre, eq.imagen, eq.modelo, eq.id_tipo, eq.id_estado, eq.id_ubicacion')
            ->join('equipos eq', 'eq.id_equipo = ee.idequipo', 'inner')
            ->where('ee.idejercicio', $idejercicio)
            ->orderBy('eq.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene en lote los equipos asociados a un conjunto de ejercicios
     */
    public function getEquiposBatch(array $idejercicios): array
    {
        if (empty($idejercicios)) {
            return [];
        }

        $rows = $this->db->table('ejercicioequipo ee')
            ->select('ee.idejercicio, ee.idejercicioequipo, ee.idequipo, 
                      eq.codigo, eq.nombre, eq.imagen, eq.modelo, eq.id_tipo')
            ->join('equipos eq', 'eq.id_equipo = ee.idequipo', 'inner')
            ->whereIn('ee.idejercicio', $idejercicios)
            ->orderBy('eq.nombre', 'ASC')
            ->get()
            ->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['idejercicio']][] = $row;
        }

        return $result;
    }
}
