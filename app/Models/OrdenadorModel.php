<?php

namespace App\Models;

use CodeIgniter\Model;

class OrdenadorModel extends Model
{
    use NavigableTrait;

    protected $table            = 'ordenador';
    protected $primaryKey       = 'idordenador';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    public function getOrdenadores(): array
    {
        try {
            $ordenadores = $this->orderBy('idordenador', 'ASC')->findAll();
            if (!empty($ordenadores)) {
                return $ordenadores;
            }
        } catch (\Throwable $e) {
            // Tabla aún no creada en la nube
        }

        return [
            ['idordenador' => 1, 'nombre' => 'Servidor Local gim360'],
        ];
    }
}
