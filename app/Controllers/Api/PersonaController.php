<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\PersonaModel;
use App\Models\SexoModel;
use App\Models\ClienteModel;
use App\Models\CorreoModel;
use App\Models\DireccionModel;
use App\Models\EstadoCivilModel;
use App\Models\EstadoCivilPersonaModel;
use App\Models\GeneroModel;
use App\Models\GeneroPersonaModel;

class PersonaController extends ResourceController
{
    protected $format = 'json';

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

        // Support CORS for all clients (Flutter Web, Mobile, Desktop)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    /**
     * Handle CORS preflight requests
     */
    public function options()
    {
        return $this->response->setStatusCode(200);
    }

    /**
     * GET /api/persona
     * List all personas with relations and optional search filter
     */
    public function index()
    {
        $search = $this->request->getGet('q') ?? $this->request->getGet('search');
        $personas = $this->personaModel->getPersonasWithRelations($search);

        return $this->respond([
            'status'  => 200,
            'message' => 'Personas obtenidas correctamente',
            'data'    => $personas,
            'total'   => count($personas),
        ]);
    }

    /**
     * GET /api/persona/{id}
     * Get single persona with relations
     */
    public function show($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de persona no proporcionado');
        }

        $persona = $this->personaModel->getPersonaDetail($id);
        if (!$persona) {
            return $this->failNotFound("Persona no encontrada con ID: {$id}");
        }

        $data = [
            'persona'        => $persona,
            'correos'        => $this->correoModel->getCorreosByPersona($id),
            'direcciones'    => $this->direccionModel->getDireccionesByPersona($id),
            'estadosCiviles' => $this->ecpModel->getEstadosCivilesByPersona($id),
            'generos'        => $this->gpModel->getGenerosByPersona($id),
        ];

        return $this->respond([
            'status'  => 200,
            'message' => 'Persona obtenida correctamente',
            'data'    => $data,
        ]);
    }

    /**
     * POST /api/persona
     * Create a new persona
     */
    public function create()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();

        $rules = [
            'cedula'          => 'required|min_length[5]|max_length[20]|is_unique[persona.cedula]',
            'apellidos'       => 'required|min_length[2]|max_length[100]',
            'nombres'         => 'required|min_length[2]|max_length[100]',
            'fechanacimiento' => 'permit_empty|valid_date',
            'idsexo'          => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $personaData = [
            'cedula'          => trim($input['cedula']),
            'apellidos'       => trim($input['apellidos']),
            'nombres'         => trim($input['nombres']),
            'fechanacimiento' => !empty($input['fechanacimiento']) ? $input['fechanacimiento'] : null,
            'idsexo'          => !empty($input['idsexo']) ? (int)$input['idsexo'] : null,
        ];

        $idpersona = $this->personaModel->insert($personaData);

        // Cliente flag
        if (!empty($input['es_cliente'])) {
            $this->clienteModel->insert(['idpersona' => $idpersona]);
        }

        // Correo inicial opcional
        if (!empty($input['correo'])) {
            $this->correoModel->insert([
                'idpersona'      => $idpersona,
                'correo'         => trim($input['correo']),
                'fechaoptencion' => date('Y-m-d'),
            ]);
        }

        // Dirección inicial opcional
        if (!empty($input['direccion'])) {
            $this->direccionModel->insert([
                'idpersona' => $idpersona,
                'direccion' => trim($input['direccion']),
            ]);
        }

        // Estado Civil inicial opcional
        if (!empty($input['idestadocivil'])) {
            $this->ecpModel->insert([
                'idpersona'     => $idpersona,
                'idestadocivil' => (int)$input['idestadocivil'],
            ]);
        }

        // Género inicial opcional
        if (!empty($input['idgenero'])) {
            $this->gpModel->insert([
                'idpersona' => $idpersona,
                'idgenero'  => (int)$input['idgenero'],
            ]);
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->failServerError('Error al registrar la persona en la base de datos');
        }

        $created = $this->personaModel->getPersonaDetail($idpersona);

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Persona registrada exitosamente',
            'data'    => $created,
        ]);
    }

    /**
     * PUT/POST /api/persona/{id}
     * Update existing persona
     */
    public function update($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de persona no proporcionado');
        }

        $persona = $this->personaModel->find($id);
        if (!$persona) {
            return $this->failNotFound("Persona no encontrada con ID: {$id}");
        }

        $input = $this->request->getJSON(true) ?: $this->request->getRawInput();
        if (empty($input)) {
            $input = $this->request->getPost();
        }

        $rules = [
            'cedula'          => "required|min_length[5]|max_length[20]|is_unique[persona.cedula,idpersona,{$id}]",
            'apellidos'       => 'required|min_length[2]|max_length[100]',
            'nombres'         => 'required|min_length[2]|max_length[100]',
            'fechanacimiento' => 'permit_empty|valid_date',
            'idsexo'          => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $updateData = [
            'cedula'          => trim($input['cedula']),
            'apellidos'       => trim($input['apellidos']),
            'nombres'         => trim($input['nombres']),
            'fechanacimiento' => !empty($input['fechanacimiento']) ? $input['fechanacimiento'] : null,
            'idsexo'          => !empty($input['idsexo']) ? (int)$input['idsexo'] : null,
        ];

        $this->personaModel->skipValidation(true)->update($id, $updateData);

        // Update cliente flag if provided
        if (isset($input['es_cliente'])) {
            $existingCliente = $this->clienteModel->where('idpersona', $id)->first();
            $shouldBeCliente = filter_var($input['es_cliente'], FILTER_VALIDATE_BOOLEAN) || $input['es_cliente'] == 1;

            if ($shouldBeCliente && !$existingCliente) {
                $this->clienteModel->insert(['idpersona' => $id]);
            } elseif (!$shouldBeCliente && $existingCliente) {
                $this->clienteModel->delete($existingCliente['idcliente']);
            }
        }

        $updated = $this->personaModel->getPersonaDetail($id);

        return $this->respond([
            'status'  => 200,
            'message' => 'Persona actualizada exitosamente',
            'data'    => $updated,
        ]);
    }

    /**
     * DELETE /api/persona/{id}
     * Delete persona
     */
    public function delete($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID de persona no proporcionado');
        }

        $persona = $this->personaModel->find($id);
        if (!$persona) {
            return $this->failNotFound("Persona no encontrada con ID: {$id}");
        }

        $this->personaModel->delete($id);

        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Persona eliminada exitosamente',
            'data'    => ['idpersona' => $id],
        ]);
    }

    /**
     * GET /api/catalogos
     * Get catalogs (sexo, estadocivil, genero)
     */
    public function catalogos()
    {
        return $this->respond([
            'status' => 200,
            'data'   => [
                'sexos'          => $this->sexoModel->findAll(),
                'estadosCiviles' => $this->estadoCivilModel->findAll(),
                'generos'        => $this->generoModel->findAll(),
            ],
        ]);
    }
}
