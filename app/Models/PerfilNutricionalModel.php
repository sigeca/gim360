<?php

namespace App\Models;

use CodeIgniter\Model;

class PerfilNutricionalModel extends Model
{
    use NavigableTrait;

    protected $table            = 'perfilnutricional';
    protected $primaryKey       = 'idperfilnutricional';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idpersona',
        'peso_kg',
        'estatura_cm',
        'fechamedicion',
        'porcentajegrasa',
        'porcentajemusculo',
        'observaciones',
    ];

    protected $validationRules = [
        'idpersona'         => 'required|is_natural_no_zero',
        'peso_kg'           => 'required|numeric|greater_than[20]|less_than[400]',
        'estatura_cm'       => 'required|numeric|greater_than[50]|less_than[260]',
        'fechamedicion'     => 'permit_empty|valid_date',
        'porcentajegrasa'   => 'permit_empty|numeric|greater_than_equal_to[1]|less_than_equal_to[70]',
        'porcentajemusculo' => 'permit_empty|numeric|greater_than_equal_to[5]|less_than_equal_to[80]',
        'observaciones'     => 'permit_empty',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required'           => 'Debe seleccionar una persona.',
            'is_natural_no_zero' => 'Persona no válida.',
        ],
        'peso_kg' => [
            'required'     => 'El peso en kg es obligatorio.',
            'numeric'      => 'El peso debe ser numérico.',
            'greater_than' => 'El peso debe ser mayor a 20 kg.',
            'less_than'    => 'El peso debe ser menor a 400 kg.',
        ],
        'estatura_cm' => [
            'required'     => 'La estatura en cm es obligatoria.',
            'numeric'      => 'La estatura debe ser numérica.',
            'greater_than' => 'La estatura debe ser mayor a 50 cm.',
            'less_than'    => 'La estatura debe ser menor a 260 cm.',
        ],
    ];

    /**
     * Calcula el Índice de Masa Corporal (IMC)
     */
    public static function calcularIMC(float $pesoKg, float $estaturaCm): ?float
    {
        if ($pesoKg <= 0 || $estaturaCm <= 0) {
            return null;
        }
        $estaturaM = $estaturaCm / 100.0;
        return round($pesoKg / ($estaturaM * $estaturaM), 2);
    }

    /**
     * Devuelve la clasificación según estándares de la OMS
     */
    public static function getClasificacionIMC(?float $imc): array
    {
        if ($imc === null || $imc <= 0) {
            return [
                'categoria'   => 'Desconocido',
                'badge_class' => 'bg-secondary',
                'text_color'  => 'text-secondary',
                'descripcion' => 'Datos insuficientes para calcular el IMC',
            ];
        }

        if ($imc < 18.5) {
            return [
                'categoria'   => 'Bajo Peso',
                'badge_class' => 'bg-warning text-dark',
                'text_color'  => 'text-warning',
                'descripcion' => 'Peso inferior al rango saludable recomendado',
            ];
        } elseif ($imc <= 24.9) {
            return [
                'categoria'   => 'Peso Normal / Saludable',
                'badge_class' => 'bg-success',
                'text_color'  => 'text-success',
                'descripcion' => 'Rango de peso corporal adecuado y saludable',
            ];
        } elseif ($imc <= 29.9) {
            return [
                'categoria'   => 'Sobrepeso',
                'badge_class' => 'bg-warning text-dark',
                'text_color'  => 'text-warning',
                'descripcion' => 'Ligero exceso de peso respecto a la estatura',
            ];
        } elseif ($imc <= 34.9) {
            return [
                'categoria'   => 'Obesidad Grado I',
                'badge_class' => 'bg-danger',
                'text_color'  => 'text-danger',
                'descripcion' => 'Obesidad moderada con riesgo cardiovascular',
            ];
        } elseif ($imc <= 39.9) {
            return [
                'categoria'   => 'Obesidad Grado II',
                'badge_class' => 'bg-danger',
                'text_color'  => 'text-danger',
                'descripcion' => 'Obesidad severa que requiere seguimiento',
            ];
        } else {
            return [
                'categoria'   => 'Obesidad Grado III (Mórbida)',
                'badge_class' => 'bg-danger text-white',
                'text_color'  => 'text-danger',
                'descripcion' => 'Riesgo elevado. Control médico prioritario',
            ];
        }
    }

    /**
     * Rango de peso saludable para una estatura dada (IMC 18.5 a 24.9)
     */
    public static function getRangoPesoSaludable(float $estaturaCm): array
    {
        if ($estaturaCm <= 0) {
            return ['min' => 0, 'max' => 0];
        }
        $estaturaM = $estaturaCm / 100.0;
        $min = round(18.5 * ($estaturaM * $estaturaM), 1);
        $max = round(24.9 * ($estaturaM * $estaturaM), 1);
        return ['min' => $min, 'max' => $max];
    }

    /**
     * Obtiene el listado completo de perfiles nutricionales con datos de la persona
     */
    public function getPerfilesWithPersona(?string $search = null)
    {
        $builder = $this->select('perfilnutricional.*, persona.cedula, persona.apellidos, persona.nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre')
                        ->join('persona', 'persona.idpersona = perfilnutricional.idpersona', 'inner')
                        ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                        ->orderBy('perfilnutricional.fechamedicion', 'DESC')
                        ->orderBy('perfilnutricional.idperfilnutricional', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.cedula', $search)
                    ->orLike('persona.apellidos', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike("CONCAT(persona.apellidos, ' ', persona.nombres)", $search)
                    ->orLike("CONCAT(persona.nombres, ' ', persona.apellidos)", $search)
                    ->orLike('perfilnutricional.observaciones', $search);
            if (is_numeric($search)) {
                $builder->orWhere('perfilnutricional.idperfilnutricional', (int)$search)
                        ->orWhere('perfilnutricional.idpersona', (int)$search);
            }
            $builder->groupEnd();
        }

        $records = $builder->findAll();
        foreach ($records as &$rec) {
            $imc = self::calcularIMC((float)$rec['peso_kg'], (float)$rec['estatura_cm']);
            $rec['imc'] = $imc;
            $rec['clasificacion'] = self::getClasificacionIMC($imc);
        }

        return $records;
    }

    /**
     * Obtiene un perfil específico con detalles de persona y cálculo de IMC
     */
    public function getPerfilWithDetails(int $id)
    {
        $rec = $this->select('perfilnutricional.*, persona.cedula, persona.apellidos, persona.nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre, cliente.idcliente')
                    ->join('persona', 'persona.idpersona = perfilnutricional.idpersona', 'inner')
                    ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                    ->join('cliente', 'cliente.idpersona = persona.idpersona', 'left')
                    ->where('perfilnutricional.idperfilnutricional', $id)
                    ->first();

        if ($rec) {
            $peso = (float)$rec['peso_kg'];
            $estatura = (float)$rec['estatura_cm'];
            $imc = self::calcularIMC($peso, $estatura);
            $rec['imc'] = $imc;
            $rec['clasificacion'] = self::getClasificacionIMC($imc);
            $rec['rango_saludable'] = self::getRangoPesoSaludable($estatura);
        }

        return $rec;
    }

    /**
     * Obtiene todo el historial de perfiles/mediciones de una persona
     */
    public function getPerfilesByPersona(int $idpersona): array
    {
        $records = $this->where('idpersona', $idpersona)
                        ->orderBy('fechamedicion', 'DESC')
                        ->orderBy('idperfilnutricional', 'DESC')
                        ->findAll();

        foreach ($records as &$rec) {
            $imc = self::calcularIMC((float)$rec['peso_kg'], (float)$rec['estatura_cm']);
            $rec['imc'] = $imc;
            $rec['clasificacion'] = self::getClasificacionIMC($imc);
        }

        return $records;
    }

    /**
     * Obtiene la última medición registrada de una persona
     */
    public function getUltimoPerfilByPersona(int $idpersona)
    {
        $rec = $this->where('idpersona', $idpersona)
                    ->orderBy('fechamedicion', 'DESC')
                    ->orderBy('idperfilnutricional', 'DESC')
                    ->first();

        if ($rec) {
            $imc = self::calcularIMC((float)$rec['peso_kg'], (float)$rec['estatura_cm']);
            $rec['imc'] = $imc;
            $rec['clasificacion'] = self::getClasificacionIMC($imc);
        }

        return $rec;
    }
}
