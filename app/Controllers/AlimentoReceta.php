<?php

namespace App\Controllers;

use App\Models\AlimentoRecetaModel;
use App\Models\RecetaModel;
use App\Models\AlimentoModel;
use App\Models\UnidadAlimentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class AlimentoReceta extends BaseController
{
    protected AlimentoRecetaModel $arModel;
    protected RecetaModel $recetaModel;
    protected AlimentoModel $alimentoModel;
    protected UnidadAlimentoModel $unidadModel;

    public function __construct()
    {
        $this->arModel       = new AlimentoRecetaModel();
        $this->recetaModel   = new RecetaModel();
        $this->alimentoModel = new AlimentoModel();
        $this->unidadModel   = new UnidadAlimentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->arModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->arModel->elprimero();
            $record = $first ? $this->arModel->getRecordWithDetails((int)$first['idalimentoreceta']) : null;
        }

        $data = [
            'title'  => 'Ingrediente de Receta' . ($record ? ': #' . $record['idalimentoreceta'] : ''),
            'rel'    => $record,
            'module' => 'alimentoreceta',
        ];

        return view('alimentoreceta/alimentoreceta_record', $data);
    }

    public function elprimero()
    {
        $first = $this->arModel->elprimero();
        return $this->actual($first ? $first['idalimentoreceta'] : null);
    }

    public function elultimo()
    {
        $last = $this->arModel->elultimo();
        return $this->actual($last ? $last['idalimentoreceta'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->arModel->siguiente((int)$id);
        return $this->actual($next ? $next['idalimentoreceta'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->arModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idalimentoreceta'] : $id);
    }

    public function listar()
    {
        $search     = $this->request->getGet('q');
        $idreceta   = $this->request->getGet('idreceta');
        $idalimento = $this->request->getGet('idalimento');

        $idreceta   = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;
        $idalimento = (!empty($idalimento) && is_numeric($idalimento)) ? (int)$idalimento : null;

        $registros  = $this->arModel->getRecordsWithDetails($search, $idreceta, $idalimento);
        $recetas    = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();
        $alimentos  = $this->alimentoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'              => 'Ingredientes en Recetas (Alimento - Receta)',
            'registros'          => $registros,
            'recetas'            => $recetas,
            'alimentos'          => $alimentos,
            'search'             => $search,
            'selectedReceta'     => $idreceta,
            'selectedAlimento'   => $idalimento,
            'module'             => 'alimentoreceta',
        ];

        return view('alimentoreceta/alimentoreceta_list', $data);
    }

    public function add()
    {
        $idrecetaPre   = $this->request->getGet('idreceta');
        $idalimentoPre = $this->request->getGet('idalimento');

        $data = [
            'title'              => 'Asignar Ingrediente a Receta',
            'recetas'            => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'alimentos'          => $this->alimentoModel->orderBy('nombre', 'ASC')->findAll(),
            'unidades'           => $this->unidadModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedReceta'   => $idrecetaPre,
            'preselectedAlimento' => $idalimentoPre,
            'module'             => 'alimentoreceta',
        ];

        return view('alimentoreceta/alimentoreceta_form', $data);
    }

    public function save()
    {
        $rules = [
            'idreceta'         => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'idalimento'       => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
            'cantidad'         => 'required|numeric|greater_than[0]|less_than[100000]',
            'idunidadalimento' => 'required|is_natural_no_zero|is_not_unique[unidadalimento.idunidadalimento]',
        ];

        $messages = [
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'Seleccione una receta válida.',
                'is_not_unique'      => 'La receta no existe en el sistema.',
            ],
            'idalimento' => [
                'required'           => 'Debe seleccionar un alimento.',
                'is_natural_no_zero' => 'Seleccione un alimento válido.',
                'is_not_unique'      => 'El alimento no existe en el sistema.',
            ],
            'cantidad' => [
                'required'     => 'La cantidad es obligatoria.',
                'numeric'      => 'La cantidad debe ser numérica.',
                'greater_than' => 'La cantidad debe ser mayor a 0.',
            ],
            'idunidadalimento' => [
                'required'           => 'Debe seleccionar una unidad de medida.',
                'is_natural_no_zero' => 'Seleccione una unidad válida.',
                'is_not_unique'      => 'La unidad no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->arModel->insert([
            'idreceta'         => (int)$this->request->getPost('idreceta'),
            'idalimento'       => (int)$this->request->getPost('idalimento'),
            'cantidad'         => (float)$this->request->getPost('cantidad'),
            'idunidadalimento' => (int)$this->request->getPost('idunidadalimento'),
        ]);

        $redirectReceta = $this->request->getPost('redirect_receta');
        if (!empty($redirectReceta)) {
            return redirect()->to(base_url('receta/actual/' . (int)$this->request->getPost('idreceta')))->with('success', 'Ingrediente agregado a la receta exitosamente.');
        }

        return redirect()->to(base_url('alimentoreceta/actual/' . $id))->with('success', 'Ingrediente asignado exitosamente a la receta.');
    }

    public function edit($id)
    {
        $rel = $this->arModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'     => 'Editar Ingrediente de Receta #' . $rel['idalimentoreceta'],
            'rel'       => $rel,
            'recetas'   => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'alimentos' => $this->alimentoModel->orderBy('nombre', 'ASC')->findAll(),
            'unidades'  => $this->unidadModel->orderBy('nombre', 'ASC')->findAll(),
            'module'    => 'alimentoreceta',
        ];

        return view('alimentoreceta/alimentoreceta_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->arModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('alimentoreceta'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idreceta'         => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'idalimento'       => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
            'cantidad'         => 'required|numeric|greater_than[0]|less_than[100000]',
            'idunidadalimento' => 'required|is_natural_no_zero|is_not_unique[unidadalimento.idunidadalimento]',
        ];

        $messages = [
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'Seleccione una receta válida.',
                'is_not_unique'      => 'La receta no existe en el sistema.',
            ],
            'idalimento' => [
                'required'           => 'Debe seleccionar un alimento.',
                'is_natural_no_zero' => 'Seleccione un alimento válido.',
                'is_not_unique'      => 'El alimento no existe en el sistema.',
            ],
            'cantidad' => [
                'required'     => 'La cantidad es obligatoria.',
                'numeric'      => 'La cantidad debe ser numérica.',
                'greater_than' => 'La cantidad debe ser mayor a 0.',
            ],
            'idunidadalimento' => [
                'required'           => 'Debe seleccionar una unidad de medida.',
                'is_natural_no_zero' => 'Seleccione una unidad válida.',
                'is_not_unique'      => 'La unidad no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->arModel->update($id, [
            'idreceta'         => (int)$this->request->getPost('idreceta'),
            'idalimento'       => (int)$this->request->getPost('idalimento'),
            'cantidad'         => (float)$this->request->getPost('cantidad'),
            'idunidadalimento' => (int)$this->request->getPost('idunidadalimento'),
        ]);

        return redirect()->to(base_url('alimentoreceta/actual/' . $id))->with('success', 'Ingrediente actualizado exitosamente.');
    }

    public function delete($id)
    {
        $rel = $this->arModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('alimentoreceta'))->with('error', 'Registro no encontrado.');
        }

        $idreceta = $rel['idreceta'];

        try {
            $this->arModel->delete($id);
            $redirectReceta = $this->request->getGet('from_receta');
            if ($redirectReceta) {
                return redirect()->to(base_url('receta/actual/' . $idreceta))->with('success', 'Ingrediente removido de la receta.');
            }

            $first = $this->arModel->elprimero();
            $targetUrl = $first ? 'alimentoreceta/actual/' . $first['idalimentoreceta'] : 'alimentoreceta';
            return redirect()->to(base_url($targetUrl))->with('success', 'Registro eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('alimentoreceta/actual/' . $id))->with('error', 'No se puede eliminar: ' . $e->getMessage());
        }
    }
}
