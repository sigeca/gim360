<?php

namespace App\Controllers;

use App\Models\RutinaPlanModel;
use App\Models\RutinaEjecicioModel;
use App\Models\PlanEjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RutinaPlan extends BaseController
{
    protected RutinaPlanModel $rutinaPlanModel;
    protected RutinaEjecicioModel $rutinaModel;
    protected PlanEjercicioModel $planModel;

    public function __construct()
    {
        $this->rutinaPlanModel = new RutinaPlanModel();
        $this->rutinaModel     = new RutinaEjecicioModel();
        $this->planModel       = new PlanEjercicioModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $rutinaplan = $this->rutinaPlanModel->getRutinaPlanWithDetails($id);
        } else {
            $last = $this->rutinaPlanModel->elultimo();
            $rutinaplan = $last ? $this->rutinaPlanModel->getRutinaPlanWithDetails($last['id_rutina_plan']) : null;
        }

        $youtubeId = null;
        if (!empty($rutinaplan['ejercicio_urlvideo'])) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $rutinaplan['ejercicio_urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        $data = [
            'title'      => 'Ficha de Rutina y Plan',
            'rutinaplan' => $rutinaplan,
            'youtubeId'  => $youtubeId,
            'module'     => 'rutinaplan',
        ];

        return view('rutinaplan/rutinaplan_record', $data);
    }

    public function elprimero()
    {
        $first = $this->rutinaPlanModel->elprimero();
        return $this->actual($first ? $first['id_rutina_plan'] : null);
    }

    public function elultimo()
    {
        $last = $this->rutinaPlanModel->elultimo();
        return $this->actual($last ? $last['id_rutina_plan'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->rutinaPlanModel->siguiente($id);
        return $this->actual($next ? $next['id_rutina_plan'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->rutinaPlanModel->anterior($id);
        return $this->actual($prev ? $prev['id_rutina_plan'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $rutinaplanes = $this->rutinaPlanModel->getRutinaPlanesWithDetails($search);

        $data = [
            'title'        => 'Listado de Rutinas y Planes',
            'rutinaplanes' => $rutinaplanes,
            'search'       => $search,
            'module'       => 'rutinaplan',
        ];

        return view('rutinaplan/rutinaplan_list', $data);
    }

    public function add()
    {
        $idrutinaPreselected = $this->request->getGet('idrutinaejercicio');
        $idplanPreselected   = $this->request->getGet('idplanejercicio');

        $data = [
            'title'               => 'Asignar Plan a Rutina',
            'rutinas'             => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'planes'              => $this->planModel->getPlanesWithDetails(),
            'idrutinaPreselected' => $idrutinaPreselected,
            'idplanPreselected'   => $idplanPreselected,
            'module'              => 'rutinaplan',
        ];

        return view('rutinaplan/rutinaplan_form', $data);
    }

    public function save()
    {
        $rules = [
            'idrutinaejercicio' => 'required|is_natural_no_zero',
            'idplanejercicio'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->rutinaPlanModel->insert([
            'idrutinaejercicio' => $this->request->getPost('idrutinaejercicio'),
            'idplanejercicio'   => $this->request->getPost('idplanejercicio'),
        ]);

        return redirect()->to(base_url('rutinaplan/actual/' . $id))->with('success', 'Relación de Rutina y Plan guardada exitosamente.');
    }

    public function edit($id)
    {
        $rutinaplan = $this->rutinaPlanModel->find($id);
        if (!$rutinaplan) {
            throw PageNotFoundException::forPageNotFound("Registro de RutinaPlan no encontrado.");
        }

        $data = [
            'title'      => 'Editar Rutina y Plan #' . $id,
            'rutinaplan' => $rutinaplan,
            'rutinas'    => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'planes'     => $this->planModel->getPlanesWithDetails(),
            'module'     => 'rutinaplan',
        ];

        return view('rutinaplan/rutinaplan_edit', $data);
    }

    public function update($id)
    {
        $rutinaplan = $this->rutinaPlanModel->find($id);
        if (!$rutinaplan) {
            return redirect()->to(base_url('rutinaplan'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idrutinaejercicio' => 'required|is_natural_no_zero',
            'idplanejercicio'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->rutinaPlanModel->update($id, [
            'idrutinaejercicio' => $this->request->getPost('idrutinaejercicio'),
            'idplanejercicio'   => $this->request->getPost('idplanejercicio'),
        ]);

        return redirect()->to(base_url('rutinaplan/actual/' . $id))->with('success', 'Relación de Rutina y Plan actualizada correctamente.');
    }

    public function delete($id)
    {
        $rutinaplan = $this->rutinaPlanModel->find($id);
        if (!$rutinaplan) {
            return redirect()->to(base_url('rutinaplan'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->rutinaPlanModel->delete($id);
            return redirect()->to(base_url('rutinaplan/elprimero'))->with('success', 'Registro eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('rutinaplan/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
