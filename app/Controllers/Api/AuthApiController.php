<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsuarioModel;
use App\Models\PersonaModel;
use App\Models\ClienteModel;
use App\Models\SexoModel;

class AuthApiController extends ResourceController
{
    protected $format = 'json';

    public function __construct()
    {
        // Support CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    }

    public function options()
    {
        return $this->response->setStatusCode(200);
    }

    /**
     * Iniciar sesión en la app móvil
     * POST /api/auth/login o POST /api/login
     */
    public function login()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        $identifier = trim($input['nombreusuario'] ?? $input['usuario'] ?? $input['cedula'] ?? '');
        $password   = $input['password'] ?? $input['contrasena'] ?? '';

        if (empty($identifier) || empty($password)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'Debe ingresar su nombre de usuario o cédula y su contraseña.',
                'message' => 'Debe ingresar su nombre de usuario o cédula y su contraseña.',
            ]);
        }

        $usuarioModel = new UsuarioModel();
        $user = $usuarioModel->getUsuarioByUsernameOrCedula($identifier);

        if (!$user) {
            return $this->response->setStatusCode(404)->setJSON([
                'status'  => 404,
                'error'   => 'El usuario o cédula "' . esc($identifier) . '" no se encuentra registrado. Regístrese si aún no tiene una cuenta.',
                'message' => 'El usuario o cédula "' . esc($identifier) . '" no se encuentra registrado. Regístrese si aún no tiene una cuenta.',
            ]);
        }

        if (!password_verify($password, $user['password'])) {
            return $this->response->setStatusCode(401)->setJSON([
                'status'  => 401,
                'error'   => 'Contraseña incorrecta. Verifique sus credenciales.',
                'message' => 'Contraseña incorrecta. Verifique sus credenciales.',
            ]);
        }

        // Obtener datos completos de la persona
        $personaModel = new PersonaModel();
        $persona = $personaModel->getPersonaWithDetails($user['idpersona']);

        // Asegurar que la persona tenga su registro como cliente
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('idpersona', $user['idpersona'])->first();
        if (!$cliente) {
            $idcliente = $clienteModel->insert(['idpersona' => $user['idpersona']]);
            $cliente = $clienteModel->find($idcliente);
        }

        $idcliente = (int)$cliente['idcliente'];

        // Obtener programa activo si tiene
        $db = \Config\Database::connect();
        $activeProg = $db->table('programacliente')
                         ->select('programaentrenamiento.nombre as programa_nombre')
                         ->join('programaentrenamiento', 'programaentrenamiento.idprogramaentrenamiento = programacliente.idprogramaentrenamiento')
                         ->join('estadoprogramacliente', 'estadoprogramacliente.idestadoprogramacliente = programacliente.idestadoprogramacliente')
                         ->where('programacliente.idcliente', $idcliente)
                         ->where('estadoprogramacliente.nombre', 'Activo')
                         ->orderBy('programacliente.idprogramacliente', 'DESC')
                         ->get()
                         ->getRowArray();

        $userData = [
            'idusuario'       => (int)$user['idusuario'],
            'nombreusuario'   => $user['nombreusuario'],
            'idpersona'       => (int)$user['idpersona'],
            'idcliente'       => $idcliente,
            'cedula'          => $persona['cedula'] ?? $user['cedula'],
            'nombres'         => $persona['nombres'] ?? $user['persona_nombres'],
            'apellidos'       => $persona['apellidos'] ?? $user['persona_apellidos'],
            'nombre_completo' => trim(($persona['nombres'] ?? $user['persona_nombres']) . ' ' . ($persona['apellidos'] ?? $user['persona_apellidos'])),
            'fechanacimiento' => $persona['fechanacimiento'] ?? null,
            'idsexo'          => !empty($persona['idsexo']) ? (int)$persona['idsexo'] : null,
            'sexo_nombre'     => $persona['sexo_nombre'] ?? null,
            'programa_activo' => $activeProg['programa_nombre'] ?? null,
        ];

        return $this->response->setStatusCode(200)->setJSON([
            'status'  => 200,
            'message' => '¡Bienvenido/a a GIM360, ' . $userData['nombres'] . '!',
            'data'    => $userData,
        ]);
    }

    /**
     * Verificar si una cédula ya está registrada como persona y si tiene usuario
     * GET /api/auth/verificar-cedula?cedula=...
     * POST /api/auth/verificar-cedula
     */
    public function verificarCedula()
    {
        $cedula = trim($this->request->getGet('cedula') ?? $this->request->getJSON(true)['cedula'] ?? $this->request->getPost('cedula') ?? '');

        if (empty($cedula)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'Debe ingresar una cédula a verificar.',
                'message' => 'Debe ingresar una cédula a verificar.',
            ]);
        }

        $personaModel = new PersonaModel();
        $persona = $personaModel->where('cedula', $cedula)->first();

        if (!$persona) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 200,
                'data'   => [
                    'existe_persona' => false,
                    'tiene_usuario'  => false,
                    'cedula'         => $cedula,
                    'mensaje'        => 'Persona no registrada. Complete los datos para registrarse.',
                ],
            ]);
        }

        $usuarioModel = new UsuarioModel();
        $usuario = $usuarioModel->where('idpersona', $persona['idpersona'])->first();

        if ($usuario) {
            return $this->response->setStatusCode(200)->setJSON([
                'status' => 200,
                'data'   => [
                    'existe_persona' => true,
                    'tiene_usuario'  => true,
                    'cedula'         => $cedula,
                    'nombreusuario'  => $usuario['nombreusuario'],
                    'persona'        => [
                        'idpersona'       => (int)$persona['idpersona'],
                        'cedula'          => $persona['cedula'],
                        'nombres'         => $persona['nombres'],
                        'apellidos'       => $persona['apellidos'],
                        'nombre_completo' => trim($persona['nombres'] . ' ' . $persona['apellidos']),
                    ],
                    'mensaje'        => 'La persona con cédula ' . $cedula . ' ya tiene usuario asignado (@' . $usuario['nombreusuario'] . '). Por favor inicie sesión.',
                ],
            ]);
        }

        return $this->response->setStatusCode(200)->setJSON([
            'status' => 200,
            'data'   => [
                'existe_persona' => true,
                'tiene_usuario'  => false,
                'cedula'         => $cedula,
                'persona'        => [
                    'idpersona'       => (int)$persona['idpersona'],
                    'cedula'          => $persona['cedula'],
                    'nombres'         => $persona['nombres'],
                    'apellidos'       => $persona['apellidos'],
                    'fechanacimiento' => $persona['fechanacimiento'],
                    'idsexo'          => !empty($persona['idsexo']) ? (int)$persona['idsexo'] : null,
                    'nombre_completo' => trim($persona['nombres'] . ' ' . $persona['apellidos']),
                ],
                'mensaje'        => '¡Persona encontrada! Ingrese su nuevo nombre de usuario y contraseña para activar su cuenta.',
            ],
        ]);
    }

    /**
     * Registro integral en la app móvil:
     * - Si la persona ya existe pero NO tiene usuario: asigna el usuario a la persona.
     * - Si la persona NO existe: crea la persona y crea su usuario.
     * POST /api/auth/registro o POST /api/registro
     */
    public function register()
    {
        $input = $this->request->getJSON(true) ?? $this->request->getPost();

        $cedula        = trim($input['cedula'] ?? '');
        $nombreusuario = trim($input['nombreusuario'] ?? $input['usuario'] ?? '');
        $password      = $input['password'] ?? $input['contrasena'] ?? '';
        $nombres       = trim($input['nombres'] ?? '');
        $apellidos     = trim($input['apellidos'] ?? '');
        $fechanacimiento = !empty($input['fechanacimiento']) ? $input['fechanacimiento'] : null;
        $idsexo        = !empty($input['idsexo']) ? (int)$input['idsexo'] : null;

        if (empty($cedula)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'La cédula es obligatoria.',
                'message' => 'La cédula es obligatoria.',
            ]);
        }

        if (empty($nombreusuario) || strlen($nombreusuario) < 3) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'El nombre de usuario debe tener al menos 3 caracteres.',
                'message' => 'El nombre de usuario debe tener al menos 3 caracteres.',
            ]);
        }

        if (empty($password) || strlen($password) < 4) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'La contraseña debe contener al menos 4 caracteres.',
                'message' => 'La contraseña debe contener al menos 4 caracteres.',
            ]);
        }

        $usuarioModel = new UsuarioModel();
        // Verificar si nombreusuario ya existe
        $existingUsername = $usuarioModel->where('nombreusuario', $nombreusuario)->first();
        if ($existingUsername) {
            return $this->response->setStatusCode(400)->setJSON([
                'status'  => 400,
                'error'   => 'El nombre de usuario "@' . $nombreusuario . '" ya está en uso. Por favor elija otro.',
                'message' => 'El nombre de usuario "@' . $nombreusuario . '" ya está en uso. Por favor elija otro.',
            ]);
        }

        $personaModel = new PersonaModel();
        $persona = $personaModel->where('cedula', $cedula)->first();

        if ($persona) {
            $idpersona = (int)$persona['idpersona'];

            // Verificar si ya tiene usuario
            $existingUser = $usuarioModel->where('idpersona', $idpersona)->first();
            if ($existingUser) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => 400,
                    'error'   => 'Esta persona ya tiene una cuenta activa (@' . $existingUser['nombreusuario'] . '). Inicie sesión.',
                    'message' => 'Esta persona ya tiene una cuenta activa (@' . $existingUser['nombreusuario'] . '). Inicie sesión.',
                ]);
            }

            // Actualizar datos si venían vacíos y se envían ahora
            $updateData = [];
            if (empty($persona['fechanacimiento']) && $fechanacimiento) {
                $updateData['fechanacimiento'] = $fechanacimiento;
            }
            if (empty($persona['idsexo']) && $idsexo) {
                $updateData['idsexo'] = $idsexo;
            }
            if (!empty($updateData)) {
                $personaModel->update($idpersona, $updateData);
            }
        } else {
            // Persona nueva: nombres y apellidos requeridos
            if (empty($nombres) || empty($apellidos)) {
                return $this->response->setStatusCode(400)->setJSON([
                    'status'  => 400,
                    'error'   => 'Para personas nuevas, los nombres y apellidos son obligatorios.',
                    'message' => 'Para personas nuevas, los nombres y apellidos son obligatorios.',
                ]);
            }

            $idpersona = $personaModel->insert([
                'cedula'          => $cedula,
                'nombres'         => $nombres,
                'apellidos'       => $apellidos,
                'fechanacimiento' => $fechanacimiento,
                'idsexo'          => $idsexo,
            ]);

            if (!$idpersona) {
                return $this->response->setStatusCode(500)->setJSON([
                    'status'  => 500,
                    'error'   => 'Error al registrar los datos personales.',
                    'message' => 'Error al registrar los datos personales.',
                ]);
            }
            $persona = $personaModel->find($idpersona);
        }

        // Asegurar que la persona tenga registro en cliente
        $clienteModel = new ClienteModel();
        $cliente = $clienteModel->where('idpersona', $idpersona)->first();
        if (!$cliente) {
            $idcliente = $clienteModel->insert(['idpersona' => $idpersona]);
            $cliente = $clienteModel->find($idcliente);
        } else {
            $idcliente = (int)$cliente['idcliente'];
        }

        // Crear la cuenta de usuario
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $idusuario = $usuarioModel->insert([
            'idpersona'     => $idpersona,
            'nombreusuario' => $nombreusuario,
            'password'      => $hashedPassword,
        ]);

        if (!$idusuario) {
            return $this->response->setStatusCode(500)->setJSON([
                'status'  => 500,
                'error'   => 'Error al crear la cuenta de usuario.',
                'message' => 'Error al crear la cuenta de usuario.',
            ]);
        }

        $fullUser = $usuarioModel->getUsuarioWithPersona($idusuario);
        $personaDet = $personaModel->getPersonaWithDetails($idpersona);

        $userData = [
            'idusuario'       => (int)$idusuario,
            'nombreusuario'   => $nombreusuario,
            'idpersona'       => $idpersona,
            'idcliente'       => $idcliente,
            'cedula'          => $personaDet['cedula'] ?? $cedula,
            'nombres'         => $personaDet['nombres'] ?? $nombres,
            'apellidos'       => $personaDet['apellidos'] ?? $apellidos,
            'nombre_completo' => trim(($personaDet['nombres'] ?? $nombres) . ' ' . ($personaDet['apellidos'] ?? $apellidos)),
            'fechanacimiento' => $personaDet['fechanacimiento'] ?? $fechanacimiento,
            'idsexo'          => !empty($personaDet['idsexo']) ? (int)$personaDet['idsexo'] : $idsexo,
            'sexo_nombre'     => $personaDet['sexo_nombre'] ?? null,
            'programa_activo' => null,
        ];

        return $this->response->setStatusCode(201)->setJSON([
            'status'  => 201,
            'message' => '¡Registro exitoso! Bienvenido/a a GIM360, ' . $userData['nombres'] . '.',
            'data'    => $userData,
        ]);
    }
}
