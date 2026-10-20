<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaPersonalizadoModel extends Model
{
    use NavigableTrait;

    protected $table            = 'programaentrenamientopersonalizado';
    protected $primaryKey       = 'idprogramapersonalizado';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramaentrenamientomodelo',
        'idcliente',
        'nombre',
        'idmotivoentrenamiento',
        'idrangoedad',
        'fechacreacion',
    ];

    protected $validationRules = [
        'nombre'                => 'required|min_length[3]|max_length[150]',
        'idcliente'             => 'required|is_natural_no_zero',
        'idmotivoentrenamiento' => 'required|is_natural_no_zero',
        'idrangoedad'           => 'permit_empty|is_natural_no_zero',
    ];

    public function getProgramaPersonalizadoWithDetails(int $id)
    {
        return $this->select('programaentrenamientopersonalizado.*,
                              motivoentrenamiento.nombre AS motivo_nombre,
                              motivoentrenamiento.objetivo AS motivo_objetivo,
                              rangoedad.nombre AS rango_nombre,
                              rangoedad.edadminima AS rango_edadminima,
                              rangoedad.edadmaxima AS rango_edadmaxima,
                              persona.nombres AS cliente_nombres,
                              persona.apellidos AS cliente_apellidos,
                              persona.cedula AS cliente_cedula')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamientopersonalizado.idmotivoentrenamiento', 'inner')
                    ->join('rangoedad', 'rangoedad.idrangoedad = programaentrenamientopersonalizado.idrangoedad', 'left')
                    ->join('cliente', 'cliente.idcliente = programaentrenamientopersonalizado.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->where('programaentrenamientopersonalizado.idprogramapersonalizado', $id)
                    ->first();
    }
}
