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
use App\Models\EjercicioClienteModel;

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
        $ejercicioClienteModel = new EjercicioClienteModel();

        $data = [
            'title' => 'Dashboard | GIM360',
            'counts' => [
                'persona'            => $personaModel->countAllResults(),
                'cliente'            => $clienteModel->countAllResults(),
                'correo'             => $correoModel->countAllResults(),
                'direccion'          => $direccionModel->countAllResults(),
                'sexo'               => $sexoModel->countAllResults(),
                'estadocivil'        => $ecModel->countAllResults(),
                'estadocivilpersona' => $ecpModel->countAllResults(),
                'genero'             => $generoModel->countAllResults(),
                'generopersona'      => $gpModel->countAllResults(),
                'visitasgim'         => $visitasGimModel->countAllResults(),
                'equipos'            => $equipoModel->countAllResults(),
                'ejercicio'          => $ejercicioModel->countAllResults(),
                'ejerciciocliente'   => $ejercicioClienteModel->countAllResults(),
            ],
            'recentPersonas'   => $personaModel->getPersonasWithRelations(),
            'recentVisitas'    => $visitasGimModel->getVisitasWithDetails(),
            'recentEquipos'    => $equipoModel->getEquiposWithDetails(),
            'recentEjercicios' => $ejercicioModel->getEjercicios(),
            'recentEC'         => $ejercicioClienteModel->getEjercicioClientesWithDetails(),
        ];

        return view('home/dashboard', $data);
    }
}
