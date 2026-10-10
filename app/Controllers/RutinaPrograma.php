<?php

namespace App\Controllers;

use App\Models\RutinaProgramaModel;
use App\Models\ProgramaEntrenamientoModel;
use App\Models\RutinaEjecicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RutinaPrograma extends BaseController
{
    protected RutinaProgramaModel $rutinaProgramaModel;
    protected ProgramaEntrenamientoModel $programaModel;
    protected RutinaEjecicioModel $rutinaModel;

    public function __construct()
    {
        $this->rutinaProgramaModel = new RutinaProgramaModel();
        $this->programaModel       = new ProgramaEntrenamientoModel();
        $this->rutinaModel         = new RutinaEjecicioModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $rutinaprograma = $this->rutinaProgramaModel->getRutinaProgramaWithDetails($id);
        } else {
            $last = $this->rutinaProgramaModel->elultimo();
            $rutinaprograma = $last ? $this->rutinaProgramaModel->getRutinaProgramaWithDetails($last['idrutinaprograma']) : null;
        }

        $data = [
            'title'          => 'Ficha de Rutina en Programa',
            'rutinaprograma' => $rutinaprograma,
            'module'         => 'rutinaprograma',
        ];

        return view('rutinaprograma/rutinaprograma_record', $data);
    }

    public function elprimero()
    {
        $first = $this->rutinaProgramaModel->elprimero();
        return $this->actual($first ? $first['idrutinaprograma'] : null);
    }

    public function elultimo()
    {
        $last = $this->rutinaProgramaModel->elultimo();
        return $this->actual($last ? $last['idrutinaprograma'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->rutinaProgramaModel->siguiente($id);
        return $this->actual($next ? $next['idrutinaprograma'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->rutinaProgramaModel->anterior($id);
        return $this->actual($prev ? $prev['idrutinaprograma'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $rutinasprogramas = $this->rutinaProgramaModel->getRutinasProgramasWithDetails($search);

        $data = [
            'title'            => 'Listado de Rutinas en Programas',
            'rutinasprogramas' => $rutinasprogramas,
            'search'           => $search,
            'module'           => 'rutinaprograma',
        ];

        return view('rutinaprograma/rutinaprograma_list', $data);
    }

    public function add()
    {
        $idProgPreselected   = $this->request->getGet('idprogramaentrenamiento') ?? $this->request->getGet('idprograma');
        $idRutinaPreselected = $this->request->getGet('idrutinaejercicio') ?? $this->request->getGet('idrutina');

        $data = [
            'title'               => 'Vincular Rutina a Programa de Entrenamiento',
            'programas'           => $this->programaModel->orderBy('nombre', 'ASC')->findAll(),
            'rutinas'             => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'idProgPreselected'   => $idProgPreselected,
            'idRutinaPreselected' => $idRutinaPreselected,
            'module'              => 'rutinaprograma',
        ];

        return view('rutinaprograma/rutinaprograma_form', $data);
    }

    public function save()
    {
        $rules = [
            'idprogramaentrenamiento' => 'required|is_natural_no_zero',
            'idrutinaejercicio'       => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idProg   = (int)$this->request->getPost('idprogramaentrenamiento');
        $idRutina = (int)$this->request->getPost('idrutinaejercicio');

        // Validar si ya existe este vínculo
        if ($this->rutinaProgramaModel->isAssigned($idProg, $idRutina)) {
            return redirect()->back()->withInput()->with('errors', [
                'idrutinaejercicio' => 'Esta rutina ya se encuentra vinculada a dicho programa de entrenamiento.'
            ]);
        }

        $id = $this->rutinaProgramaModel->insert([
            'idprogramaentrenamiento' => $idProg,
            'idrutinaejercicio'       => $idRutina,
        ]);

        return redirect()->to(base_url('rutinaprograma/actual/' . $id))->with('success', 'Rutina vinculada al programa exitosamente.');
    }

    public function edit($id)
    {
        $rutinaprograma = $this->rutinaProgramaModel->find($id);
        if (!$rutinaprograma) {
            throw PageNotFoundException::forPageNotFound("Vínculo de rutina a programa no encontrado.");
        }

        $data = [
            'title'          => 'Editar Vínculo Rutina - Programa #' . $id,
            'rutinaprograma' => $rutinaprograma,
            'programas'      => $this->programaModel->orderBy('nombre', 'ASC')->findAll(),
            'rutinas'        => $this->rutinaModel->orderBy('nombre', 'ASC')->findAll(),
            'module'         => 'rutinaprograma',
        ];

        return view('rutinaprograma/rutinaprograma_edit', $data);
    }

    public function update($id)
    {
        $rutinaprograma = $this->rutinaProgramaModel->find($id);
        if (!$rutinaprograma) {
            throw PageNotFoundException::forPageNotFound("Vínculo de rutina a programa no encontrado.");
        }

        $rules = [
            'idprogramaentrenamiento' => 'required|is_natural_no_zero',
            'idrutinaejercicio'       => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idProg   = (int)$this->request->getPost('idprogramaentrenamiento');
        $idRutina = (int)$this->request->getPost('idrutinaejercicio');

        // Si cambian valores, verificar duplicidad
        if (($idProg != $rutinaprograma['idprogramaentrenamiento'] || $idRutina != $rutinaprograma['idrutinaejercicio']) 
            && $this->rutinaProgramaModel->isAssigned($idProg, $idRutina)) {
            return redirect()->back()->withInput()->with('errors', [
                'idrutinaejercicio' => 'Esta rutina ya se encuentra vinculada a dicho programa de entrenamiento.'
            ]);
        }

        $this->rutinaProgramaModel->update($id, [
            'idprogramaentrenamiento' => $idProg,
            'idrutinaejercicio'       => $idRutina,
        ]);

        return redirect()->to(base_url('rutinaprograma/actual/' . $id))->with('success', 'Vínculo actualizado correctamente.');
    }

    public function delete($id)
    {
        $rutinaprograma = $this->rutinaProgramaModel->find($id);
        if (!$rutinaprograma) {
            throw PageNotFoundException::forPageNotFound("Vínculo de rutina a programa no encontrado.");
        }

        $this->rutinaProgramaModel->delete($id);

        return redirect()->to(base_url('rutinaprograma/listar'))->with('success', 'Vínculo eliminado exitosamente.');
    }
}
