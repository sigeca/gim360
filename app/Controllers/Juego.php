<?php

namespace App\Controllers;

use App\Models\JuegoModel;
use App\Models\EntretenimientoModel;
use App\Models\EntretenimientoJuegoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Juego extends BaseController
{
    protected JuegoModel $juegoModel;
    protected EntretenimientoJuegoModel $ejModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->juegoModel = new JuegoModel();
        $this->ejModel    = new EntretenimientoJuegoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $juego = $this->juegoModel->find($id);
        } else {
            $first = $this->juegoModel->elprimero();
            $juego = $first ?: null;
        }

        $entretenimientos = [];
        if ($juego) {
            $entretenimientos = $this->ejModel->getEntretenimientosByJuego((int)$juego['idjuego']);
        }

        $data = [
            'title'            => 'Juego Tradicional' . ($juego ? ': ' . $juego['nombre'] : ''),
            'juego'            => $juego,
            'entretenimientos' => $entretenimientos,
            'module'           => 'juego',
        ];

        return view('juego/juego_record', $data);
    }

    public function elprimero()
    {
        $first = $this->juegoModel->elprimero();
        return $this->actual($first ? $first['idjuego'] : null);
    }

    public function elultimo()
    {
        $last = $this->juegoModel->elultimo();
        return $this->actual($last ? $last['idjuego'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->juegoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idjuego'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->juegoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idjuego'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $juegos = $this->juegoModel->getJuegos($search);

        $data = [
            'title'  => 'Catálogo de Juegos Tradicionales Básicos',
            'juegos' => $juegos,
            'search' => $search,
            'module' => 'juego',
        ];

        return view('juego/juego_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Juego Tradicional',
            'module' => 'juego',
        ];

        return view('juego/juego_form', $data);
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

        $id = $this->juegoModel->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'categoria'   => trim((string)$this->request->getPost('categoria')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('juego/actual/' . $id))
                         ->with('success', 'Juego tradicional registrado exitosamente.');
    }

    public function edit($id)
    {
        $juego = $this->juegoModel->find($id);
        if (!$juego) {
            throw PageNotFoundException::forPageNotFound("Juego no encontrado.");
        }

        $data = [
            'title'  => 'Editar Juego #' . $id,
            'juego'  => $juego,
            'module' => 'juego',
        ];

        return view('juego/juego_edit', $data);
    }

    public function update($id)
    {
        $juego = $this->juegoModel->find($id);
        if (!$juego) {
            return redirect()->to(base_url('juego'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]',
            'enlace' => 'required|max_length[500]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->juegoModel->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'categoria'   => trim((string)$this->request->getPost('categoria')) ?: null,
            'enlace'      => trim((string)$this->request->getPost('enlace')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('juego/actual/' . $id))
                         ->with('success', 'Juego actualizado correctamente.');
    }

    public function delete($id)
    {
        $juego = $this->juegoModel->find($id);
        if (!$juego) {
            return redirect()->to(base_url('juego'))->with('error', 'Registro no encontrado.');
        }

        $this->juegoModel->delete($id);
        $first = $this->juegoModel->elprimero();
        $targetUrl = $first ? 'juego/actual/' . $first['idjuego'] : 'juego';
        return redirect()->to(base_url($targetUrl))->with('success', 'Juego eliminado exitosamente.');
    }
}
