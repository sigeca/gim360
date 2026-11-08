<?php

namespace App\Controllers;

use App\Models\MiEntretenimientoJuegoModel;
use App\Models\MiEntretenimientoModel;
use App\Models\JuegoModel;
use App\Models\EntretenimientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiEntretenimientoJuego extends BaseController
{
    protected MiEntretenimientoJuegoModel $model;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->model = new MiEntretenimientoJuegoModel();
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
            $rel = $first ? $this->model->getRecordWithDetails((int)$first['idmientretenimientojuego']) : null;
        }

        $data = [
            'title'    => 'Relación Mi Entretenimiento - Juego',
            'relacion' => $rel,
            'module'   => 'mientretenimientojuego',
        ];

        return view('mientretenimientojuego/mientretenimientojuego_record', $data);
    }

    public function elprimero()
    {
        $first = $this->model->elprimero();
        return $this->actual($first ? $first['idmientretenimientojuego'] : null);
    }

    public function elultimo()
    {
        $last = $this->model->elultimo();
        return $this->actual($last ? $last['idmientretenimientojuego'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->model->siguiente((int)$id);
        return $this->actual($next ? $next['idmientretenimientojuego'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->model->anterior((int)$id);
        return $this->actual($prev ? $prev['idmientretenimientojuego'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idmientretenimiento = $this->request->getGet('idmientretenimiento');
        $idjuego = $this->request->getGet('idjuego');

        $data = [
            'title'               => 'Listado Mi Entretenimiento - Juego',
            'relaciones'          => $this->model->getRecordsWithDetails($search, $idmientretenimiento ? (int)$idmientretenimiento : null, $idjuego ? (int)$idjuego : null),
            'search'              => $search,
            'idmientretenimiento' => $idmientretenimiento,
            'idjuego'             => $idjuego,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'juegos'              => (new JuegoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientojuego',
        ];

        return view('mientretenimientojuego/mientretenimientojuego_list', $data);
    }

    public function add()
    {
        $data = [
            'title'               => 'Vincular Juego a Mi Entretenimiento',
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'juegos'              => (new JuegoModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdMiEntre'   => $this->request->getGet('idmientretenimiento'),
            'selectedIdJuego'     => $this->request->getGet('idjuego'),
            'module'              => 'mientretenimientojuego',
        ];

        return view('mientretenimientojuego/mientretenimientojuego_form', $data);
    }

    public function save()
    {
        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idjuego'             => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idjuego = (int)$this->request->getPost('idjuego');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idjuego', $idjuego)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este juego ya está vinculado a este registro de Mi Entretenimiento.');
        }

        $id = $this->model->insert([
            'idmientretenimiento' => $idmientretenimiento,
            'idjuego'             => $idjuego,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Juego vinculado exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'               => 'Editar Relación Mi Entretenimiento - Juego #' . $id,
            'relacion'            => $rel,
            'misEntretenimientos' => (new MiEntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'juegos'              => (new JuegoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'              => 'mientretenimientojuego',
        ];

        return view('mientretenimientojuego/mientretenimientojuego_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientojuego'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idmientretenimiento' => 'required|is_natural_no_zero',
            'idjuego'             => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idmientretenimiento = (int)$this->request->getPost('idmientretenimiento');
        $idjuego = (int)$this->request->getPost('idjuego');

        $exists = $this->model->where('idmientretenimiento', $idmientretenimiento)
                              ->where('idjuego', $idjuego)
                              ->where('idmientretenimientojuego !=', $id)
                              ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta combinación de Mi Entretenimiento y Juego ya existe.');
        }

        $this->model->update($id, [
            'idmientretenimiento' => $idmientretenimiento,
            'idjuego'             => $idjuego,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->model->find($id);
        if (!$rel) {
            return redirect()->to(base_url('mientretenimientojuego'))->with('error', 'Registro no encontrado.');
        }

        $idmientretenimiento = $rel['idmientretenimiento'];
        $this->model->delete($id);

        return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                         ->with('success', 'Juego desvinculado exitosamente.');
    }
}
