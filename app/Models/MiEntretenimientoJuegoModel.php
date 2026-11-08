<?php

namespace App\Models;

use CodeIgniter\Model;

class MiEntretenimientoJuegoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mientretenimientojuego';
    protected $primaryKey       = 'idmientretenimientojuego';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmientretenimiento',
        'idjuego',
    ];

    protected $validationRules = [
        'idmientretenimiento' => 'required|is_natural_no_zero',
        'idjuego'             => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientojuego.*,
                              me.nombre AS mientretenimiento_nombre, me.descripcion AS mientretenimiento_descripcion,
                              p.idpersona, p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              j.nombre AS juego_nombre, j.categoria AS juego_categoria,
                              j.enlace AS juego_enlace, j.descripcion AS juego_descripcion')
                    ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientojuego.idmientretenimiento', 'inner')
                    ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                    ->join('juego j', 'j.idjuego = mientretenimientojuego.idjuego', 'inner')
                    ->where('mientretenimientojuego.idmientretenimientojuego', $id)
                    ->first();
    }

    public function getJuegosByMiEntretenimiento(int $idmientretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientojuego.*,
                              j.nombre AS juego_nombre, j.categoria AS juego_categoria,
                              j.enlace AS juego_enlace, j.descripcion AS juego_descripcion')
                    ->join('juego j', 'j.idjuego = mientretenimientojuego.idjuego', 'inner')
                    ->where('mientretenimientojuego.idmientretenimiento', $idmientretenimiento)
                    ->orderBy('j.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmientretenimiento = null, ?int $idjuego = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('mientretenimientojuego.*,
                                  me.nombre AS mientretenimiento_nombre,
                                  p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  j.nombre AS juego_nombre, j.categoria AS juego_categoria, j.enlace AS juego_enlace')
                        ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientojuego.idmientretenimiento', 'inner')
                        ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                        ->join('juego j', 'j.idjuego = mientretenimientojuego.idjuego', 'inner')
                        ->orderBy('me.nombre', 'ASC')
                        ->orderBy('j.nombre', 'ASC');

        if (!empty($idmientretenimiento)) {
            $builder->where('mientretenimientojuego.idmientretenimiento', $idmientretenimiento);
        }

        if (!empty($idjuego)) {
            $builder->where('mientretenimientojuego.idjuego', $idjuego);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('me.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('j.nombre', $search)
                    ->orLike('j.categoria', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mientretenimientojuego.idmientretenimientojuego', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
