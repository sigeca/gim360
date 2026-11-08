<?php

namespace App\Models;

use CodeIgniter\Model;

class EntretenimientoMusicaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'entretenimientomusica';
    protected $primaryKey       = 'identretenimientomusica';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'identretenimiento',
        'idmusica',
    ];

    protected $validationRules = [
        'identretenimiento' => 'required|is_natural_no_zero',
        'idmusica'          => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientomusica.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion,
                              m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero,
                              m.enlace AS musica_enlace, m.descripcion AS musica_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientomusica.identretenimiento', 'inner')
                    ->join('musica m', 'm.idmusica = entretenimientomusica.idmusica', 'inner')
                    ->where('entretenimientomusica.identretenimientomusica', $id)
                    ->first();
    }

    public function getMusicasByEntretenimiento(int $identretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientomusica.*,
                              m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero,
                              m.enlace AS musica_enlace, m.descripcion AS musica_descripcion')
                    ->join('musica m', 'm.idmusica = entretenimientomusica.idmusica', 'inner')
                    ->where('entretenimientomusica.identretenimiento', $identretenimiento)
                    ->orderBy('m.nombre', 'ASC')
                    ->findAll();
    }

    public function getEntretenimientosByMusica(int $idmusica): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('entretenimientomusica.*,
                              e.nombre AS entretenimiento_nombre, e.descripcion AS entretenimiento_descripcion')
                    ->join('entretenimiento e', 'e.identretenimiento = entretenimientomusica.identretenimiento', 'inner')
                    ->where('entretenimientomusica.idmusica', $idmusica)
                    ->orderBy('e.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $identretenimiento = null, ?int $idmusica = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('entretenimientomusica.*,
                                  e.nombre AS entretenimiento_nombre,
                                  m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero, m.enlace AS musica_enlace')
                        ->join('entretenimiento e', 'e.identretenimiento = entretenimientomusica.identretenimiento', 'inner')
                        ->join('musica m', 'm.idmusica = entretenimientomusica.idmusica', 'inner')
                        ->orderBy('e.nombre', 'ASC')
                        ->orderBy('m.nombre', 'ASC');

        if (!empty($identretenimiento)) {
            $builder->where('entretenimientomusica.identretenimiento', $identretenimiento);
        }

        if (!empty($idmusica)) {
            $builder->where('entretenimientomusica.idmusica', $idmusica);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('e.nombre', $search)
                    ->orLike('m.nombre', $search)
                    ->orLike('m.artista', $search)
                    ->orLike('m.genero', $search);
            if (is_numeric($search)) {
                $builder->orWhere('entretenimientomusica.identretenimientomusica', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
