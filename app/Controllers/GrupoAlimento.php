<?php

namespace App\Controllers;

use App\Models\GrupoAlimentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class GrupoAlimento extends BaseController
{
    protected GrupoAlimentoModel $grupoModel;

    public function __construct()
    {
        $this->grupoModel = new GrupoAlimentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $grupo = $this->grupoModel->find($id);
        } else {
            $first = $this->grupoModel->elprimero();
            $grupo = $first ?: null;
        }

        $alimentos = [];
        if ($grupo) {
            $alimentoModel = new \App\Models\AlimentoModel();
            $alimentos = $alimentoModel->where('idgrupo', $grupo['idgrupoalimento'])->orderBy('nombre', 'ASC')->findAll();
        }

        $data = [
            'title'     => 'Ficha de Grupo de Alimento' . ($grupo ? ': ' . $grupo['nombre'] : ''),
            'grupo'     => $grupo,
            'alimentos' => $alimentos,
            'module'    => 'grupoalimento',
        ];

        return view('grupoalimento/grupoalimento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->grupoModel->elprimero();
        return $this->actual($first ? $first['idgrupoalimento'] : null);
    }

    public function elultimo()
    {
        $last = $this->grupoModel->elultimo();
        return $this->actual($last ? $last['idgrupoalimento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->grupoModel->siguiente($id);
        return $this->actual($next ? $next['idgrupoalimento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->grupoModel->anterior($id);
        return $this->actual($prev ? $prev['idgrupoalimento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $grupos = $this->grupoModel->getGrupos($search);

        $data = [
            'title'  => 'Catálogo de Grupos de Alimentos',
            'grupos' => $grupos,
            'search' => $search,
            'module' => 'grupoalimento',
        ];

        return view('grupoalimento/grupoalimento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Grupo de Alimento',
            'module' => 'grupoalimento',
        ];

        return view('grupoalimento/grupoalimento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'      => 'required|min_length[2]|max_length[100]|is_unique[grupoalimento.nombre]',
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del grupo de alimento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 100 caracteres.',
                'is_unique'  => 'Ya existe un grupo registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->grupoModel->insert([
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('grupoalimento/actual/' . $id))->with('success', 'Grupo de alimento registrado exitosamente.');
    }

    public function edit($id)
    {
        $grupo = $this->grupoModel->find($id);
        if (!$grupo) {
            throw PageNotFoundException::forPageNotFound("Grupo de alimento no encontrado.");
        }

        $data = [
            'title'  => 'Editar Grupo de Alimento: ' . $grupo['nombre'],
            'grupo'  => $grupo,
            'module' => 'grupoalimento',
        ];

        return view('grupoalimento/grupoalimento_edit', $data);
    }

    public function update($id)
    {
        $grupo = $this->grupoModel->find($id);
        if (!$grupo) {
            return redirect()->to(base_url('grupoalimento'))->with('error', 'Grupo no encontrado.');
        }

        $rules = [
            'nombre'      => "required|min_length[2]|max_length[100]|is_unique[grupoalimento.nombre,idgrupoalimento,{$id}]",
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del grupo de alimento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 100 caracteres.',
                'is_unique'  => 'Ya existe otro grupo registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->grupoModel->update($id, [
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('grupoalimento/actual/' . $id))->with('success', 'Grupo de alimento actualizado exitosamente.');
    }

    public function delete($id)
    {
        $grupo = $this->grupoModel->find($id);
        if (!$grupo) {
            return redirect()->to(base_url('grupoalimento'))->with('error', 'Grupo no encontrado.');
        }

        try {
            $this->grupoModel->delete($id);
            $first = $this->grupoModel->elprimero();
            $targetUrl = $first ? 'grupoalimento/actual/' . $first['idgrupoalimento'] : 'grupoalimento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Grupo de alimento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('grupoalimento/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
