<?php

namespace App\Models;

use CodeIgniter\Model;

class ComponenteNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'componentenutricional';
    protected $primaryKey       = 'idcomponentenutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[100]|is_unique[componentenutricional.nombre,idcomponentenutricional,{idcomponentenutricional}]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del componente nutricional es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
            'is_unique'  => 'Ya existe un componente nutricional registrado con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los componentes nutricionales con buscador opcional
     *
     * @param string|null $search
     * @return array
     */
    public function getComponentes(?string $search = null)
    {
        $builder = $this->orderBy('idcomponentenutricional', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idcomponentenutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
