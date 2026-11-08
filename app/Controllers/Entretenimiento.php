<?php

namespace App\Controllers;

use App\Models\EntretenimientoModel;
use App\Models\MusicaModel;
use App\Models\VideoModel;
use App\Models\JuegoModel;
use App\Models\PodcastModel;
use App\Models\EntretenimientoMusicaModel;
use App\Models\EntretenimientoVideoModel;
use App\Models\EntretenimientoJuegoModel;
use App\Models\EntretenimientoPodcastModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Entretenimiento extends BaseController
{
    protected EntretenimientoModel $entretenimientoModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->entretenimientoModel = new EntretenimientoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $entretenimiento = $this->entretenimientoModel->getEntretenimientoWithDetails((int)$id);
        } else {
            $first = $this->entretenimientoModel->elprimero();
            $entretenimiento = $first ? $this->entretenimientoModel->getEntretenimientoWithDetails((int)$first['identretenimiento']) : null;
        }

        $data = [
            'title'            => 'Sección de Entretenimiento' . ($entretenimiento ? ': ' . $entretenimiento['nombre'] : ''),
            'entretenimiento'  => $entretenimiento,
            'catalogoMusicas'  => (new MusicaModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoVideos'   => (new VideoModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoJuegos'   => (new JuegoModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoPodcasts' => (new PodcastModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'entretenimiento',
        ];

        return view('entretenimiento/entretenimiento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->entretenimientoModel->elprimero();
        return $this->actual($first ? $first['identretenimiento'] : null);
    }

    public function elultimo()
    {
        $last = $this->entretenimientoModel->elultimo();
        return $this->actual($last ? $last['identretenimiento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->entretenimientoModel->siguiente((int)$id);
        return $this->actual($next ? $next['identretenimiento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->entretenimientoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['identretenimiento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $entretenimientos = $this->entretenimientoModel->getEntretenimientosWithCounts($search);

        $data = [
            'title'            => 'Catálogo de Entretenimiento',
            'entretenimientos' => $entretenimientos,
            'search'           => $search,
            'module'           => 'entretenimiento',
        ];

        return view('entretenimiento/entretenimiento_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Nuevo Entretenimiento',
            'module' => 'entretenimiento',
        ];

        return view('entretenimiento/entretenimiento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[150]|is_unique[entretenimiento.nombre]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del entretenimiento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede exceder los 150 caracteres.',
                'is_unique'  => 'Ya existe un registro de entretenimiento con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->entretenimientoModel->insert([
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('entretenimiento/actual/' . $id))
                         ->with('success', 'Registro de entretenimiento creado exitosamente.');
    }

    public function edit($id)
    {
        $entretenimiento = $this->entretenimientoModel->find($id);
        if (!$entretenimiento) {
            throw PageNotFoundException::forPageNotFound("Entretenimiento no encontrado.");
        }

        $data = [
            'title'           => 'Editar Entretenimiento #' . $id,
            'entretenimiento' => $entretenimiento,
            'module'          => 'entretenimiento',
        ];

        return view('entretenimiento/entretenimiento_edit', $data);
    }

    public function update($id)
    {
        $entretenimiento = $this->entretenimientoModel->find($id);
        if (!$entretenimiento) {
            return redirect()->to(base_url('entretenimiento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[150]|is_unique[entretenimiento.nombre,identretenimiento,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->entretenimientoModel->update($id, [
            'nombre'      => trim((string)$this->request->getPost('nombre')),
            'descripcion' => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('entretenimiento/actual/' . $id))
                         ->with('success', 'Entretenimiento actualizado correctamente.');
    }

    public function delete($id)
    {
        $entretenimiento = $this->entretenimientoModel->find($id);
        if (!$entretenimiento) {
            return redirect()->to(base_url('entretenimiento'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->entretenimientoModel->delete($id);
            $first = $this->entretenimientoModel->elprimero();
            $targetUrl = $first ? 'entretenimiento/actual/' . $first['identretenimiento'] : 'entretenimiento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Entretenimiento eliminado exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('entretenimiento/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}
