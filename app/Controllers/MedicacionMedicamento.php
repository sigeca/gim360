<?php

namespace App\Controllers;

use App\Models\MedicacionMedicamentoModel;
use App\Models\MedicacionModel;
use App\Models\MedicamentoModel;
use App\Models\AfeccionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MedicacionMedicamento extends BaseController
{
    protected MedicacionMedicamentoModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new MedicacionMedicamentoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $rel = $this->model->getRecordWithDetails((int)$id);
        } else {
            $first = $this->model->elprimero();
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmedicacionmedicamento']) : null;
        }

        $data = [
            'title'    => 'Detalle Medicación - Medicamento',
            'relacion' => $rel,
            'module'   => 'medicacionmedicamento',
        ];

        return view('medicacionmedicamento/medicacionmedicamento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmedicacionmedicamento'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmedicacionmedicamento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmedicacionmedicamento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmedicacionmedicamento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmedicacion = $this->request->getGet('idmedicacion');
        $idmedicamento = $this->request->getGet('idmedicamento');

        $data = [
            'title'         => 'Listado Medicación - Medicamentos',
            'relaciones'    => $this->model->getRecordsWithDetails($search, $idmedicacion ? (int)$idmedicacion : null, $idmedicamento ? (int)$idmedicamento : null),
            'search'        => $search,
            'idmedicacion'  => $idmedicacion,
            'idmedicamento' => $idmedicamento,
            'medicaciones'  => (new MedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos'  => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'        => 'medicacionmedicamento',
        ];

        return view('medicacionmedicamento/medicacionmedicamento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                 => 'Vincular Medicamento a Medicación',
            'medicaciones'          => (new MedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos'          => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMedicacion'  => $this->request->getGet('idmedicacion'),
            'selectedIdMedicamento' => $this->request->getGet('idmedicamento'),
            'module'                => 'medicacionmedicamento',
        ];

        return view('medicacionmedicamento/medicacionmedicamento_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmedicacion'  => 'required|is_natural_no_zero',
            'idmedicamento' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmedicacion = (int)$this->request->getPost('idmedicacion');
        $idmedicamento = (int)$this->request->getPost('idmedicamento');

        $exists = $this->model->where('idmedicacion', $idmedicacion)
                              ->where('idmedicamento', $idmedicamento)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este medicamento ya está vinculado a esta medicación.');
        }

        $id = $this->model->insert([
            'idmedicacion'  => $idmedicacion,
            'idmedicamento' => $idmedicamento,
            'dosis'         => trim((string)$this->request->getPost('dosis')) ?: null,
            'frecuencia'    => trim((string)$this->request->getPost('frecuencia')) ?: null,
            'instrucciones' => trim((string)$this->request->getPost('instrucciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                         ->with('success', 'Medicamento vinculado exitosamente a la medicación.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'        => 'Editar Medicación - Medicamento #' . $id,
            'relacion'     => $rel,
            'medicaciones' => (new MedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos' => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'       => 'medicacionmedicamento',
        ];

        return view('medicacionmedicamento/medicacionmedicamento_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('medicacionmedicamento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmedicacion'  => 'required|is_natural_no_zero',
            'idmedicamento' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmedicacion = (int)$this->request->getPost('idmedicacion');
        $idmedicamento = (int)$this->request->getPost('idmedicamento');

        $exists = $this->model->where('idmedicacion', $idmedicacion)
                              ->where('idmedicamento', $idmedicamento)
                              ->where('idmedicacionmedicamento !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de medicación y medicamento ya existe.');
        }

        $this->model->update($id, [
            'idmedicacion'  => $idmedicacion,
            'idmedicamento' => $idmedicamento,
            'dosis'         => trim((string)$this->request->getPost('dosis')) ?: null,
            'frecuencia'    => trim((string)$this->request->getPost('frecuencia')) ?: null,
            'instrucciones' => trim((string)$this->request->getPost('instrucciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                         ->with('success', 'Registro actualizado correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('medicacionmedicamento'))->with('error', 'Registro no encontrado.');
        }

        $idmedicacion = $rel['idmedicacion'];
        $this->model->delete($id);

        return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                         ->with('success', 'Medicamento desvinculado de la medicación.');
    }
}
