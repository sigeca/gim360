<?php

namespace App\Models;

use CodeIgniter\Model;

class EntretenimientoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'entretenimiento';
    protected $primaryKey       = 'identretenimiento';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'descripcion' => 'permit_empty',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del entretenimiento es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
            'max_length' => 'El nombre no puede exceder los 150 caracteres.',
        ],
    ];

    public static function ensureEntertainmentTables(): void
    {
        static $checked = false;
        if ($checked) {
            return;
        }
        $checked = true;

        try {
            $db = \Config\Database::connect();
            if ($db->tableExists('entretenimiento') && $db->tableExists('entretenimientopodcast')) {
                return;
            }
            $sqlFile = ROOTPATH . 'database_migration_entretenimiento.sql';
            if (!is_file($sqlFile)) {
                $sqlFile = APPPATH . 'Models/sql/database_migration_entretenimiento.sql';
            }
            if (is_file($sqlFile)) {
                $mysqli = $db->connID;
                if ($mysqli instanceof \mysqli) {
                    $sql = file_get_contents($sqlFile);
                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($res = $mysqli->store_result()) {
                                $res->free();
                            }
                        } while ($mysqli->more_results() && $mysqli->next_result());
                    }
                }
            }
        } catch (\Throwable $e) {
            log_message('error', 'EntretenimientoModel::ensureEntertainmentTables: ' . $e->getMessage());
        }
    }

    public function getEntretenimientosWithCounts(?string $search = null): array
    {
        self::ensureEntertainmentTables();

        $builder = $this->select('entretenimiento.*,
                                  (SELECT COUNT(*) FROM entretenimientomusica em WHERE em.identretenimiento = entretenimiento.identretenimiento) AS total_musicas,
                                  (SELECT COUNT(*) FROM entretenimientovideo ev WHERE ev.identretenimiento = entretenimiento.identretenimiento) AS total_videos,
                                  (SELECT COUNT(*) FROM entretenimientojuego ej WHERE ej.identretenimiento = entretenimiento.identretenimiento) AS total_juegos,
                                  (SELECT COUNT(*) FROM entretenimientopodcast ep WHERE ep.identretenimiento = entretenimiento.identretenimiento) AS total_podcasts')
                        ->orderBy('entretenimiento.identretenimiento', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('entretenimiento.nombre', $search)
                    ->orLike('entretenimiento.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('entretenimiento.identretenimiento', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }

    public function getEntretenimientoWithDetails(int $id): ?array
    {
        self::ensureEntertainmentTables();

        $ent = $this->find($id);
        if (!$ent) {
            return null;
        }

        $ent['musicas']  = (new EntretenimientoMusicaModel())->getMusicasByEntretenimiento($id);
        $ent['videos']   = (new EntretenimientoVideoModel())->getVideosByEntretenimiento($id);
        $ent['juegos']   = (new EntretenimientoJuegoModel())->getJuegosByEntretenimiento($id);
        $ent['podcasts'] = (new EntretenimientoPodcastModel())->getPodcastsByEntretenimiento($id);

        return $ent;
    }
}
