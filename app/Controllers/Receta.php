<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Receta extends BaseController
{
    protected RecetaModel $recetaModel;

    public function __construct()
    {
        $this->recetaModel = new RecetaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $receta = $this->recetaModel->getRecetaWithDetails((int)$id);
        } else {
            $first = $this->recetaModel->elprimero();
            $receta = $first ? $this->recetaModel->getRecetaWithDetails((int)$first['idreceta']) : null;
        }

        $ingredientes = [];
        $componentes  = [];
        if ($receta) {
            $arModel  = new \App\Models\AlimentoRecetaModel();
            $rcnModel = new \App\Models\RecetaComponenteNutricionalModel();
            $ingredientes = $arModel->getIngredientesByReceta((int)$receta['idreceta']);
            $componentes  = $rcnModel->getComponentesByReceta((int)$receta['idreceta']);
        }

        $data = [
            'title'        => 'Ficha de Receta' . ($receta ? ': ' . $receta['nombre'] : ''),
            'receta'       => $receta,
            'ingredientes' => $ingredientes,
            'componentes'  => $componentes,
            'module'       => 'receta',
        ];

        return view('receta/receta_record', $data);
    }

    public function elprimero()
    {
        $first = $this->recetaModel->elprimero();
        return $this->actual($first ? $first['idreceta'] : null);
    }

    public function elultimo()
    {
        $last = $this->recetaModel->elultimo();
        return $this->actual($last ? $last['idreceta'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->recetaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idreceta'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->recetaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idreceta'] : $id);
    }

    public function listar()
    {
        $search  = $this->request->getGet('q');
        $recetas = $this->recetaModel->getRecetas($search);

        $data = [
            'title'   => 'Catálogo de Recetas Saludables',
            'recetas' => $recetas,
            'search'  => $search,
            'module'  => 'receta',
        ];

        return view('receta/receta_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Nueva Receta',
            'module' => 'receta',
        ];

        return view('receta/receta_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'            => 'required|min_length[3]|max_length[150]',
            'instrucciones'     => 'permit_empty',
            'porciones'         => 'permit_empty|is_natural_no_zero|less_than[100]',
            'tiempopreparacion' => 'permit_empty|is_natural|less_than[1440]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la receta es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'porciones' => [
                'is_natural_no_zero' => 'Las porciones deben ser un número entero mayor a 0.',
                'less_than'          => 'Las porciones deben ser menores a 100.',
            ],
            'tiempopreparacion' => [
                'is_natural' => 'El tiempo de preparación debe ser un número entero en minutos (0 o más).',
                'less_than'  => 'El tiempo no puede superar los 1440 minutos.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $porciones = $this->request->getPost('porciones');
        $tiempo    = $this->request->getPost('tiempopreparacion');

        $id = $this->recetaModel->insert([
            'nombre'            => trim($this->request->getPost('nombre')),
            'instrucciones'     => trim($this->request->getPost('instrucciones')) ?: null,
            'porciones'         => (!empty($porciones) && is_numeric($porciones)) ? (int)$porciones : 1,
            'tiempopreparacion' => ($tiempo !== '' && $tiempo !== null && is_numeric($tiempo)) ? (int)$tiempo : null,
        ]);

        return redirect()->to(base_url('receta/actual/' . $id))->with('success', 'Receta registrada exitosamente.');
    }

    public function edit($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            throw PageNotFoundException::forPageNotFound("Receta no encontrada.");
        }

        $data = [
            'title'  => 'Editar Receta: ' . $receta['nombre'],
            'receta' => $receta,
            'module' => 'receta',
        ];

        return view('receta/receta_edit', $data);
    }

    public function update($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            return redirect()->to(base_url('receta'))->with('error', 'Receta no encontrada.');
        }

        $rules = [
            'nombre'            => 'required|min_length[3]|max_length[150]',
            'instrucciones'     => 'permit_empty',
            'porciones'         => 'permit_empty|is_natural_no_zero|less_than[100]',
            'tiempopreparacion' => 'permit_empty|is_natural|less_than[1440]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la receta es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'porciones' => [
                'is_natural_no_zero' => 'Las porciones deben ser un número entero mayor a 0.',
                'less_than'          => 'Las porciones deben ser menores a 100.',
            ],
            'tiempopreparacion' => [
                'is_natural' => 'El tiempo de preparación debe ser un número entero en minutos (0 o más).',
                'less_than'  => 'El tiempo no puede superar los 1440 minutos.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $porciones = $this->request->getPost('porciones');
        $tiempo    = $this->request->getPost('tiempopreparacion');

        $this->recetaModel->update($id, [
            'nombre'            => trim($this->request->getPost('nombre')),
            'instrucciones'     => trim($this->request->getPost('instrucciones')) ?: null,
            'porciones'         => (!empty($porciones) && is_numeric($porciones)) ? (int)$porciones : 1,
            'tiempopreparacion' => ($tiempo !== '' && $tiempo !== null && is_numeric($tiempo)) ? (int)$tiempo : null,
        ]);

        return redirect()->to(base_url('receta/actual/' . $id))->with('success', 'Receta actualizada exitosamente.');
    }

    public function delete($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            return redirect()->to(base_url('receta'))->with('error', 'Receta no encontrada.');
        }

        try {
            $this->recetaModel->delete($id);
            $first = $this->recetaModel->elprimero();
            $targetUrl = $first ? 'receta/actual/' . $first['idreceta'] : 'receta';
            return redirect()->to(base_url($targetUrl))->with('success', 'Receta eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('receta/actual/' . $id))->with('error', 'No se puede eliminar la receta: ' . $e->getMessage());
        }
    }
}
