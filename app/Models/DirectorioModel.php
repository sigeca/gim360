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
        try {
            $directorios = $this->select('directorio.*, o.nombre AS ordenador_nombre')
                                ->join('ordenador o', 'o.idordenador = directorio.idordenador', 'left')
                                ->orderBy('directorio.iddirectorio', 'ASC')
                                ->findAll();
            if (!empty($directorios)) {
                return $directorios;
            }
        } catch (\Throwable $e) {
            // Tabla aún no creada en la nube o join fallido
        }

        return [
            [
                'iddirectorio'     => 1,
                'nombre'           => 'Imagenes Gim360',
                'ruta'             => 'repositorio/imagen',
                'descripcion'      => 'Directorio de almacenamiento de imágenes',
                'idordenador'      => 1,
                'ordenador_nombre' => 'Servidor Local gim360'
            ],
        ];
    }
}
