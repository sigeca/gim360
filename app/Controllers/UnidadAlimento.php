<?php

namespace App\Controllers;

use App\Models\UnidadAlimentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class UnidadAlimento extends BaseController
{
    protected UnidadAlimentoModel $unidadModel;

    public function __construct()
    {
        $this->unidadModel = new UnidadAlimentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $unidad = $this->unidadModel->find((int)$id);
        } else {
            $first  = $this->unidadModel->elprimero();
            $unidad = $first ?: null;
        }

        $data = [
            'title'  => 'Ficha de Unidad de Alimento' . ($unidad ? ': ' . $unidad['nombre'] : ''),
            'unidad' => $unidad,
            'module' => 'unidadalimento',
        ];

        return view('unidadalimento/unidadalimento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->unidadModel->elprimero();
        return $this->actual($first ? $first['idunidadalimento'] : null);
    }

    public function elultimo()
    {
        $last = $this->unidadModel->elultimo();
        return $this->actual($last ? $last['idunidadalimento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->unidadModel->siguiente((int)$id);
        return $this->actual($next ? $next['idunidadalimento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->unidadModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idunidadalimento'] : $id);
    }

    public function listar()
    {
        $search   = $this->request->getGet('q');
        $unidades = $this->unidadModel->getUnidades($search);

        $data = [
            'title'    => 'Catálogo de Unidades de Medida',
            'unidades' => $unidades,
            'search'   => $search,
            'module'   => 'unidadalimento',
        ];

        return view('unidadalimento/unidadalimento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Unidad de Medida',
            'module' => 'unidadalimento',
        ];

        return view('unidadalimento/unidadalimento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'      => 'required|min_length[2]|max_length[50]|is_unique[unidadalimento.nombre]',
            'abreviatura' => 'required|min_length[1]|max_length[15]|is_unique[unidadalimento.abreviatura]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la unidad es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 50 caracteres.',
                'is_unique'  => 'Ya existe una unidad registrada con este nombre.',
            ],
            'abreviatura' => [
                'required'   => 'La abreviatura es obligatoria.',
                'min_length' => 'Debe tener al menos 1 caracter.',
                'max_length' => 'No puede superar los 15 caracteres.',
                'is_unique'  => 'Ya existe una unidad con esta abreviatura.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->unidadModel->insert([
            'nombre'      => trim($this->request->getPost('nombre')),
            'abreviatura' => trim($this->request->getPost('abreviatura')),
        ]);

        return redirect()->to(base_url('unidadalimento/actual/' . $id))->with('success', 'Unidad de medida registrada exitosamente.');
    }

    public function edit($id)
    {
        $unidad = $this->unidadModel->find($id);
        if (!$unidad) {
            throw PageNotFoundException::forPageNotFound("Unidad de alimento no encontrada.");
        }

        $data = [
            'title'  => 'Editar Unidad: ' . $unidad['nombre'],
            'unidad' => $unidad,
            'module' => 'unidadalimento',
        ];

        return view('unidadalimento/unidadalimento_edit', $data);
    }

    public function update($id)
    {
        $unidad = $this->unidadModel->find($id);
        if (!$unidad) {
            return redirect()->to(base_url('unidadalimento'))->with('error', 'Unidad no encontrada.');
        }

        $rules = [
            'nombre'      => "required|min_length[2]|max_length[50]|is_unique[unidadalimento.nombre,idunidadalimento,{$id}]",
            'abreviatura' => "required|min_length[1]|max_length[15]|is_unique[unidadalimento.abreviatura,idunidadalimento,{$id}]",
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la unidad es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 50 caracteres.',
                'is_unique'  => 'Ya existe una unidad registrada con este nombre.',
            ],
            'abreviatura' => [
                'required'   => 'La abreviatura es obligatoria.',
                'min_length' => 'Debe tener al menos 1 caracter.',
                'max_length' => 'No puede superar los 15 caracteres.',
                'is_unique'  => 'Ya existe una unidad con esta abreviatura.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->unidadModel->update($id, [
            'nombre'      => trim($this->request->getPost('nombre')),
            'abreviatura' => trim($this->request->getPost('abreviatura')),
        ]);

        return redirect()->to(base_url('unidadalimento/actual/' . $id))->with('success', 'Unidad de medida actualizada exitosamente.');
    }

    public function delete($id)
    {
        $unidad = $this->unidadModel->find($id);
        if (!$unidad) {
            return redirect()->to(base_url('unidadalimento'))->with('error', 'Unidad no encontrada.');
        }

        try {
            $this->unidadModel->delete($id);
            $first = $this->unidadModel->elprimero();
            $targetUrl = $first ? 'unidadalimento/actual/' . $first['idunidadalimento'] : 'unidadalimento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Unidad de medida eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('unidadalimento/actual/' . $id))->with('error', 'No se puede eliminar la unidad: ' . $e->getMessage());
        }
    }
}
