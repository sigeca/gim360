<?php

namespace App\Models;

use CodeIgniter\Model;

class MiEntretenimientoVideoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mientretenimientovideo';
    protected $primaryKey       = 'idmientretenimientovideo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmientretenimiento',
        'idvideo',
    ];

    protected $validationRules = [
        'idmientretenimiento' => 'required|is_natural_no_zero',
        'idvideo'             => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientovideo.*,
                              me.nombre AS mientretenimiento_nombre, me.descripcion AS mientretenimiento_descripcion,
                              p.idpersona, p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria,
                              v.enlace AS video_enlace, v.descripcion AS video_descripcion')
                    ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientovideo.idmientretenimiento', 'inner')
                    ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                    ->join('video v', 'v.idvideo = mientretenimientovideo.idvideo', 'inner')
                    ->where('mientretenimientovideo.idmientretenimientovideo', $id)
                    ->first();
    }

    public function getVideosByMiEntretenimiento(int $idmientretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientovideo.*,
                              v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria,
                              v.enlace AS video_enlace, v.descripcion AS video_descripcion')
                    ->join('video v', 'v.idvideo = mientretenimientovideo.idvideo', 'inner')
                    ->where('mientretenimientovideo.idmientretenimiento', $idmientretenimiento)
                    ->orderBy('v.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmientretenimiento = null, ?int $idvideo = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('mientretenimientovideo.*,
                                  me.nombre AS mientretenimiento_nombre,
                                  p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  v.nombre AS video_nombre, v.autor AS video_autor, v.categoria AS video_categoria, v.enlace AS video_enlace')
                        ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientovideo.idmientretenimiento', 'inner')
                        ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                        ->join('video v', 'v.idvideo = mientretenimientovideo.idvideo', 'inner')
                        ->orderBy('me.nombre', 'ASC')
                        ->orderBy('v.nombre', 'ASC');

        if (!empty($idmientretenimiento)) {
            $builder->where('mientretenimientovideo.idmientretenimiento', $idmientretenimiento);
        }

        if (!empty($idvideo)) {
            $builder->where('mientretenimientovideo.idvideo', $idvideo);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('me.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('v.nombre', $search)
                    ->orLike('v.autor', $search)
                    ->orLike('v.categoria', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mientretenimientovideo.idmientretenimientovideo', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
