<?php

namespace App\Controllers;

use App\Models\PlanAlimentacionModel;
use App\Models\PersonaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PlanAlimentacion extends BaseController
{
    protected PlanAlimentacionModel $planModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->planModel    = new PlanAlimentacionModel();
        $this->personaModel = new PersonaModel();
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
            $first = $this->planModel->elprimero();
            $plan = $first ? $this->planModel->getPlanWithDetails((int)$first['idplanalimentacion']) : null;
        }

        $otrosPlanes = [];
        if ($plan && !empty($plan['idpersona'])) {
            $otrosPlanes = $this->planModel->where('idpersona', $plan['idpersona'])
                                           ->where('idplanalimentacion !=', $plan['idplanalimentacion'])
                                           ->orderBy('fechainicio', 'DESC')
                                           ->findAll();
            foreach ($otrosPlanes as &$op) {
                $op['estado_info'] = PlanAlimentacionModel::getEstadoPlan($op['fechainicio'], $op['fechafin']);
            }
        }

        $comidas = [];
        if ($plan) {
            $comidaModel = new \App\Models\ComidaModel();
            $comidas = $comidaModel->getComidasByPlan((int)$plan['idplanalimentacion']);
        }

        $data = [
            'title'       => 'Plan de Alimentación' . ($plan ? ': ' . $plan['nombre'] : ''),
            'plan'        => $plan,
            'comidas'     => $comidas,
            'otrosPlanes' => $otrosPlanes,
            'module'      => 'planalimentacion',
        ];

        return view('planalimentacion/planalimentacion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->planModel->elprimero();
        return $this->actual($first ? $first['idplanalimentacion'] : null);
    }

    public function elultimo()
    {
        $last = $this->planModel->elultimo();
        return $this->actual($last ? $last['idplanalimentacion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->planModel->siguiente((int)$id);
        return $this->actual($next ? $next['idplanalimentacion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->planModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idplanalimentacion'] : $id);
    }

    public function listar()
    {
        $search    = $this->request->getGet('q');
        $idpersona = $this->request->getGet('idpersona');
        $idpersona = (!empty($idpersona) && is_numeric($idpersona)) ? (int)$idpersona : null;

        $planes   = $this->planModel->getPlanesWithPersona($search, $idpersona);
        $personas = $this->personaModel->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll();

        $data = [
            'title'            => 'Planes de Alimentación',
            'planes'           => $planes,
            'personas'         => $personas,
            'search'           => $search,
            'selectedPersona'  => $idpersona,
            'module'           => 'planalimentacion',
        ];

        return view('planalimentacion/planalimentacion_list', $data);
    }

    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');
        $personas = $this->personaModel->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll();

        $data = [
            'title'                => 'Registrar Plan de Alimentación',
            'personas'             => $personas,
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'planalimentacion',
        ];

        return view('planalimentacion/planalimentacion_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona'   => 'required|is_natural_no_zero|is_not_unique[persona.idpersona]',
            'nombre'      => 'required|min_length[3]|max_length[150]',
            'fechainicio' => 'required|valid_date',
            'fechafin'    => 'permit_empty|valid_date',
            'objetivo'    => 'permit_empty',
        ];

        $messages = [
            'idpersona' => [
                'required'           => 'Debe seleccionar una persona.',
                'is_natural_no_zero' => 'Persona seleccionada no válida.',
                'is_not_unique'      => 'La persona seleccionada no existe en el sistema.',
            ],
            'nombre' => [
                'required'   => 'El nombre del plan de alimentación es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'fechainicio' => [
                'required'   => 'La fecha de inicio es obligatoria.',
                'valid_date' => 'Ingrese una fecha de inicio válida.',
            ],
            'fechafin' => [
                'valid_date' => 'Ingrese una fecha de fin válida.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fechaInicio = $this->request->getPost('fechainicio');
        $fechaFin    = trim($this->request->getPost('fechafin')) ?: null;

        if (!empty($fechaFin) && $fechaFin < $fechaInicio) {
            return redirect()->back()->withInput()->with('errors', [
                'fechafin' => 'La fecha de fin no puede ser anterior a la fecha de inicio.'
            ]);
        }

        $id = $this->planModel->insert([
            'idpersona'   => (int)$this->request->getPost('idpersona'),
            'nombre'      => trim($this->request->getPost('nombre')),
            'fechainicio' => $fechaInicio,
            'fechafin'    => $fechaFin,
            'objetivo'    => trim($this->request->getPost('objetivo')) ?: null,
        ]);

        return redirect()->to(base_url('planalimentacion/actual/' . $id))->with('success', 'Plan de alimentación registrado exitosamente.');
    }

    public function edit($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            throw PageNotFoundException::forPageNotFound("Plan de alimentación no encontrado.");
        }

        $personas = $this->personaModel->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll();

        $data = [
            'title'    => 'Editar Plan de Alimentación: ' . $plan['nombre'],
            'plan'     => $plan,
            'personas' => $personas,
            'module'   => 'planalimentacion',
        ];

        return view('planalimentacion/planalimentacion_edit', $data);
    }

    public function update($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planalimentacion'))->with('error', 'Plan no encontrado.');
        }

        $rules = [
            'idpersona'   => 'required|is_natural_no_zero|is_not_unique[persona.idpersona]',
            'nombre'      => 'required|min_length[3]|max_length[150]',
            'fechainicio' => 'required|valid_date',
            'fechafin'    => 'permit_empty|valid_date',
            'objetivo'    => 'permit_empty',
        ];

        $messages = [
            'idpersona' => [
                'required'           => 'Debe seleccionar una persona.',
                'is_natural_no_zero' => 'Persona seleccionada no válida.',
                'is_not_unique'      => 'La persona seleccionada no existe en el sistema.',
            ],
            'nombre' => [
                'required'   => 'El nombre del plan de alimentación es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'fechainicio' => [
                'required'   => 'La fecha de inicio es obligatoria.',
                'valid_date' => 'Ingrese una fecha de inicio válida.',
            ],
            'fechafin' => [
                'valid_date' => 'Ingrese una fecha de fin válida.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fechaInicio = $this->request->getPost('fechainicio');
        $fechaFin    = trim($this->request->getPost('fechafin')) ?: null;

        if (!empty($fechaFin) && $fechaFin < $fechaInicio) {
            return redirect()->back()->withInput()->with('errors', [
                'fechafin' => 'La fecha de fin no puede ser anterior a la fecha de inicio.'
            ]);
        }

        $this->planModel->update($id, [
            'idpersona'   => (int)$this->request->getPost('idpersona'),
            'nombre'      => trim($this->request->getPost('nombre')),
            'fechainicio' => $fechaInicio,
            'fechafin'    => $fechaFin,
            'objetivo'    => trim($this->request->getPost('objetivo')) ?: null,
        ]);

        return redirect()->to(base_url('planalimentacion/actual/' . $id))->with('success', 'Plan de alimentación actualizado exitosamente.');
    }

    public function delete($id)
    {
        $plan = $this->planModel->find($id);
        if (!$plan) {
            return redirect()->to(base_url('planalimentacion'))->with('error', 'Plan no encontrado.');
        }

        try {
            $this->planModel->delete($id);
            $first = $this->planModel->elprimero();
            $targetUrl = $first ? 'planalimentacion/actual/' . $first['idplanalimentacion'] : 'planalimentacion';
            return redirect()->to(base_url($targetUrl))->with('success', 'Plan de alimentación eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('planalimentacion/actual/' . $id))->with('error', 'No se puede eliminar el plan: ' . $e->getMessage());
        }
    }
}
