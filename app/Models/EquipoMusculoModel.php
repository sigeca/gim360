<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoMusculoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'equipomusculo';
    protected $primaryKey       = 'idequipomusculo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idequipo',
        'idmusculo',
    ];

    protected $validationRules = [
        'idequipo'  => 'required|is_natural_no_zero',
        'idmusculo' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idequipo' => [
            'required'           => 'El equipo es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un equipo válido.',
        ],
        'idmusculo' => [
            'required'           => 'El músculo es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un músculo válido.',
        ],
    ];

    /**
     * Obtiene los músculos asignados a un equipo específico con datos completos
     */
    public function getMusculosByEquipo(int $idequipo): array
    {
        return $this->db->table('equipomusculo em')
            ->select('em.idequipomusculo, em.idequipo, em.idmusculo, 
                      m.nombre AS nombre, m.imagen AS imagen')
            ->join('musculo m', 'm.idmusculo = em.idmusculo', 'inner')
            ->where('em.idequipo', $idequipo)
            ->orderBy('m.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene en lote los músculos para varios equipos
     */
    public function getMusculosBatch(array $idequipos): array
    {
        if (empty($idequipos)) {
            return [];
        }

        $rows = $this->db->table('equipomusculo em')
            ->select('em.idequipo, em.idmusculo, m.nombre AS nombre, m.imagen AS imagen')
            ->join('musculo m', 'm.idmusculo = em.idmusculo', 'inner')
            ->whereIn('em.idequipo', $idequipos)
            ->orderBy('m.nombre', 'ASC')
            ->get()
            ->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $result[$row['idequipo']][] = $row;
        }

        return $result;
    }

    /**
     * Obtiene los equipos asociados a un músculo
     */
    public function getEquiposByMusculo(int $idmusculo): array
    {
        return $this->db->table('equipomusculo em')
            ->select('em.idequipomusculo, em.idequipo, em.idmusculo, 
                      eq.codigo AS equipo_codigo, eq.nombre AS equipo_nombre, eq.imagen AS equipo_imagen, eq.modelo AS equipo_modelo')
            ->join('equipo eq', 'eq.idequipo = em.idequipo', 'inner')
            ->where('em.idmusculo', $idmusculo)
            ->orderBy('eq.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Sincroniza los músculos asignados a un equipo (inserta nuevos, elimina desmarcados)
     */
    public function syncMusculosForEquipo(int $idequipo, array $idmusculos): bool
    {
        $idmusculos = array_filter(array_map('intval', $idmusculos), fn($id) => $id > 0);
        $idmusculos = array_unique($idmusculos);

        // Obtener los actuales
        $current = $this->where('idequipo', $idequipo)->findAll();
        $currentIds = array_column($current, 'idmusculo');

        // Determinar qué borrar y qué agregar
        $toDelete = array_diff($currentIds, $idmusculos);
        $toInsert = array_diff($idmusculos, $currentIds);

        if (!empty($toDelete)) {
            $this->where('idequipo', $idequipo)
                 ->whereIn('idmusculo', $toDelete)
                 ->delete();
        }

        foreach ($toInsert as $idmusculo) {
            $this->insert([
                'idequipo'  => $idequipo,
                'idmusculo' => $idmusculo,
            ]);
        }

        return true;
    }

    /**
     * Agrega un músculo a un equipo si no existe
     */
    public function addMusculoToEquipo(int $idequipo, int $idmusculo): bool
    {
        $exists = $this->where('idequipo', $idequipo)
                       ->where('idmusculo', $idmusculo)
                       ->first();
        if ($exists) {
            return true;
        }

        return (bool) $this->insert([
            'idequipo'  => $idequipo,
            'idmusculo' => $idmusculo,
        ]);
    }

    /**
     * Elimina la asociación entre un equipo y un músculo
     */
    public function removeMusculoFromEquipo(int $idequipo, int $idmusculo): bool
    {
        return (bool) $this->where('idequipo', $idequipo)
                           ->where('idmusculo', $idmusculo)
                           ->delete();
    }

    /**
     * Obtiene detalle de un registro EquipoMusculo con nombres e imágenes
     */
    public function getRecordWithDetails(int $id)
    {
        return $this->db->table('equipomusculo em')
            ->select('em.idequipomusculo, em.idequipo, em.idmusculo, 
                      eq.codigo AS equipo_codigo, eq.nombre AS equipo_nombre, eq.imagen AS equipo_imagen, eq.modelo AS equipo_modelo, eq.id_tipo AS equipo_tipo,
                      m.nombre AS musculo_nombre, m.imagen AS musculo_imagen')
            ->join('equipo eq', 'eq.idequipo = em.idequipo', 'inner')
            ->join('musculo m', 'm.idmusculo = em.idmusculo', 'inner')
            ->where('em.idequipomusculo', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Obtiene listado paginado o con búsqueda
     */
    public function getListado(?string $search = null, int $perPage = 25)
    {
        $builder = $this->select('equipomusculo.*, 
                                  equipo.codigo AS equipo_codigo,
                                  equipo.nombre AS equipo_nombre, 
                                  equipo.imagen AS equipo_imagen,
                                  equipo.modelo AS equipo_modelo,
                                  musculo.nombre AS musculo_nombre, 
                                  musculo.imagen AS musculo_imagen')
                        ->join('equipo', 'equipo.idequipo = equipomusculo.idequipo', 'inner')
                        ->join('musculo', 'musculo.idmusculo = equipomusculo.idmusculo', 'inner')
                        ->orderBy('equipomusculo.idequipomusculo', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('equipo.nombre', $search)
                    ->orLike('equipo.codigo', $search)
                    ->orLike('equipo.modelo', $search)
                    ->orLike('musculo.nombre', $search)
                    ->groupEnd();
        }

        if ($perPage > 0) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
