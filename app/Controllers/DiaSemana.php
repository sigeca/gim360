<?php

namespace App\Controllers;

use App\Models\DiaSemanaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DiaSemana extends BaseController
{
    protected DiaSemanaModel $diaModel;

    public function __construct()
    {
        $this->diaModel = new DiaSemanaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $dia = $this->diaModel->find((int)$id);
        } else {
            $first = $this->diaModel->elprimero();
            $dia   = $first ?: null;
        }

        $data = [
            'title'  => 'Ficha de Día de la Semana' . ($dia ? ': ' . $dia['nombre'] : ''),
            'dia'    => $dia,
            'module' => 'diasemana',
        ];

        return view('diasemana/diasemana_record', $data);
    }

    public function elprimero()
    {
        $first = $this->diaModel->elprimero();
        return $this->actual($first ? $first['iddiasemana'] : null);
    }

    public function elultimo()
    {
        $last = $this->diaModel->elultimo();
        return $this->actual($last ? $last['iddiasemana'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->diaModel->siguiente((int)$id);
        return $this->actual($next ? $next['iddiasemana'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->diaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['iddiasemana'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $dias   = $this->diaModel->getDiasSemana($search);

        $data = [
            'title'  => 'Catálogo de Días de la Semana',
            'dias'   => $dias,
            'search' => $search,
            'module' => 'diasemana',
        ];

        return view('diasemana/diasemana_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Día de la Semana',
            'module' => 'diasemana',
        ];

        return view('diasemana/diasemana_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[4]|max_length[30]|is_unique[diasemana.nombre]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del día es obligatorio.',
                'min_length' => 'Debe tener al menos 4 caracteres.',
                'max_length' => 'No puede superar los 30 caracteres.',
                'is_unique'  => 'Ya existe un día registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->diaModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('diasemana/actual/' . $id))->with('success', 'Día de la semana registrado exitosamente.');
    }

    public function edit($id)
    {
        $dia = $this->diaModel->find($id);
        if (!$dia) {
            throw PageNotFoundException::forPageNotFound("Día de la semana no encontrado.");
        }

        $data = [
            'title'  => 'Editar Día de la Semana: ' . $dia['nombre'],
            'dia'    => $dia,
            'module' => 'diasemana',
        ];

        return view('diasemana/diasemana_edit', $data);
    }

    public function update($id)
    {
        $dia = $this->diaModel->find($id);
        if (!$dia) {
            return redirect()->to(base_url('diasemana'))->with('error', 'Día no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[4]|max_length[30]|is_unique[diasemana.nombre,iddiasemana,{$id}]",
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del día es obligatorio.',
                'min_length' => 'Debe tener al menos 4 caracteres.',
                'max_length' => 'No puede superar los 30 caracteres.',
                'is_unique'  => 'Ya existe un día registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->diaModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('diasemana/actual/' . $id))->with('success', 'Día de la semana actualizado exitosamente.');
    }

    public function delete($id)
    {
        $dia = $this->diaModel->find($id);
        if (!$dia) {
            return redirect()->to(base_url('diasemana'))->with('error', 'Día no encontrado.');
        }

        try {
            $this->diaModel->delete($id);
            $first = $this->diaModel->elprimero();
            $targetUrl = $first ? 'diasemana/actual/' . $first['iddiasemana'] : 'diasemana';
            return redirect()->to(base_url($targetUrl))->with('success', 'Día de la semana eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('diasemana/actual/' . $id))->with('error', 'No se puede eliminar el día: ' . $e->getMessage());
        }
    }
}
