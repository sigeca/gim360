<?php

namespace App\Controllers;

use App\Models\EquipoMusculoModel;
use App\Models\EquipoModel;
use App\Models\MusculoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EquipoMusculo extends BaseController
{
    protected EquipoMusculoModel $emModel;
    protected EquipoModel $equipoModel;
    protected MusculoModel $musculoModel;

    public function __construct()
    {
        $this->emModel = new EquipoMusculoModel();
        $this->equipoModel = new EquipoModel();
        $this->musculoModel = new MusculoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->emModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->emModel->elprimero();
            $record = $first ? $this->emModel->getRecordWithDetails((int)$first['idequipomusculo']) : null;
        }

        $data = [
            'title'  => 'Relación Equipo - Músculo' . ($record ? ': #' . $record['idequipomusculo'] : ''),
            'rel'    => $record,
            'tipos'  => EquipoModel::getTipos(),
            'module' => 'equipomusculo',
        ];

        return view('equipomusculo/equipomusculo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->emModel->elprimero();
        return $this->actual($first ? $first['idequipomusculo'] : null);
    }

    public function elultimo()
    {
        $last = $this->emModel->elultimo();
        return $this->actual($last ? $last['idequipomusculo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->emModel->siguiente($id);
        return $this->actual($next ? $next['idequipomusculo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->emModel->anterior($id);
        return $this->actual($prev ? $prev['idequipomusculo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $listado = $this->emModel->getListado($search, 20);

        $data = [
            'title'   => 'Relaciones Equipo - Músculo',
            'listado' => $listado,
            'pager'   => $this->emModel->pager,
            'search'  => $search,
            'total'   => $this->emModel->pager ? $this->emModel->pager->getTotal() : count($listado),
            'tipos'   => EquipoModel::getTipos(),
            'module'  => 'equipomusculo',
        ];

        return view('equipomusculo/equipomusculo_list', $data);
    }

    public function add()
    {
        $data = [
            'title'          => 'Asignar Músculo a Equipo',
            'equipos'        => $this->equipoModel->orderBy('nombre', 'ASC')->findAll(),
            'musculos'       => $this->musculoModel->orderBy('nombre', 'ASC')->findAll(),
            'selectedEquipo' => $this->request->getGet('idequipo') ?? '',
            'module'         => 'equipomusculo',
        ];

        return view('equipomusculo/equipomusculo_form', $data);
    }

    public function save()
    {
        $rules = [
            'idequipo'  => 'required|is_natural_no_zero',
            'idmusculo' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idequipo  = (int)$this->request->getPost('idequipo');
        $idmusculo = (int)$this->request->getPost('idmusculo');

        // Validar unicidad
        $exists = $this->emModel->where('idequipo', $idequipo)
                                ->where('idmusculo', $idmusculo)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este músculo ya está vinculado al equipo seleccionado.');
        }

        $id = $this->emModel->insert([
            'idequipo'  => $idequipo,
            'idmusculo' => $idmusculo,
        ]);

        return redirect()->to(base_url('equipomusculo/actual/' . $id))
                         ->with('success', 'Relación equipo-músculo guardada con éxito.');
    }

    public function edit($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Relación no encontrada.");
        }

        $data = [
            'title'    => 'Editar Relación Equipo - Músculo #' . $id,
            'rel'      => $rel,
            'equipos'  => $this->equipoModel->orderBy('nombre', 'ASC')->findAll(),
            'musculos' => $this->musculoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'   => 'equipomusculo',
        ];

        return view('equipomusculo/equipomusculo_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('equipomusculo'))->with('error', 'Relación no encontrada.');
        }

        $rules = [
            'idequipo'  => 'required|is_natural_no_zero',
            'idmusculo' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idequipo  = (int)$this->request->getPost('idequipo');
        $idmusculo = (int)$this->request->getPost('idmusculo');

        // Validar que no se duplique con otra relación existente
        $exists = $this->emModel->where('idequipo', $idequipo)
                                ->where('idmusculo', $idmusculo)
                                ->where('idequipomusculo !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese equipo y músculo.');
        }

        $this->emModel->update($id, [
            'idequipo'  => $idequipo,
            'idmusculo' => $idmusculo,
        ]);

        return redirect()->to(base_url('equipomusculo/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('equipomusculo'))->with('error', 'Relación no encontrada.');
        }

        $this->emModel->delete($id);

        $first = $this->emModel->elprimero();
        $targetUrl = $first ? 'equipomusculo/actual/' . $first['idequipomusculo'] : 'equipomusculo';

        return redirect()->to(base_url($targetUrl))
                         ->with('success', 'Relación eliminada exitosamente.');
    }
}
