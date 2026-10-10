<?php

namespace App\Controllers;

use App\Models\ProgramaEntrenamientoModel;
use App\Models\MotivoEntrenamientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProgramaEntrenamiento extends BaseController
{
    protected ProgramaEntrenamientoModel $peModel;
    protected MotivoEntrenamientoModel $motivoModel;

    public function __construct()
    {
        $this->peModel     = new ProgramaEntrenamientoModel();
        $this->motivoModel = new MotivoEntrenamientoModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $programa = $this->peModel->getProgramaWithDetails($id);
        } else {
            $last = $this->peModel->elultimo();
            $programa = $last ? $this->peModel->getProgramaWithDetails($last['idprogramaentrenamiento']) : null;
        }

        $data = [
            'title'    => 'Ficha de Programa de Entrenamiento',
            'programa' => $programa,
            'module'   => 'programaentrenamiento',
        ];

        return view('programaentrenamiento/programaentrenamiento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->peModel->elprimero();
        return $this->actual($first ? $first['idprogramaentrenamiento'] : null);
    }

    public function elultimo()
    {
        $last = $this->peModel->elultimo();
        return $this->actual($last ? $last['idprogramaentrenamiento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->peModel->siguiente($id);
        return $this->actual($next ? $next['idprogramaentrenamiento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->peModel->anterior($id);
        return $this->actual($prev ? $prev['idprogramaentrenamiento'] : $id);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search    = $this->request->getGet('q');
        $programas = $this->peModel->getProgramasWithDetails($search);

        $data = [
            'title'     => 'Listado de Programas de Entrenamiento',
            'programas' => $programas,
            'search'    => $search,
            'module'    => 'programaentrenamiento',
        ];

        return view('programaentrenamiento/programaentrenamiento_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $idmotivoPreselected = $this->request->getGet('idmotivo') ?? $this->request->getGet('idmotivoentrenamiento');

        $data = [
            'title'               => 'Crear Programa de Entrenamiento',
            'motivos'             => $this->motivoModel->orderBy('nombre', 'ASC')->findAll(),
            'idmotivoPreselected' => $idmotivoPreselected,
            'module'              => 'programaentrenamiento',
        ];

        return view('programaentrenamiento/programaentrenamiento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'                => 'required|min_length[3]|max_length[100]',
            'idmotivoentrenamiento' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->peModel->insert([
            'nombre'                => trim($this->request->getPost('nombre')),
            'idmotivoentrenamiento' => (int)$this->request->getPost('idmotivoentrenamiento'),
        ]);

        return redirect()->to(base_url('programaentrenamiento/actual/' . $id))->with('success', 'Programa de entrenamiento registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $programa = $this->peModel->find($id);
        if (!$programa) {
            throw PageNotFoundException::forPageNotFound("Programa de entrenamiento no encontrado.");
        }

        $data = [
            'title'    => 'Editar Programa de Entrenamiento #' . $id,
            'programa' => $programa,
            'motivos'  => $this->motivoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'   => 'programaentrenamiento',
        ];

        return view('programaentrenamiento/programaentrenamiento_edit', $data);
    }

    public function update($id)
    {
        $programa = $this->peModel->find($id);
        if (!$programa) {
            return redirect()->to(base_url('programaentrenamiento'))->with('error', 'Programa no encontrado.');
        }

        $rules = [
            'nombre'                => 'required|min_length[3]|max_length[100]',
            'idmotivoentrenamiento' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->peModel->update($id, [
            'nombre'                => trim($this->request->getPost('nombre')),
            'idmotivoentrenamiento' => (int)$this->request->getPost('idmotivoentrenamiento'),
        ]);

        return redirect()->to(base_url('programaentrenamiento/actual/' . $id))->with('success', 'Programa de entrenamiento actualizado exitosamente.');
    }

    public function delete($id)
    {
        $programa = $this->peModel->find($id);
        if (!$programa) {
            return redirect()->to(base_url('programaentrenamiento'))->with('error', 'Programa no encontrado.');
        }

        try {
            $this->peModel->delete($id);
            return redirect()->to(base_url('programaentrenamiento/elprimero'))->with('success', 'Programa de entrenamiento eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('programaentrenamiento/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
