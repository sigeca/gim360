<?php

namespace App\Controllers;

use App\Models\AlimentoComponenteNutricionalModel;
use App\Models\AlimentoModel;
use App\Models\ComponenteNutricionalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AlimentoComponenteNutricional extends BaseController
{
    protected AlimentoComponenteNutricionalModel $acnModel;
    protected AlimentoModel $alimentoModel;
    protected ComponenteNutricionalModel $componenteModel;

    public function __construct()
    {
        $this->acnModel        = new AlimentoComponenteNutricionalModel();
        $this->alimentoModel   = new AlimentoModel();
        $this->componenteModel = new ComponenteNutricionalModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->acnModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->acnModel->elprimero();
            $record = $first ? $this->acnModel->getRecordWithDetails((int)$first['idalimentocomponentenutricional']) : null;
        }

        $data = [
            'title'  => 'Relación Alimento - Componente Nutricional' . ($record ? ': #' . $record['idalimentocomponentenutricional'] : ''),
            'rel'    => $record,
            'module' => 'alimentocomponentenutricional',
        ];

        return view('alimentocomponentenutricional/alimentocomponentenutricional_record', $data);
    }

    public function elprimero()
    {
        $first = $this->acnModel->elprimero();
        return $this->actual($first ? $first['idalimentocomponentenutricional'] : null);
    }

    public function elultimo()
    {
        $last = $this->acnModel->elultimo();
        return $this->actual($last ? $last['idalimentocomponentenutricional'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->acnModel->siguiente((int)$id);
        return $this->actual($next ? $next['idalimentocomponentenutricional'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->acnModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idalimentocomponentenutricional'] : $id);
    }

    public function listar()
    {
        $search       = $this->request->getGet('q');
        $idalimento   = $this->request->getGet('idalimento');
        $idcomponente = $this->request->getGet('idcomponente');

        $idalimento   = (!empty($idalimento) && is_numeric($idalimento)) ? (int)$idalimento : null;
        $idcomponente = (!empty($idcomponente) && is_numeric($idcomponente)) ? (int)$idcomponente : null;

        $listado     = $this->acnModel->getRecordsWithDetails($search, $idalimento, $idcomponente);
        $alimentos   = $this->alimentoModel->orderBy('nombre', 'ASC')->findAll();
        $componentes = $this->componenteModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'               => 'Componentes por Alimento',
            'listado'             => $listado,
            'alimentos'           => $alimentos,
            'componentes'         => $componentes,
            'selectedAlimento'    => $idalimento,
            'selectedComponente'  => $idcomponente,
            'search'              => $search,
            'module'              => 'alimentocomponentenutricional',
        ];

        return view('alimentocomponentenutricional/alimentocomponentenutricional_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                  => 'Asignar Componente a Alimento',
            'alimentos'              => $this->alimentoModel->orderBy('nombre', 'ASC')->findAll(),
            'componentes'            => $this->componenteModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedAlimento'    => $this->request->getGet('idalimento'),
            'preselectedComponente' => $this->request->getGet('idcomponente'),
            'module'                 => 'alimentocomponentenutricional',
        ];

        return view('alimentocomponentenutricional/alimentocomponentenutricional_form', $data);
    }

    public function save()
    {
        $rules = [
            'idalimento'              => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        $messages = [
            'idalimento' => [
                'required'           => 'Debe seleccionar un alimento.',
                'is_natural_no_zero' => 'Seleccione un alimento válido.',
                'is_not_unique'      => 'El alimento no existe.',
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

        $idalimento   = (int)$this->request->getPost('idalimento');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar unicidad de la relación
        $exists = $this->acnModel->where('idalimento', $idalimento)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este alimento ya tiene asignado este componente nutricional.');
        }

        $id = $this->acnModel->insert([
            'idalimento'              => $idalimento,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('alimentocomponentenutricional/actual/' . $id))
                         ->with('success', 'Componente asignado al alimento exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->acnModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'       => 'Editar Asignación de Componente Nutricional #' . $id,
            'rel'         => $rel,
            'alimentos'   => $this->alimentoModel->orderBy('nombre', 'ASC')->findAll(),
            'componentes' => $this->componenteModel->orderBy('nombre', 'ASC')->findAll(),
            'module'      => 'alimentocomponentenutricional',
        ];

        return view('alimentocomponentenutricional/alimentocomponentenutricional_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->acnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('alimentocomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idalimento'              => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idalimento   = (int)$this->request->getPost('idalimento');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar que no se duplique con otra relación
        $exists = $this->acnModel->where('idalimento', $idalimento)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->where('idalimentocomponentenutricional !=', $id)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese mismo alimento y componente.');
        }

        $this->acnModel->update($id, [
            'idalimento'              => $idalimento,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('alimentocomponentenutricional/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->acnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('alimentocomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->acnModel->delete($id);
            $first = $this->acnModel->elprimero();
            $targetUrl = $first ? 'alimentocomponentenutricional/actual/' . $first['idalimentocomponentenutricional'] : 'alimentocomponentenutricional';
            return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('alimentocomponentenutricional/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
