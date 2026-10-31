<?php

namespace App\Models;

use CodeIgniter\Model;

class AlimentoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'alimento';
    protected $primaryKey       = 'idalimento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idgrupo',
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'idgrupo'     => 'required|is_natural_no_zero|is_not_unique[grupoalimento.idgrupoalimento]',
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'idgrupo' => [
            'required'              => 'Debe seleccionar un grupo de alimento válido.',
            'is_natural_no_zero'    => 'El grupo de alimento seleccionado no es válido.',
            'is_not_unique'         => 'El grupo de alimento seleccionado no existe en el sistema.',
        ],
        'nombre' => [
            'required'   => 'El nombre del alimento es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 150 caracteres.',
        ],
    ];

    /**
     * Obtiene el listado de alimentos con los datos de su grupo
     *
     * @param string|null $search
     * @param int|null $idgrupo
     * @return array
     */
    public function getAlimentos(?string $search = null, ?int $idgrupo = null): array
    {
        $builder = $this->select('alimento.*, ga.nombre AS grupo_nombre, ga.descripcion AS grupo_descripcion')
                        ->join('grupoalimento ga', 'ga.idgrupoalimento = alimento.idgrupo', 'left')
                        ->orderBy('alimento.idalimento', 'ASC');

        if (!empty($idgrupo)) {
            $builder->where('alimento.idgrupo', $idgrupo);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('alimento.nombre', $search)
                    ->orLike('alimento.descripcion', $search)
                    ->orLike('ga.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('alimento.idalimento', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->findAll();
        foreach ($records as &$rec) {
            $rec['imagenes']       = $this->getImagenesByAlimento((int)$rec['idalimento']);
            $rec['total_imagenes'] = count($rec['imagenes']);
            $rec['primera_imagen'] = !empty($rec['imagenes']) ? $rec['imagenes'][0] : null;
        }

        return $records;
    }

    /**
     * Obtiene el detalle de un alimento específico con su grupo relacionado e imágenes
     *
     * @param int $id
     * @return array|null
     */
    public function getAlimentoWithDetails(int $id): ?array
    {
        $rec = $this->select('alimento.*, ga.nombre AS grupo_nombre, ga.descripcion AS grupo_descripcion')
                    ->join('grupoalimento ga', 'ga.idgrupoalimento = alimento.idgrupo', 'left')
                    ->where('alimento.idalimento', $id)
                    ->first();

        if ($rec) {
            $rec['imagenes']       = $this->getImagenesByAlimento((int)$rec['idalimento']);
            $rec['total_imagenes'] = count($rec['imagenes']);
            $rec['primera_imagen'] = !empty($rec['imagenes']) ? $rec['imagenes'][0] : null;
        }

        return $rec;
    }

    /**
     * Obtiene las imágenes asociadas a un alimento con resolución de URLs y archivo físico
     *
     * @param int $idalimento
     * @return array
     */
    public function getImagenesByAlimento(int $idalimento): array
    {
        try {
            $builder = $this->db->table('imagenalimento ia')
                ->select('ia.idimagenalimento,
                          i.idimagen,
                          i.nombre AS imagen_nombre,
                          i.descripcion AS imagen_descripcion,
                          i.palabrasclave,
                          i.licencia,
                          fi.nombre AS formato_nombre,
                          d.nombre AS directorio_nombre,
                          d.ruta AS directorio_ruta')
                ->join('imagen i', 'i.idimagen = ia.idimagen', 'inner')
                ->join('directorio d', 'd.iddirectorio = i.iddirectorio', 'left')
                ->join('formatoimagen fi', 'fi.idformatoimagen = i.idformatoimagen', 'left')
                ->where('ia.idalimento', $idalimento)
                ->orderBy('ia.idimagenalimento', 'ASC');

            $imagenes = $builder->get()->getResultArray();

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
}
