<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaModel extends Model
{
    use NavigableTrait;

    protected $table            = 'receta';
    protected $primaryKey       = 'idreceta';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'nombre',
        'instrucciones',
        'porciones',
        'tiempopreparacion',
    ];

    protected $validationRules = [
        'nombre'            => 'required|min_length[3]|max_length[150]',
        'instrucciones'     => 'permit_empty',
        'porciones'         => 'permit_empty|is_natural_no_zero|less_than[100]',
        'tiempopreparacion' => 'permit_empty|is_natural|less_than[1440]',
    ];

    protected $validationMessages = [
        'nombre' => [
            'required'   => 'El nombre de la receta es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 150 caracteres.',
        ],
        'porciones' => [
            'is_natural_no_zero' => 'El número de porciones debe ser un número entero mayor a 0.',
            'less_than'          => 'El número de porciones debe ser menor a 100.',
        ],
        'tiempopreparacion' => [
            'is_natural' => 'El tiempo de preparación debe ser un número entero en minutos (0 o más).',
            'less_than'  => 'El tiempo de preparación no puede exceder las 24 horas (1440 minutos).',
        ],
    ];

    /**
     * Formatea los minutos en un texto legible (ej: "45 min" o "1 h 15 min")
     */
    public static function formatTiempo(?int $minutos): string
    {
        if ($minutos === null || $minutos <= 0) {
            return 'No especificado';
        }

        if ($minutos < 60) {
            return "{$minutos} min";
        }

        $horas = intdiv($minutos, 60);
        $resto = $minutos % 60;

        if ($resto === 0) {
            return "{$horas} h";
        }

        return "{$horas} h {$resto} min";
    }

    /**
     * Devuelve una categoría de rapidez según el tiempo de preparación
     */
    public static function getCategoriaTiempo(?int $minutos): array
    {
        if ($minutos === null || $minutos <= 0) {
            return [
                'etiqueta'    => 'Tiempo libre',
                'badge_class' => 'bg-secondary',
                'icono'       => 'bi-clock',
            ];
        }

        if ($minutos <= 15) {
            return [
                'etiqueta'    => 'Rápida (≤15 min)',
                'badge_class' => 'bg-success',
                'icono'       => 'bi-lightning-charge-fill',
            ];
        }

        if ($minutos <= 35) {
            return [
                'etiqueta'    => 'Media (16-35 min)',
                'badge_class' => 'bg-info text-dark',
                'icono'       => 'bi-hourglass-split',
            ];
        }

        return [
            'etiqueta'    => 'Elaborada (>35 min)',
            'badge_class' => 'bg-warning text-dark',
            'icono'       => 'bi-stopwatch-fill',
        ];
    }

    /**
     * Obtiene el listado de recetas con buscador opcional
     */
    public function getRecetas(?string $search = null): array
    {
        $builder = $this->orderBy('idreceta', 'ASC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('nombre', $search)
                    ->orLike('instrucciones', $search);

            if (is_numeric($search)) {
                $builder->orWhere('idreceta', (int)$search)
                        ->orWhere('porciones', (int)$search)
                        ->orWhere('tiempopreparacion', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->findAll();
        foreach ($records as &$rec) {
            $min = !empty($rec['tiempopreparacion']) ? (int)$rec['tiempopreparacion'] : null;
            $rec['tiempo_texto']     = self::formatTiempo($min);
            $rec['categoria_tiempo'] = self::getCategoriaTiempo($min);
        }

        return $records;
    }

    /**
     * Obtiene los detalles de una receta con helpers formateados
     */
    public function getRecetaWithDetails(int $id): ?array
    {
        $rec = $this->find($id);
        if ($rec) {
            $min = !empty($rec['tiempopreparacion']) ? (int)$rec['tiempopreparacion'] : null;
            $rec['tiempo_texto']     = self::formatTiempo($min);
            $rec['categoria_tiempo'] = self::getCategoriaTiempo($min);
        }
        return $rec;
    }
}
