<?php

namespace App\Controllers;

use App\Models\EjercicioClienteModel;
use App\Models\EjercicioModel;
use App\Models\ClienteModel;

class EjercicioCliente extends BaseController
{
    protected EjercicioClienteModel $ecModel;
    protected EjercicioModel $ejercicioModel;
    protected ClienteModel $clienteModel;

    public function __construct()
    {
        $this->ecModel        = new EjercicioClienteModel();
        $this->ejercicioModel = new EjercicioModel();
        $this->clienteModel   = new ClienteModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $ejercicioCliente = $this->ecModel->getEjercicioClienteWithDetails($id);
        } else {
            $last = $this->ecModel->elultimo();
            $ejercicioCliente = $last ? $this->ecModel->getEjercicioClienteWithDetails($last['idejerciciocliente']) : null;
        }

        $youtubeId = null;
        if (!empty($ejercicioCliente['urlvideo'])) {
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $ejercicioCliente['urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        $data = [
            'title'            => 'Ficha de Ejercicio del Cliente',
            'ejercicioCliente' => $ejercicioCliente,
            'youtubeId'        => $youtubeId,
            'module'           => 'ejerciciocliente',
        ];

        return view('ejerciciocliente/ejerciciocliente_record', $data);
    }

    public function elprimero()
    {
        $first = $this->ecModel->elprimero();
        return $this->actual($first ? $first['idejerciciocliente'] : null);
    }

    public function elultimo()
    {
        $last = $this->ecModel->elultimo();
        return $this->actual($last ? $last['idejerciciocliente'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->ecModel->siguiente($id);
        return $this->actual($next ? $next['idejerciciocliente'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->ecModel->anterior($id);
        return $this->actual($prev ? $prev['idejerciciocliente'] : $id);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search       = $this->request->getGet('q');
        $asignaciones = $this->ecModel->getEjercicioClientesWithDetails($search);

        $data = [
            'title'        => 'Listado de Ejercicios por Cliente',
            'asignaciones' => $asignaciones,
            'search'       => $search,
            'module'       => 'ejerciciocliente',
        ];

        return view('ejerciciocliente/ejerciciocliente_list', $data);
    }

    // Vista de formulario para registrar nuevo registro
    public function add()
    {
        $idclientePreselected   = $this->request->getGet('idcliente');
        $idejercicioPreselected = $this->request->getGet('idejercicio');

        $data = [
            'title'                  => 'Asignar Ejercicio a Cliente',
            'clientes'               => $this->clienteModel->getClientesWithPersona(),
            'ejercicios'             => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'idclientePreselected'   => $idclientePreselected,
            'idejercicioPreselected' => $idejercicioPreselected,
            'module'                 => 'ejerciciocliente',
        ];

        return view('ejerciciocliente/ejerciciocliente_form', $data);
    }

    public function save()
    {
        $rules = [
            'idejercicio'     => 'required|is_natural_no_zero',
            'idcliente'       => 'required|is_natural_no_zero',
            'fecha'           => 'required|valid_date[Y-m-d]',
            'duracionminutos' => 'required|is_natural_no_zero|greater_than[0]|less_than_equal_to[1440]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->ecModel->insert([
            'idejercicio'     => $this->request->getPost('idejercicio'),
            'idcliente'       => $this->request->getPost('idcliente'),
            'fecha'           => $this->request->getPost('fecha'),
            'duracionminutos' => $this->request->getPost('duracionminutos'),
        ]);

        return redirect()->to(base_url('ejerciciocliente/actual/' . $id))->with('success', 'Ejercicio asignado al cliente exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $ejercicioCliente = $this->ecModel->find($id);
        if (!$ejercicioCliente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'            => 'Editar Registro #' . $id,
            'ejercicioCliente' => $ejercicioCliente,
            'clientes'         => $this->clienteModel->getClientesWithPersona(),
            'ejercicios'       => $this->ejercicioModel->orderBy('nombre', 'ASC')->findAll(),
            'module'           => 'ejerciciocliente',
        ];

        return view('ejerciciocliente/ejerciciocliente_edit', $data);
    }

    public function update($id)
    {
        $ejercicioCliente = $this->ecModel->find($id);
        if (!$ejercicioCliente) {
            return redirect()->to(base_url('ejerciciocliente'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idejercicio'     => 'required|is_natural_no_zero',
            'idcliente'       => 'required|is_natural_no_zero',
            'fecha'           => 'required|valid_date[Y-m-d]',
            'duracionminutos' => 'required|is_natural_no_zero|greater_than[0]|less_than_equal_to[1440]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ecModel->update($id, [
            'idejercicio'     => $this->request->getPost('idejercicio'),
            'idcliente'       => $this->request->getPost('idcliente'),
            'fecha'           => $this->request->getPost('fecha'),
            'duracionminutos' => $this->request->getPost('duracionminutos'),
        ]);

        return redirect()->to(base_url('ejerciciocliente/actual/' . $id))->with('success', 'Registro actualizado exitosamente.');
    }

    public function delete($id)
    {
        $ejercicioCliente = $this->ecModel->find($id);
        if (!$ejercicioCliente) {
            return redirect()->to(base_url('ejerciciocliente'))->with('error', 'Registro no encontrado.');
        }

        $this->ecModel->delete($id);

        $last = $this->ecModel->elultimo();
        $targetUrl = $last ? 'ejerciciocliente/actual/' . $last['idejerciciocliente'] : 'ejerciciocliente';

        return redirect()->to(base_url($targetUrl))->with('success', 'Registro eliminado exitosamente.');
    }
}
