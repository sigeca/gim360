<?php

namespace App\Models;

use CodeIgniter\Model;

class MusculoEjercicioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'musculoejercicio';
    protected $primaryKey       = 'idmusculoejecicio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idejercicio',
        'idmusculo',
    ];

    protected $validationRules = [
        'idejercicio' => 'required|is_natural_no_zero',
        'idmusculo'   => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idejercicio' => [
            'required'           => 'El ejercicio es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un ejercicio válido.',
        ],
        'idmusculo' => [
            'required'           => 'El músculo es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un músculo válido.',
        ],
    ];

    /**
     * Obtiene los músculos asignados a un ejercicio específico con datos completos
     */
    public function getMusculosByEjercicio(int $idejercicio): array
    {
        return $this->db->table('musculoejercicio me')
            ->select('me.idmusculoejecicio, me.idejercicio, me.idmusculo, m.nombre AS nombre, m.imagen AS imagen')
            ->join('musculo m', 'm.idmusculo = me.idmusculo', 'inner')
            ->where('me.idejercicio', $idejercicio)
            ->orderBy('m.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene los ejercicios asociados a un músculo
     */
    public function getEjerciciosByMusculo(int $idmusculo): array
    {
        return $this->db->table('musculoejercicio me')
            ->select('me.idmusculoejecicio, me.idejercicio, me.idmusculo, e.nombre AS ejercicio_nombre, e.imagen AS ejercicio_imagen, e.descripcion AS ejercicio_descripcion')
            ->join('ejercicio e', 'e.idejercicio = me.idejercicio', 'inner')
            ->where('me.idmusculo', $idmusculo)
            ->orderBy('e.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Sincroniza los músculos asignados a un ejercicio (inserta nuevos, elimina desmarcados)
     */
    public function syncMusculosForEjercicio(int $idejercicio, array $idmusculos): bool
    {
        $idmusculos = array_filter(array_map('intval', $idmusculos), fn($id) => $id > 0);
        $idmusculos = array_unique($idmusculos);

        // Obtener los actuales
        $current = $this->where('idejercicio', $idejercicio)->findAll();
        $currentIds = array_column($current, 'idmusculo');

        // Determinar qué borrar y qué agregar
        $toDelete = array_diff($currentIds, $idmusculos);
        $toInsert = array_diff($idmusculos, $currentIds);

        if (!empty($toDelete)) {
            $this->where('idejercicio', $idejercicio)
                 ->whereIn('idmusculo', $toDelete)
                 ->delete();
        }

        foreach ($toInsert as $idmusculo) {
            $this->insert([
                'idejercicio' => $idejercicio,
                'idmusculo'   => $idmusculo,
            ]);
        }

        return true;
    }

    /**
     * Agrega un músculo a un ejercicio si no existe
     */
    public function addMusculoToEjercicio(int $idejercicio, int $idmusculo): bool
    {
        $exists = $this->where('idejercicio', $idejercicio)
                       ->where('idmusculo', $idmusculo)
                       ->first();
        if ($exists) {
            return true;
        }

        return (bool) $this->insert([
            'idejercicio' => $idejercicio,
            'idmusculo'   => $idmusculo,
        ]);
    }

    /**
     * Elimina la asociación entre un ejercicio y un músculo
     */
    public function removeMusculoFromEjercicio(int $idejercicio, int $idmusculo): bool
    {
        return (bool) $this->where('idejercicio', $idejercicio)
                           ->where('idmusculo', $idmusculo)
                           ->delete();
    }

    /**
     * Obtiene detalle de un registro MusculoEjercicio con nombres e imágenes
     */
    public function getRecordWithDetails(int $id)
    {
        return $this->db->table('musculoejercicio me')
            ->select('me.idmusculoejecicio, me.idejercicio, me.idmusculo, 
                      e.nombre AS ejercicio_nombre, e.imagen AS ejercicio_imagen,
                      m.nombre AS musculo_nombre, m.imagen AS musculo_imagen')
            ->join('ejercicio e', 'e.idejercicio = me.idejercicio', 'inner')
            ->join('musculo m', 'm.idmusculo = me.idmusculo', 'inner')
            ->where('me.idmusculoejecicio', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Obtiene listado paginado o con búsqueda
     */
    public function getListado(?string $search = null, int $perPage = 25)
    {
        $builder = $this->select('musculoejercicio.*, 
                                  ejercicio.nombre AS ejercicio_nombre, 
                                  ejercicio.imagen AS ejercicio_imagen,
                                  musculo.nombre AS musculo_nombre, 
                                  musculo.imagen AS musculo_imagen')
                        ->join('ejercicio', 'ejercicio.idejercicio = musculoejercicio.idejercicio', 'inner')
                        ->join('musculo', 'musculo.idmusculo = musculoejercicio.idmusculo', 'inner')
                        ->orderBy('musculoejercicio.idmusculoejecicio', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ejercicio.nombre', $search)
                    ->orLike('musculo.nombre', $search)
                    ->groupEnd();
        }

        if ($perPage > 0) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
