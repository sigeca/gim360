<?php

namespace App\Models;

use CodeIgniter\Model;

class MotivoEntrenamientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'motivoentrenamiento';
    protected $primaryKey       = 'idmotivoentrenamiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre', 'objetivo', 'imagen', 'dimension'];

    protected $validationRules = [
        'nombre'    => 'required|min_length[2]|max_length[100]',
        'objetivo'  => 'permit_empty',
        'imagen'    => 'permit_empty|max_length[255]',
        'dimension' => 'permit_empty|max_length[50]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del motivo de entrenamiento es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 100 caracteres.',
        ],
    ];

    public function getMotivos(?string $search = null)
    {
        $builder = $this->orderBy($this->primaryKey, 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('objetivo', $search)
                    ->orLike('dimension', $search);
            if (is_numeric($search)) {
                $builder->orWhere($this->primaryKey, (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Lista los nombres de archivos de imágenes disponibles en el repositorio de motivos
     */
    public function getAvailableImages(): array
    {
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        $dirs = [
            $baseDir . '/repositorio/motivos',
            $baseDir . '/repositorio/images/motivos',
            $baseDir . '/uploads/motivos',
        ];

        $images = [];
        foreach ($dirs as $dir) {
            if (is_dir($dir)) {
                $files = scandir($dir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..' && preg_match('/\.(webp|png|jpg|jpeg|svg)$/i', $file)) {
                        $images[] = $file;
                    }
                }
            }
        }

        $images = array_values(array_unique($images));
        sort($images);
        return $images;
    }
}
