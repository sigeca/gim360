<?php

namespace App\Controllers;

use App\Models\RutinaEjecicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RutinaEjecicio extends BaseController
{
    protected RutinaEjecicioModel $rutinaModel;

    public function __construct()
    {
        $this->rutinaModel = new RutinaEjecicioModel();
    }

    protected function getModuleSlug(): string
    {
        return str_starts_with(uri_string(), 'rutinaejercicio') ? 'rutinaejercicio' : 'rutinaejecicio';
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $rutina = $id ? $this->rutinaModel->find($id) : $this->rutinaModel->elultimo();
        if ($rutina) {
            $rutina['planes'] = (new \App\Models\RutinaPlanModel())->getPlanesByRutina((int)$rutina['idrutinaejercicio']);
            $rutina['programas'] = (new \App\Models\RutinaProgramaModel())->getProgramasByRutina((int)$rutina['idrutinaejercicio']);
        }

        $data = [
            'title'  => 'Ficha de Rutina de Ejercicio',
            'rutina' => $rutina,
            'module' => $this->getModuleSlug(),
        ];

        return view('rutinaejecicio/rutinaejecicio_record', $data);
    }

    public function elprimero()
    {
        $rutina = $this->rutinaModel->elprimero();
        return $this->actual($rutina ? $rutina['idrutinaejercicio'] : null);
    }

    public function elultimo()
    {
        $rutina = $this->rutinaModel->elultimo();
        return $this->actual($rutina ? $rutina['idrutinaejercicio'] : null);
    }

    public function siguiente($id)
    {
        $rutina = $this->rutinaModel->siguiente($id);
        return $this->actual($rutina ? $rutina['idrutinaejercicio'] : $id);
    }

    public function anterior($id)
    {
        $rutina = $this->rutinaModel->anterior($id);
        return $this->actual($rutina ? $rutina['idrutinaejercicio'] : $id);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $slug    = $this->getModuleSlug();
        $search  = $this->request->getGet('q');
        $rutinas = $this->rutinaModel->getRutinas($search);

        $data = [
            'title'   => 'Catálogo de Rutinas de Ejercicio',
            'rutinas' => $rutinas,
            'search'  => $search,
            'module'  => $slug,
        ];

        return view('rutinaejecicio/rutinaejecicio_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nueva Rutina de Ejercicio',
            'module' => $this->getModuleSlug(),
        ];

        return view('rutinaejecicio/rutinaejecicio_form', $data);
    }

    public function save()
    {
        $slug = $this->getModuleSlug();

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[rutinaejecicio.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->rutinaModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url($slug . '/actual/' . $id))->with('success', 'Rutina de ejercicio registrada exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $rutina = $this->rutinaModel->find($id);
        if (!$rutina) {
            throw PageNotFoundException::forPageNotFound("Rutina de ejercicio no encontrada.");
        }

        $data = [
            'title'  => 'Editar Rutina de Ejercicio #' . $id,
            'rutina' => $rutina,
            'module' => $this->getModuleSlug(),
        ];

        return view('rutinaejecicio/rutinaejecicio_edit', $data);
    }

    public function update($id)
    {
        $slug = $this->getModuleSlug();

        $rutina = $this->rutinaModel->find($id);
        if (!$rutina) {
            return redirect()->to(base_url($slug))->with('error', 'Rutina de ejercicio no encontrada.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[rutinaejecicio.nombre,idrutinaejercicio,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->rutinaModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url($slug . '/actual/' . $id))->with('success', 'Rutina de ejercicio actualizada exitosamente.');
    }

    public function delete($id)
    {
        $slug = $this->getModuleSlug();

        $rutina = $this->rutinaModel->find($id);
        if (!$rutina) {
            return redirect()->to(base_url($slug))->with('error', 'Rutina de ejercicio no encontrada.');
        }

        try {
            $this->rutinaModel->delete($id);
            return redirect()->to(base_url($slug . '/elprimero'))->with('success', 'Rutina de ejercicio eliminada correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url($slug . '/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
