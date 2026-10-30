<?php

namespace App\Controllers;

use App\Models\RecetaComponenteNutricionalModel;
use App\Models\RecetaModel;
use App\Models\ComponenteNutricionalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RecetaComponenteNutricional extends BaseController
{
    protected RecetaComponenteNutricionalModel $rcnModel;
    protected RecetaModel $recetaModel;
    protected ComponenteNutricionalModel $componenteModel;

    public function __construct()
    {
        $this->rcnModel        = new RecetaComponenteNutricionalModel();
        $this->recetaModel     = new RecetaModel();
        $this->componenteModel = new ComponenteNutricionalModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->rcnModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->rcnModel->elprimero();
            $record = $first ? $this->rcnModel->getRecordWithDetails((int)$first['idrecetacomponentenutricional']) : null;
        }

        $data = [
            'title'  => 'Relación Receta - Componente Nutricional' . ($record ? ': #' . $record['idrecetacomponentenutricional'] : ''),
            'rel'    => $record,
            'module' => 'recetacomponentenutricional',
        ];

        return view('recetacomponentenutricional/recetacomponentenutricional_record', $data);
    }

    public function elprimero()
    {
        $first = $this->rcnModel->elprimero();
        return $this->actual($first ? $first['idrecetacomponentenutricional'] : null);
    }

    public function elultimo()
    {
        $last = $this->rcnModel->elultimo();
        return $this->actual($last ? $last['idrecetacomponentenutricional'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->rcnModel->siguiente((int)$id);
        return $this->actual($next ? $next['idrecetacomponentenutricional'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->rcnModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idrecetacomponentenutricional'] : $id);
    }

    public function listar()
    {
        $search       = $this->request->getGet('q');
        $idreceta     = $this->request->getGet('idreceta');
        $idcomponente = $this->request->getGet('idcomponente');

        $idreceta     = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;
        $idcomponente = (!empty($idcomponente) && is_numeric($idcomponente)) ? (int)$idcomponente : null;

        $listado     = $this->rcnModel->getRecordsWithDetails($search, $idreceta, $idcomponente);
        $recetas     = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();
        $componentes = $this->componenteModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'              => 'Componentes por Receta',
            'listado'            => $listado,
            'recetas'            => $recetas,
            'componentes'        => $componentes,
            'selectedReceta'     => $idreceta,
            'selectedComponente' => $idcomponente,
            'search'             => $search,
            'module'             => 'recetacomponentenutricional',
        ];

        return view('recetacomponentenutricional/recetacomponentenutricional_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                  => 'Asignar Componente a Receta',
            'recetas'                => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'componentes'            => $this->componenteModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedReceta'      => $this->request->getGet('idreceta'),
            'preselectedComponente' => $this->request->getGet('idcomponente'),
            'module'                 => 'recetacomponentenutricional',
        ];

        return view('recetacomponentenutricional/recetacomponentenutricional_form', $data);
    }

    public function save()
    {
        $rules = [
            'idreceta'                => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        $messages = [
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'Seleccione una receta válida.',
                'is_not_unique'      => 'La receta seleccionada no existe.',
            ],
            'idcomponentenutricional' => [
                'required'           => 'Debe seleccionar un componente nutricional.',
                'is_natural_no_zero' => 'Seleccione un componente válido.',
                'is_not_unique'      => 'El componente nutricional no existe.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idreceta     = (int)$this->request->getPost('idreceta');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar unicidad de la relación
        $exists = $this->rcnModel->where('idreceta', $idreceta)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta receta ya tiene asignado este componente nutricional.');
        }

        $id = $this->rcnModel->insert([
            'idreceta'                => $idreceta,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('recetacomponentenutricional/actual/' . $id))
                         ->with('success', 'Componente asignado a la receta exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->rcnModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'       => 'Editar Asignación en Receta #' . $id,
            'rel'         => $rel,
            'recetas'     => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'componentes' => $this->componenteModel->orderBy('nombre', 'ASC')->findAll(),
            'module'      => 'recetacomponentenutricional',
        ];

        return view('recetacomponentenutricional/recetacomponentenutricional_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->rcnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('recetacomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idreceta'                => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idreceta     = (int)$this->request->getPost('idreceta');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar que no se duplique
        $exists = $this->rcnModel->where('idreceta', $idreceta)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->where('idrecetacomponentenutricional !=', $id)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con esa misma receta y componente.');
        }

        $this->rcnModel->update($id, [
            'idreceta'                => $idreceta,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('recetacomponentenutricional/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->rcnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('recetacomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->rcnModel->delete($id);
            $first = $this->rcnModel->elprimero();
            $targetUrl = $first ? 'recetacomponentenutricional/actual/' . $first['idrecetacomponentenutricional'] : 'recetacomponentenutricional';
            return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('recetacomponentenutricional/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
