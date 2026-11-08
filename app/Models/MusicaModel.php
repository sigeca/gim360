<?php

namespace App\Models;

use CodeIgniter\Model;

class MusicaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'musica';
    protected $primaryKey       = 'idmusica';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'artista',
        'genero',
        'enlace',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'artista'     => 'permit_empty|max_length[150]',
        'genero'      => 'permit_empty|max_length[100]',
        'enlace'      => 'required|max_length[500]',
        'descripcion' => 'permit_empty',
    ];

    public function getMusicas(?string $search = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('musica.*,
                                  (SELECT COUNT(*) FROM entretenimientomusica em WHERE em.idmusica = musica.idmusica) AS total_entretenimientos')
                        ->orderBy('musica.idmusica', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('musica.nombre', $search)
                    ->orLike('musica.artista', $search)
                    ->orLike('musica.genero', $search)
                    ->orLike('musica.enlace', $search)
                    ->orLike('musica.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('musica.idmusica', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
