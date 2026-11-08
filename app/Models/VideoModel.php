<?php

namespace App\Models;

use CodeIgniter\Model;

class VideoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'video';
    protected $primaryKey       = 'idvideo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'autor',
        'categoria',
        'enlace',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'autor'       => 'permit_empty|max_length[150]',
        'categoria'   => 'permit_empty|max_length[100]',
        'enlace'      => 'required|max_length[500]',
        'descripcion' => 'permit_empty',
    ];

    public function getVideos(?string $search = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('video.*,
                                  (SELECT COUNT(*) FROM entretenimientovideo ev WHERE ev.idvideo = video.idvideo) AS total_entretenimientos')
                        ->orderBy('video.idvideo', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('video.nombre', $search)
                    ->orLike('video.autor', $search)
                    ->orLike('video.categoria', $search)
                    ->orLike('video.enlace', $search)
                    ->orLike('video.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('video.idvideo', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
