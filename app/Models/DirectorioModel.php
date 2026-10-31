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
            [
                'iddirectorio'     => 2,
                'nombre'           => 'Equipos',
                'ruta'             => 'repositorio/images/equipment',
                'descripcion'      => 'Directorio de imágenes de equipos y máquinas',
                'idordenador'      => 1,
                'ordenador_nombre' => 'Servidor Local gim360'
            ],
            [
                'iddirectorio'     => 3,
                'nombre'           => 'Músculos',
                'ruta'             => 'repositorio/images/muscles',
                'descripcion'      => 'Directorio de imágenes anatómicas de músculos',
                'idordenador'      => 1,
                'ordenador_nombre' => 'Servidor Local gim360'
            ],
            [
                'iddirectorio'     => 4,
                'nombre'           => 'Ejercicios',
                'ruta'             => 'repositorio/ejercicios',
                'descripcion'      => 'Directorio de imágenes y animaciones de ejercicios',
                'idordenador'      => 1,
                'ordenador_nombre' => 'Servidor Local gim360'
            ],
            [
                'iddirectorio'     => 5,
                'nombre'           => 'Motivos',
                'ruta'             => 'repositorio/motivos',
                'descripcion'      => 'Directorio de imágenes de motivos de entrenamiento',
                'idordenador'      => 1,
                'ordenador_nombre' => 'Servidor Local gim360'
            ],
        ];
    }

    /**
     * Obtiene la ruta física relativa asociada a un iddirectorio
     */
    public function getRutaDirectorio(?int $iddirectorio): string
    {
        if ($iddirectorio) {
            try {
                $dir = $this->find($iddirectorio);
                if (!empty($dir['ruta'])) {
                    return trim($dir['ruta'], '/\\');
                }
            } catch (\Throwable $e) {
                // Ignore
            }
        }
        return 'repositorio/imagen';
    }
}
