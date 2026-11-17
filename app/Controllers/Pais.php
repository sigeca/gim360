<?php

namespace App\Controllers;

use App\Models\PaisModel;

class Pais extends BaseController
{
    protected PaisModel $paisModel;

    public function __construct()
    {
        $this->paisModel = new PaisModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $pais = $id ? $this->paisModel->find($id) : $this->paisModel->elultimo();

        $data = [
            'title'  => 'Ficha de País',
            'pais'   => $pais,
            'module' => 'pais',
        ];

        return view('pais/pais_record', $data);
    }

    public function elprimero()
    {
        $pais = $this->paisModel->elprimero();
        $data = [
            'title'  => 'Ficha de País - Primer Registro',
            'pais'   => $pais,
            'module' => 'pais',
        ];
        return view('pais/pais_record', $data);
    }

    public function elultimo()
    {
        $pais = $this->paisModel->elultimo();
        $data = [
            'title'  => 'Ficha de País - Último Registro',
            'pais'   => $pais,
            'module' => 'pais',
        ];
        return view('pais/pais_record', $data);
    }

    public function siguiente($id)
    {
        $pais = $this->paisModel->siguiente($id);
        $data = [
            'title'  => 'Ficha de País',
            'pais'   => $pais,
            'module' => 'pais',
        ];
        return view('pais/pais_record', $data);
    }

    public function anterior($id)
    {
        $pais = $this->paisModel->anterior($id);
        $data = [
            'title'  => 'Ficha de País',
            'pais'   => $pais,
            'module' => 'pais',
        ];
        return view('pais/pais_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search = $this->request->getGet('q');
        $builder = $this->paisModel->orderBy('nombre', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        $data = [
            'title'  => 'Listado del Catálogo de Países',
            'paises' => $builder->findAll(),
            'search' => $search,
            'module' => 'pais',
        ];

        return view('pais/pais_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nuevo Registro de País',
            'module' => 'pais',
        ];

        return view('pais/pais_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]|is_unique[pais.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->paisModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('pais/actual/' . $id))->with('success', 'País registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $pais = $this->paisModel->find($id);
        if (!$pais) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("País no encontrado.");
        }

        $data = [
            'title'  => 'Editar País #' . $id,
            'pais'   => $pais,
            'module' => 'pais',
        ];

        return view('pais/pais_edit', $data);
    }

    public function update($id)
    {
        $pais = $this->paisModel->find($id);
        if (!$pais) {
            return redirect()->to(base_url('pais'))->with('error', 'País no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[150]|is_unique[pais.nombre,idpais,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->paisModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('pais/actual/' . $id))->with('success', 'País actualizado exitosamente.');
    }

    public function delete($id)
    {
        $pais = $this->paisModel->find($id);
        if (!$pais) {
            return redirect()->to(base_url('pais'))->with('error', 'País no encontrado.');
        }

        try {
            $this->paisModel->delete($id);
        } catch (\Throwable $e) {
            return redirect()->to(base_url('pais/actual/' . $id))
                             ->with('error', 'No se puede eliminar este país porque está asignado a una o más direcciones.');
        }

        return redirect()->to(base_url('pais/elprimero'))->with('success', 'País eliminado correctamente.');
    }
}
