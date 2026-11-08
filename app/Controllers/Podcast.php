<?php

namespace App\Controllers;

use App\Models\PodcastModel;
use App\Models\EntretenimientoModel;
use App\Models\EntretenimientoPodcastModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Podcast extends BaseController
{
    protected PodcastModel $podcastModel;
    protected EntretenimientoPodcastModel $epModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->podcastModel = new PodcastModel();
        $this->epModel      = new EntretenimientoPodcastModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $podcast = $this->podcastModel->find($id);
        } else {
            $first = $this->podcastModel->elprimero();
            $podcast = $first ?: null;
        }

        $entretenimientos = [];
        if ($podcast) {
            $entretenimientos = $this->epModel->getEntretenimientosByPodcast((int)$podcast['idpodcast']);
        }

        $data = [
            'title'            => 'Podcast' . ($podcast ? ': ' . $podcast['nombre'] : ''),
            'podcast'          => $podcast,
            'entretenimientos' => $entretenimientos,
            'module'           => 'podcast',
        ];

        return view('podcast/podcast_record', $data);
    }

    public function elprimero()
    {
        $first = $this->podcastModel->elprimero();
        return $this->actual($first ? $first['idpodcast'] : null);
    }

    public function elultimo()
    {
        $last = $this->podcastModel->elultimo();
        return $this->actual($last ? $last['idpodcast'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->podcastModel->siguiente((int)$id);
        return $this->actual($next ? $next['idpodcast'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->podcastModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idpodcast'] : $id);
    }

    public function listar()
    {
        $search   = $this->request->getGet('q');
        $podcasts = $this->podcastModel->getPodcasts($search);

        $data = [
            'title'    => 'Catálogo de Podcasts',
            'podcasts' => $podcasts,
            'search'   => $search,
            'module'   => 'podcast',
        ];

        return view('podcast/podcast_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Podcast',
            'module' => 'podcast',
        ];

        return view('podcast/podcast_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
            'enlace' => 'required|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->podcastModel->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'presentador' => trim((string)$this->request->getPost('presentador')) ?: null,
            'tema'        => trim((string)$this->request->getPost('tema')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('podcast/actual/' . $id))
                         ->with('success', 'Podcast registrado exitosamente.');
    }

    public function edit($id)
    {
        $podcast = $this->podcastModel->find($id);
        if (!$podcast) {
            throw PageNotFoundException::forPageNotFound("Podcast no encontrado.");
        }

        $data = [
            'title'   => 'Editar Podcast #' . $id,
            'podcast' => $podcast,
            'module'  => 'podcast',
        ];

        return view('podcast/podcast_edit', $data);
    }

    public function update($id)
    {
        $podcast = $this->podcastModel->find($id);
        if (!$podcast) {
            return redirect()->to(base_url('podcast'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
            'enlace' => 'required|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->podcastModel->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'presentador' => trim((string)$this->request->getPost('presentador')) ?: null,
            'tema'        => trim((string)$this->request->getPost('tema')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('podcast/actual/' . $id))
                         ->with('success', 'Podcast actualizado correctamente.');
    }

    public function delete($id)
    {
        $podcast = $this->podcastModel->find($id);
        if (!$podcast) {
            return redirect()->to(base_url('podcast'))->with('error', 'Registro no encontrado.');
        }

        $this->podcastModel->delete($id);
        $first = $this->podcastModel->elprimero();
        $targetUrl = $first ? 'podcast/actual/' . $first['idpodcast'] : 'podcast';
        return redirect()->to(base_url($targetUrl))->with('success', 'Podcast eliminado exitosamente.');
    }
}
