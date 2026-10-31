<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenRecetaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'imagenreceta';
    protected $primaryKey       = 'idimagenreceta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idimagen',
        'idreceta',
    ];

    protected $validationRules = [
        'idimagen' => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
        'idreceta' => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
    ];

    protected $validationMessages = [
        'idimagen' => [
            'required'           => 'Debe seleccionar una imagen.',
            'is_natural_no_zero' => 'Seleccione una imagen válida.',
            'is_not_unique'      => 'La imagen seleccionada no existe en el sistema.',
        ],
        'idreceta' => [
            'required'           => 'Debe seleccionar una receta.',
            'is_natural_no_zero' => 'Seleccione una receta válida.',
            'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
        ],
    ];

    /**
     * Obtiene un registro individual con todos los datos relacionados de la imagen y la receta
     */
    public function getRecordWithDetails(int $id): ?array
    {
        $record = $this->select('imagenreceta.*, 
                                 i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                 i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                                 i.fechacaptura AS imagen_fechacaptura,
                                 d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                                 fi.nombre AS formato_nombre,
                                 r.nombre AS receta_nombre, r.instrucciones AS receta_instrucciones,
                                 r.porciones AS receta_porciones, r.tiempopreparacion AS receta_tiempopreparacion')
                       ->join('imagen i', 'i.idimagen = imagenreceta.idimagen', 'inner')
                       ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                       ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                       ->join('receta r', 'r.idreceta = imagenreceta.idreceta', 'inner')
                       ->where('imagenreceta.idimagenreceta', $id)
                       ->first();

        if ($record) {
            $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
            $dirRuta = !empty($record['directorio_ruta']) ? trim($record['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $cleanName = !empty($record['imagen_nombre']) ? basename(trim($record['imagen_nombre'])) : '';
            $targetFile = $baseDir . '/' . $dirRuta . '/' . $cleanName;

            $record['archivoExiste'] = !empty($cleanName) && file_exists($targetFile);
            $record['urlImagen']     = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
            $record['urlFallback']   = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
        }

        return $record;
    }

    /**
     * Obtiene las imágenes asociadas a una receta específica con validación de archivo físico y URLs
     */
    public function getImagenesByReceta(int $idreceta): array
    {
        try {
            $imagenes = $this->select('imagenreceta.*, 
                                       i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                       i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                                       i.fechacaptura AS imagen_fechacaptura,
                                       d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                                       fi.nombre AS formato_nombre')
                             ->join('imagen i', 'i.idimagen = imagenreceta.idimagen', 'inner')
                             ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                             ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                             ->where('imagenreceta.idreceta', $idreceta)
                             ->orderBy('imagenreceta.idimagenreceta', 'ASC')
                             ->findAll();

            $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

            foreach ($imagenes as &$img) {
                $dirRuta = !empty($img['directorio_ruta']) ? trim($img['directorio_ruta'], '/\\') : 'repositorio/imagen';
                $cleanName = !empty($img['imagen_nombre']) ? basename(trim($img['imagen_nombre'])) : '';
                $targetFile = $baseDir . '/' . $dirRuta . '/' . $cleanName;

                $img['archivoExiste'] = !empty($cleanName) && file_exists($targetFile);
                $img['urlImagen']     = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
                $img['urlFallback']   = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
            }

            return $imagenes;
        } catch (\Throwable $e) {
            return [];
        }
    }

    /**
     * Obtiene las recetas asociadas a una imagen específica
     */
    public function getRecetasByImagen(int $idimagen): array
    {
        return $this->select('imagenreceta.*, 
                              r.nombre AS receta_nombre, r.porciones AS receta_porciones,
                              r.tiempopreparacion AS receta_tiempopreparacion')
                    ->join('receta r', 'r.idreceta = imagenreceta.idreceta', 'inner')
                    ->where('imagenreceta.idimagen', $idimagen)
                    ->orderBy('r.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Listado con filtros y buscador
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idreceta = null, ?int $idimagen = null): array
    {
        $builder = $this->select('imagenreceta.*, 
                                  i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                  d.ruta AS directorio_ruta, fi.nombre AS formato_nombre,
                                  r.nombre AS receta_nombre, r.porciones AS receta_porciones,
                                  r.tiempopreparacion AS receta_tiempopreparacion')
                        ->join('imagen i', 'i.idimagen = imagenreceta.idimagen', 'inner')
                        ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                        ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                        ->join('receta r', 'r.idreceta = imagenreceta.idreceta', 'inner');

        if (!empty($idreceta)) {
            $builder->where('imagenreceta.idreceta', $idreceta);
        }

        if (!empty($idimagen)) {
            $builder->where('imagenreceta.idimagen', $idimagen);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('i.nombre', $search)
                    ->orLike('i.descripcion', $search)
                    ->orLike('r.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('imagenreceta.idimagenreceta', (int)$search)
                        ->orWhere('imagenreceta.idimagen', (int)$search)
                        ->orWhere('imagenreceta.idreceta', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->orderBy('imagenreceta.idimagenreceta', 'ASC')->findAll();

        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        foreach ($records as &$rec) {
            $dirRuta = !empty($rec['directorio_ruta']) ? trim($rec['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $cleanName = !empty($rec['imagen_nombre']) ? basename(trim($rec['imagen_nombre'])) : '';
            $targetFile = $baseDir . '/' . $dirRuta . '/' . $cleanName;

            $rec['archivoExiste'] = !empty($cleanName) && file_exists($targetFile);
            $rec['urlImagen']     = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
            $rec['urlFallback']   = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
        }

        return $records;
    }
}
