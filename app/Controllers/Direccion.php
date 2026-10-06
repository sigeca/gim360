<?php

namespace App\Controllers;

use App\Models\DireccionModel;
use App\Models\PersonaModel;

class Direccion extends BaseController
{
    protected DireccionModel $direccionModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->direccionModel = new DireccionModel();
        $this->personaModel   = new PersonaModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $direccion = $this->direccionModel->select('direccion.*, persona.cedula, persona.nombres AS persona_nombres')
                                              ->join('persona', 'persona.idpersona = direccion.idpersona', 'inner')
                                              ->where('direccion.iddireccion', $id)
                                              ->first();
        } else {
            $last = $this->direccionModel->elultimo();
            $direccion = $last ? $this->direccionModel->select('direccion.*, persona.cedula, persona.nombres AS persona_nombres')
                                                      ->join('persona', 'persona.idpersona = direccion.idpersona', 'inner')
                                                      ->where('direccion.iddireccion', $last['iddireccion'])
                                                      ->first() : null;
        }

        $data = [
            'title'     => 'Ficha de Dirección',
            'direccion' => $direccion,
            'module'    => 'direccion',
        ];

        return view('direccion/direccion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->direccionModel->elprimero();
        return $this->actual($first ? $first['iddireccion'] : null);
    }

    public function elultimo()
    {
        $last = $this->direccionModel->elultimo();
        return $this->actual($last ? $last['iddireccion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->direccionModel->siguiente($id);
        return $this->actual($next ? $next['iddireccion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->direccionModel->anterior($id);
        return $this->actual($prev ? $prev['iddireccion'] : $id);
    }

    // Vista para listar todas las direcciones
    public function listar()
    {
        $search = $this->request->getGet('q');
        $direcciones = $this->direccionModel->getDireccionesWithPersona($search);

        $data = [
            'title'       => 'Listado de Direcciones Registradas',
            'direcciones' => $direcciones,
            'search'      => $search,
            'module'      => 'direccion',
        ];

        return view('direccion/direccion_list', $data);
    }

    // Vista de formulario para registrar nueva dirección
    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Registrar Dirección',
            'personas'             => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'direccion',
        ];

        return view('direccion/direccion_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'direccion' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->direccionModel->insert([
            'idpersona' => $this->request->getPost('idpersona'),
            'direccion' => trim($this->request->getPost('direccion')),
        ]);

        return redirect()->to(base_url('direccion/actual/' . $id))->with('success', 'Dirección registrada exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $direccion = $this->direccionModel->find($id);
        if (!$direccion) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Dirección no encontrada.");
        }

        $data = [
            'title'     => 'Editar Dirección #' . $id,
            'direccion' => $direccion,
            'personas'  => $this->personaModel->orderBy('nombres', 'ASC')->findAll(),
            'module'    => 'direccion',
        ];

        return view('direccion/direccion_edit', $data);
    }

    public function update($id)
    {
        $direccion = $this->direccionModel->find($id);
        if (!$direccion) {
            return redirect()->to(base_url('direccion'))->with('error', 'Dirección no encontrada.');
        }

        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'direccion' => 'required|min_length[3]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->direccionModel->update($id, [
            'idpersona' => $this->request->getPost('idpersona'),
            'direccion' => trim($this->request->getPost('direccion')),
        ]);

        return redirect()->to(base_url('direccion/actual/' . $id))->with('success', 'Dirección actualizada exitosamente.');
    }

    public function delete($id)
    {
        $direccion = $this->direccionModel->find($id);
        if (!$direccion) {
            return redirect()->to(base_url('direccion'))->with('error', 'Dirección no encontrada.');
        }

        $this->direccionModel->delete($id);

        return redirect()->to(base_url('direccion/elprimero'))->with('success', 'Dirección eliminada correctamente.');
    }
}
