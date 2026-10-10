<?php

namespace App\Models;

use CodeIgniter\Model;

class EjercicioEquipoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ejercicioequipo';
    protected $primaryKey       = 'idejercicioequipo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idejercicio',
        'idequipo',
    ];

    protected $validationRules = [
        'idejercicio' => 'required|is_natural_no_zero',
        'idequipo'    => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idejercicio' => [
            'required'           => 'El ejercicio es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un ejercicio válido.',
        ],
        'idequipo' => [
            'required'           => 'El equipo o máquina es obligatorio.',
            'is_natural_no_zero' => 'Seleccione un equipo válido.',
        ],
    ];

    /**
     * Obtiene los equipos asignados a un ejercicio específico con datos completos
     */
    public function getEquiposByEjercicio(int $idejercicio): array
    {
        return $this->db->table('ejercicioequipo ee')
            ->select('ee.idejercicioequipo, ee.idejercicio, ee.idequipo, 
                      eq.codigo, eq.nombre AS nombre, eq.imagen AS imagen, 
                      eq.modelo, eq.id_tipo, eq.id_estado, eq.id_ubicacion')
            ->join('equipos eq', 'eq.id_equipo = ee.idequipo', 'inner')
            ->where('ee.idejercicio', $idejercicio)
            ->orderBy('eq.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Obtiene los ejercicios asociados a un equipo
     */
    public function getEjerciciosByEquipo(int $idequipo): array
    {
        return $this->db->table('ejercicioequipo ee')
            ->select('ee.idejercicioequipo, ee.idejercicio, ee.idequipo, 
                      e.nombre AS ejercicio_nombre, e.imagen AS ejercicio_imagen, 
                      e.descripcion AS ejercicio_descripcion')
            ->join('ejercicio e', 'e.idejercicio = ee.idejercicio', 'inner')
            ->where('ee.idequipo', $idequipo)
            ->orderBy('e.nombre', 'ASC')
            ->get()
            ->getResultArray();
    }

    /**
     * Sincroniza los equipos asignados a un ejercicio (inserta nuevos, elimina desmarcados)
     */
    public function syncEquiposForEjercicio(int $idejercicio, array $idequipos): bool
    {
        $idequipos = array_filter(array_map('intval', $idequipos), fn($id) => $id > 0);
        $idequipos = array_unique($idequipos);

        // Obtener los actuales
        $current = $this->where('idejercicio', $idejercicio)->findAll();
        $currentIds = array_column($current, 'idequipo');

        // Determinar qué borrar y qué agregar
        $toDelete = array_diff($currentIds, $idequipos);
        $toInsert = array_diff($idequipos, $currentIds);

        if (!empty($toDelete)) {
            $this->where('idejercicio', $idejercicio)
                 ->whereIn('idequipo', $toDelete)
                 ->delete();
        }

        foreach ($toInsert as $idequipo) {
            $this->insert([
                'idejercicio' => $idejercicio,
                'idequipo'    => $idequipo,
            ]);
        }

        return true;
    }

    /**
     * Agrega un equipo a un ejercicio si no existe
     */
    public function addEquipoToEjercicio(int $idejercicio, int $idequipo): bool
    {
        $exists = $this->where('idejercicio', $idejercicio)
                       ->where('idequipo', $idequipo)
                       ->first();
        if ($exists) {
            return true;
        }

        return (bool) $this->insert([
            'idejercicio' => $idejercicio,
            'idequipo'    => $idequipo,
        ]);
    }

    /**
     * Elimina la asociación entre un ejercicio y un equipo
     */
    public function removeEquipoFromEjercicio(int $idejercicio, int $idequipo): bool
    {
        return (bool) $this->where('idejercicio', $idejercicio)
                           ->where('idequipo', $idequipo)
                           ->delete();
    }

    /**
     * Obtiene detalle de un registro EjercicioEquipo con nombres e imágenes
     */
    public function getRecordWithDetails(int $id)
    {
        return $this->db->table('ejercicioequipo ee')
            ->select('ee.idejercicioequipo, ee.idejercicio, ee.idequipo, 
                      e.nombre AS ejercicio_nombre, e.imagen AS ejercicio_imagen, e.descripcion AS ejercicio_descripcion,
                      eq.codigo AS equipo_codigo, eq.nombre AS equipo_nombre, eq.imagen AS equipo_imagen, eq.modelo AS equipo_modelo, eq.id_tipo AS equipo_tipo')
            ->join('ejercicio e', 'e.idejercicio = ee.idejercicio', 'inner')
            ->join('equipos eq', 'eq.id_equipo = ee.idequipo', 'inner')
            ->where('ee.idejercicioequipo', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Obtiene listado paginado o con búsqueda
     */
    public function getListado(?string $search = null, int $perPage = 25)
    {
        $builder = $this->select('ejercicioequipo.*, 
                                  ejercicio.nombre AS ejercicio_nombre, 
                                  ejercicio.imagen AS ejercicio_imagen,
                                  equipos.codigo AS equipo_codigo,
                                  equipos.nombre AS equipo_nombre, 
                                  equipos.imagen AS equipo_imagen,
                                  equipos.modelo AS equipo_modelo')
                        ->join('ejercicio', 'ejercicio.idejercicio = ejercicioequipo.idejercicio', 'inner')
                        ->join('equipos', 'equipos.id_equipo = ejercicioequipo.idequipo', 'inner')
                        ->orderBy('ejercicioequipo.idejercicioequipo', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('ejercicio.nombre', $search)
                    ->orLike('equipos.nombre', $search)
                    ->orLike('equipos.codigo', $search)
                    ->orLike('equipos.modelo', $search)
                    ->groupEnd();
        }

        if ($perPage > 0) {
            return $builder->paginate($perPage);
        }

        return $builder->findAll();
    }
}
