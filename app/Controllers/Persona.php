<?php

namespace App\Controllers;

use App\Models\PersonaModel;
use App\Models\SexoModel;
use App\Models\ClienteModel;
use App\Models\CorreoModel;
use App\Models\DireccionModel;
use App\Models\EstadoCivilModel;
use App\Models\EstadoCivilPersonaModel;
use App\Models\GeneroModel;
use App\Models\GeneroPersonaModel;

class Persona extends BaseController
{
    protected PersonaModel $personaModel;
    protected SexoModel $sexoModel;
    protected ClienteModel $clienteModel;
    protected CorreoModel $correoModel;
    protected DireccionModel $direccionModel;
    protected EstadoCivilModel $estadoCivilModel;
    protected EstadoCivilPersonaModel $ecpModel;
    protected GeneroModel $generoModel;
    protected GeneroPersonaModel $gpModel;

    public function __construct()
    {
        $this->personaModel     = new PersonaModel();
        $this->sexoModel        = new SexoModel();
        $this->clienteModel     = new ClienteModel();
        $this->correoModel      = new CorreoModel();
        $this->direccionModel   = new DireccionModel();
        $this->estadoCivilModel = new EstadoCivilModel();
        $this->ecpModel         = new EstadoCivilPersonaModel();
        $this->generoModel      = new GeneroModel();
        $this->gpModel          = new GeneroPersonaModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $persona = $this->personaModel->getPersonaDetail($id);
        } else {
            $last = $this->personaModel->elultimo();
            $persona = $last ? $this->personaModel->getPersonaDetail($last['idpersona']) : null;
        }

        if (!$persona) {
            $data = [
                'title'   => 'Ficha de Persona',
                'persona' => null,
                'module'  => 'persona',
            ];
            return view('persona/persona_record', $data);
        }

        $idpersona = $persona['idpersona'];

        $data = [
            'title'          => 'Ficha de Persona: ' . esc($persona['apellidos'] . ' ' . $persona['nombres']),
            'persona'        => $persona,
            'module'         => 'persona',
            'correos'        => $this->correoModel->getCorreosByPersona($idpersona),
            'direcciones'    => $this->direccionModel->getDireccionesByPersona($idpersona),
            'estadosCiviles' => $this->ecpModel->getEstadosCivilesByPersona($idpersona),
            'generos'        => $this->gpModel->getGenerosByPersona($idpersona),
            'catalogoSexo'   => $this->sexoModel->findAll(),
            'catalogoEC'     => $this->estadoCivilModel->findAll(),
            'catalogoGen'    => $this->generoModel->findAll(),
        ];

        return view('persona/persona_record', $data);
    }

    public function elprimero()
    {
        $first = $this->personaModel->elprimero();
        $id = $first ? $first['idpersona'] : null;
        return $this->actual($id);
    }

    public function elultimo()
    {
        $last = $this->personaModel->elultimo();
        $id = $last ? $last['idpersona'] : null;
        return $this->actual($id);
    }

    public function siguiente($id)
    {
        $next = $this->personaModel->siguiente($id);
        $nextId = $next ? $next['idpersona'] : $id;
        return $this->actual($nextId);
    }

    public function anterior($id)
    {
        $prev = $this->personaModel->anterior($id);
        $prevId = $prev ? $prev['idpersona'] : $id;
        return $this->actual($prevId);
    }

    // Vista para listar todas las personas
    public function listar()
    {
        $search = $this->request->getGet('q');
        $personas = $this->personaModel->getPersonasWithRelations($search);

        $data = [
            'title'    => 'Listado General de Personas',
            'personas' => $personas,
            'search'   => $search,
            'module'   => 'persona',
        ];

        return view('persona/persona_list', $data);
    }

    // Vista de formulario para registrar nueva persona
    public function add()
    {
        $data = [
            'title'          => 'Registrar Nueva Persona',
            'module'         => 'persona',
            'sexos'          => $this->sexoModel->findAll(),
            'estadosCiviles' => $this->estadoCivilModel->findAll(),
            'generos'        => $this->generoModel->findAll(),
        ];

        return view('persona/persona_form', $data);
    }

    public function save()
    {
        $rules = [
            'cedula'          => 'required|min_length[5]|max_length[20]|is_unique[persona.cedula]',
            'apellidos'       => 'required|min_length[2]|max_length[100]',
            'nombres'         => 'required|min_length[2]|max_length[100]',
            'fechanacimiento' => 'permit_empty|valid_date',
            'idsexo'          => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $idpersona = $this->personaModel->insert([
            'cedula'          => trim($this->request->getPost('cedula')),
            'apellidos'       => trim($this->request->getPost('apellidos')),
            'nombres'         => trim($this->request->getPost('nombres')),
            'fechanacimiento' => !empty($this->request->getPost('fechanacimiento')) ? $this->request->getPost('fechanacimiento') : null,
            'idsexo'          => !empty($this->request->getPost('idsexo')) ? $this->request->getPost('idsexo') : null,
        ]);

        if ($this->request->getPost('es_cliente')) {
            $this->clienteModel->insert(['idpersona' => $idpersona]);
        }

        $correo = trim($this->request->getPost('correo') ?? '');
        if (!empty($correo)) {
            $this->correoModel->insert([
                'idpersona'      => $idpersona,
                'correo'         => $correo,
                'fechaoptencion' => date('Y-m-d'),
            ]);
        }

        $direccion = trim($this->request->getPost('direccion') ?? '');
        if (!empty($direccion)) {
            $this->direccionModel->insert([
                'idpersona' => $idpersona,
                'direccion' => $direccion,
            ]);
        }

        $idEC = $this->request->getPost('idestadocivil');
        if (!empty($idEC)) {
            $this->ecpModel->insert([
                'idpersona'     => $idpersona,
                'idestadocivil' => $idEC,
            ]);
        }

        $idGen = $this->request->getPost('idgenero');
        if (!empty($idGen)) {
            $this->gpModel->insert([
                'idpersona' => $idpersona,
                'idgenero'  => $idGen,
            ]);
        }

        $db->transComplete();

        return redirect()->to(base_url('persona/actual/' . $idpersona))
                         ->with('success', 'Persona registrada exitosamente con todas sus dependencias.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $persona = $this->personaModel->find($id);
        if (!$persona) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Persona no encontrada.");
        }

        $data = [
            'title'   => 'Editar Persona: ' . esc($persona['apellidos'] . ' ' . $persona['nombres']),
            'persona' => $persona,
            'module'  => 'persona',
            'sexos'   => $this->sexoModel->findAll(),
        ];

        return view('persona/persona_edit', $data);
    }

    public function update($id)
    {
        $persona = $this->personaModel->find($id);
        if (!$persona) {
            return redirect()->to(base_url('persona'))->with('error', 'Persona no encontrada.');
        }

        $rules = [
            'cedula'          => "required|min_length[5]|max_length[20]|is_unique[persona.cedula,idpersona,{$id}]",
            'apellidos'       => 'required|min_length[2]|max_length[100]',
            'nombres'         => 'required|min_length[2]|max_length[100]',
            'fechanacimiento' => 'permit_empty|valid_date',
            'idsexo'          => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->personaModel->update($id, [
            'cedula'          => trim($this->request->getPost('cedula')),
            'apellidos'       => trim($this->request->getPost('apellidos')),
            'nombres'         => trim($this->request->getPost('nombres')),
            'fechanacimiento' => !empty($this->request->getPost('fechanacimiento')) ? $this->request->getPost('fechanacimiento') : null,
            'idsexo'          => !empty($this->request->getPost('idsexo')) ? $this->request->getPost('idsexo') : null,
        ]);

        return redirect()->to(base_url('persona/actual/' . $id))->with('success', 'Datos de la persona actualizados correctamente.');
    }

    public function delete($id)
    {
        $persona = $this->personaModel->find($id);
        if (!$persona) {
            return redirect()->to(base_url('persona'))->with('error', 'Persona no encontrada.');
        }

        $this->personaModel->delete($id);

        return redirect()->to(base_url('persona/elprimero'))->with('success', 'Persona y sus dependencias eliminadas correctamente.');
    }

    public function toggleCliente($id)
    {
        $cliente = $this->clienteModel->where('idpersona', $id)->first();
        if ($cliente) {
            $this->clienteModel->delete($cliente['idcliente']);
            $msg = 'Persona retirada de clientes.';
        } else {
            $this->clienteModel->insert(['idpersona' => $id]);
            $msg = 'Persona asignada como cliente activo.';
        }

        return redirect()->to(base_url('persona/actual/' . $id))->with('success', $msg);
    }
}
