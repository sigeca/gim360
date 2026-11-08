<?php

namespace App\Controllers;

use App\Models\AfeccionModel;
use App\Models\MedicacionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Afeccion extends BaseController
{
    protected AfeccionModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new AfeccionModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $afeccion = $this->model->getAfeccionWithDetails((int)$id);
        } else {
            $first = $this->model->elprimero();
            $afeccion = $first ? $this->model->getAfeccionWithDetails((int)$first['idafeccion']) : null;
        }

        $data = [
            'title'    => 'Afección Médica' . ($afeccion ? ': ' . $afeccion['nombre'] : ''),
            'afeccion' => $afeccion,
            'module'   => 'afeccion',
        ];

        return view('afeccion/afeccion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idafeccion'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idafeccion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idafeccion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idafeccion'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $afecciones = $this->model->getAfeccionesWithCounts($search);

        $data = [
            'title'      => 'Catálogo de Afecciones Médicas',
            'afecciones' => $afecciones,
            'search'     => $search,
            'module'     => 'afeccion',
        ];

        return view('afeccion/afeccion_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Nueva Afección',
            'module' => 'afeccion',
        ];

        return view('afeccion/afeccion_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]|is_unique[afeccion.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
            'sintomas'    => trim((string)$this->request->getPost('sintomas')) ?: null,
        ]);

        return redirect()->to(base_url('afeccion/actual/' . $id))
                         ->with('success', 'Afección registrada exitosamente.');
    }

    public function edit($id)
    {
        $afeccion = $this->model->find($id);
        if (!$afeccion) {
            throw PageNotFoundException::forPageNotFound("Afección no encontrada.");
        }

        $data = [
            'title'    => 'Editar Afección #' . $id,
            'afeccion' => $afeccion,
            'module'   => 'afeccion',
        ];

        return view('afeccion/afeccion_edit', $data);
    }

    public function update($id)
    {
        $afeccion = $this->model->find($id);
        if (!$afeccion) {
            return redirect()->to(base_url('afeccion'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[150]|is_unique[afeccion.nombre,idafeccion,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
            'sintomas'    => trim((string)$this->request->getPost('sintomas')) ?: null,
        ]);

        return redirect()->to(base_url('afeccion/actual/' . $id))
                         ->with('success', 'Afección actualizada correctamente.');
    }

    public function delete($id)
    {
        $afeccion = $this->model->find($id);
        if (!$afeccion) {
            return redirect()->to(base_url('afeccion'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->model->delete($id);
            $first = $this->model->elprimero();
            $targetUrl = $first ? 'afeccion/actual/' . $first['idafeccion'] : 'afeccion';
            return redirect()->to(base_url($targetUrl))->with('success', 'Afección eliminada exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('afeccion/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}
