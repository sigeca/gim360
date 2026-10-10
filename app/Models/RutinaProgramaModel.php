<?php

namespace App\Models;

use CodeIgniter\Model;

class RutinaProgramaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'rutinaprograma';
    protected $primaryKey       = 'idrutinaprograma';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramaentrenamiento',
        'idrutinaejercicio',
    ];

    protected $validationRules = [
        'idprogramaentrenamiento' => 'required|is_natural_no_zero',
        'idrutinaejercicio'       => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idprogramaentrenamiento' => [
            'required'           => 'Debe seleccionar un programa de entrenamiento.',
            'is_natural_no_zero' => 'Seleccione un programa de entrenamiento válido.',
        ],
        'idrutinaejercicio' => [
            'required'           => 'Debe seleccionar una rutina de ejercicio.',
            'is_natural_no_zero' => 'Seleccione una rutina válida.',
        ],
    ];

    /**
     * Obtiene una asignación de rutina a programa con detalles completos.
     */
    public function getRutinaProgramaWithDetails($id)
    {
        $rp = $this->select('rutinaprograma.*, 
                             programaentrenamiento.nombre AS programa_nombre, 
                             programaentrenamiento.idmotivoentrenamiento,
                             motivoentrenamiento.nombre AS motivo_nombre, 
                             motivoentrenamiento.objetivo AS motivo_objetivo,
                             rutinaejecicio.nombre AS rutina_nombre')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = rutinaprograma.idprogramaentrenamiento', 'inner')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = rutinaprograma.idrutinaejercicio', 'inner')
                    ->where('rutinaprograma.idrutinaprograma', $id)
                    ->first();

        if ($rp) {
            $rp['planes'] = (new RutinaPlanModel())->getPlanesByRutina((int)$rp['idrutinaejercicio']);
        }

        return $rp;
    }

    /**
     * Obtiene el listado completo de asignaciones rutina-programa con búsqueda opcional.
     */
    public function getRutinasProgramasWithDetails(?string $search = null)
    {
        $builder = $this->select('rutinaprograma.*, 
                                  programaentrenamiento.nombre AS programa_nombre, 
                                  programaentrenamiento.idmotivoentrenamiento,
                                  motivoentrenamiento.nombre AS motivo_nombre, 
                                  rutinaejecicio.nombre AS rutina_nombre,
                                  (SELECT COUNT(*) FROM rutinaplan WHERE rutinaplan.idrutinaejercicio = rutinaprograma.idrutinaejercicio) AS total_planes')
                        ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = rutinaprograma.idprogramaentrenamiento', 'inner')
                        ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                        ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = rutinaprograma.idrutinaejercicio', 'inner')
                        ->orderBy('rutinaprograma.idrutinaprograma', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('programaentrenamiento.nombre', $search)
                    ->orLike('motivoentrenamiento.nombre', $search)
                    ->orLike('rutinaejecicio.nombre', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene todas las rutinas asignadas a un programa, incluyendo los planes de cada rutina.
     */
    public function getRutinasByPrograma(int $idprogramaentrenamiento): array
    {
        $rutinas = $this->select('rutinaprograma.*, 
                                  rutinaejecicio.nombre AS rutina_nombre')
                        ->join('rutinaejecicio', 'rutinaejecicio.idrutinaejercicio = rutinaprograma.idrutinaejercicio', 'inner')
                        ->where('rutinaprograma.idprogramaentrenamiento', $idprogramaentrenamiento)
                        ->orderBy('rutinaejecicio.nombre', 'ASC')
                        ->findAll();

        $rutinaPlanModel = new RutinaPlanModel();
        foreach ($rutinas as &$rutina) {
            $rutina['planes'] = $rutinaPlanModel->getPlanesByRutina((int)$rutina['idrutinaejercicio']);
        }

        return $rutinas;
    }

    /**
     * Obtiene todos los programas que contienen una rutina específica.
     */
    public function getProgramasByRutina(int $idrutinaejercicio): array
    {
        return $this->select('rutinaprograma.*, 
                              programaentrenamiento.nombre AS programa_nombre,
                              motivoentrenamiento.nombre AS motivo_nombre')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = rutinaprograma.idprogramaentrenamiento', 'inner')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->where('rutinaprograma.idrutinaejercicio', $idrutinaejercicio)
                    ->orderBy('programaentrenamiento.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Verifica si una rutina ya está asignada a un programa.
     */
    public function isAssigned(int $idprogramaentrenamiento, int $idrutinaejercicio): bool
    {
        return $this->where('idprogramaentrenamiento', $idprogramaentrenamiento)
                    ->where('idrutinaejercicio', $idrutinaejercicio)
                    ->countAllResults() > 0;
    }
}
