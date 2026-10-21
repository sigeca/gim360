<?php

namespace App\Controllers;

use App\Models\PersonaModel;
use App\Models\ClienteModel;
use App\Models\CorreoModel;
use App\Models\DireccionModel;
use App\Models\SexoModel;
use App\Models\EstadoCivilModel;
use App\Models\EstadoCivilPersonaModel;
use App\Models\GeneroModel;
use App\Models\GeneroPersonaModel;
use App\Models\VisitasGimModel;
use App\Models\EquipoModel;
use App\Models\EjercicioModel;
use App\Models\MotivoEntrenamientoModel;
use App\Models\RutinaEjecicioModel;
use App\Models\PlanEjercicioModel;
use App\Models\RutinaPlanModel;
use App\Models\MusculoModel;
use App\Models\MusculoEjercicioModel;
use App\Models\ProgramaEntrenamientoModel;
use App\Models\ProgramaClienteModel;
use App\Models\EstadoProgramaClienteModel;
use App\Models\EjercicioEquipoModel;
use App\Models\RutinaProgramaModel;
use App\Models\RangoEdadModel;
use App\Models\EjecucionProgramaModel;
use App\Models\UsuarioModel;

class Home extends BaseController
{
    public function index(): string
    {
        $personaModel          = new PersonaModel();
        $clienteModel          = new ClienteModel();
        $correoModel           = new CorreoModel();
        $direccionModel        = new DireccionModel();
        $sexoModel             = new SexoModel();
        $ecModel               = new EstadoCivilModel();
        $ecpModel              = new EstadoCivilPersonaModel();
        $generoModel           = new GeneroModel();
        $gpModel               = new GeneroPersonaModel();
        $visitasGimModel       = new VisitasGimModel();
        $equipoModel           = new EquipoModel();
        $ejercicioModel        = new EjercicioModel();
        $motivoModel           = new MotivoEntrenamientoModel();
        $rutinaModel           = new RutinaEjecicioModel();
        $planModel             = new PlanEjercicioModel();
        $rpModel               = new RutinaPlanModel();
        $musculoModel          = new MusculoModel();
        $meModel               = new MusculoEjercicioModel();
        $peModel               = new ProgramaEntrenamientoModel();
        $pcModel               = new ProgramaClienteModel();
        $epcModel              = new EstadoProgramaClienteModel();
        $eeModel               = new EjercicioEquipoModel();
        $rprogModel            = new RutinaProgramaModel();
        $rangoModel            = new RangoEdadModel();
        $ejecProgModel         = new EjecucionProgramaModel();
        $usuarioModel          = new UsuarioModel();

        $db = \Config\Database::connect();

        // Distribución de Equipos por Tipo
        $tiposNombres = EquipoModel::getTipos();
        $equiposRaw = $db->table('equipo')
            ->select('id_tipo, COUNT(*) as total')
            ->groupBy('id_tipo')
            ->get()->getResultArray();
        $equipmentByType = [];
        foreach ($equiposRaw as $row) {
            $tipoLabel = $tiposNombres[$row['id_tipo']] ?? 'Otros';
            $equipmentByType[$tipoLabel] = (int)$row['total'];
        }

        // Top Músculos con Ejercicios Asociados
        $musclesRaw = $db->table('musculoejercicio me')
            ->select('m.nombre, COUNT(*) as total')
            ->join('musculo m', 'm.idmusculo = me.idmusculo')
            ->groupBy('m.idmusculo, m.nombre')
            ->orderBy('total', 'DESC')
            ->limit(6)
            ->get()->getResultArray();
        $topMuscles = [];
        foreach ($musclesRaw as $row) {
            $topMuscles[$row['nombre']] = (int)$row['total'];
        }

        $data = [
            'title' => 'Dashboard | GIM360',
            'counts' => [
                'persona'              => $personaModel->countAllResults(),
                'cliente'              => $clienteModel->countAllResults(),
                'correo'               => $correoModel->countAllResults(),
                'direccion'            => $direccionModel->countAllResults(),
                'sexo'                 => $sexoModel->countAllResults(),
                'estadocivil'          => $ecModel->countAllResults(),
                'estadocivilpersona'   => $ecpModel->countAllResults(),
                'genero'               => $generoModel->countAllResults(),
                'generopersona'        => $gpModel->countAllResults(),
                'visitasgim'           => $visitasGimModel->countAllResults(),
                'equipo'               => $equipoModel->countAllResults(),
                'equipos'              => $equipoModel->countAllResults(),
                'ejercicio'            => $ejercicioModel->countAllResults(),
                'musculo'              => $musculoModel->countAllResults(),
                'musculoejercicio'     => $meModel->countAllResults(),
                'ejercicioequipo'      => $eeModel->countAllResults(),
                'equipomusculo'        => (new \App\Models\EquipoMusculoModel())->countAllResults(),
                'disponibilidadequipo' => (new \App\Models\DisponibilidadEquipoModel())->countAllResults(),
                'motivoentrenamiento'  => $motivoModel->countAllResults(),
                'rangoedad'            => $rangoModel->countAllResults(),
                'rutinaejecicio'       => $rutinaModel->countAllResults(),
                'planejercicio'        => $planModel->countAllResults(),
                'rutinaplan'           => $rpModel->countAllResults(),
                'programaentrenamiento'=> $peModel->countAllResults(),
                'rutinaprograma'       => $rprogModel->countAllResults(),
                'programacliente'      => $pcModel->countAllResults(),
                'estadoprogramacliente'=> $epcModel->countAllResults(),
                'ejecucionprograma'    => $ejecProgModel->countAllResults(),
                'usuario'              => $usuarioModel->countAllResults(),
            ],
            'equipmentByType'  => $equipmentByType,
            'topMuscles'       => $topMuscles,
            'recentPersonas'   => $personaModel->getPersonasWithRelations(),
            'recentVisitas'    => $visitasGimModel->getVisitasWithDetails(),
            'recentEquipos'    => $equipoModel->getEquiposWithDetails(),
            'recentEjercicios' => $ejercicioModel->getEjercicios(),
        ];

        return view('home/dashboard', $data);
    }
}
