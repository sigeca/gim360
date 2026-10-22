<?php

namespace App\Controllers;

use App\Models\PlanPersonalizadoModel;
use App\Models\EjercicioModel;
use App\Models\RutinaPersonalizadaModel;
use App\Models\RutinaPlanPersonalizadoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PlanPersonalizado extends BaseController
{
    protected PlanPersonalizadoModel $planModel;
    protected EjercicioModel $ejercicioModel;
    protected RutinaPersonalizadaModel $rutinaModel;
    protected RutinaPlanPersonalizadoModel $rutinaPlanModel;

    public function __construct()
    {
        $this->planModel       = new PlanPersonalizadoModel();
        $this->ejercicioModel  = new EjercicioModel();
        $this->rutinaModel     = new RutinaPersonalizadaModel();
        $this->rutinaPlanModel = new RutinaPlanPersonalizadoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $plan = $this->planModel->getPlanWithDetails((int)$id);
        } else {
            $last = $this->planModel->elultimo();
            $plan = $last ? $this->planModel->getPlanWithDetails((int)$last['idplanpersonalizado']) : null;
        }

        $youtubeId = null;
        if (!empty($plan['ejercicio_urlvideo'])) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $plan['ejercicio_urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        // Calcular fecha estimada de fin a partir de fechainicio y duracionsemana
        $fechaFinEstimada = null;
        if (!empty($plan['fechainicio']) && !empty($plan['duracionsemana'])) {
            $semanas = (int)$plan['duracionsemana'];
            $fechaFinEstimada = date('Y-m-d', strtotime($plan['fechainicio'] . " +{$semanas} weeks"));
        }

        $data = [
            'title'            => 'Ficha de Plan de Ejercicio Personalizado',
            'plan'             => $plan,
            'youtubeId'        => $youtubeId,
            'fechaFinEstimada' => $fechaFinEstimada,
            'module'           => 'planpersonalizado',
        ];

        return view('planpersonalizado/planpersonalizado_record', $data);
    }

    public function elprimero()
    {
        $first = $this->planModel->elprimero();
        return $this->actual($first ? $first['idplanpersonalizado'] : null);
    }

    public function elultimo()
    {
        $last = $this->planModel->elultimo();
        return $this->actual($last ? $last['idplanpersonalizado'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->planModel->siguiente($id);
        return $this->actual($next ? $next['idplanpersonalizado'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->planModel->anterior($id);
        return $this->actual($prev ? $prev['idplanpersonalizado'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $planes = $this->planModel->getPlanesPersonalizadosWithDetails($search);

        $data = [
            'title'   => 'Listado de Planes de Ejercicio Personalizados',
            'planes'  => $planes,
            'search'  => $search,
            'module'  => 'planpersonalizado',
        ];

        return view('planpersonalizado/planpersonalizado_list', $data);
    }

    public function add()
    {
        $idejercicioPreselected = $this->request->getGet('idejercicio');
        $idrutinaPreselected    = $this->request->getGet('idrutina');

        $data = [
            'title'                  => 'Crear Plan de Ejercicio Personalizado',
            'ejercicios'             => $this->ejercicioModel->select('ejercicio.*, nombreespanol AS nombre')->orderBy('nombreespanol', 'ASC')->findAll(),
            'rutinas'                => $this->rutinaModel->orderBy('idrutinapersonalizada', 'DESC')->findAll(),
            'idejercicioPreselected' => $idejercicioPreselected,
            'idrutinaPreselected'    => $idrutinaPreselected,
            'module'                 => 'planpersonalizado',
        ];

        return view('planpersonalizado/planpersonalizado_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'         => 'permit_empty|min_length[3]|max_length[150]',
            'idejercicio'    => 'required|is_natural_no_zero',
            'fechainicio'    => 'permit_empty|valid_date[Y-m-d]',
            'duracionsemana' => 'permit_empty|is_natural_no_zero',
            'diassemanas'    => 'permit_empty|is_natural_no_zero',
            'repeticiones'   => 'permit_empty|is_natural_no_zero',
            'series'         => 'permit_empty|is_natural_no_zero',
            'tiempodescanso' => 'permit_empty|is_natural',
            'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idEjercicio    = (int)$this->request->getPost('idejercicio');
        $nombre         = trim((string)$this->request->getPost('nombre'));
        if (empty($nombre)) {
            $ej = $this->ejercicioModel->find($idEjercicio);
            $nombre = 'Plan ' . (!empty($ej['nombreespanol']) ? $ej['nombreespanol'] : ($ej['nombreingles'] ?? 'Personalizado'));
        }

        $fechainicio    = $this->request->getPost('fechainicio') ?: date('Y-m-d');
        $duracionsemana = $this->request->getPost('duracionsemana') ? (int)$this->request->getPost('duracionsemana') : 4;
        $diassemanas    = $this->request->getPost('diassemanas');
        $repeticiones   = $this->request->getPost('repeticiones');
        $series         = $this->request->getPost('series');
        $tiempodescanso = $this->request->getPost('tiempodescanso');
        $peso           = $this->request->getPost('peso');

        $id = $this->planModel->insert([
            'nombre'         => mb_substr($nombre, 0, 150),
            'idejercicio'    => $idEjercicio,
            'fechainicio'    => $fechainicio,
            'duracionsemana' => $duracionsemana,
            'diassemanas'    => ($diassemanas !== null && $diassemanas !== '') ? (int)$diassemanas : 3,
            'repeticiones'   => ($repeticiones !== null && $repeticiones !== '') ? (int)$repeticiones : 12,
            'series'         => ($series !== null && $series !== '') ? (int)$series : 3,
            'tiempodescanso' => ($tiempodescanso !== null && $tiempodescanso !== '') ? (int)$tiempodescanso : 60,
            'peso'           => ($peso !== null && $peso !== '') ? (float)$peso : 0.0,
        ]);

        if (!$id) {
            return redirect()->back()->withInput()->with('errors', $this->planModel->errors());
        }

        // Si se seleccionó una rutina personalizada, asociar
        $idRutina = $this->request->getPost('idrutinapersonalizada');
        if (!empty($idRutina)) {
            $this->rutinaPlanModel->insert([
                'idrutinapersonalizada' => (int)$idRutina,
                'idplanpersonalizado'   => (int)$id,
            ]);
        }

        return redirect()->to(base_url('planpersonalizado/actual/' . $id))->with('success', 'Plan de ejercicio personalizado registrado exitosamente.');
    }

    public function edit($id)
    {
        $plan = $this->planModel->getPlanWithDetails((int)$id);
        if (!$plan) {
            throw PageNotFoundException::forPageNotFound("Plan de ejercicio personalizado no encontrado.");
        }

        $data = [
            'title'      => 'Editar Plan de Ejercicio Personalizado #' . $id,
            'plan'       => $plan,
            'ejercicios' => $this->ejercicioModel->select('ejercicio.*, nombreespanol AS nombre')->orderBy('nombreespanol', 'ASC')->findAll(),
            'module'     => 'planpersonalizado',
        ];

        return view('planpersonalizado/planpersonalizado_edit', $data);
    }

    public function update($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planpersonalizado'))->with('error', 'Plan de ejercicio personalizado no encontrado.');
        }

        $rules = [
            'nombre'         => 'permit_empty|min_length[3]|max_length[150]',
            'idejercicio'    => 'required|is_natural_no_zero',
            'fechainicio'    => 'permit_empty|valid_date[Y-m-d]',
            'duracionsemana' => 'permit_empty|is_natural_no_zero',
            'diassemanas'    => 'permit_empty|is_natural_no_zero',
            'repeticiones'   => 'permit_empty|is_natural_no_zero',
            'series'         => 'permit_empty|is_natural_no_zero',
            'tiempodescanso' => 'permit_empty|is_natural',
            'peso'           => 'permit_empty|numeric|greater_than_equal_to[0]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idEjercicio    = (int)$this->request->getPost('idejercicio');
        $nombre         = trim((string)$this->request->getPost('nombre'));
        if (empty($nombre)) {
            $ej = $this->ejercicioModel->find($idEjercicio);
            $nombre = 'Plan ' . (!empty($ej['nombreespanol']) ? $ej['nombreespanol'] : ($ej['nombreingles'] ?? 'Personalizado'));
        }

        $fechainicio    = $this->request->getPost('fechainicio') ?: date('Y-m-d');
        $duracionsemana = $this->request->getPost('duracionsemana') ? (int)$this->request->getPost('duracionsemana') : 4;
        $diassemanas    = $this->request->getPost('diassemanas');
        $repeticiones   = $this->request->getPost('repeticiones');
        $series         = $this->request->getPost('series');
        $tiempodescanso = $this->request->getPost('tiempodescanso');
        $peso           = $this->request->getPost('peso');

        $this->planModel->update($id, [
            'nombre'         => mb_substr($nombre, 0, 150),
            'idejercicio'    => $idEjercicio,
            'fechainicio'    => $fechainicio,
            'duracionsemana' => $duracionsemana,
            'diassemanas'    => ($diassemanas !== null && $diassemanas !== '') ? (int)$diassemanas : null,
            'repeticiones'   => ($repeticiones !== null && $repeticiones !== '') ? (int)$repeticiones : null,
            'series'         => ($series !== null && $series !== '') ? (int)$series : null,
            'tiempodescanso' => ($tiempodescanso !== null && $tiempodescanso !== '') ? (int)$tiempodescanso : null,
            'peso'           => ($peso !== null && $peso !== '') ? (float)$peso : null,
        ]);

        return redirect()->to(base_url('planpersonalizado/actual/' . $id))->with('success', 'Plan de ejercicio personalizado actualizado exitosamente.');
    }

    public function delete($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planpersonalizado'))->with('error', 'Plan no encontrado.');
        }

        try {
            // Eliminar asignaciones en rutinaplanpersonalizado
            $this->rutinaPlanModel->where('idplanpersonalizado', $id)->delete();
            $this->planModel->delete($id);
            return redirect()->to(base_url('planpersonalizado/elprimero'))->with('success', 'Plan de ejercicio personalizado eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('planpersonalizado/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
