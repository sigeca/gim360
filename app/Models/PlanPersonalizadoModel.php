<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanPersonalizadoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'planejerciciopersonalizado';
    protected $primaryKey       = 'idplanpersonalizado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idplanejerciciomodelo',
        'nombre',
        'idejercicio',
        'diassemanas',
        'repeticiones',
        'series',
        'tiempodescanso',
        'peso',
    ];

    protected $validationRules = [
        'idejercicio' => 'required|is_natural_no_zero',
    ];

    public function getPlanWithDetails(int $id)
    {
        return $this->select('planejerciciopersonalizado.*,
                              planejerciciopersonalizado.idplanpersonalizado AS idplanejercicio,
                              ejercicio.nombreespanol AS ejercicio_nombre,
                              ejercicio.nombreespanol AS ejercicio_nombreespanol,
                              ejercicio.nombreingles AS ejercicio_nombreingles,
                              ejercicio.descripcion AS ejercicio_descripcion,
                              ejercicio.urlvideo AS ejercicio_urlvideo,
                              ejercicio.imagen AS ejercicio_imagen')
                    ->join('ejercicio', 'ejercicio.idejercicio = planejerciciopersonalizado.idejercicio', 'inner')
                    ->where('planejerciciopersonalizado.idplanpersonalizado', $id)
                    ->first();
    }

    public function getPlanesByRutinaPersonalizada(int $idRutinaPersonalizada): array
    {
        $db = \Config\Database::connect();
        return $db->table('rutinaplanpersonalizado rplp')
                  ->select('rplp.idrutinaplanpersonalizado,
                            rplp.idrutinaplanpersonalizado AS id_rutina_plan,
                            rplp.idrutinapersonalizada,
                            rplp.idrutinapersonalizada AS idrutinaejercicio,
                            pep.idplanpersonalizado,
                            pep.idplanpersonalizado AS idplanejercicio,
                            pep.idplanejerciciomodelo,
                            pep.nombre,
                            pep.diassemanas,
                            pep.diassemanas AS plan_diassemanas,
                            pep.repeticiones,
                            pep.repeticiones AS plan_repeticiones,
                            pep.series,
                            pep.series AS plan_series,
                            pep.tiempodescanso,
                            pep.tiempodescanso AS plan_tiempodescanso,
                            pep.peso,
                            pep.peso AS plan_peso,
                            ej.idejercicio,
                            ej.nombreespanol AS ejercicio_nombre,
                            ej.nombreespanol AS ejercicio_nombreespanol,
                            ej.nombreingles AS ejercicio_nombreingles,
                            ej.descripcion AS ejercicio_descripcion,
                            ej.urlvideo AS ejercicio_urlvideo,
                            ej.imagen AS ejercicio_imagen')
                  ->join('planejerciciopersonalizado pep', 'pep.idplanpersonalizado = rplp.idplanpersonalizado', 'inner')
                  ->join('ejercicio ej', 'ej.idejercicio = pep.idejercicio', 'inner')
                  ->where('rplp.idrutinapersonalizada', $idRutinaPersonalizada)
                  ->orderBy('rplp.idrutinaplanpersonalizado', 'ASC')
                  ->get()
                  ->getResultArray();
    }
}
