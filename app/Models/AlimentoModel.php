<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'alimento';
    protected $primaryKey       = 'idalimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idgrupo',
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'idgrupo'     => 'required|is_natural_no_zero|is_not_unique[grupoalimento.idgrupoalimento]',
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'idgrupo' => [
            'required'              => 'Debe seleccionar un grupo de alimento válido.',
            'is_natural_no_zero'    => 'El grupo de alimento seleccionado no es válido.',
            'is_not_unique'         => 'El grupo de alimento seleccionado no existe en el sistema.',
        ],
        'nombre' => [
            'required'   => 'El nombre del alimento es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 150 caracteres.',
        ],
    ];

    /**
     * Obtiene el listado de alimentos con los datos de su grupo
     *
     * @param string|null $search
     * @param int|null $idgrupo
     * @return array
     */
    public function getAlimentos(?string $search = null, ?int $idgrupo = null): array
    {
        $builder = $this->select('alimento.*, ga.nombre AS grupo_nombre, ga.descripcion AS grupo_descripcion')
                        ->join('grupoalimento ga', 'ga.idgrupoalimento = alimento.idgrupo', 'left')
                        ->orderBy('alimento.idalimento', 'ASC');

        if (!empty($idgrupo)) {
            $builder->where('alimento.idgrupo', $idgrupo);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('alimento.nombre', $search)
                    ->orLike('alimento.descripcion', $search)
                    ->orLike('ga.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('alimento.idalimento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtiene el detalle de un alimento específico con su grupo relacionado
     *
     * @param int $id
     * @return array|null
     */
    public function getAlimentoWithDetails(int $id): ?array
    {
        return $this->select('alimento.*, ga.nombre AS grupo_nombre, ga.descripcion AS grupo_descripcion')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = alimento.idgrupo', 'left')
                    ->where('alimento.idalimento', $id)
                    ->first();
    }
}
