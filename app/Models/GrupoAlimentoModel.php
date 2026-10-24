<?php

namespace App\Models;

use CodeIgniter\Model;

class GrupoAlimentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'grupoalimento';
    protected $primaryKey       = 'idgrupoalimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[100]|is_unique[grupoalimento.nombre,idgrupoalimento,{idgrupoalimento}]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del grupo de alimento es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
            'is_unique'  => 'Ya existe un grupo de alimento con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los grupos de alimentos con buscador opcional
     */
    public function getGrupos(?string $search = null)
    {
        $builder = $this->orderBy('idgrupoalimento', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idgrupoalimento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
