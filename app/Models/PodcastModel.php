<?php

namespace App\Models;

use CodeIgniter\Model;

class PodcastModel extends Model
{
    use NavigableTrait;

    protected $table            = 'podcast';
    protected $primaryKey       = 'idpodcast';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'presentador',
        'tema',
        'enlace',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'presentador' => 'permit_empty|max_length[150]',
        'tema'        => 'permit_empty|max_length[100]',
        'enlace'      => 'required|max_length[500]',
        'descripcion' => 'permit_empty',
    ];

    public function getPodcasts(?string $search = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('podcast.*,
                                  (SELECT COUNT(*) FROM entretenimientopodcast ep WHERE ep.idpodcast = podcast.idpodcast) AS total_entretenimientos')
                        ->orderBy('podcast.idpodcast', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('podcast.nombre', $search)
                    ->orLike('podcast.presentador', $search)
                    ->orLike('podcast.tema', $search)
                    ->orLike('podcast.enlace', $search)
                    ->orLike('podcast.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('podcast.idpodcast', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
