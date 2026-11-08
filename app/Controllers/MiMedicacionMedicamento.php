<?php

namespace App\Controllers;

use App\Models\MiMedicacionMedicamentoModel;
use App\Models\MiMedicacionModel;
use App\Models\MedicamentoModel;
use App\Models\AfeccionModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiMedicacionMedicamento extends BaseController
{
    protected MiMedicacionMedicamentoModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new MiMedicacionMedicamentoModel();
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
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmimedicacionmedicamento']) : null;
        }

        $data = [
            'title'    => 'Detalle Mi Medicación - Medicamento',
            'relacion' => $rel,
            'module'   => 'mimedicacionmedicamento',
        ];

        return view('mimedicacionmedicamento/mimedicacionmedicamento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmimedicacionmedicamento'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmimedicacionmedicamento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmimedicacionmedicamento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmimedicacionmedicamento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmimedicacion = $this->request->getGet('idmimedicacion');
        $idmedicamento = $this->request->getGet('idmedicamento');

        $data = [
            'title'           => 'Listado Mi Medicación - Medicamentos',
            'relaciones'      => $this->model->getRecordsWithDetails($search, $idmimedicacion ? (int)$idmimedicacion : null, $idmedicamento ? (int)$idmedicamento : null),
            'search'          => $search,
            'idmimedicacion'  => $idmimedicacion,
            'idmedicamento'   => $idmedicamento,
            'misMedicaciones' => (new MiMedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos'    => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'          => 'mimedicacionmedicamento',
        ];

        return view('mimedicacionmedicamento/mimedicacionmedicamento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                 => 'Vincular Medicamento a Mi Medicación',
            'misMedicaciones'       => (new MiMedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos'          => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMiMedic'     => $this->request->getGet('idmimedicacion'),
            'selectedIdMedicamento' => $this->request->getGet('idmedicamento'),
            'module'                => 'mimedicacionmedicamento',
        ];

        return view('mimedicacionmedicamento/mimedicacionmedicamento_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmimedicacion' => 'required|is_natural_no_zero',
            'idmedicamento'  => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmimedicacion = (int)$this->request->getPost('idmimedicacion');
        $idmedicamento = (int)$this->request->getPost('idmedicamento');

        $exists = $this->model->where('idmimedicacion', $idmimedicacion)
                              ->where('idmedicamento', $idmedicamento)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este medicamento ya está vinculado a este tratamiento de Mi Medicación.');
        }

        $id = $this->model->insert([
            'idmimedicacion' => $idmimedicacion,
            'idmedicamento'  => $idmedicamento,
            'dosis'          => trim((string)$this->request->getPost('dosis')) ?: null,
            'frecuencia'     => trim((string)$this->request->getPost('frecuencia')) ?: null,
            'instrucciones'  => trim((string)$this->request->getPost('instrucciones')) ?: null,
        ]);

        return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                         ->with('success', 'Medicamento vinculado exitosamente a Mi Medicación.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'           => 'Editar Mi Medicación - Medicamento #' . $id,
            'relacion'        => $rel,
            'misMedicaciones' => (new MiMedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicamentos'    => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'          => 'mimedicacionmedicamento',
        ];

        return view('mimedicacionmedicamento/mimedicacionmedicamento_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mimedicacionmedicamento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmimedicacion' => 'required|is_natural_no_zero',
            'idmedicamento'  => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmimedicacion = (int)$this->request->getPost('idmimedicacion');
        $idmedicamento = (int)$this->request->getPost('idmedicamento');

        $exists = $this->model->where('idmimedicacion', $idmimedicacion)
                              ->where('idmedicamento', $idmedicamento)
                              ->where('idmimedicacionmedicamento !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de Mi Medicación y Medicamento ya existe.');
        }

        $this->model->update($id, [
            'idmimedicacion' => $idmimedicacion,
            'idmedicamento'  => $idmedicamento,
            'dosis'          => trim((string)$this->request->getPost('dosis')) ?: null,
            'frecuencia'     => trim((string)$this->request->getPost('frecuencia')) ?: null,
            'instrucciones'  => trim((string)$this->request->getPost('instrucciones')) ?: null,
        ]);

        return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                         ->with('success', 'Registro actualizado correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mimedicacionmedicamento'))->with('error', 'Registro no encontrado.');
        }

        $idmimedicacion = $rel['idmimedicacion'];
        $this->model->delete($id);

        return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                         ->with('success', 'Medicamento retirado de Mi Medicación.');
    }
}
