<?php

namespace App\Models;

use CodeIgniter\Model;

class EntretenimientoJuegoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'entretenimientojuego';
    protected $primaryKey       = 'identretenimientojuego';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'identretenimiento',
        'idjuego',
    ];

    protected $validationRules = [
        'identretenimiento' => 'required|is_natural_no_zero',
        'idjuego'           => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientojuego.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion,
                              j.nombre AS juego_nombre, j.categoria AS juego_categoria,
                              j.enlace AS juego_enlace, j.descripcion AS juego_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientojuego.identretenimiento', 'inner')
                    ->join('juego j', 'j.idjuego = entretenimientojuego.idjuego', 'inner')
                    ->where('entretenimientojuego.identretenimientojuego', $id)
                    ->first();
    }

    public function getJuegosByEntretenimiento(int $identretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientojuego.*,
                              j.nombre AS juego_nombre, j.categoria AS juego_categoria,
                              j.enlace AS juego_enlace, j.descripcion AS juego_descripcion')
                    ->join('juego j', 'j.idjuego = entretenimientojuego.idjuego', 'inner')
                    ->where('entretenimientojuego.identretenimiento', $identretenimiento)
                    ->orderBy('j.nombre', 'ASC')
                    ->findAll();
    }

    public function getEntretenimientosByJuego(int $idjuego): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientojuego.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientojuego.identretenimiento', 'inner')
                    ->where('entretenimientojuego.idjuego', $idjuego)
                    ->orderBy('e.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $identretenimiento = null, ?int $idjuego = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('entretenimientojuego.*,
                                  e.nombre AS entretenimiento_nombre,
                                  j.nombre AS juego_nombre, j.categoria AS juego_categoria, j.enlace AS juego_enlace')
                        ->join('entretenimiento e', 'e.identretenimiento = entretenimientojuego.identretenimiento', 'inner')
                        ->join('juego j', 'j.idjuego = entretenimientojuego.idjuego', 'inner')
                        ->orderBy('e.nombre', 'ASC')
                        ->orderBy('j.nombre', 'ASC');

        if (!empty($identretenimiento)) {
            $builder->where('entretenimientojuego.identretenimiento', $identretenimiento);
        }

        if (!empty($idjuego)) {
            $builder->where('entretenimientojuego.idjuego', $idjuego);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('e.nombre', $search)
                    ->orLike('j.nombre', $search)
                    ->orLike('j.categoria', $search);
            if (is_numeric($search)) {
                $builder->orWhere('entretenimientojuego.identretenimientojuego', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
