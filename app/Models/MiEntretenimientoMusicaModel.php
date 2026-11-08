<?php

namespace App\Models;

use CodeIgniter\Model;

class MiEntretenimientoMusicaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mientretenimientomusica';
    protected $primaryKey       = 'idmientretenimientomusica';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idmientretenimiento',
        'idmusica',
    ];

    protected $validationRules = [
        'idmientretenimiento' => 'required|is_natural_no_zero',
        'idmusica'            => 'required|is_natural_no_zero',
    ];

    public function getRecordWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientomusica.*,
                              me.nombre AS mientretenimiento_nombre, me.descripcion AS mientretenimiento_descripcion,
                              p.idpersona, p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero,
                              m.enlace AS musica_enlace, m.descripcion AS musica_descripcion')
                    ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientomusica.idmientretenimiento', 'inner')
                    ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                    ->join('musica m', 'm.idmusica = mientretenimientomusica.idmusica', 'inner')
                    ->where('mientretenimientomusica.idmientretenimientomusica', $id)
                    ->first();
    }

    public function getMusicasByMiEntretenimiento(int $idmientretenimiento): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        return $this->select('mientretenimientomusica.*,
                              m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero,
                              m.enlace AS musica_enlace, m.descripcion AS musica_descripcion')
                    ->join('musica m', 'm.idmusica = mientretenimientomusica.idmusica', 'inner')
                    ->where('mientretenimientomusica.idmientretenimiento', $idmientretenimiento)
                    ->orderBy('m.nombre', 'ASC')
                    ->findAll();
    }

    public function getRecordsWithDetails(?string $search = null, ?int $idmientretenimiento = null, ?int $idmusica = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('mientretenimientomusica.*,
                                  me.nombre AS mientretenimiento_nombre,
                                  p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  m.nombre AS musica_nombre, m.artista AS musica_artista, m.genero AS musica_genero, m.enlace AS musica_enlace')
                        ->join('mientretenimiento me', 'me.idmientretenimiento = mientretenimientomusica.idmientretenimiento', 'inner')
                        ->join('persona p', 'p.idpersona = me.idpersona', 'inner')
                        ->join('musica m', 'm.idmusica = mientretenimientomusica.idmusica', 'inner')
                        ->orderBy('me.nombre', 'ASC')
                        ->orderBy('m.nombre', 'ASC');

        if (!empty($idmientretenimiento)) {
            $builder->where('mientretenimientomusica.idmientretenimiento', $idmientretenimiento);
        }

        if (!empty($idmusica)) {
            $builder->where('mientretenimientomusica.idmusica', $idmusica);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('me.nombre', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('m.nombre', $search)
                    ->orLike('m.artista', $search)
                    ->orLike('m.genero', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mientretenimientomusica.idmientretenimientomusica', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
