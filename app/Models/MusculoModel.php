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
        'idtrenmuscular',
    ];

    protected $validationRules = [
        'nombre'         => 'required|min_length[2]|max_length[100]',
        'imagen'         => 'permit_empty|max_length[255]',
        'idtrenmuscular' => 'permit_empty|is_natural_no_zero',
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
     * Obtiene un músculo con la información de su tren muscular
     */
    public function getMusculoWithDetails($id)
    {
        return $this->select('musculo.*, trenmuscular.nombre AS tren_nombre')
                    ->join('trenmuscular', 'trenmuscular.idtrenmuscular = musculo.idtrenmuscular', 'left')
                    ->where('musculo.idmusculo', $id)
                    ->first();
    }

    /**
     * Obtiene músculos con filtro de búsqueda opcional y nombre de tren muscular
     */
    public function getMusculos(?string $search = null)
    {
        $builder = $this->select('musculo.*, trenmuscular.nombre AS tren_nombre')
                        ->join('trenmuscular', 'trenmuscular.idtrenmuscular = musculo.idtrenmuscular', 'left')
                        ->orderBy('musculo.idmusculo', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('musculo.nombre', $search)
                    ->orLike('trenmuscular.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('musculo.idmusculo', (int)$search)
                        ->orWhere('musculo.idtrenmuscular', (int)$search);
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
