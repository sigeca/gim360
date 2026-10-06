<?php

namespace App\Controllers;

use App\Models\EstadoCivilModel;

class EstadoCivil extends BaseController
{
    protected EstadoCivilModel $estadoCivilModel;

    public function __construct()
    {
        $this->estadoCivilModel = new EstadoCivilModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $estadoCivil = $id ? $this->estadoCivilModel->find($id) : $this->estadoCivilModel->elultimo();

        $data = [
            'title'       => 'Ficha de Estado Civil',
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];

        return view('estadocivil/estadocivil_record', $data);
    }

    public function elprimero()
    {
        $estadoCivil = $this->estadoCivilModel->elprimero();
        $data = [
            'title'       => 'Ficha de Estado Civil - Primer Registro',
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];
        return view('estadocivil/estadocivil_record', $data);
    }

    public function elultimo()
    {
        $estadoCivil = $this->estadoCivilModel->elultimo();
        $data = [
            'title'       => 'Ficha de Estado Civil - Último Registro',
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];
        return view('estadocivil/estadocivil_record', $data);
    }

    public function siguiente($id)
    {
        $estadoCivil = $this->estadoCivilModel->siguiente($id);
        $data = [
            'title'       => 'Ficha de Estado Civil',
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];
        return view('estadocivil/estadocivil_record', $data);
    }

    public function anterior($id)
    {
        $estadoCivil = $this->estadoCivilModel->anterior($id);
        $data = [
            'title'       => 'Ficha de Estado Civil',
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];
        return view('estadocivil/estadocivil_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search = $this->request->getGet('q');
        $builder = $this->estadoCivilModel->orderBy('idestadocivil', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        $data = [
            'title'          => 'Listado de Estados Civiles',
            'estadosCiviles' => $builder->findAll(),
            'search'         => $search,
            'module'         => 'estadocivil',
        ];

        return view('estadocivil/estadocivil_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nuevo Estado Civil',
            'module' => 'estadocivil',
        ];

        return view('estadocivil/estadocivil_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[estadocivil.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->estadoCivilModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('estadocivil/actual/' . $id))->with('success', 'Estado civil registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $estadoCivil = $this->estadoCivilModel->find($id);
        if (!$estadoCivil) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Estado civil no encontrado.");
        }

        $data = [
            'title'       => 'Editar Estado Civil #' . $id,
            'estadoCivil' => $estadoCivil,
            'module'      => 'estadocivil',
        ];

        return view('estadocivil/estadocivil_edit', $data);
    }

    public function update($id)
    {
        $estadoCivil = $this->estadoCivilModel->find($id);
        if (!$estadoCivil) {
            return redirect()->to(base_url('estadocivil'))->with('error', 'Estado civil no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[estadocivil.nombre,idestadocivil,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->estadoCivilModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('estadocivil/actual/' . $id))->with('success', 'Estado civil actualizado exitosamente.');
    }

    public function delete($id)
    {
        $estadoCivil = $this->estadoCivilModel->find($id);
        if (!$estadoCivil) {
            return redirect()->to(base_url('estadocivil'))->with('error', 'Estado civil no encontrado.');
        }

        try {
            $this->estadoCivilModel->delete($id);
            return redirect()->to(base_url('estadocivil/elprimero'))->with('success', 'Estado civil eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('estadocivil/actual/' . $id))->with('error', 'No se puede eliminar porque existen registros asociados.');
        }
    }
}
