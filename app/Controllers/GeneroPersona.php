<?php

namespace App\Controllers;

use App\Models\GeneroPersonaModel;
use App\Models\PersonaModel;
use App\Models\GeneroModel;

class GeneroPersona extends BaseController
{
    protected GeneroPersonaModel $gpModel;
    protected PersonaModel $personaModel;
    protected GeneroModel $generoModel;

    public function __construct()
    {
        $this->gpModel      = new GeneroPersonaModel();
        $this->personaModel = new PersonaModel();
        $this->generoModel  = new GeneroModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $asignacion = $this->gpModel->select('generopersona.*, persona.cedula, persona.nombres AS persona_nombres, genero.nombre AS genero_nombre')
                                        ->join('persona', 'persona.idpersona = generopersona.idpersona', 'inner')
                                        ->join('genero', 'genero.idgenero = generopersona.idgenero', 'inner')
                                        ->where('generopersona.idgeneropersona', $id)
                                        ->first();
        } else {
            $last = $this->gpModel->elultimo();
            $asignacion = $last ? $this->gpModel->select('generopersona.*, persona.cedula, persona.nombres AS persona_nombres, genero.nombre AS genero_nombre')
                                                ->join('persona', 'persona.idpersona = generopersona.idpersona', 'inner')
                                                ->join('genero', 'genero.idgenero = generopersona.idgenero', 'inner')
                                                ->where('generopersona.idgeneropersona', $last['idgeneropersona'])
                                                ->first() : null;
        }

        $data = [
            'title'      => 'Ficha de Asignación de Género',
            'asignacion' => $asignacion,
            'module'     => 'generopersona',
        ];

        return view('generopersona/generopersona_record', $data);
    }

    public function elprimero()
    {
        $first = $this->gpModel->elprimero();
        return $this->actual($first ? $first['idgeneropersona'] : null);
    }

    public function elultimo()
    {
        $last = $this->gpModel->elultimo();
        return $this->actual($last ? $last['idgeneropersona'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->gpModel->siguiente($id);
        return $this->actual($next ? $next['idgeneropersona'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->gpModel->anterior($id);
        return $this->actual($prev ? $prev['idgeneropersona'] : $id);
    }

    // Vista para listar todas las asignaciones
    public function listar()
    {
        $search = $this->request->getGet('q');
        $asignaciones = $this->gpModel->getGeneroPersonasWithDetails($search);

        $data = [
            'title'        => 'Listado de Asignaciones Género - Persona',
            'asignaciones' => $asignaciones,
            'search'       => $search,
            'module'       => 'generopersona',
        ];

        return view('generopersona/generopersona_list', $data);
    }

    // Vista de formulario para registrar nueva asignación
    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Asignar Género a Persona',
            'personas'             => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'generos'              => $this->generoModel->orderBy('nombre', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'generopersona',
        ];

        return view('generopersona/generopersona_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'idgenero'  => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->gpModel->insert([
            'idpersona' => $this->request->getPost('idpersona'),
            'idgenero'  => $this->request->getPost('idgenero'),
        ]);

        $redirectPersona = $this->request->getPost('redirect_persona');
        if (!empty($redirectPersona)) {
            return redirect()->to(base_url('persona/actual/' . $redirectPersona))->with('success', 'Género asignado correctamente.');
        }

        return redirect()->to(base_url('generopersona/actual/' . $id))->with('success', 'Asignación de género registrada exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $asignacion = $this->gpModel->find($id);
        if (!$asignacion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'      => 'Editar Asignación #' . $id,
            'asignacion' => $asignacion,
            'personas'   => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'generos'    => $this->generoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'generopersona',
        ];

        return view('generopersona/generopersona_edit', $data);
    }

    public function update($id)
    {
        $asignacion = $this->gpModel->find($id);
        if (!$asignacion) {
            return redirect()->to(base_url('generopersona'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'idgenero'  => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->gpModel->update($id, [
            'idpersona' => $this->request->getPost('idpersona'),
            'idgenero'  => $this->request->getPost('idgenero'),
        ]);

        return redirect()->to(base_url('generopersona/actual/' . $id))->with('success', 'Asignación actualizada exitosamente.');
    }

    public function delete($id)
    {
        $asignacion = $this->gpModel->find($id);
        if (!$asignacion) {
            return redirect()->to(base_url('generopersona'))->with('error', 'Registro no encontrado.');
        }

        $this->gpModel->delete($id);

        $redirectPersona = $this->request->getPost('redirect_persona');
        if (!empty($redirectPersona)) {
            return redirect()->to(base_url('persona/actual/' . $redirectPersona))->with('success', 'Asignación eliminada correctamente.');
        }

        $next = $this->gpModel->elultimo();
        $targetUrl = $next ? 'generopersona/actual/' . $next['idgeneropersona'] : 'generopersona';

        return redirect()->to(base_url($targetUrl))->with('success', 'Asignación eliminada exitosamente.');
    }
}
