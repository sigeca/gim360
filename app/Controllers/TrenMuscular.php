<?php

namespace App\Controllers;

use App\Models\TrenMuscularModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class TrenMuscular extends BaseController
{
    protected TrenMuscularModel $trenModel;

    public function __construct()
    {
        $this->trenModel = new TrenMuscularModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $tren = $this->trenModel->getTrenWithCounts((int)$id);
        } else {
            $first = $this->trenModel->elprimero();
            $tren = $first ? $this->trenModel->getTrenWithCounts((int)$first['idtrenmuscular']) : null;
        }

        $musculos = [];
        $ejercicios = [];
        $programas = [];

        if ($tren) {
            $idTren = (int)$tren['idtrenmuscular'];
            $musculos = $this->trenModel->getMusculosByTren($idTren);
            $ejercicios = $this->trenModel->getEjerciciosByTren($idTren);
            $programas = $this->trenModel->getProgramasByTren($idTren);
        }

        $data = [
            'title'      => 'Ficha de Tren Muscular' . ($tren ? ': ' . $tren['nombre'] : ''),
            'tren'       => $tren,
            'musculos'   => $musculos,
            'ejercicios' => $ejercicios,
            'programas'  => $programas,
            'module'     => 'trenmuscular',
        ];

        return view('trenmuscular/trenmuscular_record', $data);
    }

    public function elprimero()
    {
        $first = $this->trenModel->elprimero();
        return $this->actual($first ? $first['idtrenmuscular'] : null);
    }

    public function elultimo()
    {
        $last = $this->trenModel->elultimo();
        return $this->actual($last ? $last['idtrenmuscular'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->trenModel->siguiente($id);
        return $this->actual($next ? $next['idtrenmuscular'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->trenModel->anterior($id);
        return $this->actual($prev ? $prev['idtrenmuscular'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $trenes = $this->trenModel->getTrenes($search);

        $data = [
            'title'  => 'Catálogo de Trenes Musculares',
            'trenes' => $trenes,
            'search' => $search,
            'module' => 'trenmuscular',
        ];

        return view('trenmuscular/trenmuscular_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Nuevo Tren Muscular',
            'module' => 'trenmuscular',
        ];

        return view('trenmuscular/trenmuscular_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[trenmuscular.nombre]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del tren muscular es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 50 caracteres.',
                'is_unique'  => 'Ya existe un tren muscular registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->trenModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('trenmuscular/actual/' . $id))->with('success', 'Tren muscular registrado exitosamente.');
    }

    public function edit($id)
    {
        $tren = $this->trenModel->find($id);
        if (!$tren) {
            throw PageNotFoundException::forPageNotFound("Tren muscular no encontrado.");
        }

        $data = [
            'title'  => 'Editar Tren Muscular: ' . $tren['nombre'],
            'tren'   => $tren,
            'module' => 'trenmuscular',
        ];

        return view('trenmuscular/trenmuscular_edit', $data);
    }

    public function update($id)
    {
        $tren = $this->trenModel->find($id);
        if (!$tren) {
            return redirect()->to(base_url('trenmuscular'))->with('error', 'Tren muscular no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[trenmuscular.nombre,idtrenmuscular,{$id}]",
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del tren muscular es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 50 caracteres.',
                'is_unique'  => 'Ya existe otro tren muscular registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->trenModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('trenmuscular/actual/' . $id))->with('success', 'Tren muscular actualizado exitosamente.');
    }

    public function delete($id)
    {
        $tren = $this->trenModel->find($id);
        if (!$tren) {
            return redirect()->to(base_url('trenmuscular'))->with('error', 'Tren muscular no encontrado.');
        }

        try {
            $this->trenModel->delete($id);
            $first = $this->trenModel->elprimero();
            $targetUrl = $first ? 'trenmuscular/actual/' . $first['idtrenmuscular'] : 'trenmuscular';
            return redirect()->to(base_url($targetUrl))->with('success', 'Tren muscular eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('trenmuscular/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
