<?php

namespace App\Controllers;

use App\Models\EntretenimientoJuegoModel;
use App\Models\EntretenimientoModel;
use App\Models\JuegoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EntretenimientoJuego extends BaseController
{
    protected EntretenimientoJuegoModel $ejModel;
    protected EntretenimientoModel $entretenimientoModel;
    protected JuegoModel $juegoModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->ejModel              = new EntretenimientoJuegoModel();
        $this->entretenimientoModel = new EntretenimientoModel();
        $this->juegoModel           = new JuegoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->ejModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->ejModel->elprimero();
            $record = $first ? $this->ejModel->getRecordWithDetails((int)$first['identretenimientojuego']) : null;
        }

        $data = [
            'title'  => 'Relación Entretenimiento - Juego' . ($record ? ': #' . $record['identretenimientojuego'] : ''),
            'rel'    => $record,
            'module' => 'entretenimientojuego',
        ];

        return view('entretenimientojuego/entretenimientojuego_record', $data);
    }

    public function elprimero()
    {
        $first = $this->ejModel->elprimero();
        return $this->actual($first ? $first['identretenimientojuego'] : null);
    }

    public function elultimo()
    {
        $last = $this->ejModel->elultimo();
        return $this->actual($last ? $last['identretenimientojuego'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->ejModel->siguiente((int)$id);
        return $this->actual($next ? $next['identretenimientojuego'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->ejModel->anterior((int)$id);
        return $this->actual($prev ? $prev['identretenimientojuego'] : $id);
    }

    public function listar()
    {
        $search            = $this->request->getGet('q');
        $identretenimiento = $this->request->getGet('identretenimiento');
        $idjuego           = $this->request->getGet('idjuego');

        $identretenimiento = (!empty($identretenimiento) && is_numeric($identretenimiento)) ? (int)$identretenimiento : null;
        $idjuego           = (!empty($idjuego) && is_numeric($idjuego)) ? (int)$idjuego : null;

        $listado          = $this->ejModel->getRecordsWithDetails($search, $identretenimiento, $idjuego);
        $entretenimientos = $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll();
        $juegos           = $this->juegoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'                   => 'Juegos por Entretenimiento',
            'listado'                 => $listado,
            'entretenimientos'        => $entretenimientos,
            'juegos'                  => $juegos,
            'selectedEntretenimiento' => $identretenimiento,
            'selectedJuego'           => $idjuego,
            'search'                  => $search,
            'module'                  => 'entretenimientojuego',
        ];

        return view('entretenimientojuego/entretenimientojuego_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                      => 'Asignar Juego a Entretenimiento',
            'entretenimientos'           => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'juegos'                     => $this->juegoModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedEntretenimiento' => $this->request->getGet('identretenimiento'),
            'preselectedJuego'           => $this->request->getGet('idjuego'),
            'module'                     => 'entretenimientojuego',
        ];

        return view('entretenimientojuego/entretenimientojuego_form', $data);
    }

    public function save()
    {
        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idjuego'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idjuego           = (int)$this->request->getPost('idjuego');

        $exists = $this->ejModel->where('identretenimiento', $identretenimiento)
                                ->where('idjuego', $idjuego)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este entretenimiento ya tiene asignado este juego.');
        }

        $id = $this->ejModel->insert([
            'identretenimiento' => $identretenimiento,
            'idjuego'           => $idjuego,
        ]);

        return redirect()->to(base_url('entretenimientojuego/actual/' . $id))
                         ->with('success', 'Juego asignado al entretenimiento exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->ejModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'            => 'Editar Asignación Entretenimiento - Juego #' . $id,
            'rel'              => $rel,
            'entretenimientos' => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'juegos'           => $this->juegoModel->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'entretenimientojuego',
        ];

        return view('entretenimientojuego/entretenimientojuego_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->ejModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientojuego'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idjuego'           => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idjuego           = (int)$this->request->getPost('idjuego');

        $exists = $this->ejModel->where('identretenimiento', $identretenimiento)
                                ->where('idjuego', $idjuego)
                                ->where('identretenimientojuego !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese mismo entretenimiento y juego.');
        }

        $this->ejModel->update($id, [
            'identretenimiento' => $identretenimiento,
            'idjuego'           => $idjuego,
        ]);

        return redirect()->to(base_url('entretenimientojuego/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->ejModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientojuego'))->with('error', 'Registro no encontrado.');
        }

        $this->ejModel->delete($id);
        $first = $this->ejModel->elprimero();
        $targetUrl = $first ? 'entretenimientojuego/actual/' . $first['identretenimientojuego'] : 'entretenimientojuego';
        return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
    }
}
