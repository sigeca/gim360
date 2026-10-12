<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CorreoModel;
use App\Models\PersonaModel;

class CorreoApiController extends ResourceController
{
    protected $format = 'json';
    protected CorreoModel $correoModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->correoModel = new CorreoModel();
        $this->personaModel = new PersonaModel();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    public function options()
    {
        return $this->response->setStatusCode(200);
    }

    public function index()
    {
        $search = $this->request->getGet('q') ?? $this->request->getGet('search');
        $idpersona = $this->request->getGet('idpersona');

        if (!empty($idpersona)) {
            $data = $this->correoModel->getCorreosByPersona((int)$idpersona);
        } else {
            $data = $this->correoModel->getCorreosWithPersona($search);
        }

        return $this->respond([
            'status'  => 200,
            'message' => 'Correos obtenidos correctamente',
            'data'    => $data,
            'total'   => count($data),
        ]);
    }

    public function show($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }
        $item = $this->correoModel->find($id);
        if (!$item) {
            return $this->failNotFound('Correo no encontrado');
        }
        $persona = $this->personaModel->find($item['idpersona']);
        $item['persona'] = $persona;
        return $this->respond([
            'status' => 200,
            'data'   => $item,
        ]);
    }

    public function create()
    {
        $input = $this->request->getJSON(true) ?: $this->request->getPost();
        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'correo'    => 'required|valid_email|max_length[150]',
        ];
        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $idpersona = (int)$input['idpersona'];
        if (!$this->personaModel->find($idpersona)) {
            return $this->failNotFound("La persona con ID {$idpersona} no existe");
        }

        $id = $this->correoModel->insert([
            'idpersona'      => $idpersona,
            'correo'         => trim($input['correo']),
            'fechaoptencion' => !empty($input['fechaoptencion']) ? $input['fechaoptencion'] : date('Y-m-d'),
        ]);

        if (!$id) {
            return $this->failServerError('Error al registrar correo');
        }

        return $this->respondCreated([
            'status'  => 201,
            'message' => 'Correo registrado exitosamente',
            'data'    => $this->correoModel->find($id),
        ]);
    }

    public function update($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }
        $item = $this->correoModel->find($id);
        if (!$item) {
            return $this->failNotFound('Correo no encontrado');
        }

        $input = $this->request->getJSON(true) ?: $this->request->getRawInput();
        if (empty($input)) {
            $input = $this->request->getPost();
        }

        $rules = [
            'correo' => 'required|valid_email|max_length[150]',
        ];
        if (!$this->validateData($input, $rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $updateData = ['correo' => trim($input['correo'])];
        if (!empty($input['fechaoptencion'])) {
            $updateData['fechaoptencion'] = $input['fechaoptencion'];
        }
        if (!empty($input['idpersona'])) {
            $updateData['idpersona'] = (int)$input['idpersona'];
        }

        $this->correoModel->update($id, $updateData);

        return $this->respond([
            'status'  => 200,
            'message' => 'Correo actualizado exitosamente',
            'data'    => $this->correoModel->find($id),
        ]);
    }

    public function delete($id = null)
    {
        if (empty($id)) {
            return $this->failNotFound('ID no proporcionado');
        }
        $item = $this->correoModel->find($id);
        if (!$item) {
            return $this->failNotFound('Correo no encontrado');
        }

        $this->correoModel->delete($id);
        return $this->respondDeleted([
            'status'  => 200,
            'message' => 'Correo eliminado exitosamente',
            'data'    => ['idcorreo' => $id],
        ]);
    }
}
