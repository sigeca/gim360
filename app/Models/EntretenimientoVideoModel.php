<?php

namespace App\Models;

use CodeIgniter\Model;

class EntretenimientoVideoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'entretenimientovideo';
    protected $primaryKey       = 'identretenimientovideo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'identretenimiento',
        'idvideo',
    ];

    protected $validationRules = [
        'identretenimiento' => 'required|is_natural_no_zero',
        'idvideo'           => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientovideo.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion,
                              v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria,
                              v.enlace AS video_enlace, v.descripcion AS video_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientovideo.identretenimiento', 'inner')
                    ->join('video v', 'v.idvideo = entretenimientovideo.idvideo', 'inner')
                    ->where('entretenimientovideo.identretenimientovideo', $id)
                    ->first();
    }

    public function getVideosByEntretenimiento(int $identretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientovideo.*,
                              v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria,
                              v.enlace AS video_enlace, v.descripcion AS video_descripcion')
                    ->join('video v', 'v.idvideo = entretenimientovideo.idvideo', 'inner')
                    ->where('entretenimientovideo.identretenimiento', $identretenimiento)
                    ->orderBy('v.nombre', 'ASC')
                    ->findAll();
    }

    public function getEntretenimientosByVideo(int $idvideo): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientovideo.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientovideo.identretenimiento', 'inner')
                    ->where('entretenimientovideo.idvideo', $idvideo)
                    ->orderBy('e.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $identretenimiento = null, ?int $idvideo = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('entretenimientovideo.*,
                                  e.nombre AS entretenimiento_nombre,
                                  v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria, v.enlace AS video_enlace')
                        ->join('entretenimiento e', 'e.identretenimiento = entretenimientovideo.identretenimiento', 'inner')
                        ->join('video v', 'v.idvideo = entretenimientovideo.idvideo', 'inner')
                        ->orderBy('e.nombre', 'ASC')
                        ->orderBy('v.nombre', 'ASC');

        if (!empty($identretenimiento)) {
            $builder->where('entretenimientovideo.identretenimiento', $identretenimiento);
        }

        if (!empty($idvideo)) {
            $builder->where('entretenimientovideo.idvideo', $idvideo);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('e.nombre', $search)
                    ->orLike('v.nombre', $search)
                    ->orLike('v.autor', $search)
                    ->orLike('v.categoria', $search);
            if (is_numeric($search)) {
                $builder->orWhere('entretenimientovideo.identretenimientovideo', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
