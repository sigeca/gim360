<?php

namespace App\Controllers;

use App\Models\MedicacionModel;
use App\Models\AfeccionModel;
use App\Models\MedicamentoModel;
use App\Models\MedicacionMedicamentoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Medicacion extends BaseController
{
    protected MedicacionModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new MedicacionModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $medicacion = $this->model->getMedicacionWithDetails((int)$id);
        } else {
            $first = $this->model->elprimero();
            $medicacion = $first ? $this->model->getMedicacionWithDetails((int)$first['idmedicacion']) : null;
        }

        $data = [
            'title'              => 'Medicación' . ($medicacion ? ': ' . $medicacion['nombre'] : ''),
            'medicacion'         => $medicacion,
            'catalogoMedicamentos' => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'             => 'medicacion',
        ];

        return view('medicacion/medicacion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmedicacion'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmedicacion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmedicacion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmedicacion'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idafeccion = $this->request->getGet('idafeccion');
        $medicaciones = $this->model->getMedicacionesWithDetails($search, $idafeccion ? (int)$idafeccion : null);

        $data = [
            'title'        => 'Catálogo de Medicaciones / Protocolos Médicos',
            'medicaciones' => $medicaciones,
            'afecciones'   => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'idafeccion'   => $idafeccion,
            'search'       => $search,
            'module'       => 'medicacion',
        ];

        return view('medicacion/medicacion_list', $data);
    }

    public function add()
    {
        $data = [
            'title'              => 'Registrar Nueva Medicación',
            'afecciones'         => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdAfeccion' => $this->request->getGet('idafeccion'),
            'module'             => 'medicacion',
        ];

        return view('medicacion/medicacion_form', $data);
    }

    public function save()
    {
        $rules = [
            'idafeccion' => 'required|is_natural_no_zero',
            'nombre'     => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->model->insert([
            'idafeccion'      => (int)$this->request->getPost('idafeccion'),
            'nombre'          => trim((string)$this->request->getPost('nombre')),
            'descripcion'     => trim((string)$this->request->getPost('descripcion')) ?: null,
            'duracion'        => trim((string)$this->request->getPost('duracion')) ?: null,
            'recomendaciones' => trim((string)$this->request->getPost('recomendaciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicacion/actual/' . $id))
                         ->with('success', 'Medicación registrada exitosamente. Ahora puedes vincular los medicamentos necesarios.');
    }

    public function edit($id)
    {
        $medicacion = $this->model->find($id);
        if (!$medicacion) {
            throw PageNotFoundException::forPageNotFound("Medicación no encontrada.");
        }

        $data = [
            'title'      => 'Editar Medicación #' . $id,
            'medicacion' => $medicacion,
            'afecciones' => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'medicacion',
        ];

        return view('medicacion/medicacion_edit', $data);
    }

    public function update($id)
    {
        $medicacion = $this->model->find($id);
        if (!$medicacion) {
            return redirect()->to(base_url('medicacion'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idafeccion' => 'required|is_natural_no_zero',
            'nombre'     => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'idafeccion'      => (int)$this->request->getPost('idafeccion'),
            'nombre'          => trim((string)$this->request->getPost('nombre')),
            'descripcion'     => trim((string)$this->request->getPost('descripcion')) ?: null,
            'duracion'        => trim((string)$this->request->getPost('duracion')) ?: null,
            'recomendaciones' => trim((string)$this->request->getPost('recomendaciones')) ?: null,
        ]);

        return redirect()->to(base_url('medicacion/actual/' . $id))
                         ->with('success', 'Medicación actualizada correctamente.');
    }

    public function delete($id)
    {
        $medicacion = $this->model->find($id);
        if (!$medicacion) {
            return redirect()->to(base_url('medicacion'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->model->delete($id);
            $first = $this->model->elprimero();
            $targetUrl = $first ? 'medicacion/actual/' . $first['idmedicacion'] : 'medicacion';
            return redirect()->to(base_url($targetUrl))->with('success', 'Medicación eliminada exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('medicacion/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Acción rápida para agregar un medicamento con dosis e instrucciones directamente a la medicación
     */
    public function agregarMedicamento($idmedicacion)
    {
        $idmedicamento = $this->request->getPost('idmedicamento');
        if (empty($idmedicamento)) {
            // Si el usuario ingresa un nuevo medicamento al vuelo
            $nuevoNombre = trim((string)$this->request->getPost('nuevo_nombre'));
            if (!empty($nuevoNombre)) {
                $medModel = new MedicamentoModel();
                $idmedicamento = $medModel->insert([
                    'nombre'          => $nuevoNombre,
                    'principioactivo' => trim((string)$this->request->getPost('nuevo_principioactivo')) ?: null,
                    'concentracion'   => trim((string)$this->request->getPost('nuevo_concentracion')) ?: null,
                    'presentacion'    => trim((string)$this->request->getPost('nuevo_presentacion')) ?: null,
                ]);
            }
        }

        if (empty($idmedicamento)) {
            return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                             ->with('error', 'Debe seleccionar un medicamento del catálogo o ingresar el nombre de uno nuevo.');
        }

        $mmModel = new MedicacionMedicamentoModel();
        try {
            $mmModel->ignore(true)->insert([
                'idmedicacion'  => (int)$idmedicacion,
                'idmedicamento' => (int)$idmedicamento,
                'dosis'         => trim((string)$this->request->getPost('dosis')) ?: null,
                'frecuencia'    => trim((string)$this->request->getPost('frecuencia')) ?: null,
                'instrucciones' => trim((string)$this->request->getPost('instrucciones')) ?: null,
            ]);

            return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                             ->with('success', 'Medicamento agregado a la medicación con éxito.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                             ->with('error', 'Error al vincular medicamento: ' . $e->getMessage());
        }
    }
}
