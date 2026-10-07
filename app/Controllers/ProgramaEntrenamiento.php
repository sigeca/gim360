<?php

namespace App\Controllers;

use App\Models\ProgramaEntrenamientoModel;
use App\Models\MotivoEntrenamientoModel;
use App\Models\RutinaEjecicioModel;
use App\Models\EjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProgramaEntrenamiento extends BaseController
{
    protected ProgramaEntrenamientoModel $peModel;
    protected MotivoEntrenamientoModel $motivoModel;
    protected RutinaEjecicioModel $rutinaModel;
    protected EjercicioModel $ejercicioModel;

    public function __construct()
    {
        $this->peModel        = new ProgramaEntrenamientoModel();
        $this->motivoModel    = new MotivoEntrenamientoModel();
        $this->rutinaModel    = new RutinaEjecicioModel();
        $this->ejercicioModel = new EjercicioModel();
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

        $youtubeId = null;
        if (!empty($programa['ejercicio_urlvideo'])) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $programa['ejercicio_urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        $data = [
            'title'     => 'Ficha de Programa de Entrenamiento',
            'programa'  => $programa,
            'youtubeId' => $youtubeId,
            'module'    => 'programaentrenamiento',
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
        $idmotivoPreselected   = $this->request->getGet('idmotivo');
        $idrutinaPreselected   = $this->request->getGet('idrutina');
        $idejercicioPreselected = $this->request->getGet('idejercicio');

        $data = [
            'title'                  => 'Crear Programa de Entrenamiento',
            'motivos'                => $this->motivoModel->orderBy('nombre', 'ASC')->findAll(),
            'rutinas'                => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'ejercicios'             => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'idmotivoPreselected'    => $idmotivoPreselected,
            'idrutinaPreselected'    => $idrutinaPreselected,
            'idejercicioPreselected' => $idejercicioPreselected,
            'module'                 => 'programaentrenamiento',
        ];

        return view('programaentrenamiento/programaentrenamiento_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmotivoentrenamiento' => 'required|is_natural_no_zero',
            'idrutinaejercicio'     => 'required|is_natural_no_zero',
            'idejercicio'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->peModel->insert([
            'idmotivoentrenamiento' => $this->request->getPost('idmotivoentrenamiento'),
            'idrutinaejercicio'     => $this->request->getPost('idrutinaejercicio'),
            'idejercicio'           => $this->request->getPost('idejercicio'),
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
            'title'      => 'Editar Programa de Entrenamiento #' . $id,
            'programa'   => $programa,
            'motivos'    => $this->motivoModel->orderBy('nombre', 'ASC')->findAll(),
            'rutinas'    => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'ejercicios' => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'module'     => 'programaentrenamiento',
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
            'idmotivoentrenamiento' => 'required|is_natural_no_zero',
            'idrutinaejercicio'     => 'required|is_natural_no_zero',
            'idejercicio'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->peModel->update($id, [
            'idmotivoentrenamiento' => $this->request->getPost('idmotivoentrenamiento'),
            'idrutinaejercicio'     => $this->request->getPost('idrutinaejercicio'),
            'idejercicio'           => $this->request->getPost('idejercicio'),
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
