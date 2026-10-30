<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentoComponenteNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'alimentocomponentenutricional';
    protected $primaryKey       = 'idalimentocomponentenutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idalimento',
        'idcomponentenutricional',
    ];

    protected $validationRules = [
        'idalimento'              => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
        'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
    ];

    protected $validationMessages = [
        'idalimento' => [
            'required'           => 'Debe seleccionar un alimento.',
            'is_natural_no_zero' => 'Seleccione un alimento válido.',
            'is_not_unique'      => 'El alimento seleccionado no existe en el sistema.',
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
        return $this->select('alimentocomponentenutricional.*, 
                              a.nombre AS alimento_nombre, a.descripcion AS alimento_descripcion,
                              ga.nombre AS grupo_nombre,
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('alimento a', 'a.idalimento = alimentocomponentenutricional.idalimento', 'inner')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = alimentocomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('alimentocomponentenutricional.idalimentocomponentenutricional', $id)
                    ->first();
    }

    /**
     * Obtiene componentes nutricionales asociados a un alimento específico
     */
    public function getComponentesByAlimento(int $idalimento): array
    {
        return $this->select('alimentocomponentenutricional.*, 
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = alimentocomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('alimentocomponentenutricional.idalimento', $idalimento)
                    ->orderBy('cn.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene los alimentos que contienen un componente específico
     */
    public function getAlimentosByComponente(int $idcomponente): array
    {
        return $this->select('alimentocomponentenutricional.*, 
                              a.nombre AS alimento_nombre, ga.nombre AS grupo_nombre')
                    ->join('alimento a', 'a.idalimento = alimentocomponentenutricional.idalimento', 'inner')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                    ->where('alimentocomponentenutricional.idcomponentenutricional', $idcomponente)
                    ->orderBy('a.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Listado con filtros y buscador
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idalimento = null, ?int $idcomponente = null): array
    {
        $builder = $this->select('alimentocomponentenutricional.*, 
                                  a.nombre AS alimento_nombre, 
                                  ga.nombre AS grupo_nombre,
                                  cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                        ->join('alimento a', 'a.idalimento = alimentocomponentenutricional.idalimento', 'inner')
                        ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                        ->join('componentenutricional cn', 'cn.idcomponentenutricional = alimentocomponentenutricional.idcomponentenutricional', 'inner')
                        ->orderBy('a.nombre', 'ASC')
                        ->orderBy('cn.nombre', 'ASC');

        if (!empty($idalimento)) {
            $builder->where('alimentocomponentenutricional.idalimento', $idalimento);
        }

        if (!empty($idcomponente)) {
            $builder->where('alimentocomponentenutricional.idcomponentenutricional', $idcomponente);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('a.nombre', $search)
                    ->orLike('cn.nombre', $search)
                    ->orLike('ga.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('alimentocomponentenutricional.idalimentocomponentenutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
