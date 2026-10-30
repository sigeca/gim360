<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaComponenteNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'recetacomponentenutricional';
    protected $primaryKey       = 'idrecetacomponentenutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idreceta',
        'idcomponentenutricional',
    ];

    protected $validationRules = [
        'idreceta'                => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
        'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
    ];

    protected $validationMessages = [
        'idreceta' => [
            'required'           => 'Debe seleccionar una receta.',
            'is_natural_no_zero' => 'Seleccione una receta válida.',
            'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
        ],
        'idcomponentenutricional' => [
            'required'           => 'Debe seleccionar un componente nutricional.',
            'is_natural_no_zero' => 'Seleccione un componente nutricional válido.',
            'is_not_unique'      => 'El componente nutricional seleccionado no existe.',
        ],
    ];

    /**
     * Obtiene un registro individual con los nombres y descripciones relacionados
     */
    public function getRecordWithDetails(int $id): ?array
    {
        return $this->select('recetacomponentenutricional.*, 
                              r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion,
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('receta r', 'r.idreceta = recetacomponentenutricional.idreceta', 'inner')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = recetacomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('recetacomponentenutricional.idrecetacomponentenutricional', $id)
                    ->first();
    }

    /**
     * Obtiene componentes nutricionales asociados a una receta específica
     */
    public function getComponentesByReceta(int $idreceta): array
    {
        return $this->select('recetacomponentenutricional.*, 
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = recetacomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('recetacomponentenutricional.idreceta', $idreceta)
                    ->orderBy('cn.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene las recetas que contienen un componente específico
     */
    public function getRecetasByComponente(int $idcomponente): array
    {
        return $this->select('recetacomponentenutricional.*, 
                              r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion')
                    ->join('receta r', 'r.idreceta = recetacomponentenutricional.idreceta', 'inner')
                    ->where('recetacomponentenutricional.idcomponentenutricional', $idcomponente)
                    ->orderBy('r.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Listado con filtros y buscador
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idreceta = null, ?int $idcomponente = null): array
    {
        $builder = $this->select('recetacomponentenutricional.*, 
                                  r.nombre AS receta_nombre, r.porciones,
                                  cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                        ->join('receta r', 'r.idreceta = recetacomponentenutricional.idreceta', 'inner')
                        ->join('componentenutricional cn', 'cn.idcomponentenutricional = recetacomponentenutricional.idcomponentenutricional', 'inner')
                        ->orderBy('r.nombre', 'ASC')
                        ->orderBy('cn.nombre', 'ASC');

        if (!empty($idreceta)) {
            $builder->where('recetacomponentenutricional.idreceta', $idreceta);
        }

        if (!empty($idcomponente)) {
            $builder->where('recetacomponentenutricional.idcomponentenutricional', $idcomponente);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('r.nombre', $search)
                    ->orLike('cn.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('recetacomponentenutricional.idrecetacomponentenutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
