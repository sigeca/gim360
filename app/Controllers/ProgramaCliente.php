<?php

namespace App\Controllers;

use App\Models\ProgramaClienteModel;
use App\Models\ClienteModel;
use App\Models\ProgramaEntrenamientoModel;
use App\Models\EstadoProgramaClienteModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ProgramaCliente extends BaseController
{
    protected ProgramaClienteModel $programaClienteModel;
    protected ClienteModel $clienteModel;
    protected ProgramaEntrenamientoModel $programaModel;
    protected EstadoProgramaClienteModel $estadoModel;

    public function __construct()
    {
        $this->programaClienteModel = new ProgramaClienteModel();
        $this->clienteModel         = new ClienteModel();
        $this->programaModel        = new ProgramaEntrenamientoModel();
        $this->estadoModel         = new EstadoProgramaClienteModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $programaCliente = $this->programaClienteModel->getProgramaClienteWithDetails($id);
        } else {
            $last = $this->programaClienteModel->elultimo();
            $programaCliente = $last ? $this->programaClienteModel->getProgramaClienteWithDetails($last['idprogramacliente']) : null;
        }

        $data = [
            'title'           => 'Ficha de Programa Particularizado Asignado al Cliente',
            'programaCliente' => $programaCliente,
            'module'          => 'programacliente',
        ];

        return view('programacliente/programacliente_record', $data);
    }

    public function elprimero()
    {
        $first = $this->programaClienteModel->elprimero();
        return $this->actual($first ? $first['idprogramacliente'] : null);
    }

    public function elultimo()
    {
        $last = $this->programaClienteModel->elultimo();
        return $this->actual($last ? $last['idprogramacliente'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->programaClienteModel->siguiente($id);
        return $this->actual($next ? $next['idprogramacliente'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->programaClienteModel->anterior($id);
        return $this->actual($prev ? $prev['idprogramacliente'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $programasClientes = $this->programaClienteModel->getProgramasClientesWithDetails($search);

        $data = [
            'title'             => 'Listado de Programas de Clientes',
            'programasClientes' => $programasClientes,
            'search'            => $search,
            'module'            => 'programacliente',
        ];

        return view('programacliente/programacliente_list', $data);
    }

    public function add()
    {
        $idClientePreselected = $this->request->getGet('idcliente');
        $idProgPreselected    = $this->request->getGet('idprogramaentrenamiento');

        $data = [
            'title'                => 'Asignar Programa de Entrenamiento Modelo a Cliente',
            'clientes'             => $this->clienteModel->getClientesWithPersona(),
            'programas'            => $this->programaModel->getProgramasWithDetails(),
            'estados'              => $this->estadoModel->getEstados(),
            'idClientePreselected' => $idClientePreselected,
            'idProgPreselected'    => $idProgPreselected,
            'module'               => 'programacliente',
        ];

        return view('programacliente/programacliente_form', $data);
    }

    public function save()
    {
        $rules = [
            'idcliente'               => 'required|is_natural_no_zero',
            'idprogramaentrenamiento' => 'required|is_natural_no_zero',
            'fechainicio'             => 'required|valid_date[Y-m-d]',
            'idestadoprogramacliente' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idCliente = (int)$this->request->getPost('idcliente');
        $idProgModelo = (int)$this->request->getPost('idprogramaentrenamiento');

        // Clonar el programa modelo hacia las tablas personalizadas del cliente
        try {
            $idProgPersonalizado = $this->programaClienteModel->clonarProgramaModeloACliente($idProgModelo, $idCliente);
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Error al particularizar el programa: ' . $e->getMessage());
        }

        $id = $this->programaClienteModel->insert([
            'idcliente'               => $idCliente,
            'idprogramaentrenamiento' => $idProgModelo,
            'idprogramapersonalizado' => $idProgPersonalizado,
            'fechainicio'             => $this->request->getPost('fechainicio'),
            'idestadoprogramacliente' => (int)$this->request->getPost('idestadoprogramacliente'),
        ]);

        return redirect()->to(base_url('programacliente/actual/' . $id))->with('success', 'Programa modelo particularizado y asignado al cliente exitosamente.');
    }

    public function edit($id)
    {
        $programaCliente = $this->programaClienteModel->find($id);
        if (!$programaCliente) {
            throw PageNotFoundException::forPageNotFound("Programa de cliente no encontrado.");
        }

        $data = [
            'title'           => 'Editar Asignación de Programa #' . $id,
            'programaCliente' => $programaCliente,
            'clientes'        => $this->clienteModel->getClientesWithPersona(),
            'programas'       => $this->programaModel->getProgramasWithDetails(),
            'estados'         => $this->estadoModel->getEstados(),
            'module'          => 'programacliente',
        ];

        return view('programacliente/programacliente_edit', $data);
    }

    public function update($id)
    {
        $programaCliente = $this->programaClienteModel->find($id);
        if (!$programaCliente) {
            return redirect()->to(base_url('programacliente'))->with('error', 'Programa de cliente no encontrado.');
        }

        $rules = [
            'idcliente'               => 'required|is_natural_no_zero',
            'idprogramaentrenamiento' => 'required|is_natural_no_zero',
            'fechainicio'             => 'required|valid_date[Y-m-d]',
            'idestadoprogramacliente' => 'required|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->programaClienteModel->update($id, [
            'idcliente'               => (int)$this->request->getPost('idcliente'),
            'idprogramaentrenamiento' => (int)$this->request->getPost('idprogramaentrenamiento'),
            'fechainicio'             => $this->request->getPost('fechainicio'),
            'idestadoprogramacliente' => (int)$this->request->getPost('idestadoprogramacliente'),
        ]);

        return redirect()->to(base_url('programacliente/actual/' . $id))->with('success', 'Programa de cliente actualizado exitosamente.');
    }

    public function delete($id)
    {
        $programaCliente = $this->programaClienteModel->find($id);
        if (!$programaCliente) {
            return redirect()->to(base_url('programacliente'))->with('error', 'Programa de cliente no encontrado.');
        }

        $idProgPers = !empty($programaCliente['idprogramapersonalizado']) ? (int)$programaCliente['idprogramapersonalizado'] : null;

        $this->programaClienteModel->delete($id);

        if ($idProgPers) {
            $db = \Config\Database::connect();
            $rutinas = $db->table('rutinaprogramapersonalizado')
                          ->where('idprogramapersonalizado', $idProgPers)
                          ->get()
                          ->getResultArray();
            foreach ($rutinas as $r) {
                $idRutina = (int)$r['idrutinapersonalizada'];
                $planes = $db->table('rutinaplanpersonalizado')
                             ->where('idrutinapersonalizada', $idRutina)
                             ->get()
                             ->getResultArray();
                foreach ($planes as $pl) {
                    $idPlan = (int)$pl['idplanpersonalizado'];
                    $db->table('rutinaplanpersonalizado')->where('idrutinaplanpersonalizado', (int)$pl['idrutinaplanpersonalizado'])->delete();
                    $db->table('planejerciciopersonalizado')->where('idplanpersonalizado', $idPlan)->delete();
                }
                $db->table('rutinaprogramapersonalizado')->where('idrutinaprogramapersonalizado', (int)$r['idrutinaprogramapersonalizado'])->delete();
                $db->table('rutinaejerciciopersonalizado')->where('idrutinapersonalizada', $idRutina)->delete();
            }
            $db->table('programaentrenamientopersonalizado')->where('idprogramapersonalizado', $idProgPers)->delete();
        }

        return redirect()->to(base_url('programacliente/elprimero'))->with('success', 'Asignación de programa eliminada correctamente.');
    }
}
