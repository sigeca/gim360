<?php

namespace App\Controllers;

use App\Models\EstadoProgramaClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EstadoProgramaCliente extends BaseController
{
    protected EstadoProgramaClienteModel $estadoModel;

    public function __construct()
    {
        $this->estadoModel = new EstadoProgramaClienteModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $estado = $id ? $this->estadoModel->find($id) : $this->estadoModel->elprimero();

        $data = [
            'title'  => 'Ficha de Estado de Programa de Cliente',
            'estado' => $estado,
            'module' => 'estadoprogramacliente',
        ];

        return view('estadoprogramacliente/estadoprogramacliente_record', $data);
    }

    public function elprimero()
    {
        $estado = $this->estadoModel->elprimero();
        return $this->actual($estado ? $estado['idestadoprogramacliente'] : null);
    }

    public function elultimo()
    {
        $estado = $this->estadoModel->elultimo();
        return $this->actual($estado ? $estado['idestadoprogramacliente'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->estadoModel->siguiente($id);
        return $this->actual($next ? $next['idestadoprogramacliente'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->estadoModel->anterior($id);
        return $this->actual($prev ? $prev['idestadoprogramacliente'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $estados = $this->estadoModel->getEstados($search);

        $data = [
            'title'   => 'Listado de Estados de Programa de Cliente',
            'estados' => $estados,
            'search'  => $search,
            'module'  => 'estadoprogramacliente',
        ];

        return view('estadoprogramacliente/estadoprogramacliente_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Nuevo Estado de Programa de Cliente',
            'module' => 'estadoprogramacliente',
        ];

        return view('estadoprogramacliente/estadoprogramacliente_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[estadoprogramacliente.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->estadoModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('estadoprogramacliente/actual/' . $id))->with('success', 'Estado de programa registrado exitosamente.');
    }

    public function edit($id)
    {
        $estado = $this->estadoModel->find($id);
        if (!$estado) {
            throw PageNotFoundException::forPageNotFound("Estado de programa no encontrado.");
        }

        $data = [
            'title'  => 'Editar Estado de Programa #' . $id,
            'estado' => $estado,
            'module' => 'estadoprogramacliente',
        ];

        return view('estadoprogramacliente/estadoprogramacliente_edit', $data);
    }

    public function update($id)
    {
        $estado = $this->estadoModel->find($id);
        if (!$estado) {
            return redirect()->to(base_url('estadoprogramacliente'))->with('error', 'Estado de programa no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[estadoprogramacliente.nombre,idestadoprogramacliente,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->estadoModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('estadoprogramacliente/actual/' . $id))->with('success', 'Estado de programa actualizado exitosamente.');
    }

    public function delete($id)
    {
        $estado = $this->estadoModel->find($id);
        if (!$estado) {
            return redirect()->to(base_url('estadoprogramacliente'))->with('error', 'Estado de programa no encontrado.');
        }

        try {
            $this->estadoModel->delete($id);
            return redirect()->to(base_url('estadoprogramacliente/elprimero'))->with('success', 'Estado de programa eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('estadoprogramacliente/actual/' . $id))->with('error', 'No se puede eliminar este estado porque existen programas de clientes asociados.');
        }
    }
}
