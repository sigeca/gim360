<?php

namespace App\Controllers;

use App\Models\PlanEjercicioModel;
use App\Models\EjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PlanEjercicio extends BaseController
{
    protected PlanEjercicioModel $planModel;
    protected EjercicioModel $ejercicioModel;

    public function __construct()
    {
        $this->planModel      = new PlanEjercicioModel();
        $this->ejercicioModel = new EjercicioModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $plan = $this->planModel->getPlanWithDetails($id);
        } else {
            $last = $this->planModel->elultimo();
            $plan = $last ? $this->planModel->getPlanWithDetails($last['idplanejercicio']) : null;
        }

        $youtubeId = null;
        if (!empty($plan['ejercicio_urlvideo'])) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $plan['ejercicio_urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        $data = [
            'title'     => 'Ficha de Plan de Ejercicio',
            'plan'      => $plan,
            'youtubeId' => $youtubeId,
            'module'    => 'planejercicio',
        ];

        return view('planejercicio/planejercicio_record', $data);
    }

    public function elprimero()
    {
        $first = $this->planModel->elprimero();
        return $this->actual($first ? $first['idplanejercicio'] : null);
    }

    public function elultimo()
    {
        $last = $this->planModel->elultimo();
        return $this->actual($last ? $last['idplanejercicio'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->planModel->siguiente($id);
        return $this->actual($next ? $next['idplanejercicio'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->planModel->anterior($id);
        return $this->actual($prev ? $prev['idplanejercicio'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $planes = $this->planModel->getPlanesWithDetails($search);

        $data = [
            'title'   => 'Listado de Planes de Ejercicio',
            'planes'  => $planes,
            'search'  => $search,
            'module'  => 'planejercicio',
        ];

        return view('planejercicio/planejercicio_list', $data);
    }

    public function add()
    {
        $idejercicioPreselected = $this->request->getGet('idejercicio');

        $data = [
            'title'                  => 'Crear Plan de Ejercicio',
            'ejercicios'             => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'idejercicioPreselected' => $idejercicioPreselected,
            'module'                 => 'planejercicio',
        ];

        return view('planejercicio/planejercicio_form', $data);
    }

    public function save()
    {
        $rules = [
            'idejercicio'    => 'required|is_natural_no_zero',
            'diassemanas'    => 'permit_empty|is_natural_no_zero',
            'dias'           => 'permit_empty|is_natural_no_zero',
            'repeticiones'   => 'permit_empty|is_natural_no_zero',
            'series'         => 'permit_empty|is_natural_no_zero',
            'tiempodescanso' => 'permit_empty|is_natural',
            'tiempodescando' => 'permit_empty|is_natural',
            'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $diassemanas    = $this->request->getPost('diassemanas') ?? $this->request->getPost('dias');
        $repeticiones   = $this->request->getPost('repeticiones');
        $series         = $this->request->getPost('series');
        $tiempodescanso = $this->request->getPost('tiempodescanso') ?? $this->request->getPost('tiempodescando');
        $peso           = $this->request->getPost('peso');

        $id = $this->planModel->insert([
            'idejercicio'    => $this->request->getPost('idejercicio'),
            'diassemanas'    => ($diassemanas !== null && $diassemanas !== '') ? (int)$diassemanas : null,
            'repeticiones'   => ($repeticiones !== null && $repeticiones !== '') ? (int)$repeticiones : null,
            'series'         => ($series !== null && $series !== '') ? (int)$series : null,
            'tiempodescanso' => ($tiempodescanso !== null && $tiempodescanso !== '') ? (int)$tiempodescanso : null,
            'peso'           => ($peso !== null && $peso !== '') ? (float)$peso : null,
        ]);

        return redirect()->to(base_url('planejercicio/actual/' . $id))->with('success', 'Plan de ejercicio registrado exitosamente.');
    }

    public function edit($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            throw PageNotFoundException::forPageNotFound("Plan de ejercicio no encontrado.");
        }

        $data = [
            'title'      => 'Editar Plan de Ejercicio #' . $id,
            'plan'       => $plan,
            'ejercicios' => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'planejercicio',
        ];

        return view('planejercicio/planejercicio_edit', $data);
    }

    public function update($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planejercicio'))->with('error', 'Plan de ejercicio no encontrado.');
        }

        $rules = [
            'idejercicio'    => 'required|is_natural_no_zero',
            'diassemanas'    => 'permit_empty|is_natural_no_zero',
            'dias'           => 'permit_empty|is_natural_no_zero',
            'repeticiones'   => 'permit_empty|is_natural_no_zero',
            'series'         => 'permit_empty|is_natural_no_zero',
            'tiempodescanso' => 'permit_empty|is_natural',
            'tiempodescando' => 'permit_empty|is_natural',
            'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $diassemanas    = $this->request->getPost('diassemanas') ?? $this->request->getPost('dias');
        $repeticiones   = $this->request->getPost('repeticiones');
        $series         = $this->request->getPost('series');
        $tiempodescanso = $this->request->getPost('tiempodescanso') ?? $this->request->getPost('tiempodescando');
        $peso           = $this->request->getPost('peso');

        $this->planModel->update($id, [
            'idejercicio'    => $this->request->getPost('idejercicio'),
            'diassemanas'    => ($diassemanas !== null && $diassemanas !== '') ? (int)$diassemanas : null,
            'repeticiones'   => ($repeticiones !== null && $repeticiones !== '') ? (int)$repeticiones : null,
            'series'         => ($series !== null && $series !== '') ? (int)$series : null,
            'tiempodescanso' => ($tiempodescanso !== null && $tiempodescanso !== '') ? (int)$tiempodescanso : null,
            'peso'           => ($peso !== null && $peso !== '') ? (float)$peso : null,
        ]);

        return redirect()->to(base_url('planejercicio/actual/' . $id))->with('success', 'Plan de ejercicio actualizado exitosamente.');
    }

    public function delete($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planejercicio'))->with('error', 'Plan no encontrado.');
        }

        try {
            $this->planModel->delete($id);
            return redirect()->to(base_url('planejercicio/elprimero'))->with('success', 'Plan de ejercicio eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('planejercicio/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
