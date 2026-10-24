<?php

namespace App\Controllers;

use App\Models\ComidaModel;
use App\Models\PlanAlimentacionModel;
use App\Models\TipoComidaModel;
use App\Models\RecetaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Comida extends BaseController
{
    protected ComidaModel $comidaModel;
    protected PlanAlimentacionModel $planModel;
    protected TipoComidaModel $tipoComidaModel;
    protected RecetaModel $recetaModel;

    public function __construct()
    {
        $this->comidaModel     = new ComidaModel();
        $this->planModel       = new PlanAlimentacionModel();
        $this->tipoComidaModel = new TipoComidaModel();
        $this->recetaModel     = new RecetaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $comida = $this->comidaModel->getRecordWithDetails((int)$id);
        } else {
            $first  = $this->comidaModel->elprimero();
            $comida = $first ? $this->comidaModel->getRecordWithDetails((int)$first['idcomida']) : null;
        }

        $data = [
            'title'  => 'Ficha de Comida' . ($comida ? ': #' . $comida['idcomida'] : ''),
            'comida' => $comida,
            'module' => 'comida',
        ];

        return view('comida/comida_record', $data);
    }

    public function elprimero()
    {
        $first = $this->comidaModel->elprimero();
        return $this->actual($first ? $first['idcomida'] : null);
    }

    public function elultimo()
    {
        $last = $this->comidaModel->elultimo();
        return $this->actual($last ? $last['idcomida'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->comidaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idcomida'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->comidaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idcomida'] : $id);
    }

    public function listar()
    {
        $search       = $this->request->getGet('q');
        $idplan       = $this->request->getGet('idplanalimentacion');
        $idtipocomida = $this->request->getGet('idtipocomida');
        $idreceta     = $this->request->getGet('idreceta');

        $idplan       = (!empty($idplan) && is_numeric($idplan)) ? (int)$idplan : null;
        $idtipocomida = (!empty($idtipocomida) && is_numeric($idtipocomida)) ? (int)$idtipocomida : null;
        $idreceta     = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;

        $comidas = $this->comidaModel->getRecordsWithDetails($search, $idplan, $idtipocomida, $idreceta);
        $planes  = $this->planModel->orderBy('nombre', 'ASC')->findAll();
        $tipos   = $this->tipoComidaModel->orderBy('idtipocomida', 'ASC')->findAll();
        $recetas = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'                => 'Catálogo de Comidas en Planes',
            'comidas'              => $comidas,
            'planes'               => $planes,
            'tipos'                => $tipos,
            'recetas'              => $recetas,
            'search'               => $search,
            'selectedPlan'         => $idplan,
            'selectedTipo'         => $idtipocomida,
            'selectedReceta'       => $idreceta,
            'module'               => 'comida',
        ];

        return view('comida/comida_list', $data);
    }

    public function add()
    {
        $idplanPre = $this->request->getGet('idplanalimentacion');

        $data = [
            'title'          => 'Programar Comida en Plan',
            'planes'         => $this->planModel->orderBy('nombre', 'ASC')->findAll(),
            'tipos'          => $this->tipoComidaModel->orderBy('idtipocomida', 'ASC')->findAll(),
            'recetas'        => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedPlan'=> $idplanPre,
            'module'         => 'comida',
        ];

        return view('comida/comida_form', $data);
    }

    public function save()
    {
        $rules = [
            'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
            'idtipocomida'       => 'required|is_natural_no_zero|is_not_unique[tipocomida.idtipocomida]',
            'idreceta'           => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'horarecomendada'    => 'permit_empty',
        ];

        $messages = [
            'idplanalimentacion' => [
                'required'           => 'Debe seleccionar un plan de alimentación.',
                'is_natural_no_zero' => 'Seleccione un plan válido.',
                'is_not_unique'      => 'El plan de alimentación seleccionado no existe.',
            ],
            'idtipocomida' => [
                'required'           => 'Debe seleccionar un tipo de comida.',
                'is_natural_no_zero' => 'Seleccione un tipo de comida válido.',
                'is_not_unique'      => 'El tipo de comida no existe.',
            ],
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'Seleccione una receta válida.',
                'is_not_unique'      => 'La receta seleccionada no existe.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hora = trim($this->request->getPost('horarecomendada')) ?: null;

        $id = $this->comidaModel->insert([
            'idplanalimentacion' => (int)$this->request->getPost('idplanalimentacion'),
            'idtipocomida'       => (int)$this->request->getPost('idtipocomida'),
            'idreceta'           => (int)$this->request->getPost('idreceta'),
            'horarecomendada'    => $hora,
        ]);

        $redirectPlan = $this->request->getPost('redirect_plan');
        if (!empty($redirectPlan)) {
            return redirect()->to(base_url('planalimentacion/actual/' . (int)$this->request->getPost('idplanalimentacion')))->with('success', 'Comida agregada al plan exitosamente.');
        }

        return redirect()->to(base_url('comida/actual/' . $id))->with('success', 'Comida registrada exitosamente.');
    }

    public function edit($id)
    {
        $comida = $this->comidaModel->find($id);
        if (!$comida) {
            throw PageNotFoundException::forPageNotFound("Comida no encontrada.");
        }

        $data = [
            'title'   => 'Editar Comida #' . $comida['idcomida'],
            'comida'  => $comida,
            'planes'  => $this->planModel->orderBy('nombre', 'ASC')->findAll(),
            'tipos'   => $this->tipoComidaModel->orderBy('idtipocomida', 'ASC')->findAll(),
            'recetas' => $this->recetaModel->orderBy('nombre', 'ASC')->findAll(),
            'module'  => 'comida',
        ];

        return view('comida/comida_edit', $data);
    }

    public function update($id)
    {
        $comida = $this->comidaModel->find($id);
        if (!$comida) {
            return redirect()->to(base_url('comida'))->with('error', 'Comida no encontrada.');
        }

        $rules = [
            'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
            'idtipocomida'       => 'required|is_natural_no_zero|is_not_unique[tipocomida.idtipocomida]',
            'idreceta'           => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
            'horarecomendada'    => 'permit_empty',
        ];

        $messages = [
            'idplanalimentacion' => [
                'required'           => 'Debe seleccionar un plan de alimentación.',
                'is_natural_no_zero' => 'Seleccione un plan válido.',
                'is_not_unique'      => 'El plan seleccionado no existe.',
            ],
            'idtipocomida' => [
                'required'           => 'Debe seleccionar un tipo de comida.',
                'is_natural_no_zero' => 'Seleccione un tipo de comida válido.',
                'is_not_unique'      => 'El tipo de comida no existe.',
            ],
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'Seleccione una receta válida.',
                'is_not_unique'      => 'La receta no existe.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $hora = trim($this->request->getPost('horarecomendada')) ?: null;

        $this->comidaModel->update($id, [
            'idplanalimentacion' => (int)$this->request->getPost('idplanalimentacion'),
            'idtipocomida'       => (int)$this->request->getPost('idtipocomida'),
            'idreceta'           => (int)$this->request->getPost('idreceta'),
            'horarecomendada'    => $hora,
        ]);

        return redirect()->to(base_url('comida/actual/' . $id))->with('success', 'Comida actualizada exitosamente.');
    }

    public function delete($id)
    {
        $comida = $this->comidaModel->find($id);
        if (!$comida) {
            return redirect()->to(base_url('comida'))->with('error', 'Comida no encontrada.');
        }

        $idplan = $comida['idplanalimentacion'];

        try {
            $this->comidaModel->delete($id);

            $fromPlan = $this->request->getGet('from_plan');
            if ($fromPlan) {
                return redirect()->to(base_url('planalimentacion/actual/' . $idplan))->with('success', 'Comida removida del plan.');
            }

            $first = $this->comidaModel->elprimero();
            $targetUrl = $first ? 'comida/actual/' . $first['idcomida'] : 'comida';
            return redirect()->to(base_url($targetUrl))->with('success', 'Comida eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('comida/actual/' . $id))->with('error', 'No se puede eliminar la comida: ' . $e->getMessage());
        }
    }
}
