<?php

namespace App\Controllers;

use App\Models\MiEntretenimientoPodcastModel;
use App\Models\MiEntretenimientoModel;
use App\Models\PodcastModel;
use App\Models\EntretenimientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiEntretenimientoPodcast extends BaseController
{
    protected MiEntretenimientoPodcastModel $model;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->model = new MiEntretenimientoPodcastModel();
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
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmientretenimientopodcast']) : null;
        }

        $data = [
            'title'    => 'Relación Mi Entretenimiento - Podcast',
            'relacion' => $rel,
            'module'   => 'mientretenimientopodcast',
        ];

        return view('mientretenimientopodcast/mientretenimientopodcast_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmientretenimientopodcast'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmientretenimientopodcast'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmientretenimientopodcast'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmientretenimientopodcast'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmientretenimiento = $this->request->getGet('idmientretenimiento');
        $idpodcast = $this->request->getGet('idpodcast');

        $data = [
            'title'               => 'Listado Mi Entretenimiento - Podcast',
            'relaciones'          => $this->model->getRecordsWithDetails($search, $idmientretenimiento ? (int)$idmientretenimiento : null, $idpodcast ? (int)$idpodcast : null),
            'search'              => $search,
            'idmientretenimiento' => $idmientretenimiento,
            'idpodcast'           => $idpodcast,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'podcasts'            => (new PodcastModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientopodcast',
        ];

        return view('mientretenimientopodcast/mientretenimientopodcast_list', $data);
    }

    public function add()
    {
        $data = [
            'title'               => 'Vincular Podcast a Mi Entretenimiento',
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'podcasts'            => (new PodcastModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMiEntre'   => $this->request->getGet('idmientretenimiento'),
            'selectedIdPodcast'   => $this->request->getGet('idpodcast'),
            'module'              => 'mientretenimientopodcast',
        ];

        return view('mientretenimientopodcast/mientretenimientopodcast_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idpodcast'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idpodcast = (int)$this->request->getPost('idpodcast');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idpodcast', $idpodcast)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este podcast ya está vinculado a este registro de Mi Entretenimiento.');
        }

        $id = $this->model->insert([
            'idmientretenimiento' => $idmientretenimiento,
            'idpodcast'           => $idpodcast,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Podcast vinculado exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'               => 'Editar Relación Mi Entretenimiento - Podcast #' . $id,
            'relacion'            => $rel,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'podcasts'            => (new PodcastModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientopodcast',
        ];

        return view('mientretenimientopodcast/mientretenimientopodcast_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientopodcast'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idpodcast'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idpodcast = (int)$this->request->getPost('idpodcast');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idpodcast', $idpodcast)
                              ->where('idmientretenimientopodcast !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de Mi Entretenimiento y Podcast ya existe.');
        }

        $this->model->update($id, [
            'idmientretenimiento' => $idmientretenimiento,
            'idpodcast'           => $idpodcast,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientopodcast'))->with('error', 'Registro no encontrado.');
        }

        $idmientretenimiento = $rel['idmientretenimiento'];
        $this->model->delete($id);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Podcast desvinculado exitosamente.');
    }
}
