<?php

namespace App\Controllers;

use App\Models\EjercicioEquipoModel;
use App\Models\EjercicioModel;
use App\Models\EquipoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EjercicioEquipo extends BaseController
{
    protected EjercicioEquipoModel $eeModel;
    protected EjercicioModel $ejercicioModel;
    protected EquipoModel $equipoModel;

    public function __construct()
    {
        $this->eeModel = new EjercicioEquipoModel();
        $this->ejercicioModel = new EjercicioModel();
        $this->equipoModel = new EquipoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->eeModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->eeModel->elprimero();
            $record = $first ? $this->eeModel->getRecordWithDetails((int)$first['idejercicioequipo']) : null;
        }

        $data = [
            'title'  => 'Relación Ejercicio - Equipo' . ($record ? ': #' . $record['idejercicioequipo'] : ''),
            'rel'    => $record,
            'tipos'  => EquipoModel::getTipos(),
            'module' => 'ejercicioequipo',
        ];

        return view('ejercicioequipo/ejercicioequipo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->eeModel->elprimero();
        return $this->actual($first ? $first['idejercicioequipo'] : null);
    }

    public function elultimo()
    {
        $last = $this->eeModel->elultimo();
        return $this->actual($last ? $last['idejercicioequipo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->eeModel->siguiente($id);
        return $this->actual($next ? $next['idejercicioequipo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->eeModel->anterior($id);
        return $this->actual($prev ? $prev['idejercicioequipo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $listado = $this->eeModel->getListado($search, 20);

        $data = [
            'title'   => 'Relaciones Ejercicio - Equipamiento',
            'listado' => $listado,
            'pager'   => $this->eeModel->pager,
            'search'  => $search,
            'total'   => $this->eeModel->pager ? $this->eeModel->pager->getTotal() : count($listado),
            'module'  => 'ejercicioequipo',
        ];

        return view('ejercicioequipo/ejercicioequipo_list', $data);
    }

    public function add()
    {
        $data = [
            'title'             => 'Asignar Equipo a Ejercicio',
            'ejercicios'        => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'equipos'           => $this->equipoModel->orderBy('nombre', 'ASC')->findAll(),
            'selectedEjercicio' => $this->request->getGet('idejercicio') ?? '',
            'module'            => 'ejercicioequipo',
        ];

        return view('ejercicioequipo/ejercicioequipo_form', $data);
    }

    public function save()
    {
        $rules = [
            'idejercicio' => 'required|is_natural_no_zero',
            'idequipo'    => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idejercicio = (int)$this->request->getPost('idejercicio');
        $idequipo    = (int)$this->request->getPost('idequipo');

        // Validar duplicidad
        $exists = $this->eeModel->where('idejercicio', $idejercicio)
                                ->where('idequipo', $idequipo)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este equipo ya está asignado al ejercicio seleccionado.');
        }

        $id = $this->eeModel->insert([
            'idejercicio' => $idejercicio,
            'idequipo'    => $idequipo,
        ]);

        return redirect()->to(base_url('ejercicioequipo/actual/' . $id))
                         ->with('success', 'Equipo asignado al ejercicio correctamente.');
    }

    public function edit($id)
    {
        $rel = $this->eeModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Relación no encontrada.");
        }

        $data = [
            'title'      => 'Editar Asignación de Equipo',
            'rel'        => $rel,
            'ejercicios' => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'equipos'    => $this->equipoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'ejercicioequipo',
        ];

        return view('ejercicioequipo/ejercicioequipo_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->eeModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('ejercicioequipo'))->with('error', 'Relación no encontrada.');
        }

        $rules = [
            'idejercicio' => 'required|is_natural_no_zero',
            'idequipo'    => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idejercicio = (int)$this->request->getPost('idejercicio');
        $idequipo    = (int)$this->request->getPost('idequipo');

        // Validar duplicidad con otro registro
        $exists = $this->eeModel->where('idejercicio', $idejercicio)
                                ->where('idequipo', $idequipo)
                                ->where('idejercicioequipo !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese ejercicio y equipo.');
        }

        $this->eeModel->update($id, [
            'idejercicio' => $idejercicio,
            'idequipo'    => $idequipo,
        ]);

        return redirect()->to(base_url('ejercicioequipo/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->eeModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('ejercicioequipo'))->with('error', 'Relación no encontrada.');
        }

        $this->eeModel->delete($id);

        $first = $this->eeModel->elprimero();
        $targetUrl = $first ? 'ejercicioequipo/actual/' . $first['idejercicioequipo'] : 'ejercicioequipo';

        return redirect()->to(base_url($targetUrl))
                         ->with('success', 'Relación eliminada exitosamente.');
    }
}
