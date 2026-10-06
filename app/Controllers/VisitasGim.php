<?php

namespace App\Controllers;

use App\Models\VisitasGimModel;
use App\Models\ClienteModel;

class VisitasGim extends BaseController
{
    protected VisitasGimModel $visitasGimModel;
    protected ClienteModel $clienteModel;

    public function __construct()
    {
        $this->visitasGimModel = new VisitasGimModel();
        $this->clienteModel    = new ClienteModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $visita = $this->visitasGimModel->getVisitaWithDetails($id);
        } else {
            $last = $this->visitasGimModel->elultimo();
            $visita = $last ? $this->visitasGimModel->getVisitaWithDetails($last['idvisitasgim']) : null;
        }

        $data = [
            'title'  => 'Ficha de Visita al Gimnasio',
            'visita' => $visita,
            'module' => 'visitasgim',
        ];

        return view('visitasgim/visitasgim_record', $data);
    }

    public function elprimero()
    {
        $first = $this->visitasGimModel->elprimero();
        return $this->actual($first ? $first['idvisitasgim'] : null);
    }

    public function elultimo()
    {
        $last = $this->visitasGimModel->elultimo();
        return $this->actual($last ? $last['idvisitasgim'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->visitasGimModel->siguiente($id);
        return $this->actual($next ? $next['idvisitasgim'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->visitasGimModel->anterior($id);
        return $this->actual($prev ? $prev['idvisitasgim'] : $id);
    }

    // Vista para listar todas las visitas
    public function listar()
    {
        $search  = $this->request->getGet('q');
        $visitas = $this->visitasGimModel->getVisitasWithDetails($search);

        $data = [
            'title'   => 'Listado de Visitas al Gimnasio',
            'visitas' => $visitas,
            'search'  => $search,
            'module'  => 'visitasgim',
        ];

        return view('visitasgim/visitasgim_list', $data);
    }

    // Formulario para registrar nueva visita
    public function add()
    {
        $idclientePreselected = $this->request->getGet('idcliente');
        $clientes = $this->clienteModel->getClientesWithPersona();

        $data = [
            'title'                => 'Registrar Visita al Gimnasio',
            'clientes'             => $clientes,
            'idclientePreselected' => $idclientePreselected,
            'module'               => 'visitasgim',
        ];

        return view('visitasgim/visitasgim_form', $data);
    }

    public function save()
    {
        $rules = [
            'idcliente'   => 'required|is_natural_no_zero',
            'fecha'       => 'required|valid_date[Y-m-d]',
            'horaingreso' => 'required',
            'horasalida'  => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $horasalida = $this->request->getPost('horasalida');

        $id = $this->visitasGimModel->insert([
            'idcliente'   => $this->request->getPost('idcliente'),
            'fecha'       => $this->request->getPost('fecha'),
            'horaingreso' => $this->request->getPost('horaingreso'),
            'horasalida'  => !empty($horasalida) ? $horasalida : null,
        ]);

        return redirect()->to(base_url('visitasgim/actual/' . $id))->with('success', 'Visita registrada exitosamente.');
    }

    // Formulario para editar visita existente
    public function edit($id)
    {
        $visita = $this->visitasGimModel->find($id);
        if (!$visita) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Visita no encontrada.");
        }

        $clientes = $this->clienteModel->getClientesWithPersona();

        $data = [
            'title'    => 'Editar Visita #' . $id,
            'visita'   => $visita,
            'clientes' => $clientes,
            'module'   => 'visitasgim',
        ];

        return view('visitasgim/visitasgim_edit', $data);
    }

    public function update($id)
    {
        $visita = $this->visitasGimModel->find($id);
        if (!$visita) {
            return redirect()->to(base_url('visitasgim'))->with('error', 'Visita no encontrada.');
        }

        $rules = [
            'idcliente'   => 'required|is_natural_no_zero',
            'fecha'       => 'required|valid_date[Y-m-d]',
            'horaingreso' => 'required',
            'horasalida'  => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $horasalida = $this->request->getPost('horasalida');

        $this->visitasGimModel->update($id, [
            'idcliente'   => $this->request->getPost('idcliente'),
            'fecha'       => $this->request->getPost('fecha'),
            'horaingreso' => $this->request->getPost('horaingreso'),
            'horasalida'  => !empty($horasalida) ? $horasalida : null,
        ]);

        return redirect()->to(base_url('visitasgim/actual/' . $id))->with('success', 'Visita actualizada exitosamente.');
    }

    public function delete($id)
    {
        $visita = $this->visitasGimModel->find($id);
        if (!$visita) {
            return redirect()->to(base_url('visitasgim'))->with('error', 'Visita no encontrada.');
        }

        $this->visitasGimModel->delete($id);

        $last = $this->visitasGimModel->elultimo();
        $targetUrl = $last ? 'visitasgim/actual/' . $last['idvisitasgim'] : 'visitasgim';

        return redirect()->to(base_url($targetUrl))->with('success', 'Visita eliminada exitosamente.');
    }
}
