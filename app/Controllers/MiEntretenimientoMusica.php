<?php

namespace App\Controllers;

use App\Models\MiEntretenimientoMusicaModel;
use App\Models\MiEntretenimientoModel;
use App\Models\MusicaModel;
use App\Models\EntretenimientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiEntretenimientoMusica extends BaseController
{
    protected MiEntretenimientoMusicaModel $model;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->model = new MiEntretenimientoMusicaModel();
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
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmientretenimientomusica']) : null;
        }

        $data = [
            'title'    => 'Relación Mi Entretenimiento - Música',
            'relacion' => $rel,
            'module'   => 'mientretenimientomusica',
        ];

        return view('mientretenimientomusica/mientretenimientomusica_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmientretenimientomusica'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmientretenimientomusica'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmientretenimientomusica'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmientretenimientomusica'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmientretenimiento = $this->request->getGet('idmientretenimiento');
        $idmusica = $this->request->getGet('idmusica');

        $data = [
            'title'               => 'Listado Mi Entretenimiento - Música',
            'relaciones'          => $this->model->getRecordsWithDetails($search, $idmientretenimiento ? (int)$idmientretenimiento : null, $idmusica ? (int)$idmusica : null),
            'search'              => $search,
            'idmientretenimiento' => $idmientretenimiento,
            'idmusica'            => $idmusica,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'musicas'             => (new MusicaModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientomusica',
        ];

        return view('mientretenimientomusica/mientretenimientomusica_list', $data);
    }

    public function add()
    {
        $data = [
            'title'               => 'Vincular Música a Mi Entretenimiento',
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'musicas'             => (new MusicaModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMiEntre'   => $this->request->getGet('idmientretenimiento'),
            'selectedIdMusica'    => $this->request->getGet('idmusica'),
            'module'              => 'mientretenimientomusica',
        ];

        return view('mientretenimientomusica/mientretenimientomusica_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idmusica'            => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idmusica = (int)$this->request->getPost('idmusica');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idmusica', $idmusica)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta música ya está vinculada a este registro de Mi Entretenimiento.');
        }

        $id = $this->model->insert([
            'idmientretenimiento' => $idmientretenimiento,
            'idmusica'            => $idmusica,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Música vinculada exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'               => 'Editar Relación Mi Entretenimiento - Música #' . $id,
            'relacion'            => $rel,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'musicas'             => (new MusicaModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientomusica',
        ];

        return view('mientretenimientomusica/mientretenimientomusica_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientomusica'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idmusica'            => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idmusica = (int)$this->request->getPost('idmusica');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idmusica', $idmusica)
                              ->where('idmientretenimientomusica !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de Mi Entretenimiento y Música ya existe.');
        }

        $this->model->update($id, [
            'idmientretenimiento' => $idmientretenimiento,
            'idmusica'            => $idmusica,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientomusica'))->with('error', 'Registro no encontrado.');
        }

        $idmientretenimiento = $rel['idmientretenimiento'];
        $this->model->delete($id);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Música desvinculada exitosamente.');
    }
}
