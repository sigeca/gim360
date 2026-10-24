<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentoRecetaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'alimentoreceta';
    protected $primaryKey       = 'idalimentoreceta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idreceta',
        'idalimento',
        'cantidad',
        'idunidadalimento',
    ];

    protected $validationRules = [
        'idreceta'         => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
        'idalimento'       => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
        'cantidad'         => 'required|numeric|greater_than[0]|less_than[100000]',
        'idunidadalimento' => 'required|is_natural_no_zero|is_not_unique[unidadalimento.idunidadalimento]',
    ];

    protected $validationMessages = [
        'idreceta' => [
            'required'           => 'Debe seleccionar una receta.',
            'is_natural_no_zero' => 'Seleccione una receta válida.',
            'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
        ],
        'idalimento' => [
            'required'           => 'Debe seleccionar un alimento o ingrediente.',
            'is_natural_no_zero' => 'Seleccione un alimento válido.',
            'is_not_unique'      => 'El alimento seleccionado no existe en el sistema.',
        ],
        'cantidad' => [
            'required'     => 'La cantidad es obligatoria.',
            'numeric'      => 'La cantidad debe ser un valor numérico.',
            'greater_than' => 'La cantidad debe ser mayor a 0.',
            'less_than'    => 'La cantidad no puede superar los 100,000.',
        ],
        'idunidadalimento' => [
            'required'           => 'Debe seleccionar una unidad de medida.',
            'is_natural_no_zero' => 'Seleccione una unidad válida.',
            'is_not_unique'      => 'La unidad seleccionada no existe en el sistema.',
        ],
    ];

    /**
     * Obtiene los ingredientes asociados a una receta específica
     */
    public function getIngredientesByReceta(int $idreceta): array
    {
        return $this->select('alimentoreceta.*, a.nombre AS alimento_nombre, ga.nombre AS grupo_nombre, u.nombre AS unidad_nombre, u.abreviatura AS unidad_abreviatura')
                    ->join('alimento a', 'a.idalimento = alimentoreceta.idalimento', 'inner')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                    ->join('unidadalimento u', 'u.idunidadalimento = alimentoreceta.idunidadalimento', 'inner')
                    ->where('alimentoreceta.idreceta', $idreceta)
                    ->orderBy('a.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene las recetas que utilizan un alimento específico
     */
    public function getRecetasByAlimento(int $idalimento): array
    {
        return $this->select('alimentoreceta.*, r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion, u.nombre AS unidad_nombre, u.abreviatura AS unidad_abreviatura')
                    ->join('receta r', 'r.idreceta = alimentoreceta.idreceta', 'inner')
                    ->join('unidadalimento u', 'u.idunidadalimento = alimentoreceta.idunidadalimento', 'inner')
                    ->where('alimentoreceta.idalimento', $idalimento)
                    ->orderBy('r.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene un registro individual con todos los nombres relacionados
     */
    public function getRecordWithDetails(int $id): ?array
    {
        return $this->select('alimentoreceta.*, r.nombre AS receta_nombre, r.porciones, r.tiempopreparacion, a.nombre AS alimento_nombre, ga.nombre AS grupo_nombre, u.nombre AS unidad_nombre, u.abreviatura AS unidad_abreviatura')
                    ->join('receta r', 'r.idreceta = alimentoreceta.idreceta', 'inner')
                    ->join('alimento a', 'a.idalimento = alimentoreceta.idalimento', 'inner')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                    ->join('unidadalimento u', 'u.idunidadalimento = alimentoreceta.idunidadalimento', 'inner')
                    ->where('alimentoreceta.idalimentoreceta', $id)
                    ->first();
    }

    /**
     * Obtiene el listado completo con filtros opcionales
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idreceta = null, ?int $idalimento = null): array
    {
        $builder = $this->select('alimentoreceta.*, r.nombre AS receta_nombre, a.nombre AS alimento_nombre, ga.nombre AS grupo_nombre, u.nombre AS unidad_nombre, u.abreviatura AS unidad_abreviatura')
                        ->join('receta r', 'r.idreceta = alimentoreceta.idreceta', 'inner')
                        ->join('alimento a', 'a.idalimento = alimentoreceta.idalimento', 'inner')
                        ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                        ->join('unidadalimento u', 'u.idunidadalimento = alimentoreceta.idunidadalimento', 'inner')
                        ->orderBy('r.nombre', 'ASC')
                        ->orderBy('a.nombre', 'ASC');

        if (!empty($idreceta)) {
            $builder->where('alimentoreceta.idreceta', $idreceta);
        }

        if (!empty($idalimento)) {
            $builder->where('alimentoreceta.idalimento', $idalimento);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('r.nombre', $search)
                    ->orLike('a.nombre', $search)
                    ->orLike('ga.nombre', $search)
                    ->orLike('u.nombre', $search)
                    ->orLike('u.abreviatura', $search);
            if (is_numeric($search)) {
                $builder->orWhere('alimentoreceta.idalimentoreceta', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
