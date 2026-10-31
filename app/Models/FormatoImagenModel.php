<?php

namespace App\Models;

use CodeIgniter\Model;

class FormatoImagenModel extends Model
{
    use NavigableTrait;

    protected $table            = 'formatoimagen';
    protected $primaryKey       = 'idformatoimagen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
    ];

    public function getFormatos(): array
    {
        try {
            $formatos = $this->orderBy('idformatoimagen', 'ASC')->findAll();
            if (!empty($formatos)) {
                return $formatos;
            }
        } catch (\Throwable $e) {
            // Tabla aún no creada en la nube o error temporal
        }

        return [
            ['idformatoimagen' => 1, 'nombre' => 'jpg'],
            ['idformatoimagen' => 2, 'nombre' => 'png'],
            ['idformatoimagen' => 3, 'nombre' => 'webp'],
            ['idformatoimagen' => 4, 'nombre' => 'gif'],
            ['idformatoimagen' => 5, 'nombre' => 'jpeg'],
        ];
    }
}
