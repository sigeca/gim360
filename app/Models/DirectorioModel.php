<?php

namespace App\Models;

use CodeIgniter\Model;

class DirectorioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'directorio';
    protected $primaryKey       = 'iddirectorio';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'ruta', 'descripcion', 'idordenador'];

    public function getDirectorios(): array
    {
        return $this->select('directorio.*, o.nombre AS ordenador_nombre')
                    ->join('ordenador o', 'o.idordenador = directorio.idordenador', 'left')
                    ->orderBy('directorio.iddirectorio', 'ASC')
                    ->findAll();
    }
}
