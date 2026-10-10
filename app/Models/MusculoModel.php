<?php

namespace App\Models;

use CodeIgniter\Model;

class MusculoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'musculo';
    protected $primaryKey       = 'idmusculo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'imagen',
    ];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[100]',
        'imagen' => 'permit_empty|max_length[255]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del músculo es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede exceder los 100 caracteres.',
        ],
        'imagen' => [
            'max_length' => 'El nombre del archivo de imagen no puede exceder los 255 caracteres.',
        ],
    ];

    /**
     * Obtiene músculos con filtro de búsqueda opcional
     */
    public function getMusculos(?string $search = null)
    {
        $builder = $this->orderBy($this->primaryKey, 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere($this->primaryKey, (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Lista los nombres de archivos de imágenes disponibles en el repositorio
     */
    public function getAvailableImages(): array
    {
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        $dir = $baseDir . '/repositorio/images/muscles';
        if (!is_dir($dir)) {
            $dir = $baseDir . '/repositorio/images/muscle';
        }

        if (!is_dir($dir)) {
            return [];
        }

        $files = scandir($dir);
        $images = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && preg_match('/\.(webp|png|jpg|jpeg|svg)$/i', $file)) {
                $images[] = $file;
            }
        }
        sort($images);
        return $images;
    }
}
