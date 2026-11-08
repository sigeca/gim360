<?php

namespace App\Controllers;

use App\Models\EntretenimientoPodcastModel;
use App\Models\EntretenimientoModel;
use App\Models\PodcastModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EntretenimientoPodcast extends BaseController
{
    protected EntretenimientoPodcastModel $epModel;
    protected EntretenimientoModel $entretenimientoModel;
    protected PodcastModel $podcastModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->epModel              = new EntretenimientoPodcastModel();
        $this->entretenimientoModel = new EntretenimientoModel();
        $this->podcastModel         = new PodcastModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->epModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->epModel->elprimero();
            $record = $first ? $this->epModel->getRecordWithDetails((int)$first['identretenimientopodcast']) : null;
        }

        $data = [
            'title'  => 'Relación Entretenimiento - Podcast' . ($record ? ': #' . $record['identretenimientopodcast'] : ''),
            'rel'    => $record,
            'module' => 'entretenimientopodcast',
        ];

        return view('entretenimientopodcast/entretenimientopodcast_record', $data);
    }

    public function elprimero()
    {
        $first = $this->epModel->elprimero();
        return $this->actual($first ? $first['identretenimientopodcast'] : null);
    }

    public function elultimo()
    {
        $last = $this->epModel->elultimo();
        return $this->actual($last ? $last['identretenimientopodcast'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->epModel->siguiente((int)$id);
        return $this->actual($next ? $next['identretenimientopodcast'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->epModel->anterior((int)$id);
        return $this->actual($prev ? $prev['identretenimientopodcast'] : $id);
    }

    public function listar()
    {
        $search            = $this->request->getGet('q');
        $identretenimiento = $this->request->getGet('identretenimiento');
        $idpodcast         = $this->request->getGet('idpodcast');

        $identretenimiento = (!empty($identretenimiento) && is_numeric($identretenimiento)) ? (int)$identretenimiento : null;
        $idpodcast         = (!empty($idpodcast) && is_numeric($idpodcast)) ? (int)$idpodcast : null;

        $listado          = $this->epModel->getRecordsWithDetails($search, $identretenimiento, $idpodcast);
        $entretenimientos = $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll();
        $podcasts         = $this->podcastModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'                   => 'Podcasts por Entretenimiento',
            'listado'                 => $listado,
            'entretenimientos'        => $entretenimientos,
            'podcasts'                => $podcasts,
            'selectedEntretenimiento' => $identretenimiento,
            'selectedPodcast'         => $idpodcast,
            'search'                  => $search,
            'module'                  => 'entretenimientopodcast',
        ];

        return view('entretenimientopodcast/entretenimientopodcast_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                      => 'Asignar Podcast a Entretenimiento',
            'entretenimientos'           => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'podcasts'                   => $this->podcastModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedEntretenimiento' => $this->request->getGet('identretenimiento'),
            'preselectedPodcast'         => $this->request->getGet('idpodcast'),
            'module'                     => 'entretenimientopodcast',
        ];

        return view('entretenimientopodcast/entretenimientopodcast_form', $data);
    }

    public function save()
    {
        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idpodcast'         => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idpodcast         = (int)$this->request->getPost('idpodcast');

        $exists = $this->epModel->where('identretenimiento', $identretenimiento)
                                ->where('idpodcast', $idpodcast)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este entretenimiento ya tiene asignado este podcast.');
        }

        $id = $this->epModel->insert([
            'identretenimiento' => $identretenimiento,
            'idpodcast'         => $idpodcast,
        ]);

        return redirect()->to(base_url('entretenimientopodcast/actual/' . $id))
                         ->with('success', 'Podcast asignado al entretenimiento exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->epModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'            => 'Editar Asignación Entretenimiento - Podcast #' . $id,
            'rel'              => $rel,
            'entretenimientos' => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'podcasts'         => $this->podcastModel->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'entretenimientopodcast',
        ];

        return view('entretenimientopodcast/entretenimientopodcast_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->epModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientopodcast'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idpodcast'         => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idpodcast         = (int)$this->request->getPost('idpodcast');

        $exists = $this->epModel->where('identretenimiento', $identretenimiento)
                                ->where('idpodcast', $idpodcast)
                                ->where('identretenimientopodcast !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese mismo entretenimiento y podcast.');
        }

        $this->epModel->update($id, [
            'identretenimiento' => $identretenimiento,
            'idpodcast'         => $idpodcast,
        ]);

        return redirect()->to(base_url('entretenimientopodcast/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->epModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientopodcast'))->with('error', 'Registro no encontrado.');
        }

        $this->epModel->delete($id);
        $first = $this->epModel->elprimero();
        $targetUrl = $first ? 'entretenimientopodcast/actual/' . $first['identretenimientopodcast'] : 'entretenimientopodcast';
        return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
    }
}
