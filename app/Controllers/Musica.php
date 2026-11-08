<?php

namespace App\Controllers;

use App\Models\MusicaModel;
use App\Models\EntretenimientoModel;
use App\Models\EntretenimientoMusicaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Musica extends BaseController
{
    protected MusicaModel $musicaModel;
    protected EntretenimientoMusicaModel $emModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->musicaModel = new MusicaModel();
        $this->emModel     = new EntretenimientoMusicaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $musica = $this->musicaModel->find($id);
        } else {
            $first = $this->musicaModel->elprimero();
            $musica = $first ?: null;
        }

        $entretenimientos = [];
        if ($musica) {
            $entretenimientos = $this->emModel->getEntretenimientosByMusica((int)$musica['idmusica']);
        }

        $data = [
            'title'            => 'Música' . ($musica ? ': ' . $musica['nombre'] : ''),
            'musica'           => $musica,
            'entretenimientos' => $entretenimientos,
            'module'           => 'musica',
        ];

        return view('musica/musica_record', $data);
    }

    public function elprimero()
    {
        $first = $this->musicaModel->elprimero();
        return $this->actual($first ? $first['idmusica'] : null);
    }

    public function elultimo()
    {
        $last = $this->musicaModel->elultimo();
        return $this->actual($last ? $last['idmusica'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->musicaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idmusica'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->musicaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idmusica'] : $id);
    }

    public function listar()
    {
        $search  = $this->request->getGet('q');
        $musicas = $this->musicaModel->getMusicas($search);

        $data = [
            'title'   => 'Catálogo de Música',
            'musicas' => $musicas,
            'search'  => $search,
            'module'  => 'musica',
        ];

        return view('musica/musica_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Música',
            'module' => 'musica',
        ];

        return view('musica/musica_form', $data);
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

        $id = $this->musicaModel->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'artista'     => trim((string)$this->request->getPost('artista')) ?: null,
            'genero'      => trim((string)$this->request->getPost('genero')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('musica/actual/' . $id))
                         ->with('success', 'Música registrada exitosamente.');
    }

    public function edit($id)
    {
        $musica = $this->musicaModel->find($id);
        if (!$musica) {
            throw PageNotFoundException::forPageNotFound("Música no encontrada.");
        }

        $data = [
            'title'  => 'Editar Música #' . $id,
            'musica' => $musica,
            'module' => 'musica',
        ];

        return view('musica/musica_edit', $data);
    }

    public function update($id)
    {
        $musica = $this->musicaModel->find($id);
        if (!$musica) {
            return redirect()->to(base_url('musica'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
            'enlace' => 'required|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->musicaModel->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'artista'     => trim((string)$this->request->getPost('artista')) ?: null,
            'genero'      => trim((string)$this->request->getPost('genero')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('musica/actual/' . $id))
                         ->with('success', 'Música actualizada correctamente.');
    }

    public function delete($id)
    {
        $musica = $this->musicaModel->find($id);
        if (!$musica) {
            return redirect()->to(base_url('musica'))->with('error', 'Registro no encontrado.');
        }

        $this->musicaModel->delete($id);
        $first = $this->musicaModel->elprimero();
        $targetUrl = $first ? 'musica/actual/' . $first['idmusica'] : 'musica';
        return redirect()->to(base_url($targetUrl))->with('success', 'Música eliminada exitosamente.');
    }
}
