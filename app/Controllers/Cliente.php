<?php

namespace App\Controllers;

use App\Models\ClienteModel;
use App\Models\PersonaModel;

class Cliente extends BaseController
{
    protected ClienteModel $clienteModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->personaModel = new PersonaModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $cliente = $this->clienteModel->select('cliente.*, persona.cedula, persona.nombres AS persona_nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre')
                                          ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                                          ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                                          ->where('cliente.idcliente', $id)
                                          ->first();
        } else {
            $last = $this->clienteModel->elultimo();
            $cliente = $last ? $this->clienteModel->select('cliente.*, persona.cedula, persona.nombres AS persona_nombres, persona.fechanacimiento, sexo.nombre AS sexo_nombre')
                                                  ->join('persona', 'persona.idpersona = cliente.idpersona', 'inner')
                                                  ->join('sexo', 'sexo.idsexo = persona.idsexo', 'left')
                                                  ->where('cliente.idcliente', $last['idcliente'])
                                                  ->first() : null;
        }

        $data = [
            'title'   => 'Ficha de Cliente',
            'cliente' => $cliente,
            'module'  => 'cliente',
        ];

        return view('cliente/cliente_record', $data);
    }

    public function elprimero()
    {
        $first = $this->clienteModel->elprimero();
        return $this->actual($first ? $first['idcliente'] : null);
    }

    public function elultimo()
    {
        $last = $this->clienteModel->elultimo();
        return $this->actual($last ? $last['idcliente'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->clienteModel->siguiente($id);
        return $this->actual($next ? $next['idcliente'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->clienteModel->anterior($id);
        return $this->actual($prev ? $prev['idcliente'] : $id);
    }

    // Vista para listar todos los clientes
    public function listar()
    {
        $search = $this->request->getGet('q');
        $clientes = $this->clienteModel->getClientesWithPersona($search);

        $data = [
            'title'    => 'Listado de Clientes Gym',
            'clientes' => $clientes,
            'search'   => $search,
            'module'   => 'cliente',
        ];

        return view('cliente/cliente_list', $data);
    }

    // Vista de formulario para registrar nuevo cliente
    public function add()
    {
        $db = \Config\Database::connect();
        $subQuery = $db->table('cliente')->select('idpersona');
        $personasDisponibles = $this->personaModel->whereNotIn('idpersona', $subQuery)->orderBy('nombres', 'ASC')->findAll();

        $data = [
            'title'               => 'Asignar Nuevo Cliente',
            'personasDisponibles' => $personasDisponibles,
            'module'              => 'cliente',
        ];

        return view('cliente/cliente_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona' => 'required|is_natural_no_zero|is_unique[cliente.idpersona]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->clienteModel->insert([
            'idpersona' => $this->request->getPost('idpersona'),
        ]);

        return redirect()->to(base_url('cliente/actual/' . $id))->with('success', 'Cliente registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $cliente = $this->clienteModel->find($id);
        if (!$cliente) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente no encontrado.");
        }

        $personas = $this->personaModel->orderBy('nombres', 'ASC')->findAll();

        $data = [
            'title'    => 'Modificar Asignación de Cliente #' . $id,
            'cliente'  => $cliente,
            'personas' => $personas,
            'module'   => 'cliente',
        ];

        return view('cliente/cliente_edit', $data);
    }

    public function update($id)
    {
        $cliente = $this->clienteModel->find($id);
        if (!$cliente) {
            return redirect()->to(base_url('cliente'))->with('error', 'Cliente no encontrado.');
        }

        $rules = [
            'idpersona' => "required|is_natural_no_zero|is_unique[cliente.idpersona,idcliente,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->clienteModel->update($id, [
            'idpersona' => $this->request->getPost('idpersona'),
        ]);

        return redirect()->to(base_url('cliente/actual/' . $id))->with('success', 'Cliente actualizado exitosamente.');
    }

    public function delete($id)
    {
        $cliente = $this->clienteModel->find($id);
        if (!$cliente) {
            return redirect()->to(base_url('cliente'))->with('error', 'Registro no encontrado.');
        }

        $this->clienteModel->delete($id);

        return redirect()->to(base_url('cliente/elprimero'))->with('success', 'Cliente retirado correctamente.');
    }
}
