<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadAlimentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'unidadalimento';
    protected $primaryKey       = 'idunidadalimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'abreviatura',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[50]|is_unique[unidadalimento.nombre,idunidadalimento,{idunidadalimento}]',
        'abreviatura' => 'required|min_length[1]|max_length[15]|is_unique[unidadalimento.abreviatura,idunidadalimento,{idunidadalimento}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la unidad es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 50 caracteres.',
            'is_unique'  => 'Ya existe una unidad registrada con este nombre.',
        ],
        'abreviatura' => [
            'required'   => 'La abreviatura es obligatoria.',
            'min_length' => 'Debe tener al menos 1 caracter.',
            'max_length' => 'No puede superar los 15 caracteres.',
            'is_unique'  => 'Ya existe una unidad con esta abreviatura.',
        ],
    ];

    /**
     * Obtiene el listado de unidades con buscador opcional
     */
    public function getUnidades(?string $search = null): array
    {
        $builder = $this->orderBy('idunidadalimento', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('abreviatura', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idunidadalimento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
