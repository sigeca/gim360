<?php

namespace App\Controllers;

use App\Models\TipoComidaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TipoComida extends BaseController
{
    protected TipoComidaModel $tipoComidaModel;

    public function __construct()
    {
        $this->tipoComidaModel = new TipoComidaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $tipo = $this->tipoComidaModel->find((int)$id);
        } else {
            $first = $this->tipoComidaModel->elprimero();
            $tipo  = $first ?: null;
        }

        $data = [
            'title'  => 'Ficha de Tipo de Comida' . ($tipo ? ': ' . $tipo['nombre'] : ''),
            'tipo'   => $tipo,
            'module' => 'tipocomida',
        ];

        return view('tipocomida/tipocomida_record', $data);
    }

    public function elprimero()
    {
        $first = $this->tipoComidaModel->elprimero();
        return $this->actual($first ? $first['idtipocomida'] : null);
    }

    public function elultimo()
    {
        $last = $this->tipoComidaModel->elultimo();
        return $this->actual($last ? $last['idtipocomida'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->tipoComidaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idtipocomida'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->tipoComidaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idtipocomida'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $tipos  = $this->tipoComidaModel->getTiposComida($search);

        $data = [
            'title'  => 'Catálogo de Tipos de Comida',
            'tipos'  => $tipos,
            'search' => $search,
            'module' => 'tipocomida',
        ];

        return view('tipocomida/tipocomida_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Tipo de Comida',
            'module' => 'tipocomida',
        ];

        return view('tipocomida/tipocomida_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[60]|is_unique[tipocomida.nombre]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del tipo de comida es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 60 caracteres.',
                'is_unique'  => 'Ya existe un tipo de comida registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->tipoComidaModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('tipocomida/actual/' . $id))->with('success', 'Tipo de comida registrado exitosamente.');
    }

    public function edit($id)
    {
        $tipo = $this->tipoComidaModel->find($id);
        if (!$tipo) {
            throw PageNotFoundException::forPageNotFound("Tipo de comida no encontrado.");
        }

        $data = [
            'title'  => 'Editar Tipo de Comida: ' . $tipo['nombre'],
            'tipo'   => $tipo,
            'module' => 'tipocomida',
        ];

        return view('tipocomida/tipocomida_edit', $data);
    }

    public function update($id)
    {
        $tipo = $this->tipoComidaModel->find($id);
        if (!$tipo) {
            return redirect()->to(base_url('tipocomida'))->with('error', 'Tipo de comida no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[60]|is_unique[tipocomida.nombre,idtipocomida,{$id}]",
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del tipo de comida es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 60 caracteres.',
                'is_unique'  => 'Ya existe un tipo de comida registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->tipoComidaModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('tipocomida/actual/' . $id))->with('success', 'Tipo de comida actualizado exitosamente.');
    }

    public function delete($id)
    {
        $tipo = $this->tipoComidaModel->find($id);
        if (!$tipo) {
            return redirect()->to(base_url('tipocomida'))->with('error', 'Tipo de comida no encontrado.');
        }

        try {
            $this->tipoComidaModel->delete($id);
            $first = $this->tipoComidaModel->elprimero();
            $targetUrl = $first ? 'tipocomida/actual/' . $first['idtipocomida'] : 'tipocomida';
            return redirect()->to(base_url($targetUrl))->with('success', 'Tipo de comida eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('tipocomida/actual/' . $id))->with('error', 'No se puede eliminar el tipo de comida: ' . $e->getMessage());
        }
    }
}
