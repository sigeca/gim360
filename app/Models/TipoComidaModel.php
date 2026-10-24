<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoComidaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'tipocomida';
    protected $primaryKey       = 'idtipocomida';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[60]|is_unique[tipocomida.nombre,idtipocomida,{idtipocomida}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del tipo de comida es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 60 caracteres.',
            'is_unique'  => 'Ya existe un tipo de comida registrado con este nombre.',
        ],
    ];

    /**
     * Obtiene todos los tipos de comida con buscador opcional
     */
    public function getTiposComida(?string $search = null): array
    {
        $builder = $this->orderBy('idtipocomida', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('idtipocomida', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
