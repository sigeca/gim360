<?php

namespace App\Models;

use CodeIgniter\Model;

class PlanAlimentacionModel extends Model
{
    use NavigableTrait;

    protected $table            = 'planalimentacion';
    protected $primaryKey       = 'idplanalimentacion';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idpersona',
        'idobjetivonutricional',
        'nombre',
        'fechainicio',
        'fechafin',
        'objetivo',
    ];

    protected $validationRules = [
        'idpersona'             => 'required|is_natural_no_zero|is_not_unique[persona.idpersona]',
        'idobjetivonutricional' => 'permit_empty|is_natural_no_zero',
        'nombre'                => 'required|min_length[3]|max_length[150]',
        'fechainicio'           => 'required|valid_date',
        'fechafin'              => 'permit_empty|valid_date',
        'objetivo'              => 'permit_empty',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required'           => 'Debe seleccionar una persona asignada al plan.',
            'is_natural_no_zero' => 'Seleccione una persona válida.',
            'is_not_unique'      => 'La persona seleccionada no existe en el sistema.',
        ],
        'nombre' => [
            'required'   => 'El nombre del plan de alimentación es obligatorio.',
            'min_length' => 'El nombre debe tener al menos 3 caracteres.',
            'max_length' => 'El nombre no puede superar los 150 caracteres.',
        ],
        'fechainicio' => [
            'required'   => 'La fecha de inicio es obligatoria.',
            'valid_date' => 'Ingrese una fecha de inicio válida (AAAA-MM-DD).',
        ],
        'fechafin' => [
            'valid_date' => 'Ingrese una fecha de fin válida (AAAA-MM-DD).',
        ],
    ];

    /**
     * Determina el estado de vigencia de un plan nutricional
     */
    public static function getEstadoPlan(string $fechaInicio, ?string $fechaFin): array
    {
        $hoy = date('Y-m-d');

        if ($hoy < $fechaInicio) {
            return [
                'clave'       => 'programado',
                'etiqueta'    => 'Programado',
                'badge_class' => 'bg-info text-dark',
                'icono'       => 'bi-calendar-event',
                'descripcion' => 'Iniciará próximamente',
            ];
        }

        if (!empty($fechaFin) && $hoy > $fechaFin) {
            return [
                'clave'       => 'finalizado',
                'etiqueta'    => 'Finalizado',
                'badge_class' => 'bg-secondary',
                'icono'       => 'bi-check-circle',
                'descripcion' => 'Plan culminado',
            ];
        }

        return [
            'clave'       => 'vigente',
            'etiqueta'    => 'Vigente / Activo',
            'badge_class' => 'bg-success',
            'icono'       => 'bi-play-circle-fill',
            'descripcion' => 'En curso actualmente',
        ];
    }

    /**
     * Obtiene el listado de planes de alimentación con datos de la persona y objetivo nutricional
     */
    public function getPlanesWithPersona(?string $search = null, ?int $idpersona = null): array
    {
        $builder = $this->select('planalimentacion.*, persona.cedula, persona.apellidos, persona.nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre, objetivonutricional.nombre AS objetivonutricional_nombre')
                        ->join('persona', 'persona.idpersona = planalimentacion.idpersona', 'inner')
                        ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                        ->join('objetivonutricional', 'objetivonutricional.idobjetivonutricional = planalimentacion.idobjetivonutricional', 'left')
                        ->orderBy('planalimentacion.fechainicio', 'DESC')
                        ->orderBy('planalimentacion.idplanalimentacion', 'DESC');

        if (!empty($idpersona)) {
            $builder->where('planalimentacion.idpersona', $idpersona);
        }

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('planalimentacion.nombre', $search)
                    ->orLike('planalimentacion.objetivo', $search)
                    ->orLike('objetivonutricional.nombre', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('persona.apellidos', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike("CONCAT(persona.apellidos, ' ', persona.nombres)", $search)
                    ->orLike("CONCAT(persona.nombres, ' ', persona.apellidos)", $search);

            if (is_numeric($search)) {
                $builder->orWhere('planalimentacion.idplanalimentacion', (int)$search)
                        ->orWhere('planalimentacion.idpersona', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->findAll();
        foreach ($records as &$rec) {
            $rec['estado_info'] = self::getEstadoPlan($rec['fechainicio'], $rec['fechafin']);
        }

        return $records;
    }

    /**
     * Obtiene un plan con detalles completos de la persona y objetivo nutricional
     */
    public function getPlanWithDetails(int $id): ?array
    {
        $rec = $this->select('planalimentacion.*, persona.cedula, persona.apellidos, persona.nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre, cliente.idcliente, objetivonutricional.nombre AS objetivonutricional_nombre')
                    ->join('persona', 'persona.idpersona = planalimentacion.idpersona', 'inner')
                    ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                    ->join('cliente', 'cliente.idpersona = persona.idpersona', 'left')
                    ->join('objetivonutricional', 'objetivonutricional.idobjetivonutricional = planalimentacion.idobjetivonutricional', 'left')
                    ->where('planalimentacion.idplanalimentacion', $id)
                    ->first();

        if ($rec) {
            $rec['estado_info'] = self::getEstadoPlan($rec['fechainicio'], $rec['fechafin']);
        }

        return $rec;
    }

    /**
     * Obtiene los planes de alimentación asignados a una persona
     */
    public function getPlanesByPersona(int $idpersona): array
    {
        $records = $this->select('planalimentacion.*, objetivonutricional.nombre AS objetivonutricional_nombre')
                        ->join('objetivonutricional', 'objetivonutricional.idobjetivonutricional = planalimentacion.idobjetivonutricional', 'left')
                        ->where('planalimentacion.idpersona', $idpersona)
                        ->orderBy('planalimentacion.fechainicio', 'DESC')
                        ->orderBy('planalimentacion.idplanalimentacion', 'DESC')
                        ->findAll();

        foreach ($records as &$rec) {
            $rec['estado_info'] = self::getEstadoPlan($rec['fechainicio'], $rec['fechafin']);
        }

        return $records;
    }
}
