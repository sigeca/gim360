<?php

namespace App\Controllers;

use App\Models\EstadoCivilPersonaModel;
use App\Models\PersonaModel;
use App\Models\EstadoCivilModel;

class EstadoCivilPersona extends BaseController
{
    protected EstadoCivilPersonaModel $ecpModel;
    protected PersonaModel $personaModel;
    protected EstadoCivilModel $estadoCivilModel;

    public function __construct()
    {
        $this->ecpModel         = new EstadoCivilPersonaModel();
        $this->personaModel     = new PersonaModel();
        $this->estadoCivilModel = new EstadoCivilModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $asignacion = $this->ecpModel->select('estadocivilpersona.*, persona.cedula, persona.nombres AS persona_nombres, estadocivil.nombre AS estadocivil_nombre')
                                         ->join('persona', 'persona.idpersona = estadocivilpersona.idpersona', 'inner')
                                         ->join('estadocivil', 'estadocivil.idestadocivil = estadocivilpersona.idestadocivil', 'inner')
                                         ->where('estadocivilpersona.idestadocivilpersona', $id)
                                         ->first();
        } else {
            $last = $this->ecpModel->elultimo();
            $asignacion = $last ? $this->ecpModel->select('estadocivilpersona.*, persona.cedula, persona.nombres AS persona_nombres, estadocivil.nombre AS estadocivil_nombre')
                                                 ->join('persona', 'persona.idpersona = estadocivilpersona.idpersona', 'inner')
                                                 ->join('estadocivil', 'estadocivil.idestadocivil = estadocivilpersona.idestadocivil', 'inner')
                                                 ->where('estadocivilpersona.idestadocivilpersona', $last['idestadocivilpersona'])
                                                 ->first() : null;
        }

        $data = [
            'title'      => 'Ficha de Asignación de Estado Civil',
            'asignacion' => $asignacion,
            'module'     => 'estadocivilpersona',
        ];

        return view('estadocivilpersona/estadocivilpersona_record', $data);
    }

    public function elprimero()
    {
        $first = $this->ecpModel->elprimero();
        return $this->actual($first ? $first['idestadocivilpersona'] : null);
    }

    public function elultimo()
    {
        $last = $this->ecpModel->elultimo();
        return $this->actual($last ? $last['idestadocivilpersona'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->ecpModel->siguiente($id);
        return $this->actual($next ? $next['idestadocivilpersona'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->ecpModel->anterior($id);
        return $this->actual($prev ? $prev['idestadocivilpersona'] : $id);
    }

    // Vista para listar todas las asignaciones
    public function listar()
    {
        $search = $this->request->getGet('q');
        $asignaciones = $this->ecpModel->getEstadoCivilPersonasWithDetails($search);

        $data = [
            'title'        => 'Listado de Asignaciones Estado Civil - Persona',
            'asignaciones' => $asignaciones,
            'search'       => $search,
            'module'       => 'estadocivilpersona',
        ];

        return view('estadocivilpersona/estadocivilpersona_list', $data);
    }

    // Vista de formulario para registrar nueva asignación
    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Asignar Estado Civil a Persona',
            'personas'             => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'estadosCiviles'       => $this->estadoCivilModel->orderBy('nombre', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'estadocivilpersona',
        ];

        return view('estadocivilpersona/estadocivilpersona_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona'     => 'required|is_natural_no_zero',
            'idestadocivil' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->ecpModel->insert([
            'idpersona'     => $this->request->getPost('idpersona'),
            'idestadocivil' => $this->request->getPost('idestadocivil'),
        ]);

        $redirectPersona = $this->request->getPost('redirect_persona');
        if (!empty($redirectPersona)) {
            return redirect()->to(base_url('persona/actual/' . $redirectPersona))->with('success', 'Estado civil asignado correctamente.');
        }

        return redirect()->to(base_url('estadocivilpersona/actual/' . $id))->with('success', 'Asignación registrada exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $asignacion = $this->ecpModel->find($id);
        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'          => 'Editar Asignación #' . $id,
            'asignacion'     => $asignacion,
            'personas'       => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'estadosCiviles' => $this->estadoCivilModel->orderBy('nombre', 'ASC')->findAll(),
            'module'         => 'estadocivilpersona',
        ];

        return view('estadocivilpersona/estadocivilpersona_edit', $data);
    }

    public function update($id)
    {
        $asignacion = $this->ecpModel->find($id);
        if (!$asignacion) {
            return redirect()->to(base_url('estadocivilpersona'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idpersona'     => 'required|is_natural_no_zero',
            'idestadocivil' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ecpModel->update($id, [
            'idpersona'     => $this->request->getPost('idpersona'),
            'idestadocivil' => $this->request->getPost('idestadocivil'),
        ]);

        return redirect()->to(base_url('estadocivilpersona/actual/' . $id))->with('success', 'Asignación actualizada exitosamente.');
    }

    public function delete($id)
    {
        $asignacion = $this->ecpModel->find($id);
        if (!$asignacion) {
            return redirect()->to(base_url('estadocivilpersona'))->with('error', 'Registro no encontrado.');
        }

        $this->ecpModel->delete($id);

        $redirectPersona = $this->request->getPost('redirect_persona');
        if (!empty($redirectPersona)) {
            return redirect()->to(base_url('persona/actual/' . $redirectPersona))->with('success', 'Asignación eliminada correctamente.');
        }

        $next = $this->ecpModel->elultimo();
        $targetUrl = $next ? 'estadocivilpersona/actual/' . $next['idestadocivilpersona'] : 'estadocivilpersona';

        return redirect()->to(base_url($targetUrl))->with('success', 'Asignación eliminada exitosamente.');
    }
}
