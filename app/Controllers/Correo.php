<?php

namespace App\Controllers;

use App\Models\CorreoModel;
use App\Models\PersonaModel;

class Correo extends BaseController
{
    protected CorreoModel $correoModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->correoModel  = new CorreoModel();
        $this->personaModel = new PersonaModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $correo = $this->correoModel->select('correo.*, persona.cedula, persona.nombres AS persona_nombres')
                                        ->join('persona', 'persona.idpersona = correo.idpersona', 'inner')
                                        ->where('correo.idcorreo', $id)
                                        ->first();
        } else {
            $last = $this->correoModel->elultimo();
            $correo = $last ? $this->correoModel->select('correo.*, persona.cedula, persona.nombres AS persona_nombres')
                                                ->join('persona', 'persona.idpersona = correo.idpersona', 'inner')
                                                ->where('correo.idcorreo', $last['idcorreo'])
                                                ->first() : null;
        }

        $data = [
            'title'  => 'Ficha de Correo Electrónico',
            'correo' => $correo,
            'module' => 'correo',
        ];

        return view('correo/correo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->correoModel->elprimero();
        return $this->actual($first ? $first['idcorreo'] : null);
    }

    public function elultimo()
    {
        $last = $this->correoModel->elultimo();
        return $this->actual($last ? $last['idcorreo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->correoModel->siguiente($id);
        return $this->actual($next ? $next['idcorreo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->correoModel->anterior($id);
        return $this->actual($prev ? $prev['idcorreo'] : $id);
    }

    // Vista para listar todos los correos
    public function listar()
    {
        $search = $this->request->getGet('q');
        $correos = $this->correoModel->getCorreosWithPersona($search);

        $data = [
            'title'   => 'Listado de Correos Electrónicos',
            'correos' => $correos,
            'search'  => $search,
            'module'  => 'correo',
        ];

        return view('correo/correo_list', $data);
    }

    // Vista de formulario para registrar nuevo correo
    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Registrar Correo Electrónico',
            'personas'             => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'correo',
        ];

        return view('correo/correo_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona'      => 'required|is_natural_no_zero',
            'correo'         => 'required|valid_email|max_length[150]',
            'fechaoptencion' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->correoModel->insert([
            'idpersona'      => $this->request->getPost('idpersona'),
            'correo'         => trim($this->request->getPost('correo')),
            'fechaoptencion' => !empty($this->request->getPost('fechaoptencion')) ? $this->request->getPost('fechaoptencion') : null,
        ]);

        return redirect()->to(base_url('correo/actual/' . $id))->with('success', 'Correo registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $correo = $this->correoModel->find($id);
        if (!$correo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Correo no encontrado.");
        }

        $data = [
            'title'    => 'Editar Correo #' . $id,
            'correo'   => $correo,
            'personas' => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'module'   => 'correo',
        ];

        return view('correo/correo_edit', $data);
    }

    public function update($id)
    {
        $correo = $this->correoModel->find($id);
        if (!$correo) {
            return redirect()->to(base_url('correo'))->with('error', 'Correo no encontrado.');
        }

        $rules = [
            'idpersona'      => 'required|is_natural_no_zero',
            'correo'         => 'required|valid_email|max_length[150]',
            'fechaoptencion' => 'permit_empty|valid_date',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->correoModel->update($id, [
            'idpersona'      => $this->request->getPost('idpersona'),
            'correo'         => trim($this->request->getPost('correo')),
            'fechaoptencion' => !empty($this->request->getPost('fechaoptencion')) ? $this->request->getPost('fechaoptencion') : null,
        ]);

        return redirect()->to(base_url('correo/actual/' . $id))->with('success', 'Correo actualizado exitosamente.');
    }

    public function delete($id)
    {
        $correo = $this->correoModel->find($id);
        if (!$correo) {
            return redirect()->to(base_url('correo'))->with('error', 'Correo no encontrado.');
        }

        $this->correoModel->delete($id);

        return redirect()->to(base_url('correo/elprimero'))->with('success', 'Correo eliminado correctamente.');
    }
}
