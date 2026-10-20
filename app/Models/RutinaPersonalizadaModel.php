<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaPersonalizadaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rutinaejerciciopersonalizado';
    protected $primaryKey       = 'idrutinapersonalizada';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idrutinaejerciciomodelo',
        'idcliente',
        'nombre',
        'fechacreacion',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
    ];

    /**
     * Obtiene las rutinas de un programa personalizado con sus planes de ejercicio
     */
    public function getRutinasByProgramaPersonalizado(int $idProgramaPersonalizado): array
    {
        $db = \Config\Database::connect();
        $rutinas = $db->table('rutinaprogramapersonalizado rpp')
                      ->select('rep.idrutinapersonalizada,
                                rep.idrutinapersonalizada AS idrutinaejercicio,
                                rep.idrutinaejerciciomodelo,
                                rep.idcliente,
                                rep.nombre,
                                rep.nombre AS rutina_nombre,
                                rpp.idrutinaprogramapersonalizado')
                      ->join('rutinaejerciciopersonalizado rep', 'rep.idrutinapersonalizada = rpp.idrutinapersonalizada', 'inner')
                      ->where('rpp.idprogramapersonalizado', $idProgramaPersonalizado)
                      ->orderBy('rep.idrutinapersonalizada', 'ASC')
                      ->get()
                      ->getResultArray();

        $planPersModel = new PlanPersonalizadoModel();
        foreach ($rutinas as &$rutina) {
            $rutina['planes'] = $planPersModel->getPlanesByRutinaPersonalizada((int)$rutina['idrutinapersonalizada']);
            $rutina['total_ejercicios'] = count($rutina['planes']);
        }

        return $rutinas;
    }
}
