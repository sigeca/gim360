<?php

namespace App\Controllers;

use App\Models\PerfilNutricionalModel;
use App\Models\PersonaModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PerfilNutricional extends BaseController
{
    protected PerfilNutricionalModel $pnModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->pnModel = new PerfilNutricionalModel();
        $this->personaModel = new PersonaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $perfil = $this->pnModel->getPerfilWithDetails((int)$id);
        } else {
            $last = $this->pnModel->elultimo();
            $perfil = $last ? $this->pnModel->getPerfilWithDetails((int)$last['idperfilnutricional']) : null;
        }

        $historial = [];
        if ($perfil) {
            $historial = $this->pnModel->getPerfilesByPersona((int)$perfil['idpersona']);
        }

        $data = [
            'title'     => 'Ficha de Control Nutricional' . ($perfil ? ' - ' . $perfil['nombres'] . ' ' . $perfil['apellidos'] : ''),
            'perfil'    => $perfil,
            'historial' => $historial,
            'module'    => 'perfilnutricional',
        ];

        return view('perfilnutricional/perfilnutricional_record', $data);
    }

    public function elprimero()
    {
        $first = $this->pnModel->elprimero();
        return $this->actual($first ? $first['idperfilnutricional'] : null);
    }

    public function elultimo()
    {
        $last = $this->pnModel->elultimo();
        return $this->actual($last ? $last['idperfilnutricional'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->pnModel->siguiente($id);
        return $this->actual($next ? $next['idperfilnutricional'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->pnModel->anterior($id);
        return $this->actual($prev ? $prev['idperfilnutricional'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $perfiles = $this->pnModel->getPerfilesWithPersona($search);

        $data = [
            'title'    => 'Control Nutricional - Listado de Evaluaciones',
            'perfiles' => $perfiles,
            'search'   => $search,
            'module'   => 'perfilnutricional',
        ];

        return view('perfilnutricional/perfilnutricional_list', $data);
    }

    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Registrar Control Nutricional',
            'personas'             => $this->personaModel->orderBy('apellidos', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'perfilnutricional',
        ];

        return view('perfilnutricional/perfilnutricional_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona'         => 'required|is_natural_no_zero',
            'peso_kg'           => 'required|numeric|greater_than[20]|less_than[400]',
            'estatura_cm'       => 'required|numeric|greater_than[50]|less_than[260]',
            'fechamedicion'     => 'permit_empty|valid_date',
            'porcentajegrasa'   => 'permit_empty|numeric|greater_than_equal_to[1]|less_than_equal_to[70]',
            'porcentajemusculo' => 'permit_empty|numeric|greater_than_equal_to[5]|less_than_equal_to[80]',
            'observaciones'     => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fecha = $this->request->getPost('fechamedicion');
        if (empty($fecha)) {
            $fecha = date('Y-m-d');
        }

        $grasa = $this->request->getPost('porcentajegrasa');
        $musculo = $this->request->getPost('porcentajemusculo');

        $id = $this->pnModel->insert([
            'idpersona'         => (int)$this->request->getPost('idpersona'),
            'peso_kg'           => (float)$this->request->getPost('peso_kg'),
            'estatura_cm'       => (float)$this->request->getPost('estatura_cm'),
            'fechamedicion'     => $fecha,
            'porcentajegrasa'   => ($grasa !== '' && $grasa !== null) ? (float)$grasa : null,
            'porcentajemusculo' => ($musculo !== '' && $musculo !== null) ? (float)$musculo : null,
            'observaciones'     => trim($this->request->getPost('observaciones')) ?: null,
        ]);

        return redirect()->to(base_url('perfilnutricional/actual/' . $id))->with('success', 'Control nutricional registrado exitosamente.');
    }

    public function edit($id)
    {
        $perfil = $this->pnModel->find($id);
        if (!$perfil) {
            throw PageNotFoundException::forPageNotFound("Perfil nutricional no encontrado.");
        }

        $data = [
            'title'    => 'Editar Control Nutricional #' . $id,
            'perfil'   => $perfil,
            'personas' => $this->personaModel->orderBy('apellidos', 'ASC')->findAll(),
            'module'   => 'perfilnutricional',
        ];

        return view('perfilnutricional/perfilnutricional_edit', $data);
    }

    public function update($id)
    {
        $perfil = $this->pnModel->find($id);
        if (!$perfil) {
            return redirect()->to(base_url('perfilnutricional'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idpersona'         => 'required|is_natural_no_zero',
            'peso_kg'           => 'required|numeric|greater_than[20]|less_than[400]',
            'estatura_cm'       => 'required|numeric|greater_than[50]|less_than[260]',
            'fechamedicion'     => 'permit_empty|valid_date',
            'porcentajegrasa'   => 'permit_empty|numeric|greater_than_equal_to[1]|less_than_equal_to[70]',
            'porcentajemusculo' => 'permit_empty|numeric|greater_than_equal_to[5]|less_than_equal_to[80]',
            'observaciones'     => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fecha = $this->request->getPost('fechamedicion');
        if (empty($fecha)) {
            $fecha = date('Y-m-d');
        }

        $grasa = $this->request->getPost('porcentajegrasa');
        $musculo = $this->request->getPost('porcentajemusculo');

        $this->pnModel->update($id, [
            'idpersona'         => (int)$this->request->getPost('idpersona'),
            'peso_kg'           => (float)$this->request->getPost('peso_kg'),
            'estatura_cm'       => (float)$this->request->getPost('estatura_cm'),
            'fechamedicion'     => $fecha,
            'porcentajegrasa'   => ($grasa !== '' && $grasa !== null) ? (float)$grasa : null,
            'porcentajemusculo' => ($musculo !== '' && $musculo !== null) ? (float)$musculo : null,
            'observaciones'     => trim($this->request->getPost('observaciones')) ?: null,
        ]);

        return redirect()->to(base_url('perfilnutricional/actual/' . $id))->with('success', 'Control nutricional actualizado exitosamente.');
    }

    public function delete($id)
    {
        $perfil = $this->pnModel->find($id);
        if (!$perfil) {
            return redirect()->to(base_url('perfilnutricional'))->with('error', 'Registro no encontrado.');
        }

        $this->pnModel->delete($id);
        $first = $this->pnModel->elprimero();
        $targetUrl = $first ? 'perfilnutricional/actual/' . $first['idperfilnutricional'] : 'perfilnutricional';

        return redirect()->to(base_url($targetUrl))->with('success', 'Registro nutricional eliminado exitosamente.');
    }
}
