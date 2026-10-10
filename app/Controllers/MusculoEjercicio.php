<?php

namespace App\Controllers;

use App\Models\MusculoEjercicioModel;
use App\Models\EjercicioModel;
use App\Models\MusculoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MusculoEjercicio extends BaseController
{
    protected MusculoEjercicioModel $meModel;
    protected EjercicioModel $ejercicioModel;
    protected MusculoModel $musculoModel;

    public function __construct()
    {
        $this->meModel = new MusculoEjercicioModel();
        $this->ejercicioModel = new EjercicioModel();
        $this->musculoModel = new MusculoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->meModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->meModel->elprimero();
            $record = $first ? $this->meModel->getRecordWithDetails((int)$first['idmusculoejecicio']) : null;
        }

        $data = [
            'title'  => 'Relación Músculo - Ejercicio' . ($record ? ': #' . $record['idmusculoejecicio'] : ''),
            'rel'    => $record,
            'module' => 'musculoejercicio',
        ];

        return view('musculoejercicio/musculoejercicio_record', $data);
    }

    public function elprimero()
    {
        $first = $this->meModel->elprimero();
        return $this->actual($first ? $first['idmusculoejecicio'] : null);
    }

    public function elultimo()
    {
        $last = $this->meModel->elultimo();
        return $this->actual($last ? $last['idmusculoejecicio'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->meModel->siguiente($id);
        return $this->actual($next ? $next['idmusculoejecicio'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->meModel->anterior($id);
        return $this->actual($prev ? $prev['idmusculoejecicio'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $listado = $this->meModel->getListado($search, 20);

        $data = [
            'title'   => 'Relaciones Músculo - Ejercicio',
            'listado' => $listado,
            'pager'   => $this->meModel->pager,
            'search'  => $search,
            'total'   => $this->meModel->pager ? $this->meModel->pager->getTotal() : count($listado),
            'module'  => 'musculoejercicio',
        ];

        return view('musculoejercicio/musculoejercicio_list', $data);
    }

    public function add()
    {
        $data = [
            'title'      => 'Asignar Músculo a Ejercicio',
            'ejercicios' => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'musculos'   => $this->musculoModel->orderBy('nombre', 'ASC')->findAll(),
            'selectedEjercicio' => $this->request->getGet('idejercicio') ?? '',
            'module'     => 'musculoejercicio',
        ];

        return view('musculoejercicio/musculoejercicio_form', $data);
    }

    public function save()
    {
        $rules = [
            'idejercicio' => 'required|is_natural_no_zero',
            'idmusculo'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idejercicio = (int) $this->request->getPost('idejercicio');
        $idmusculo   = (int) $this->request->getPost('idmusculo');

        // Verificar si ya existe
        $existing = $this->meModel->where('idejercicio', $idejercicio)
                                  ->where('idmusculo', $idmusculo)
                                  ->first();

        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Esta relación entre el ejercicio y el músculo ya existe.');
        }

        $id = $this->meModel->insert([
            'idejercicio' => $idejercicio,
            'idmusculo'   => $idmusculo,
        ]);

        return redirect()->to(base_url('musculoejercicio/actual/' . $id))->with('success', 'Relación asignada correctamente.');
    }

    public function edit($id)
    {
        $record = $this->meModel->find($id);
        if (!$record) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'      => 'Editar Relación Músculo - Ejercicio #' . $id,
            'rel'        => $record,
            'ejercicios' => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'musculos'   => $this->musculoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'musculoejercicio',
        ];

        return view('musculoejercicio/musculoejercicio_edit', $data);
    }

    public function update($id)
    {
        $record = $this->meModel->find($id);
        if (!$record) {
            return redirect()->to(base_url('musculoejercicio'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idejercicio' => 'required|is_natural_no_zero',
            'idmusculo'   => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idejercicio = (int) $this->request->getPost('idejercicio');
        $idmusculo   = (int) $this->request->getPost('idmusculo');

        // Verificar unicidad excluyendo el actual
        $existing = $this->meModel->where('idejercicio', $idejercicio)
                                  ->where('idmusculo', $idmusculo)
                                  ->where('idmusculoejecicio !=', $id)
                                  ->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra relación con este mismo ejercicio y músculo.');
        }

        $this->meModel->update($id, [
            'idejercicio' => $idejercicio,
            'idmusculo'   => $idmusculo,
        ]);

        return redirect()->to(base_url('musculoejercicio/actual/' . $id))->with('success', 'Relación actualizada exitosamente.');
    }

    public function delete($id)
    {
        $record = $this->meModel->find($id);
        if (!$record) {
            return redirect()->to(base_url('musculoejercicio'))->with('error', 'Registro no encontrado.');
        }

        $this->meModel->delete($id);
        $first = $this->meModel->elprimero();
        $target = $first ? 'musculoejercicio/actual/' . $first['idmusculoejecicio'] : 'musculoejercicio';

        return redirect()->to(base_url($target))->with('success', 'Relación eliminada exitosamente.');
    }
}
