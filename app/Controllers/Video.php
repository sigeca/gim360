<?php

namespace App\Controllers;

use App\Models\VideoModel;
use App\Models\EntretenimientoModel;
use App\Models\EntretenimientoVideoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Video extends BaseController
{
    protected VideoModel $videoModel;
    protected EntretenimientoVideoModel $evModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->videoModel = new VideoModel();
        $this->evModel    = new EntretenimientoVideoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $video = $this->videoModel->find($id);
        } else {
            $first = $this->videoModel->elprimero();
            $video = $first ?: null;
        }

        $entretenimientos = [];
        if ($video) {
            $entretenimientos = $this->evModel->getEntretenimientosByVideo((int)$video['idvideo']);
        }

        $data = [
            'title'            => 'Video' . ($video ? ': ' . $video['nombre'] : ''),
            'video'            => $video,
            'entretenimientos' => $entretenimientos,
            'module'           => 'video',
        ];

        return view('video/video_record', $data);
    }

    public function elprimero()
    {
        $first = $this->videoModel->elprimero();
        return $this->actual($first ? $first['idvideo'] : null);
    }

    public function elultimo()
    {
        $last = $this->videoModel->elultimo();
        return $this->actual($last ? $last['idvideo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->videoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idvideo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->videoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idvideo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $videos = $this->videoModel->getVideos($search);

        $data = [
            'title'  => 'Catálogo de Videos',
            'videos' => $videos,
            'search' => $search,
            'module' => 'video',
        ];

        return view('video/video_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Video',
            'module' => 'video',
        ];

        return view('video/video_form', $data);
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

        $id = $this->videoModel->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'autor'       => trim((string)$this->request->getPost('autor')) ?: null,
            'categoria'   => trim((string)$this->request->getPost('categoria')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('video/actual/' . $id))
                         ->with('success', 'Video registrado exitosamente.');
    }

    public function edit($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) {
            throw PageNotFoundException::forPageNotFound("Video no encontrado.");
        }

        $data = [
            'title'  => 'Editar Video #' . $id,
            'video'  => $video,
            'module' => 'video',
        ];

        return view('video/video_edit', $data);
    }

    public function update($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) {
            return redirect()->to(base_url('video'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
            'enlace' => 'required|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->videoModel->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'autor'       => trim((string)$this->request->getPost('autor')) ?: null,
            'categoria'   => trim((string)$this->request->getPost('categoria')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('video/actual/' . $id))
                         ->with('success', 'Video actualizado correctamente.');
    }

    public function delete($id)
    {
        $video = $this->videoModel->find($id);
        if (!$video) {
            return redirect()->to(base_url('video'))->with('error', 'Registro no encontrado.');
        }

        $this->videoModel->delete($id);
        $first = $this->videoModel->elprimero();
        $targetUrl = $first ? 'video/actual/' . $first['idvideo'] : 'video';
        return redirect()->to(base_url($targetUrl))->with('success', 'Video eliminado exitosamente.');
    }
}
