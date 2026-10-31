<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenModel extends Model
{
    use NavigableTrait;

    protected $table            = 'imagen';
    protected $primaryKey       = 'idimagen';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'idformatoimagen',
        'fechacaptura',
        'descripcion',
        'palabrasclave',
        'licencia',
        'fechacreacion',
        'idordenador',
        'iddirectorio',
    ];

    /**
     * Obtiene una imagen individual con información de formato, ordenador y directorio
     */
    public function getImagenWithDetails(int $id): ?array
    {
        return $this->select('imagen.*, 
                              fi.nombre AS formato_nombre, 
                              o.nombre AS ordenador_nombre, 
                              d.nombre AS directorio_nombre, d.ruta AS directorio_ruta')
                    ->join('formatoimagen fi', 'fi.idformatoimagen = imagen.idformatoimagen', 'left')
                    ->join('ordenador o', 'o.idordenador = imagen.idordenador', 'left')
                    ->join('directorio d', 'd.iddirectorio = imagen.iddirectorio', 'left')
                    ->where('imagen.idimagen', $id)
                    ->first();
    }

    /**
     * Obtiene todas las imágenes con detalles y buscador opcional
     */
    public function getImagenes(?string $search = null): array
    {
        $builder = $this->select('imagen.*, 
                                  fi.nombre AS formato_nombre, 
                                  o.nombre AS ordenador_nombre, 
                                  d.nombre AS directorio_nombre, d.ruta AS directorio_ruta')
                        ->join('formatoimagen fi', 'fi.idformatoimagen = imagen.idformatoimagen', 'left')
                        ->join('ordenador o', 'o.idordenador = imagen.idordenador', 'left')
                        ->join('directorio d', 'd.iddirectorio = imagen.iddirectorio', 'left')
                        ->orderBy('imagen.idimagen', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('imagen.nombre', $search)
                    ->orLike('imagen.descripcion', $search)
                    ->orLike('imagen.palabrasclave', $search)
                    ->orLike('fi.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('imagen.idimagen', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Genera el nombre del archivo con el formato exacto del proyecto SICA:
     * Ymd_His-00000.ext (ej: 20261030_210500-00001.jpg)
     */
    public function generarNombreSica(int $idimagen, ?string $extension = 'jpg'): string
    {
        date_default_timezone_set('America/Guayaquil');
        $ext = strtolower(ltrim($extension ?: 'jpg', '.'));
        return date("Ymd_His") . "-" . sprintf("%05d", $idimagen) . "." . $ext;
    }
}
