<?php

namespace App\Controllers;

use App\Models\MiMedicacionModel;
use App\Models\MiMedicacionMedicamentoModel;
use App\Models\MedicacionModel;
use App\Models\MedicamentoModel;
use App\Models\AfeccionModel;
use App\Models\PersonaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiMedicacion extends BaseController
{
    protected MiMedicacionModel $model;

    public function __construct()
    {
        AfeccionModel::ensureMedicationTables();
        $this->model = new MiMedicacionModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $mimedicacion = $this->model->getMiMedicacionWithDetails((int)$id);
        } else {
            $first = $this->model->elprimero();
            $mimedicacion = $first ? $this->model->getMiMedicacionWithDetails((int)$first['idmimedicacion']) : null;
        }

        $data = [
            'title'                => 'Mi Medicación' . ($mimedicacion ? ': ' . $mimedicacion['nombre'] : ''),
            'mimedicacion'         => $mimedicacion,
            'catalogoMedicamentos' => (new MedicamentoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'               => 'mimedicacion',
        ];

        return view('mimedicacion/mimedicacion_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmimedicacion'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmimedicacion'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmimedicacion'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmimedicacion'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idpersona = $this->request->getGet('idpersona');
        $idafeccion = $this->request->getGet('idafeccion');

        $data = [
            'title'           => 'Catálogo de Mi Medicación (Tratamientos por Persona)',
            'misMedicaciones' => $this->model->getMisMedicacionesWithDetails($search, $idpersona ? (int)$idpersona : null, $idafeccion ? (int)$idafeccion : null),
            'personas'        => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'afecciones'      => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'idpersona'       => $idpersona,
            'idafeccion'      => $idafeccion,
            'search'          => $search,
            'module'          => 'mimedicacion',
        ];

        return view('mimedicacion/mimedicacion_list', $data);
    }

    public function add()
    {
        $idmedicacion = $this->request->getGet('idmedicacion');
        $idafeccion = $this->request->getGet('idafeccion');
        $idpersona = $this->request->getGet('idpersona') ?: session()->get('idpersona');

        $baseMedicacion = null;
        if (!empty($idmedicacion)) {
            $baseMedicacion = (new MedicacionModel())->getMedicacionWithDetails((int)$idmedicacion);
            if ($baseMedicacion && empty($idafeccion)) {
                $idafeccion = $baseMedicacion['idafeccion'];
            }
        }

        $data = [
            'title'                => 'Personalizar / Registrar Mi Medicación',
            'personas'             => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'afecciones'           => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicaciones'         => (new MedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdPersona'    => $idpersona,
            'selectedIdAfeccion'   => $idafeccion,
            'selectedIdMedicacion' => $idmedicacion,
            'baseMedicacion'       => $baseMedicacion,
            'module'               => 'mimedicacion',
        ];

        return view('mimedicacion/mimedicacion_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'nombre'    => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idpersona = (int)$this->request->getPost('idpersona');
        $idmedicacion = $this->request->getPost('idmedicacion') ? (int)$this->request->getPost('idmedicacion') : null;
        $idafeccion = $this->request->getPost('idafeccion') ? (int)$this->request->getPost('idafeccion') : null;
        $nombre = trim((string)$this->request->getPost('nombre'));
        $descripcion = trim((string)$this->request->getPost('descripcion')) ?: null;
        $clonarMedicamentos = (bool)$this->request->getPost('clonar_medicamentos');

        if (!empty($idmedicacion) && $clonarMedicamentos) {
            try {
                $id = $this->model->clonarDesdeMedicacion($idmedicacion, $idpersona, $nombre, $descripcion);
                return redirect()->to(base_url('mimedicacion/actual/' . $id))
                                 ->with('success', '¡Medicación personalizada guardada con éxito! Se copiaron automáticamente los medicamentos y dosis.');
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->with('error', 'Error al personalizar: ' . $e->getMessage());
            }
        }

        $id = $this->model->insert([
            'idpersona'      => $idpersona,
            'idafeccion'     => $idafeccion,
            'idmedicacion'   => $idmedicacion,
            'nombre'         => $nombre,
            'descripcion'    => $descripcion,
            'fechainicio'    => $this->request->getPost('fechainicio') ?: date('Y-m-d'),
            'fechafin'       => $this->request->getPost('fechafin') ?: null,
            'medicotratante' => trim((string)$this->request->getPost('medicotratante')) ?: null,
            'estado'         => trim((string)$this->request->getPost('estado')) ?: 'Activa',
        ]);

        return redirect()->to(base_url('mimedicacion/actual/' . $id))
                         ->with('success', 'Tratamiento de Mi Medicación creado exitosamente.');
    }

    /**
     * Acción directa de 1 clic para clonar/personalizar una medicación base para una persona
     */
    public function personalizar($idmedicacion = null)
    {
        $idmedicacion = $idmedicacion ?: $this->request->getPost('idmedicacion');
        $idpersona = $this->request->getPost('idpersona') ?: session()->get('idpersona');

        if (empty($idpersona)) {
            return redirect()->to(base_url('mimedicacion/add?idmedicacion=' . $idmedicacion));
        }

        try {
            $id = $this->model->clonarDesdeMedicacion((int)$idmedicacion, (int)$idpersona);
            return redirect()->to(base_url('mimedicacion/actual/' . $id))
                             ->with('success', '¡Medicación personalizada creada exitosamente en Mi Medicación!');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('medicacion/actual/' . $idmedicacion))
                             ->with('error', 'Error al personalizar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mimedicacion = $this->model->find($id);
        if (!$mimedicacion) {
            throw PageNotFoundException::forPageNotFound("Mi Medicación no encontrada.");
        }

        $data = [
            'title'        => 'Editar Mi Medicación #' . $id,
            'mimedicacion' => $mimedicacion,
            'personas'     => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'afecciones'   => (new AfeccionModel())->orderBy('nombre', 'ASC')->findAll(),
            'medicaciones' => (new MedicacionModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'       => 'mimedicacion',
        ];

        return view('mimedicacion/mimedicacion_edit', $data);
    }

    public function update($id)
    {
        $mimedicacion = $this->model->find($id);
        if (!$mimedicacion) {
            return redirect()->to(base_url('mimedicacion'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'nombre'    => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->model->update($id, [
            'idpersona'      => (int)$this->request->getPost('idpersona'),
            'idafeccion'     => $this->request->getPost('idafeccion') ? (int)$this->request->getPost('idafeccion') : null,
            'idmedicacion'   => $this->request->getPost('idmedicacion') ? (int)$this->request->getPost('idmedicacion') : null,
            'nombre'         => trim((string)$this->request->getPost('nombre')),
            'descripcion'    => trim((string)$this->request->getPost('descripcion')) ?: null,
            'fechainicio'    => $this->request->getPost('fechainicio') ?: null,
            'fechafin'       => $this->request->getPost('fechafin') ?: null,
            'medicotratante' => trim((string)$this->request->getPost('medicotratante')) ?: null,
            'estado'         => trim((string)$this->request->getPost('estado')) ?: 'Activa',
        ]);

        return redirect()->to(base_url('mimedicacion/actual/' . $id))
                         ->with('success', 'Mi Medicación actualizada correctamente.');
    }

    public function delete($id)
    {
        $mimedicacion = $this->model->find($id);
        if (!$mimedicacion) {
            return redirect()->to(base_url('mimedicacion'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->model->delete($id);
            $first = $this->model->elprimero();
            $targetUrl = $first ? 'mimedicacion/actual/' . $first['idmimedicacion'] : 'mimedicacion';
            return redirect()->to(base_url($targetUrl))->with('success', 'Registro de Mi Medicación eliminado exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mimedicacion/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Acción rápida para sumar un medicamento a Mi Medicación (seleccionado o nuevo)
     */
    public function agregarMedicamento($idmimedicacion)
    {
        $idmedicamento = $this->request->getPost('idmedicamento');
        if (empty($idmedicamento)) {
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
            return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                             ->with('error', 'Debe seleccionar un medicamento del catálogo o ingresar uno nuevo.');
        }

        $mmmModel = new MiMedicacionMedicamentoModel();
        try {
            $mmmModel->ignore(true)->insert([
                'idmimedicacion' => (int)$idmimedicacion,
                'idmedicamento'  => (int)$idmedicamento,
                'dosis'          => trim((string)$this->request->getPost('dosis')) ?: null,
                'frecuencia'     => trim((string)$this->request->getPost('frecuencia')) ?: null,
                'instrucciones'  => trim((string)$this->request->getPost('instrucciones')) ?: null,
            ]);

            return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                             ->with('success', 'Medicamento agregado a tu medicación personal.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mimedicacion/actual/' . $idmimedicacion))
                             ->with('error', 'Error al agregar medicamento: ' . $e->getMessage());
        }
    }
}
