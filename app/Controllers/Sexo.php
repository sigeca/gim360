<?php

namespace App\Controllers;

use App\Models\SexoModel;

class Sexo extends BaseController
{
    protected SexoModel $sexoModel;

    public function __construct()
    {
        $this->sexoModel = new SexoModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $sexo = $id ? $this->sexoModel->find($id) : $this->sexoModel->elultimo();

        $data = [
            'title'  => 'Ficha de Sexo',
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];

        return view('sexo/sexo_record', $data);
    }

    public function elprimero()
    {
        $sexo = $this->sexoModel->elprimero();
        $data = [
            'title'  => 'Ficha de Sexo - Primer Registro',
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];
        return view('sexo/sexo_record', $data);
    }

    public function elultimo()
    {
        $sexo = $this->sexoModel->elultimo();
        $data = [
            'title'  => 'Ficha de Sexo - Último Registro',
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];
        return view('sexo/sexo_record', $data);
    }

    public function siguiente($id)
    {
        $sexo = $this->sexoModel->siguiente($id);
        $data = [
            'title'  => 'Ficha de Sexo',
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];
        return view('sexo/sexo_record', $data);
    }

    public function anterior($id)
    {
        $sexo = $this->sexoModel->anterior($id);
        $data = [
            'title'  => 'Ficha de Sexo',
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];
        return view('sexo/sexo_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search = $this->request->getGet('q');
        $builder = $this->sexoModel->orderBy('idsexo', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        $data = [
            'title'  => 'Listado del Catálogo de Sexos',
            'sexos'  => $builder->findAll(),
            'search' => $search,
            'module' => 'sexo',
        ];

        return view('sexo/sexo_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nuevo Registro de Sexo',
            'module' => 'sexo',
        ];

        return view('sexo/sexo_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[sexo.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->sexoModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('sexo/actual/' . $id))->with('success', 'Sexo registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $sexo = $this->sexoModel->find($id);
        if (!$sexo) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Sexo no encontrado.");
        }

        $data = [
            'title'  => 'Editar Sexo #' . $id,
            'sexo'   => $sexo,
            'module' => 'sexo',
        ];

        return view('sexo/sexo_edit', $data);
    }

    public function update($id)
    {
        $sexo = $this->sexoModel->find($id);
        if (!$sexo) {
            return redirect()->to(base_url('sexo'))->with('error', 'Sexo no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[sexo.nombre,idsexo,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->sexoModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('sexo/actual/' . $id))->with('success', 'Sexo actualizado correctamente.');
    }

    public function delete($id)
    {
        $sexo = $this->sexoModel->find($id);
        if (!$sexo) {
            return redirect()->to(base_url('sexo'))->with('error', 'Sexo no encontrado.');
        }

        try {
            $this->sexoModel->delete($id);
            return redirect()->to(base_url('sexo/elprimero'))->with('success', 'Sexo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('sexo/actual/' . $id))->with('error', 'No se puede eliminar porque existen registros asociados.');
        }
    }
}
