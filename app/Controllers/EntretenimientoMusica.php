<?php

namespace App\Controllers;

use App\Models\EntretenimientoMusicaModel;
use App\Models\EntretenimientoModel;
use App\Models\MusicaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EntretenimientoMusica extends BaseController
{
    protected EntretenimientoMusicaModel $emModel;
    protected EntretenimientoModel $entretenimientoModel;
    protected MusicaModel $musicaModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->emModel              = new EntretenimientoMusicaModel();
        $this->entretenimientoModel = new EntretenimientoModel();
        $this->musicaModel          = new MusicaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $record = $this->emModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->emModel->elprimero();
            $record = $first ? $this->emModel->getRecordWithDetails((int)$first['identretenimientomusica']) : null;
        }

        $data = [
            'title'  => 'Relación Entretenimiento - Música' . ($record ? ': #' . $record['identretenimientomusica'] : ''),
            'rel'    => $record,
            'module' => 'entretenimientomusica',
        ];

        return view('entretenimientomusica/entretenimientomusica_record', $data);
    }

    public function elprimero()
    {
        $first = $this->emModel->elprimero();
        return $this->actual($first ? $first['identretenimientomusica'] : null);
    }

    public function elultimo()
    {
        $last = $this->emModel->elultimo();
        return $this->actual($last ? $last['identretenimientomusica'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->emModel->siguiente((int)$id);
        return $this->actual($next ? $next['identretenimientomusica'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->emModel->anterior((int)$id);
        return $this->actual($prev ? $prev['identretenimientomusica'] : $id);
    }

    public function listar()
    {
        $search            = $this->request->getGet('q');
        $identretenimiento = $this->request->getGet('identretenimiento');
        $idmusica          = $this->request->getGet('idmusica');

        $identretenimiento = (!empty($identretenimiento) && is_numeric($identretenimiento)) ? (int)$identretenimiento : null;
        $idmusica          = (!empty($idmusica) && is_numeric($idmusica)) ? (int)$idmusica : null;

        $listado          = $this->emModel->getRecordsWithDetails($search, $identretenimiento, $idmusica);
        $entretenimientos = $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll();
        $musicas          = $this->musicaModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'                   => 'Músicas por Entretenimiento',
            'listado'                 => $listado,
            'entretenimientos'        => $entretenimientos,
            'musicas'                 => $musicas,
            'selectedEntretenimiento' => $identretenimiento,
            'selectedMusica'          => $idmusica,
            'search'                  => $search,
            'module'                  => 'entretenimientomusica',
        ];

        return view('entretenimientomusica/entretenimientomusica_list', $data);
    }

    public function add()
    {
        $data = [
            'title'                      => 'Asignar Música a Entretenimiento',
            'entretenimientos'           => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'musicas'                    => $this->musicaModel->orderBy('nombre', 'ASC')->findAll(),
            'preselectedEntretenimiento' => $this->request->getGet('identretenimiento'),
            'preselectedMusica'          => $this->request->getGet('idmusica'),
            'module'                     => 'entretenimientomusica',
        ];

        return view('entretenimientomusica/entretenimientomusica_form', $data);
    }

    public function save()
    {
        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idmusica'          => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idmusica          = (int)$this->request->getPost('idmusica');

        $exists = $this->emModel->where('identretenimiento', $identretenimiento)
                                ->where('idmusica', $idmusica)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Este entretenimiento ya tiene asignada esta música.');
        }

        $id = $this->emModel->insert([
            'identretenimiento' => $identretenimiento,
            'idmusica'          => $idmusica,
        ]);

        return redirect()->to(base_url('entretenimientomusica/actual/' . $id))
                         ->with('success', 'Música asignada al entretenimiento exitosamente.');
    }

    public function edit($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'            => 'Editar Asignación Entretenimiento - Música #' . $id,
            'rel'              => $rel,
            'entretenimientos' => $this->entretenimientoModel->orderBy('nombre', 'ASC')->findAll(),
            'musicas'          => $this->musicaModel->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'entretenimientomusica',
        ];

        return view('entretenimientomusica/entretenimientomusica_edit', $data);
    }

    public function update($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientomusica'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'identretenimiento' => 'required|is_natural_no_zero',
            'idmusica'          => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identretenimiento = (int)$this->request->getPost('identretenimiento');
        $idmusica          = (int)$this->request->getPost('idmusica');

        $exists = $this->emModel->where('identretenimiento', $identretenimiento)
                                ->where('idmusica', $idmusica)
                                ->where('identretenimientomusica !=', $id)
                                ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con ese mismo entretenimiento y música.');
        }

        $this->emModel->update($id, [
            'identretenimiento' => $identretenimiento,
            'idmusica'          => $idmusica,
        ]);

        return redirect()->to(base_url('entretenimientomusica/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    public function delete($id)
    {
        $rel = $this->emModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('entretenimientomusica'))->with('error', 'Registro no encontrado.');
        }

        $this->emModel->delete($id);
        $first = $this->emModel->elprimero();
        $targetUrl = $first ? 'entretenimientomusica/actual/' . $first['identretenimientomusica'] : 'entretenimientomusica';
        return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
    }
}
