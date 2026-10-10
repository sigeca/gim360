<?php

namespace App\Models;

use CodeIgniter\Model;

class EquipoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'equipos';
    protected $primaryKey       = 'id_equipo';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'codigo',
        'nombre',
        'imagen',
        'id_tipo',
        'id_marca',
        'modelo',
        'numero_serie',
        'descripcion',
        'id_ubicacion',
        'fecha_adquisicion',
        'valor_adquisicion',
        'id_estado',
        'activo',
        'observaciones',
    ];

    protected $validationRules = [
        'codigo'            => 'required|min_length[2]|max_length[30]|is_unique[equipos.codigo,id_equipo,{id_equipo}]',
        'nombre'            => 'required|min_length[2]|max_length[100]',
        'imagen'            => 'permit_empty|max_length[255]',
        'id_tipo'           => 'permit_empty|is_natural_no_zero',
        'id_marca'          => 'permit_empty|is_natural_no_zero',
        'id_ubicacion'      => 'permit_empty|is_natural_no_zero',
        'id_estado'         => 'permit_empty|is_natural_no_zero',
        'valor_adquisicion' => 'permit_empty|numeric',
        'fecha_adquisicion' => 'permit_empty|valid_date[Y-m-d]',
        'activo'            => 'permit_empty|in_list[0,1]',
    ];

    protected $validationMessages = [
        'codigo' => [
            'required'  => 'El código del equipo es obligatorio.',
            'is_unique' => 'Ya existe un equipo registrado con este código.',
        ],
        'nombre' => [
            'required'   => 'El nombre del equipo es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 2 caracteres.',
        ],
    ];

    public static function getTipos(): array
    {
        return [
            1 => 'Cardiovascular',
            2 => 'Musculación y Fuerza',
            3 => 'Peso Libre',
            4 => 'Funcional y Crossfit',
            5 => 'Accesorios y Otros',
        ];
    }

    public static function getMarcas(): array
    {
        return [
            1 => 'Life Fitness',
            2 => 'Matrix Fitness',
            3 => 'Hammer Strength',
            4 => 'Technogym',
            5 => 'Precor',
            6 => 'Bowflex',
            7 => 'Cybex',
            8 => 'Generica / Otra',
        ];
    }

    public static function getUbicaciones(): array
    {
        return [
            1 => 'Sala de Cardio (Piso 1)',
            2 => 'Área de Musculación (Piso 1)',
            3 => 'Sala de Spinning (Piso 2)',
            4 => 'Área Funcional / Box (Piso 2)',
            5 => 'Zona de Pesas Libres',
            6 => 'Bodega de Mantenimiento',
        ];
    }

    public static function getEstados(): array
    {
        return [
            1 => 'Operativo / Excelente',
            2 => 'Operativo / Desgaste Regular',
            3 => 'En Mantenimiento',
            4 => 'Averiado / Requiere Reparación',
            5 => 'Fuera de Servicio / Baja',
        ];
    }

    public function getEquiposWithDetails($search = null)
    {
        $builder = $this->orderBy('id_equipo', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('codigo', $search)
                    ->orLike('nombre', $search)
                    ->orLike('imagen', $search)
                    ->orLike('modelo', $search)
                    ->orLike('numero_serie', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    public function getAvailableImages(): array
    {
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        $folder = $baseDir . '/repositorio/images/equipment';
        if (!is_dir($folder)) {
            $folder = $baseDir . '/repositorio/image/equipment';
        }

        if (!is_dir($folder)) {
            return [];
        }

        $files = scandir($folder);
        $images = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && preg_match('/\.(webp|png|jpg|jpeg|svg)$/i', $file)) {
                $images[] = $file;
            }
        }
        sort($images);
        return $images;
    }
}
