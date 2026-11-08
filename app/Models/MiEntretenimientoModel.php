<?php

namespace App\Models;

use CodeIgniter\Model;

class MiEntretenimientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'mientretenimiento';
    protected $primaryKey       = 'idmientretenimiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idpersona',
        'identretenimiento',
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'idpersona'         => 'required|is_natural_no_zero',
        'identretenimiento' => 'permit_empty|is_natural_no_zero',
        'nombre'            => 'required|min_length[2]|max_length[150]',
        'descripcion'       => 'permit_empty',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required' => 'La persona propietaria es obligatoria.',
        ],
        'nombre' => [
            'required'   => 'El nombre de mi entretenimiento es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public function getMisEntretenimientosWithCounts(?string $search = null, ?int $idpersona = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('mientretenimiento.*,
                                  p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                                  e.nombre AS base_entretenimiento_nombre,
                                  (SELECT COUNT(*) FROM mientretenimientomusica mem WHERE mem.idmientretenimiento = mientretenimiento.idmientretenimiento) AS total_musicas,
                                  (SELECT COUNT(*) FROM mientretenimientovideo mev WHERE mev.idmientretenimiento = mientretenimiento.idmientretenimiento) AS total_videos,
                                  (SELECT COUNT(*) FROM mientretenimientojuego mej WHERE mej.idmientretenimiento = mientretenimiento.idmientretenimiento) AS total_juegos,
                                  (SELECT COUNT(*) FROM mientretenimientopodcast mepod WHERE mepod.idmientretenimiento = mientretenimiento.idmientretenimiento) AS total_podcasts')
                        ->join('persona p', 'p.idpersona = mientretenimiento.idpersona', 'inner')
                        ->join('entretenimiento e', 'e.identretenimiento = mientretenimiento.identretenimiento', 'left')
                        ->orderBy('mientretenimiento.idmientretenimiento', 'DESC');

        if (!empty($idpersona)) {
            $builder->where('mientretenimiento.idpersona', $idpersona);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('mientretenimiento.nombre', $search)
                    ->orLike('mientretenimiento.descripcion', $search)
                    ->orLike('p.nombres', $search)
                    ->orLike('p.apellidos', $search)
                    ->orLike('p.cedula', $search)
                    ->orLike('e.nombre', $search);
            if (is_numeric($search)) {
                $builder->orWhere('mientretenimiento.idmientretenimiento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getMiEntretenimientoWithDetails(int $id): ?array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $ent = $this->select('mientretenimiento.*,
                              p.cedula AS persona_cedula, p.nombres AS persona_nombres, p.apellidos AS persona_apellidos,
                              e.nombre AS base_entretenimiento_nombre, e.descripcion AS base_entretenimiento_descripcion')
                    ->join('persona p', 'p.idpersona = mientretenimiento.idpersona', 'inner')
                    ->join('entretenimiento e', 'e.identretenimiento = mientretenimiento.identretenimiento', 'left')
                    ->where('mientretenimiento.idmientretenimiento', $id)
                    ->first();

        if (!$ent) {
            return null;
        }

        $ent['musicas']  = (new MiEntretenimientoMusicaModel())->getMusicasByMiEntretenimiento($id);
        $ent['videos']   = (new MiEntretenimientoVideoModel())->getVideosByMiEntretenimiento($id);
        $ent['juegos']   = (new MiEntretenimientoJuegoModel())->getJuegosByMiEntretenimiento($id);
        $ent['podcasts'] = (new MiEntretenimientoPodcastModel())->getPodcastsByMiEntretenimiento($id);

        return $ent;
    }

    /**
     * Clona un registro de entretenimiento base hacia mientretenimiento para una persona,
     * copiando automáticamente todas sus músicas, videos, juegos y podcasts relacionados.
     */
    public function clonarDesdeEntretenimiento(int $identretenimiento, int $idpersona, ?string $nombrePersonalizado = null, ?string $descripcionPersonalizada = null): int
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $baseModel = new EntretenimientoModel();
        $base = $baseModel->find($identretenimiento);
        if (!$base) {
            throw new \RuntimeException("El registro de entretenimiento base #{$identretenimiento} no existe.");
        }

        $nombre = !empty($nombrePersonalizado) ? trim($nombrePersonalizado) : ('Mi ' . $base['nombre'] . ' (Personalizado)');
        $descripcion = !empty($descripcionPersonalizada) ? trim($descripcionPersonalizada) : ($base['descripcion'] ?? 'Personalizado a partir de ' . $base['nombre']);

        $idMiEntretenimiento = $this->insert([
            'idpersona'         => $idpersona,
            'identretenimiento' => $identretenimiento,
            'nombre'            => $nombre,
            'descripcion'       => $descripcion,
        ]);

        if (!$idMiEntretenimiento) {
            throw new \RuntimeException("No se pudo crear el registro en mientretenimiento.");
        }

        $idMi = (int)$idMiEntretenimiento;

        // 1. Copiar músicas
        $db = \Config\Database::connect();
        $musicas = $db->table('entretenimientomusica')->where('identretenimiento', $identretenimiento)->get()->getResultArray();
        $memModel = new MiEntretenimientoMusicaModel();
        foreach ($musicas as $m) {
            try {
                $memModel->ignore(true)->insert([
                    'idmientretenimiento' => $idMi,
                    'idmusica'            => (int)$m['idmusica'],
                ]);
            } catch (\Throwable $e) {}
        }

        // 2. Copiar videos
        $videos = $db->table('entretenimientovideo')->where('identretenimiento', $identretenimiento)->get()->getResultArray();
        $mevModel = new MiEntretenimientoVideoModel();
        foreach ($videos as $v) {
            try {
                $mevModel->ignore(true)->insert([
                    'idmientretenimiento' => $idMi,
                    'idvideo'             => (int)$v['idvideo'],
                ]);
            } catch (\Throwable $e) {}
        }

        // 3. Copiar juegos
        $juegos = $db->table('entretenimientojuego')->where('identretenimiento', $identretenimiento)->get()->getResultArray();
        $mejModel = new MiEntretenimientoJuegoModel();
        foreach ($juegos as $j) {
            try {
                $mejModel->ignore(true)->insert([
                    'idmientretenimiento' => $idMi,
                    'idjuego'             => (int)$j['idjuego'],
                ]);
            } catch (\Throwable $e) {}
        }

        // 4. Copiar podcasts
        $podcasts = $db->table('entretenimientopodcast')->where('identretenimiento', $identretenimiento)->get()->getResultArray();
        $mepodModel = new MiEntretenimientoPodcastModel();
        foreach ($podcasts as $p) {
            try {
                $mepodModel->ignore(true)->insert([
                    'idmientretenimiento' => $idMi,
                    'idpodcast'           => (int)$p['idpodcast'],
                ]);
            } catch (\Throwable $e) {}
        }

        return $idMi;
    }
}
