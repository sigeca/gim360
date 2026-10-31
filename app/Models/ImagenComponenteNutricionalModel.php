<?php

namespace App\Models;

use CodeIgniter\Model;

class ImagenComponenteNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'imagencomponentenutricional';
    protected $primaryKey       = 'idimagencomponentenutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idimagen',
        'idcomponentenutricional',
    ];

    protected $validationRules = [
        'idimagen'                => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
        'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
    ];

    protected $validationMessages = [
        'idimagen' => [
            'required'           => 'Debe seleccionar una imagen.',
            'is_natural_no_zero' => 'Seleccione una imagen válida.',
            'is_not_unique'      => 'La imagen seleccionada no existe en el sistema.',
        ],
        'idcomponentenutricional' => [
            'required'           => 'Debe seleccionar un componente nutricional.',
            'is_natural_no_zero' => 'Seleccione un componente nutricional válido.',
            'is_not_unique'      => 'El componente nutricional seleccionado no existe.',
        ],
    ];

    /**
     * Obtiene un registro individual con los nombres, imágenes y descripciones relacionadas
     */
    public function getRecordWithDetails(int $id): ?array
    {
        return $this->select('imagencomponentenutricional.*, 
                              i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                              i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                              i.fechacaptura AS imagen_fechacaptura,
                              d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                              fi.nombre AS formato_nombre,
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('imagen i', 'i.idimagen = imagencomponentenutricional.idimagen', 'inner')
                    ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                    ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = imagencomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('imagencomponentenutricional.idimagencomponentenutricional', $id)
                    ->first();
    }

    /**
     * Obtiene las imágenes asociadas a un componente nutricional específico
     */
    public function getImagenesByComponente(int $idcomponente): array
    {
        return $this->select('imagencomponentenutricional.*, 
                              i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                              i.palabrasclave AS imagen_tags, i.licencia AS imagen_licencia,
                              i.fechacaptura AS imagen_fechacaptura,
                              d.nombre AS directorio_nombre, d.ruta AS directorio_ruta,
                              fi.nombre AS formato_nombre')
                    ->join('imagen i', 'i.idimagen = imagencomponentenutricional.idimagen', 'inner')
                    ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                    ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                    ->where('imagencomponentenutricional.idcomponentenutricional', $idcomponente)
                    ->orderBy('imagencomponentenutricional.idimagencomponentenutricional', 'ASC')
                    ->findAll();
    }

    /**
     * Obtiene los componentes nutricionales asociados a una imagen específica
     */
    public function getComponentesByImagen(int $idimagen): array
    {
        return $this->select('imagencomponentenutricional.*, 
                              cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                    ->join('componentenutricional cn', 'cn.idcomponentenutricional = imagencomponentenutricional.idcomponentenutricional', 'inner')
                    ->where('imagencomponentenutricional.idimagen', $idimagen)
                    ->orderBy('cn.nombre', 'ASC')
                    ->findAll();
    }

    /**
     * Listado con filtros y buscador
     */
    public function getRecordsWithDetails(?string $search = null, ?int $idcomponente = null, ?int $idimagen = null): array
    {
        $builder = $this->select('imagencomponentenutricional.*, 
                                  i.nombre AS imagen_nombre, i.descripcion AS imagen_descripcion, 
                                  d.ruta AS directorio_ruta, fi.nombre AS formato_nombre,
                                  cn.nombre AS componente_nombre, cn.descripcion AS componente_descripcion')
                        ->join('imagen i', 'i.idimagen = imagencomponentenutricional.idimagen', 'inner')
                        ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                        ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                        ->join('componentenutricional cn', 'cn.idcomponentenutricional = imagencomponentenutricional.idcomponentenutricional', 'inner')
                        ->orderBy('cn.nombre', 'ASC')
                        ->orderBy('imagencomponentenutricional.idimagencomponentenutricional', 'DESC');

        if (!empty($idcomponente)) {
            $builder->where('imagencomponentenutricional.idcomponentenutricional', $idcomponente);
        }

        if (!empty($idimagen)) {
            $builder->where('imagencomponentenutricional.idimagen', $idimagen);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('cn.nombre', $search)
                    ->orLike('i.nombre', $search)
                    ->orLike('i.descripcion', $search)
                    ->orLike('cn.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('imagencomponentenutricional.idimagencomponentenutricional', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
