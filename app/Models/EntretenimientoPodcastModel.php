<?php

namespace App\Models;

use CodeIgniter\Model;

class EntretenimientoPodcastModel extends Model
{
    use NavigableTrait;

    protected $table            = 'entretenimientopodcast';
    protected $primaryKey       = 'identretenimientopodcast';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'identretenimiento',
        'idpodcast',
    ];

    protected $validationRules = [
        'identretenimiento' => 'required|is_natural_no_zero',
        'idpodcast'         => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientopodcast.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion,
                              p.nombre AS podcast_nombre, p.presentador AS podcast_presentador, p.tema AS podcast_tema,
                              p.enlace AS podcast_enlace, p.descripcion AS podcast_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientopodcast.identretenimiento', 'inner')
                    ->join('podcast p', 'p.idpodcast = entretenimientopodcast.idpodcast', 'inner')
                    ->where('entretenimientopodcast.identretenimientopodcast', $id)
                    ->first();
    }

    public function getPodcastsByEntretenimiento(int $identretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientopodcast.*,
                              p.nombre AS podcast_nombre, p.presentador AS podcast_presentador, p.tema AS podcast_tema,
                              p.enlace AS podcast_enlace, p.descripcion AS podcast_descripcion')
                    ->join('podcast p', 'p.idpodcast = entretenimientopodcast.idpodcast', 'inner')
                    ->where('entretenimientopodcast.identretenimiento', $identretenimiento)
                    ->orderBy('p.nombre', 'ASC')
                    ->findAll();
    }

    public function getEntretenimientosByPodcast(int $idpodcast): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientopodcast.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientopodcast.identretenimiento', 'inner')
                    ->where('entretenimientopodcast.idpodcast', $idpodcast)
                    ->orderBy('e.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $identretenimiento = null, ?int $idpodcast = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('entretenimientopodcast.*,
                                  e.nombre AS entretenimiento_nombre,
                                  p.nombre AS podcast_nombre, p.presentador AS podcast_presentador, p.tema AS podcast_tema, p.enlace AS podcast_enlace')
                        ->join('entretenimiento e', 'e.identretenimiento = entretenimientopodcast.identretenimiento', 'inner')
                        ->join('podcast p', 'p.idpodcast = entretenimientopodcast.idpodcast', 'inner')
                        ->orderBy('e.nombre', 'ASC')
                        ->orderBy('p.nombre', 'ASC');

        if (!empty($identretenimiento)) {
            $builder->where('entretenimientopodcast.identretenimiento', $identretenimiento);
        }

        if (!empty($idpodcast)) {
            $builder->where('entretenimientopodcast.idpodcast', $idpodcast);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('e.nombre', $search)
                    ->orLike('p.nombre', $search)
                    ->orLike('p.presentador', $search)
                    ->orLike('p.tema', $search);
            if (is_numeric($search)) {
                $builder->orWhere('entretenimientopodcast.identretenimientopodcast', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
