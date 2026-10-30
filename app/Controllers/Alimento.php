<?php

namespace App\Controllers;

use App\Models\AlimentoModel;
use App\Models\GrupoAlimentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Alimento extends BaseController
{
    protected AlimentoModel $alimentoModel;
    protected GrupoAlimentoModel $grupoModel;

    public function __construct()
    {
        $this->alimentoModel = new AlimentoModel();
        $this->grupoModel    = new GrupoAlimentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $alimento = $this->alimentoModel->getAlimentoWithDetails((int)$id);
        } else {
            $first = $this->alimentoModel->elprimero();
            $alimento = $first ? $this->alimentoModel->getAlimentoWithDetails((int)$first['idalimento']) : null;
        }

        $componentes = [];
        if ($alimento) {
            $acnModel = new \App\Models\AlimentoComponenteNutricionalModel();
            $componentes = $acnModel->getComponentesByAlimento((int)$alimento['idalimento']);
        }

        $data = [
            'title'       => 'Ficha de Alimento' . ($alimento ? ': ' . $alimento['nombre'] : ''),
            'alimento'    => $alimento,
            'componentes' => $componentes,
            'module'      => 'alimento',
        ];

        return view('alimento/alimento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->alimentoModel->elprimero();
        return $this->actual($first ? $first['idalimento'] : null);
    }

    public function elultimo()
    {
        $last = $this->alimentoModel->elultimo();
        return $this->actual($last ? $last['idalimento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->alimentoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idalimento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->alimentoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idalimento'] : $id);
    }

    public function listar()
    {
        $search  = $this->request->getGet('q');
        $idgrupo = $this->request->getGet('idgrupo');
        $idgrupo = (!empty($idgrupo) && is_numeric($idgrupo)) ? (int)$idgrupo : null;

        $alimentos = $this->alimentoModel->getAlimentos($search, $idgrupo);
        $grupos    = $this->grupoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'         => 'Catálogo de Alimentos',
            'alimentos'     => $alimentos,
            'grupos'        => $grupos,
            'search'        => $search,
            'selectedGrupo' => $idgrupo,
            'module'        => 'alimento',
        ];

        return view('alimento/alimento_list', $data);
    }

    public function add()
    {
        $grupos  = $this->grupoModel->orderBy('nombre', 'ASC')->findAll();
        $idgrupo = $this->request->getGet('idgrupo');

        $data = [
            'title'              => 'Registrar Alimento',
            'grupos'             => $grupos,
            'preselectedIdgrupo' => $idgrupo,
            'module'             => 'alimento',
        ];

        return view('alimento/alimento_form', $data);
    }

    public function save()
    {
        $rules = [
            'idgrupo'     => 'required|is_natural_no_zero|is_not_unique[grupoalimento.idgrupoalimento]',
            'nombre'      => 'required|min_length[2]|max_length[150]',
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'idgrupo' => [
                'required'           => 'Debe seleccionar un grupo de alimento.',
                'is_natural_no_zero' => 'Seleccione un grupo de alimento válido.',
                'is_not_unique'      => 'El grupo de alimento seleccionado no existe en el sistema.',
            ],
            'nombre' => [
                'required'   => 'El nombre del alimento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 150 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->alimentoModel->insert([
            'idgrupo'     => (int)$this->request->getPost('idgrupo'),
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('alimento/actual/' . $id))->with('success', 'Alimento registrado exitosamente.');
    }

    public function edit($id)
    {
        $alimento = $this->alimentoModel->find($id);
        if (!$alimento) {
            throw PageNotFoundException::forPageNotFound("Alimento no encontrado.");
        }

        $grupos = $this->grupoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'    => 'Editar Alimento: ' . $alimento['nombre'],
            'alimento' => $alimento,
            'grupos'   => $grupos,
            'module'   => 'alimento',
        ];

        return view('alimento/alimento_edit', $data);
    }

    public function update($id)
    {
        $alimento = $this->alimentoModel->find($id);
        if (!$alimento) {
            return redirect()->to(base_url('alimento'))->with('error', 'Alimento no encontrado.');
        }

        $rules = [
            'idgrupo'     => 'required|is_natural_no_zero|is_not_unique[grupoalimento.idgrupoalimento]',
            'nombre'      => 'required|min_length[2]|max_length[150]',
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'idgrupo' => [
                'required'           => 'Debe seleccionar un grupo de alimento.',
                'is_natural_no_zero' => 'Seleccione un grupo de alimento válido.',
                'is_not_unique'      => 'El grupo de alimento seleccionado no existe en el sistema.',
            ],
            'nombre' => [
                'required'   => 'El nombre del alimento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 150 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->alimentoModel->update($id, [
            'idgrupo'     => (int)$this->request->getPost('idgrupo'),
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('alimento/actual/' . $id))->with('success', 'Alimento actualizado exitosamente.');
    }

    public function delete($id)
    {
        $alimento = $this->alimentoModel->find($id);
        if (!$alimento) {
            return redirect()->to(base_url('alimento'))->with('error', 'Alimento no encontrado.');
        }

        try {
            $this->alimentoModel->delete($id);
            $first = $this->alimentoModel->elprimero();
            $targetUrl = $first ? 'alimento/actual/' . $first['idalimento'] : 'alimento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Alimento eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('alimento/actual/' . $id))->with('error', 'No se puede eliminar el alimento: ' . $e->getMessage());
        }
    }
}
