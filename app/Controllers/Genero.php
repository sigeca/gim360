<?php

namespace App\Controllers;

use App\Models\GeneroModel;

class Genero extends BaseController
{
    protected GeneroModel $generoModel;

    public function __construct()
    {
        $this->generoModel = new GeneroModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $genero = $id ? $this->generoModel->find($id) : $this->generoModel->elultimo();

        $data = [
            'title'  => 'Ficha de Género',
            'genero' => $genero,
            'module' => 'genero',
        ];

        return view('genero/genero_record', $data);
    }

    public function elprimero()
    {
        $genero = $this->generoModel->elprimero();
        $data = [
            'title'  => 'Ficha de Género - Primer Registro',
            'genero' => $genero,
            'module' => 'genero',
        ];
        return view('genero/genero_record', $data);
    }

    public function elultimo()
    {
        $genero = $this->generoModel->elultimo();
        $data = [
            'title'  => 'Ficha de Género - Último Registro',
            'genero' => $genero,
            'module' => 'genero',
        ];
        return view('genero/genero_record', $data);
    }

    public function siguiente($id)
    {
        $genero = $this->generoModel->siguiente($id);
        $data = [
            'title'  => 'Ficha de Género',
            'genero' => $genero,
            'module' => 'genero',
        ];
        return view('genero/genero_record', $data);
    }

    public function anterior($id)
    {
        $genero = $this->generoModel->anterior($id);
        $data = [
            'title'  => 'Ficha de Género',
            'genero' => $genero,
            'module' => 'genero',
        ];
        return view('genero/genero_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search = $this->request->getGet('q');
        $builder = $this->generoModel->orderBy('idgenero', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        $data = [
            'title'   => 'Listado de Identidades de Género',
            'generos' => $builder->findAll(),
            'search'  => $search,
            'module'  => 'genero',
        ];

        return view('genero/genero_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nuevo Género',
            'module' => 'genero',
        ];

        return view('genero/genero_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[genero.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->generoModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('genero/actual/' . $id))->with('success', 'Género registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $genero = $this->generoModel->find($id);
        if (!$genero) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Género no encontrado.");
        }

        $data = [
            'title'  => 'Editar Género #' . $id,
            'genero' => $genero,
            'module' => 'genero',
        ];

        return view('genero/genero_edit', $data);
    }

    public function update($id)
    {
        $genero = $this->generoModel->find($id);
        if (!$genero) {
            return redirect()->to(base_url('genero'))->with('error', 'Género no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[genero.nombre,idgenero,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->generoModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('genero/actual/' . $id))->with('success', 'Género actualizado exitosamente.');
    }

    public function delete($id)
    {
        $genero = $this->generoModel->find($id);
        if (!$genero) {
            return redirect()->to(base_url('genero'))->with('error', 'Género no encontrado.');
        }

        try {
            $this->generoModel->delete($id);
            return redirect()->to(base_url('genero/elprimero'))->with('success', 'Género eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('genero/actual/' . $id))->with('error', 'No se puede eliminar porque existen registros asociados.');
        }
    }
}
