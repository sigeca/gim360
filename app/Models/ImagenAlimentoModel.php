<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenAlimentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'imagenalimento';
    protected $primaryKey       = 'idimagenalimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idimagen',
        'idalimento',
    ];

    protected $validationRules = [
        'idimagen'   => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
        'idalimento' => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
    ];

    protected $validationMessages = [
        'idimagen' => [
            'required'           => 'Debe seleccionar una imagen.',
            'is_natural_no_zero' => 'Seleccione una imagen válida.',
            'is_not_unique'      => 'La imagen seleccionada no existe en el sistema.',
        ],
        'idalimento' => [
            'required'           => 'Debe seleccionar un alimento.',
            'is_natural_no_zero' => 'Seleccione un alimento válido.',
            'is_not_unique'      => 'El alimento seleccionado no existe en el sistema.',
        ],
    ];

    /**
     * Obtiene un registro individual con todos los datos relacionados de la imagen y el alimento
     */
    public function getRecordWithDetails(int $id): ?array
    {
        $record = $this->select('imagenalimento.*, 
                                 i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                 i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                                 i.fechacaptura AS imagen_fechacaptura,
                                 d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                                 fi.nombre AS formato_nombre,
                                 a.nombre AS alimento_nombre, a.descripcion AS alimento_descripcion,
                                 ga.nombre AS grupo_nombre')
                       ->join('imagen i', 'i.idimagen = imagenalimento.idimagen', 'inner')
                       ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                       ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                       ->join('alimento a', 'a.idalimento = imagenalimento.idalimento', 'inner')
                       ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                       ->where('imagenalimento.idimagenalimento', $id)
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
     * Obtiene las imágenes asociadas a un alimento específico con validación de archivo físico y URLs
     */
    public function getImagenesByAlimento(int $idalimento): array
    {
        try {
            $imagenes = $this->select('imagenalimento.*, 
                                       i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                       i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                                       i.fechacaptura AS imagen_fechacaptura,
                                       d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                                       fi.nombre AS formato_nombre')
                             ->join('imagen i', 'i.idimagen = imagenalimento.idimagen', 'inner')
                             ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                             ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                             ->where('imagenalimento.idalimento', $idalimento)
                             ->orderBy('imagenalimento.idimagenalimento', 'ASC')
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
     * Obtiene los alimentos asociados a una imagen específica
     */
    public function getAlimentosByImagen(int $idimagen): array
    {
        return $this->select('imagenalimento.*, 
                              a.nombre AS alimento_nombre, a.descripcion AS alimento_descripcion,
                              ga.nombre AS grupo_nombre')
                    ->join('alimento a', 'a.idalimento = imagenalimento.idalimento', 'inner')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left')
                    ->where('imagenalimento.idimagen', $idimagen)
                    ->orderBy('a.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Listado con filtros y buscador
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idalimento = null, ?int $idimagen = null): array
    {
        $builder = $this->select('imagenalimento.*, 
                                  i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                  d.ruta AS directorio_ruta, fi.nombre AS formato_nombre,
                                  a.nombre AS alimento_nombre, a.descripcion AS alimento_descripcion,
                                  ga.nombre AS grupo_nombre')
                        ->join('imagen i', 'i.idimagen = imagenalimento.idimagen', 'inner')
                        ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                        ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                        ->join('alimento a', 'a.idalimento = imagenalimento.idalimento', 'inner')
                        ->join('grupoalimento ga', 'ga.idgrupoalimento = a.idgrupo', 'left');

        if (!empty($idalimento)) {
            $builder->where('imagenalimento.idalimento', $idalimento);
        }

        if (!empty($idimagen)) {
            $builder->where('imagenalimento.idimagen', $idimagen);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('i.nombre', $search)
                    ->orLike('i.descripcion', $search)
                    ->orLike('a.nombre', $search)
                    ->orLike('ga.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('imagenalimento.idimagenalimento', (int)$search)
                        ->orWhere('imagenalimento.idimagen', (int)$search)
                        ->orWhere('imagenalimento.idalimento', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->orderBy('imagenalimento.idimagenalimento', 'ASC')->findAll();

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
