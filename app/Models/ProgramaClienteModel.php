<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramaClienteModel extends Model
{
    use NavigableTrait;

    protected $table            = 'programacliente';
    protected $primaryKey       = 'idprogramacliente';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'idprogramaentrenamiento',
        'idcliente',
        'fechainicio',
        'idestadoprogramacliente',
    ];

    protected $validationRules = [
        'idprogramaentrenamiento' => 'required|is_natural_no_zero',
        'idcliente'               => 'required|is_natural_no_zero',
        'fechainicio'             => 'required|valid_date[Y-m-d]',
        'idestadoprogramacliente' => 'required|is_natural_no_zero',
    ];

    protected $validationMessages = [
        'idprogramaentrenamiento' => [
            'required'           => 'Debe seleccionar un programa de entrenamiento.',
            'is_natural_no_zero' => 'El programa de entrenamiento seleccionado no es válido.',
        ],
        'idcliente' => [
            'required'           => 'Debe seleccionar un cliente.',
            'is_natural_no_zero' => 'El cliente seleccionado no es válido.',
        ],
        'fechainicio' => [
            'required'   => 'La fecha de inicio es obligatoria.',
            'valid_date' => 'La fecha de inicio debe tener el formato AAAA-MM-DD.',
        ],
        'idestadoprogramacliente' => [
            'required'           => 'Debe seleccionar un estado para el programa.',
            'is_natural_no_zero' => 'El estado seleccionado no es válido.',
        ],
    ];

    public function getProgramaClienteWithDetails($id)
    {
        $pc = $this->select('programacliente.*, 
                             cliente.idpersona, 
                             persona.cedula AS cliente_cedula, 
                             persona.nombres AS cliente_nombres, 
                             persona.fechanacimiento AS cliente_fechanacimiento,
                             programaentrenamiento.nombre AS programa_nombre,
                             programaentrenamiento.idmotivoentrenamiento,
                             motivoentrenamiento.nombre AS motivo_nombre, 
                             motivoentrenamiento.objetivo AS motivo_objetivo,
                             estadoprogramacliente.nombre AS estado_nombre')
                    ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                    ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                    ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                    ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                    ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                    ->where('programacliente.idprogramacliente', $id)
                    ->first();

        if ($pc) {
            $pc['rutinas'] = (new RutinaProgramaModel())->getRutinasByPrograma((int)$pc['idprogramaentrenamiento']);
            
            // Recolectar todos los planes/ejercicios de todas las rutinas asignadas al programa
            $allPlanes = [];
            foreach ($pc['rutinas'] as $rutina) {
                if (!empty($rutina['planes'])) {
                    foreach ($rutina['planes'] as $pl) {
                        $pl['rutina_nombre'] = $rutina['rutina_nombre'];
                        $allPlanes[] = $pl;
                    }
                }
            }
            $pc['planes'] = $allPlanes;
        }

        return $pc;
    }

    public function getProgramasClientesWithDetails(?string $search = null)
    {
        $builder = $this->select('programacliente.*, 
                                  cliente.idpersona, 
                                  persona.cedula AS cliente_cedula, 
                                  persona.nombres AS cliente_nombres, 
                                  programaentrenamiento.nombre AS programa_nombre,
                                  motivoentrenamiento.nombre AS motivo_nombre, 
                                  estadoprogramacliente.nombre AS estado_nombre,
                                  (SELECT COUNT(*) FROM rutinaprograma WHERE rutinaprograma.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento) AS total_rutinas,
                                  (SELECT COUNT(*) FROM rutinaplan WHERE rutinaplan.idrutinaejercicio IN (SELECT rp.idrutinaejercicio FROM rutinaprograma rp WHERE rp.idprogramaentrenamiento = programaentrenamiento.idprogramaentrenamiento)) AS total_planes')
                        ->join('cliente', 'cliente.idcliente = programacliente.idcliente', 'inner')
                        ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                        ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento', 'inner')
                        ->join('motivoentrenamiento', 'motivoentrenamiento.idmotivoentrenamiento = programaentrenamiento.idmotivoentrenamiento', 'inner')
                        ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente', 'inner')
                        ->orderBy('programacliente.idprogramacliente', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('persona.nombres', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('programaentrenamiento.nombre', $search)
                    ->orLike('motivoentrenamiento.nombre', $search)
                    ->orLike('estadoprogramacliente.nombre', $search)
                    ->orLike('programacliente.fechainicio', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }
}
