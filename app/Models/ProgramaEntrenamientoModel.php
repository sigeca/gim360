<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaEntrenamientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'programaentrenamiento';
    protected $primaryKey       = 'idprogramaentrenamiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'idmotivoentrenamiento',
        'idrangoedad',
    ];

    protected $validationRules = [
        'nombre'                => 'required|min_length[3]|max_length[100]',
        'idmotivoentrenamiento' => 'required|is_natural_no_zero',
        'idrangoedad'           => 'permit_empty|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del programa de entrenamiento es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede exceder los 100 caracteres.',
        ],
        'idmotivoentrenamiento' => [
            'required'           => 'Debe seleccionar un motivo de entrenamiento.',
            'is_natural_no_zero' => 'Debe seleccionar un motivo válido.',
        ],
        'idrangoedad' => [
            'is_natural_no_zero' => 'El rango de edad seleccionado no es válido.',
        ],
    ];

    public function getProgramaWithDetails($id)
    {
        $programa = $this->select('programaentrenamiento.*, 
                                   motivoentrenamiento.nombre AS motivo_nombre, 
                                   motivoentrenamiento.objetivo AS motivo_objetivo,
                                   rangoedad.nombre AS rango_nombre,
                                   rangoedad.edadminima AS rango_edadminima,
                                   rangoedad.edadmaxima AS rango_edadmaxima')
                         ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                         ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                         ->where('programaentrenamiento.idprogramaentrenamiento', $id)
                         ->first();

        if ($programa) {
            $programa['rutinas'] = (new RutinaProgramaModel())->getRutinasByPrograma((int)$programa['idprogramaentrenamiento']);
            
            // Recolectar todos los planes/ejercicios de todas las rutinas asignadas
            $allPlanes = [];
            foreach ($programa['rutinas'] as $rutina) {
                if (!empty($rutina['planes'])) {
                    foreach ($rutina['planes'] as $pl) {
                        $pl['rutina_nombre'] = $rutina['rutina_nombre'];
                        $allPlanes[] = $pl;
                    }
                }
            }
            $programa['planes'] = $allPlanes;
        }

        return $programa;
    }

    public function getProgramasWithDetails(?string $search = null)
    {
        $builder = $this->select('programaentrenamiento.*, 
                                  motivoentrenamiento.nombre AS motivo_nombre, 
                                  motivoentrenamiento.objetivo AS motivo_objetivo,
                                  rangoedad.nombre AS rango_nombre,
                                  rangoedad.edadminima AS rango_edadminima,
                                  rangoedad.edadmaxima AS rango_edadmaxima,
                                  (SELECT COUNT(*) FROM rutinaprograma WHERE rutinaprograma.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento) AS total_rutinas,
                                  (SELECT COUNT(*) FROM rutinaplan WHERE rutinaplan.idrutinaejercicio IN (SELECT rp.idrutinaejercicio FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento)) AS total_planes')
                        ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                        ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamiento.idrangoedad', 'left')
                        ->orderBy('programaentrenamiento.idprogramaentrenamiento', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('programaentrenamiento.nombre', $search)
                    ->orLike('motivoentrenamiento.nombre', $search)
                    ->orLike('rangoedad.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('programaentrenamiento.idprogramaentrenamiento', (int)$search)
                        ->orWhere('rangoedad.edadminima', (int)$search)
                        ->orWhere('rangoedad.edadmaxima', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
