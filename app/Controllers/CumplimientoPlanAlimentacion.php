<?php

namespace App\Controllers;

use App\Models\CumplimientoPlanAlimentacionModel;
use App\Models\PlanAlimentacionModel;
use App\Models\ComidaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class CumplimientoPlanAlimentacion extends BaseController
{
    protected CumplimientoPlanAlimentacionModel $cumplimientoModel;
    protected PlanAlimentacionModel $planModel;
    protected ComidaModel $comidaModel;

    public function __construct()
    {
        $this->cumplimientoModel = new CumplimientoPlanAlimentacionModel();
        $this->planModel         = new PlanAlimentacionModel();
        $this->comidaModel       = new ComidaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $cumplimiento = $this->cumplimientoModel->getCumplimientoWithDetails((int)$id);
        } else {
            $first = $this->cumplimientoModel->elprimero();
            $cumplimiento = $first ? $this->cumplimientoModel->getCumplimientoWithDetails((int)$first['idcumplimientoplanalimentacion']) : null;
        }

        $data = [
            'title'        => 'Ficha de Cumplimiento' . ($cumplimiento ? ': #' . $cumplimiento['idcumplimientoplanalimentacion'] : ''),
            'cumplimiento' => $cumplimiento,
            'module'       => 'cumplimientoplanalimentacion',
        ];

        return view('cumplimientoplanalimentacion/cumplimientoplanalimentacion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->cumplimientoModel->elprimero();
        return $this->actual($first ? $first['idcumplimientoplanalimentacion'] : null);
    }

    public function elultimo()
    {
        $last = $this->cumplimientoModel->elultimo();
        return $this->actual($last ? $last['idcumplimientoplanalimentacion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->cumplimientoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idcumplimientoplanalimentacion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->cumplimientoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idcumplimientoplanalimentacion'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idplan = $this->request->getGet('idplanalimentacion');
        $fecha  = $this->request->getGet('fecha');

        $idplan = (!empty($idplan) && is_numeric($idplan)) ? (int)$idplan : null;
        $fecha  = !empty($fecha) ? trim($fecha) : null;

        $cumplimientos = $this->cumplimientoModel->getCumplimientosWithDetails($search, $idplan, null, $fecha);
        $planes        = $this->planModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'         => 'Registro de Cumplimiento de Planes de Alimentación',
            'cumplimientos' => $cumplimientos,
            'planes'        => $planes,
            'search'        => $search,
            'selectedPlan'  => $idplan,
            'selectedFecha' => $fecha,
            'module'        => 'cumplimientoplanalimentacion',
        ];

        return view('cumplimientoplanalimentacion/cumplimientoplanalimentacion_list', $data);
    }

    public function add()
    {
        $idplanPre   = $this->request->getGet('idplanalimentacion');
        $idcomidaPre = $this->request->getGet('idcomida');

        $planes = $this->planModel->orderBy('nombre', 'ASC')->findAll();
        
        $comidas = [];
        if (!empty($idplanPre)) {
            $comidas = $this->comidaModel->getComidasByPlan((int)$idplanPre);
        } else if (!empty($planes)) {
            $comidas = $this->comidaModel->getComidasByPlan((int)$planes[0]['idplanalimentacion']);
        }

        $data = [
            'title'           => 'Registrar Cumplimiento de Comida',
            'planes'          => $planes,
            'comidas'         => $comidas,
            'preselectedPlan' => $idplanPre,
            'preselectedComida' => $idcomidaPre,
            'defaultFechaHora'=> date('Y-m-d\TH:i'),
            'module'          => 'cumplimientoplanalimentacion',
        ];

        return view('cumplimientoplanalimentacion/cumplimientoplanalimentacion_form', $data);
    }

    public function save()
    {
        $rules = [
            'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
            'idcomida'           => 'required|is_natural_no_zero|is_not_unique[comida.idcomida]',
            'fechahora'          => 'required',
        ];

        $messages = [
            'idplanalimentacion' => [
                'required'           => 'Debe seleccionar un plan de alimentación.',
                'is_natural_no_zero' => 'Seleccione un plan válido.',
                'is_not_unique'      => 'El plan de alimentación seleccionado no existe.',
            ],
            'idcomida' => [
                'required'           => 'Debe seleccionar la comida efectuada.',
                'is_natural_no_zero' => 'Seleccione una comida válida.',
                'is_not_unique'      => 'La comida seleccionada no existe.',
            ],
            'fechahora' => [
                'required' => 'La fecha y hora son obligatorias.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Formatear fechahora para MySQL (Y-m-d H:i:s)
        $rawFechaHora = $this->request->getPost('fechahora');
        $timestamp = strtotime($rawFechaHora);
        $fechaHoraDb = $timestamp ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d H:i:s');

        $id = $this->cumplimientoModel->insert([
            'idplanalimentacion' => (int)$this->request->getPost('idplanalimentacion'),
            'idcomida'           => (int)$this->request->getPost('idcomida'),
            'fechahora'          => $fechaHoraDb,
        ]);

        $redirectPlan = $this->request->getPost('redirect_plan');
        if (!empty($redirectPlan)) {
            return redirect()->to(base_url('planalimentacion/actual/' . (int)$this->request->getPost('idplanalimentacion')))->with('success', 'Cumplimiento de comida registrado con éxito.');
        }

        return redirect()->to(base_url('cumplimientoplanalimentacion/actual/' . $id))->with('success', 'Cumplimiento registrado con éxito.');
    }

    public function edit($id)
    {
        $cumplimiento = $this->cumplimientoModel->find($id);
        if (!$cumplimiento) {
            throw PageNotFoundException::forPageNotFound("Registro de cumplimiento no encontrado.");
        }

        $planes  = $this->planModel->orderBy('nombre', 'ASC')->findAll();
        $comidas = $this->comidaModel->getComidasByPlan((int)$cumplimiento['idplanalimentacion']);

        $data = [
            'title'        => 'Editar Cumplimiento #' . $cumplimiento['idcumplimientoplanalimentacion'],
            'cumplimiento' => $cumplimiento,
            'planes'       => $planes,
            'comidas'      => $comidas,
            'module'       => 'cumplimientoplanalimentacion',
        ];

        return view('cumplimientoplanalimentacion/cumplimientoplanalimentacion_edit', $data);
    }

    public function update($id)
    {
        $cumplimiento = $this->cumplimientoModel->find($id);
        if (!$cumplimiento) {
            return redirect()->to(base_url('cumplimientoplanalimentacion'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idplanalimentacion' => 'required|is_natural_no_zero|is_not_unique[planalimentacion.idplanalimentacion]',
            'idcomida'           => 'required|is_natural_no_zero|is_not_unique[comida.idcomida]',
            'fechahora'          => 'required',
        ];

        $messages = [
            'idplanalimentacion' => [
                'required'           => 'Debe seleccionar un plan de alimentación.',
                'is_natural_no_zero' => 'Seleccione un plan válido.',
                'is_not_unique'      => 'El plan de alimentación seleccionado no existe.',
            ],
            'idcomida' => [
                'required'           => 'Debe seleccionar una comida programada.',
                'is_natural_no_zero' => 'Seleccione una comida válida.',
                'is_not_unique'      => 'La comida seleccionada no existe.',
            ],
            'fechahora' => [
                'required' => 'La fecha y hora son obligatorias.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rawFechaHora = $this->request->getPost('fechahora');
        $timestamp = strtotime($rawFechaHora);
        $fechaHoraDb = $timestamp ? date('Y-m-d H:i:s', $timestamp) : date('Y-m-d H:i:s');

        $this->cumplimientoModel->update($id, [
            'idplanalimentacion' => (int)$this->request->getPost('idplanalimentacion'),
            'idcomida'           => (int)$this->request->getPost('idcomida'),
            'fechahora'          => $fechaHoraDb,
        ]);

        return redirect()->to(base_url('cumplimientoplanalimentacion/actual/' . $id))->with('success', 'Registro de cumplimiento actualizado correctamente.');
    }

    public function delete($id)
    {
        $cumplimiento = $this->cumplimientoModel->find($id);
        $fromPlan = $this->request->getGet('from_plan') ?? $this->request->getPost('from_plan');

        if (!$cumplimiento) {
            if ($fromPlan) {
                return redirect()->back()->with('error', 'Registro de cumplimiento no encontrado.');
            }
            return redirect()->to(base_url('cumplimientoplanalimentacion/listar'))->with('error', 'Registro no encontrado.');
        }

        $idplan = $cumplimiento['idplanalimentacion'];

        try {
            $this->cumplimientoModel->delete($id);

            if ($fromPlan) {
                return redirect()->to(base_url('planalimentacion/actual/' . $idplan))->with('success', 'Registro de cumplimiento eliminado exitosamente.');
            }

            // Si la petición vino del listado general, regresar a listar
            $referer = (string)$this->request->getServer('HTTP_REFERER');
            if (strpos($referer, 'listar') !== false) {
                return redirect()->to(base_url('cumplimientoplanalimentacion/listar'))->with('success', 'Registro de cumplimiento eliminado exitosamente.');
            }

            $first = $this->cumplimientoModel->elprimero();
            $targetUrl = $first ? 'cumplimientoplanalimentacion/actual/' . $first['idcumplimientoplanalimentacion'] : 'cumplimientoplanalimentacion/listar';
            return redirect()->to(base_url($targetUrl))->with('success', 'Registro de cumplimiento eliminado exitosamente.');
        } catch (\Exception $e) {
            if ($fromPlan) {
                return redirect()->to(base_url('planalimentacion/actual/' . $idplan))->with('error', 'Error al eliminar: ' . $e->getMessage());
            }
            return redirect()->to(base_url('cumplimientoplanalimentacion/listar'))->with('error', 'Error al eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Endpoint JSON para retornar las comidas de un plan específico
     */
    public function getComidasPorPlanAjax($idplan)
    {
        $comidas = $this->comidaModel->getComidasByPlan((int)$idplan);
        return $this->response->setJSON($comidas);
    }
}
