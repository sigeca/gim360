<?php

namespace App\Models;

use CodeIgniter\Model;

class MiEntretenimientoPodcastModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mientretenimientopodcast';
    protected $primaryKey       = 'idmientretenimientopodcast';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmientretenimiento',
        'idpodcast',
    ];

    protected $validationRules = [
        'idmientretenimiento' => 'required|is_natural_no_zero',
        'idpodcast'           => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientopodcast.*,
                              me.nombre AS mientretenimiento_nombre, me.descripcion AS mientretenimiento_descripcion,
                              p.idpersona, p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              pod.nombre AS podcast_nombre, pod.presentador AS podcast_presentador, pod.tema AS podcast_tema,
                              pod.enlace AS podcast_enlace, pod.descripcion AS podcast_descripcion')
                    ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientopodcast.idmientretenimiento', 'inner')
                    ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                    ->join('podcast pod', 'pod.idpodcast = mientretenimientopodcast.idpodcast', 'inner')
                    ->where('mientretenimientopodcast.idmientretenimientopodcast', $id)
                    ->first();
    }

    public function getPodcastsByMiEntretenimiento(int $idmientretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientopodcast.*,
                              pod.nombre AS podcast_nombre, pod.presentador AS podcast_presentador, pod.tema AS podcast_tema,
                              pod.enlace AS podcast_enlace, pod.descripcion AS podcast_descripcion')
                    ->join('podcast pod', 'pod.idpodcast = mientretenimientopodcast.idpodcast', 'inner')
                    ->where('mientretenimientopodcast.idmientretenimiento', $idmientretenimiento)
                    ->orderBy('pod.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmientretenimiento = null, ?int $idpodcast = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('mientretenimientopodcast.*,
                                  me.nombre AS mientretenimiento_nombre,
                                  p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  pod.nombre AS podcast_nombre, pod.presentador AS podcast_presentador, pod.tema AS podcast_tema, pod.enlace AS podcast_enlace')
                        ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientopodcast.idmientretenimiento', 'inner')
                        ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                        ->join('podcast pod', 'pod.idpodcast = mientretenimientopodcast.idpodcast', 'inner')
                        ->orderBy('me.nombre', 'ASC')
                        ->orderBy('pod.nombre', 'ASC');

        if (!empty($idmientretenimiento)) {
            $builder->where('mientretenimientopodcast.idmientretenimiento', $idmientretenimiento);
        }

        if (!empty($idpodcast)) {
            $builder->where('mientretenimientopodcast.idpodcast', $idpodcast);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('me.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('pod.nombre', $search)
                    ->orLike('pod.presentador', $search)
                    ->orLike('pod.tema', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mientretenimientopodcast.idmientretenimientopodcast', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
