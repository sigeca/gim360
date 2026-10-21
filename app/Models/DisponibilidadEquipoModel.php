<?php

namespace App\Models;

use CodeIgniter\Model;

class DisponibilidadEquipoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'disponibilidadequipo';
    protected $primaryKey       = 'iddisponibilidadequipo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['nombre'];

    protected $validationRules = [
        'nombre' => 'required|min_length[2]|max_length[50]|is_unique[disponibilidadequipo.nombre,iddisponibilidadequipo,{iddisponibilidadequipo}]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre del estado de disponibilidad es obligatorio.',
            'min_length' => 'Debe tener al menos 2 caracteres.',
            'max_length' => 'No puede superar los 50 caracteres.',
            'is_unique'  => 'Ya existe un estado de disponibilidad con ese nombre.',
        ],
    ];

    /**
     * Obtiene las disponibilidades como un mapa id => nombre
     */
    public static function getOpciones(): array
    {
        $db = \Config\Database::connect();
        $rows = $db->table('disponibilidadequipo')->orderBy('iddisponibilidadequipo', 'ASC')->get()->getResultArray();
        $res = [];
        foreach ($rows as $r) {
            $res[$r['iddisponibilidadequipo']] = $r['nombre'];
        }
        return $res;
    }
}
