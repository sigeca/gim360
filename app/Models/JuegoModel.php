<?php

namespace App\Models;

use CodeIgniter\Model;

class JuegoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'juego';
    protected $primaryKey       = 'idjuego';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'categoria',
        'enlace',
        'descripcion',
    ];

    protected $validationRules = [
        'nombre'      => 'required|min_length[2]|max_length[150]',
        'categoria'   => 'permit_empty|max_length[100]',
        'enlace'      => 'required|max_length[500]',
        'descripcion' => 'permit_empty',
    ];

    public function getJuegos(?string $search = null): array
    {
        EntretenimientoModel::ensureEntertainmentTables();

        $builder = $this->select('juego.*,
                                  (SELECT COUNT(*) FROM entretenimientojuego ej WHERE ej.idjuego = juego.idjuego) AS total_entretenimientos')
                        ->orderBy('juego.idjuego', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('juego.nombre', $search)
                    ->orLike('juego.categoria', $search)
                    ->orLike('juego.enlace', $search)
                    ->orLike('juego.descripcion', $search);
            if (is_numeric($search)) {
                $builder->orWhere('juego.idjuego', (int)$search);
            }
            $builder->groupEnd();
        }

        return $builder->findAll();
    }
}
