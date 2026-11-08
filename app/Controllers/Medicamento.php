<?php

namespace App\Controllers;

use App\Models\MedicamentoModel;
use App\Models\AfeccionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Medicamento extends BaseController
{
    protected MedicamentoModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new MedicamentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $medicamento = $this->model->getMedicamentoWithDetails((int)$id);
        } else {
            $first = $this->model->elprimero();
            $medicamento = $first ? $this->model->getMedicamentoWithDetails((int)$first['idmedicamento']) : null;
        }

        $data = [
            'title'       => 'Medicamento' . ($medicamento ? ': ' . $medicamento['nombre'] : ''),
            'medicamento' => $medicamento,
            'module'      => 'medicamento',
        ];

        return view('medicamento/medicamento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmedicamento'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmedicamento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmedicamento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmedicamento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $medicamentos = $this->model->getMedicamentosWithCounts($search);

        $data = [
            'title'        => 'Catálogo de Medicamentos',
            'medicamentos' => $medicamentos,
            'search'       => $search,
            'module'       => 'medicamento',
        ];

        return view('medicamento/medicamento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Nuevo Medicamento',
            'module' => 'medicamento',
        ];

        return view('medicamento/medicamento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'nombre'             => trim((string)$this->request->getPost('nombre')),
            'principioactivo'    => trim((string)$this->request->getPost('principioactivo')) ?: null,
            'concentracion'      => trim((string)$this->request->getPost('concentracion')) ?: null,
            'presentacion'       => trim((string)$this->request->getPost('presentacion')) ?: null,
            'laboratorio'        => trim((string)$this->request->getPost('laboratorio')) ?: null,
            'descripcion'        => trim((string)$this->request->getPost('descripcion')) ?: null,
            'indicaciones'       => trim((string)$this->request->getPost('indicaciones')) ?: null,
            'contraindicaciones' => trim((string)$this->request->getPost('contraindicaciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicamento/actual/' . $id))
                         ->with('success', 'Medicamento registrado exitosamente.');
    }

    public function edit($id)
    {
        $medicamento = $this->model->find($id);
        if (!$medicamento) {
            throw PageNotFoundException::forPageNotFound("Medicamento no encontrado.");
        }

        $data = [
            'title'       => 'Editar Medicamento #' . $id,
            'medicamento' => $medicamento,
            'module'      => 'medicamento',
        ];

        return view('medicamento/medicamento_edit', $data);
    }

    public function update($id)
    {
        $medicamento = $this->model->find($id);
        if (!$medicamento) {
            return redirect()->to(base_url('medicamento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[150]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nombre'             => trim((string)$this->request->getPost('nombre')),
            'principioactivo'    => trim((string)$this->request->getPost('principioactivo')) ?: null,
            'concentracion'      => trim((string)$this->request->getPost('concentracion')) ?: null,
            'presentacion'       => trim((string)$this->request->getPost('presentacion')) ?: null,
            'laboratorio'        => trim((string)$this->request->getPost('laboratorio')) ?: null,
            'descripcion'        => trim((string)$this->request->getPost('descripcion')) ?: null,
            'indicaciones'       => trim((string)$this->request->getPost('indicaciones')) ?: null,
            'contraindicaciones' => trim((string)$this->request->getPost('contraindicaciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicamento/actual/' . $id))
                         ->with('success', 'Medicamento actualizado correctamente.');
    }

    public function delete($id)
    {
        $medicamento = $this->model->find($id);
        if (!$medicamento) {
            return redirect()->to(base_url('medicamento'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->model->delete($id);
            $first = $this->model->elprimero();
            $targetUrl = $first ? 'medicamento/actual/' . $first['idmedicamento'] : 'medicamento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Medicamento eliminado exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('medicamento/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}
