<?php

namespace App\Controllers;

use App\Models\EntretenimientoVideoModel;
use App\Models\EntretenimientoModel;
use App\Models\VideoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EntretenimientoVideo extends BaseController
{
    protected EntretenimientoVideoModel $evModel;
    protected EntretenimientoModel $entretenimientoModel;
    protected VideoModel $videoModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->evModel              = new EntretenimientoVideoModel();
        $this->entretenimientoModel = new EntretenimientoModel();
        $this->videoModel           = new VideoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->evModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->evModel->elprimero();
            $record = $first ? $this->evModel->getRecordWithDetails((int)$first['identretenimientovideo']) : null;
        }

        $data = [
            'title'  => 'Relación Entretenimiento - Video' . ($record ? ': #' . $record['identretenimientovideo'] : ''),
            'rel'    => $record,
            'module' => 'entretenimientovideo',
        ];

        return view('entretenimientovideo/entretenimientovideo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->evModel->elprimero();
        return $this->actual($first ? $first['identretenimientovideo'] : null);
    }

    public function elultimo()
    {
        $last = $this->evModel->elultimo();
        return $this->actual($last ? $last['identretenimientovideo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->evModel->siguiente((int)$id);
        return $this->actual($next ? $next['identretenimientovideo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->evModel->anterior((int)$id);
        return $this->actual($prev ? $prev['identretenimientovideo'] : $id);
    }

    public function listar()
    {
        $search            = $this->request->getGet('q');
        $identretenimiento = $this->request->getGet('identretenimiento');
        $idvideo           = $this->request->getGet('idvideo');

        $identretenimiento = (!empty($identretenimiento) && is_numeric($identretenimiento)) ? (int)$identretenimiento : null;
        $idvideo           = (!empty($idvideo) && is_numeric($idvideo)) ? (int)$idvideo : null;

        $listado          = $this->evModel->getRecordsWithDetails($search, $identretenimiento, $idvideo);
        $entretenimientos = $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll();
        $videos           = $this->videoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'                   => 'Videos por Entretenimiento',
            'listado'                 => $listado,
            'entretenimientos'        => $entretenimientos,
            'videos'                  => $videos,
            'selectedEntretenimiento' => $identretenimiento,
            'selectedVideo'           => $idvideo,
            'search'                  => $search,
            'module'                  => 'entretenimientovideo',
        ];

        return view('entretenimientovideo/entretenimientovideo_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                      => 'Asignar Video a Entretenimiento',
            'entretenimientos'           => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'videos'                     => $this->videoModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedEntretenimiento' => $this->request->getGet('identretenimiento'),
            'preselectedVideo'           => $this->request->getGet('idvideo'),
            'module'                     => 'entretenimientovideo',
        ];

        return view('entretenimientovideo/entretenimientovideo_form', $data);
    }

    public function save()
    {
        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idvideo'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idvideo           = (int)$this->request->getPost('idvideo');

        $exists = $this->evModel->where('identretenimiento', $identretenimiento)
                                ->where('idvideo', $idvideo)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este entretenimiento ya tiene asignado este video.');
        }

        $id = $this->evModel->insert([
            'identretenimiento' => $identretenimiento,
            'idvideo'           => $idvideo,
        ]);

        return redirect()->to(base_url('entretenimientovideo/actual/' . $id))
                         ->with('success', 'Video asignado al entretenimiento exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->evModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'            => 'Editar Asignación Entretenimiento - Video #' . $id,
            'rel'              => $rel,
            'entretenimientos' => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'videos'           => $this->videoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'entretenimientovideo',
        ];

        return view('entretenimientovideo/entretenimientovideo_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->evModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientovideo'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idvideo'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idvideo           = (int)$this->request->getPost('idvideo');

        $exists = $this->evModel->where('identretenimiento', $identretenimiento)
                                ->where('idvideo', $idvideo)
                                ->where('identretenimientovideo !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese mismo entretenimiento y video.');
        }

        $this->evModel->update($id, [
            'identretenimiento' => $identretenimiento,
            'idvideo'           => $idvideo,
        ]);

        return redirect()->to(base_url('entretenimientovideo/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->evModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientovideo'))->with('error', 'Registro no encontrado.');
        }

        $this->evModel->delete($id);
        $first = $this->evModel->elprimero();
        $targetUrl = $first ? 'entretenimientovideo/actual/' . $first['identretenimientovideo'] : 'entretenimientovideo';
        return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
    }
}
