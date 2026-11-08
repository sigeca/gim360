<?php

namespace App\Controllers;

use App\Models\MiEntretenimientoVideoModel;
use App\Models\MiEntretenimientoModel;
use App\Models\VideoModel;
use App\Models\EntretenimientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiEntretenimientoVideo extends BaseController
{
    protected MiEntretenimientoVideoModel $model;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->model = new MiEntretenimientoVideoModel();
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
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmientretenimientovideo']) : null;
        }

        $data = [
            'title'    => 'Relación Mi Entretenimiento - Video',
            'relacion' => $rel,
            'module'   => 'mientretenimientovideo',
        ];

        return view('mientretenimientovideo/mientretenimientovideo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmientretenimientovideo'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmientretenimientovideo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmientretenimientovideo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmientretenimientovideo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmientretenimiento = $this->request->getGet('idmientretenimiento');
        $idvideo = $this->request->getGet('idvideo');

        $data = [
            'title'               => 'Listado Mi Entretenimiento - Video',
            'relaciones'          => $this->model->getRecordsWithDetails($search, $idmientretenimiento ? (int)$idmientretenimiento : null, $idvideo ? (int)$idvideo : null),
            'search'              => $search,
            'idmientretenimiento' => $idmientretenimiento,
            'idvideo'             => $idvideo,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'videos'              => (new VideoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientovideo',
        ];

        return view('mientretenimientovideo/mientretenimientovideo_list', $data);
    }

    public function add()
    {
        $data = [
            'title'               => 'Vincular Video a Mi Entretenimiento',
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'videos'              => (new VideoModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMiEntre'   => $this->request->getGet('idmientretenimiento'),
            'selectedIdVideo'     => $this->request->getGet('idvideo'),
            'module'              => 'mientretenimientovideo',
        ];

        return view('mientretenimientovideo/mientretenimientovideo_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idvideo'             => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idvideo = (int)$this->request->getPost('idvideo');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idvideo', $idvideo)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este video ya está vinculado a este registro de Mi Entretenimiento.');
        }

        $id = $this->model->insert([
            'idmientretenimiento' => $idmientretenimiento,
            'idvideo'             => $idvideo,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Video vinculado exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'               => 'Editar Relación Mi Entretenimiento - Video #' . $id,
            'relacion'            => $rel,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'videos'              => (new VideoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientovideo',
        ];

        return view('mientretenimientovideo/mientretenimientovideo_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientovideo'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idvideo'             => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idvideo = (int)$this->request->getPost('idvideo');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idvideo', $idvideo)
                              ->where('idmientretenimientovideo !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de Mi Entretenimiento y Video ya existe.');
        }

        $this->model->update($id, [
            'idmientretenimiento' => $idmientretenimiento,
            'idvideo'             => $idvideo,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientovideo'))->with('error', 'Registro no encontrado.');
        }

        $idmientretenimiento = $rel['idmientretenimiento'];
        $this->model->delete($id);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Video desvinculado exitosamente.');
    }
}
