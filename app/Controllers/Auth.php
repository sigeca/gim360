<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PersonaModel;
use App\Models\SexoModel;

class Auth extends BaseController
{
    protected UsuarioModel $usuarioModel;
    protected PersonaModel $personaModel;
    protected SexoModel $sexoModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        $this->personaModel = new PersonaModel();
        $this->sexoModel    = new SexoModel();
    }

    /**
     * Muestra el formulario de inicio de sesión
     */
    public function login()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('home'))->with('info', 'Ya has iniciado sesión.');
        }

        $data = [
            'title' => 'Iniciar Sesión | GIM360',
        ];

        return view('auth/login', $data);
    }

    /**
     * Procesa la autenticación del usuario
     */
    public function processLogin()
    {
        $rules = [
            'nombreusuario' => 'required',
            'password'      => 'required',
        ];

        $messages = [
            'nombreusuario' => [
                'required' => 'Ingrese su nombre de usuario o cédula.',
            ],
            'password' => [
                'required' => 'Ingrese su contraseña.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identifier = trim($this->request->getPost('nombreusuario'));
        $password   = $this->request->getPost('password');

        // Búsqueda por nombre de usuario o por cédula
        $user = $this->usuarioModel->getUsuarioByUsernameOrCedula($identifier);

        if (!$user) {
            return redirect()->back()->withInput()->with('error', 'El usuario o cédula ingresado no se encuentra registrado. Si es nuevo, por favor regístrese.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Contraseña incorrecta. Por favor, verifique sus datos.');
        }

        // Crear la sesión autenticada
        session()->set([
            'isLoggedIn'              => true,
            'idusuario'               => $user['idusuario'],
            'idpersona'               => $user['idpersona'],
            'nombreusuario'           => $user['nombreusuario'],
            'persona_cedula'          => $user['cedula'],
            'persona_nombres'         => $user['persona_nombres'],
            'persona_apellidos'       => $user['persona_apellidos'],
            'persona_nombre_completo' => trim($user['persona_apellidos'] . ' ' . $user['persona_nombres']),
        ]);

        return redirect()->to(base_url('home'))->with('success', '¡Bienvenido/a de nuevo, ' . esc($user['persona_nombres']) . '!');
    }

    /**
     * Muestra el formulario de registro al sistema
     */
    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('home'))->with('info', 'Ya has iniciado sesión.');
        }

        $data = [
            'title' => 'Registrarse en el Sistema | GIM360',
            'sexos' => $this->sexoModel->findAll(),
        ];

        return view('auth/register', $data);
    }

    /**
     * Procesa el registro integral de persona y usuario
     */
    public function processRegister()
    {
        $rules = [
            'cedula'           => 'required|min_length[5]|max_length[20]',
            'nombres'          => 'required|min_length[2]|max_length[100]',
            'apellidos'        => 'required|min_length[2]|max_length[100]',
            'fechanacimiento'  => 'permit_empty|valid_date',
            'idsexo'           => 'permit_empty|is_natural_no_zero',
            'nombreusuario'    => 'required|min_length[3]|max_length[50]|is_unique[usuario.nombreusuario]',
            'password'         => 'required|min_length[4]|max_length[200]',
            'password_confirm' => 'required|matches[password]',
        ];

        $messages = [
            'cedula' => [
                'required'   => 'La cédula es obligatoria.',
                'min_length' => 'La cédula debe contener al menos 5 caracteres.',
                'max_length' => 'La cédula no puede superar los 20 caracteres.',
            ],
            'nombres' => [
                'required'   => 'Los nombres son obligatorios.',
                'min_length' => 'Los nombres deben tener al menos 2 caracteres.',
            ],
            'apellidos' => [
                'required'   => 'Los apellidos son obligatorios.',
                'min_length' => 'Los apellidos deben tener al menos 2 caracteres.',
            ],
            'nombreusuario' => [
                'required'   => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de usuario no puede exceder 50 caracteres.',
                'is_unique'  => 'Este nombre de usuario ya está ocupado. Por favor, elija otro.',
            ],
            'password' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 4 caracteres.',
            ],
            'password_confirm' => [
                'required' => 'Debe confirmar su contraseña.',
                'matches'  => 'Las contraseñas no coinciden.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cedula = trim($this->request->getPost('cedula'));

        // Verificar si la persona ya existe en la base de datos
        $persona = $this->personaModel->where('cedula', $cedula)->first();

        if ($persona) {
            $idpersona = $persona['idpersona'];

            // Verificar si esta persona ya tiene un usuario asignado
            $existingUser = $this->usuarioModel->where('idpersona', $idpersona)->first();
            if ($existingUser) {
                return redirect()->back()->withInput()->with('error', 'La persona con cédula ' . esc($cedula) . ' ya tiene la cuenta de usuario "@' . esc($existingUser['nombreusuario']) . '". Por favor inicie sesión.');
            }

            // Opcionalmente actualizamos nombres o datos si venían vacíos
            $updatePersona = [];
            if (empty($persona['fechanacimiento']) && !empty($this->request->getPost('fechanacimiento'))) {
                $updatePersona['fechanacimiento'] = $this->request->getPost('fechanacimiento');
            }
            if (empty($persona['idsexo']) && !empty($this->request->getPost('idsexo'))) {
                $updatePersona['idsexo'] = $this->request->getPost('idsexo');
            }
            if (!empty($updatePersona)) {
                $this->personaModel->update($idpersona, $updatePersona);
            }
        } else {
            // Si la persona no está registrada como persona, se registra primero
            $idpersona = $this->personaModel->insert([
                'cedula'          => $cedula,
                'nombres'         => trim($this->request->getPost('nombres')),
                'apellidos'       => trim($this->request->getPost('apellidos')),
                'fechanacimiento' => !empty($this->request->getPost('fechanacimiento')) ? $this->request->getPost('fechanacimiento') : null,
                'idsexo'          => !empty($this->request->getPost('idsexo')) ? $this->request->getPost('idsexo') : null,
            ]);

            if (!$idpersona) {
                return redirect()->back()->withInput()->with('error', 'Ocurrió un error al registrar los datos personales.');
            }
        }

        // Crear la cuenta de usuario para esta persona
        $hashedPassword = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        $idusuario = $this->usuarioModel->insert([
            'idpersona'     => $idpersona,
            'nombreusuario' => trim($this->request->getPost('nombreusuario')),
            'password'      => $hashedPassword,
        ]);

        if (!$idusuario) {
            return redirect()->back()->withInput()->with('error', 'Ocurrió un error al crear la cuenta de usuario.');
        }

        // Recuperar usuario completo con persona para sesión automática
        $user = $this->usuarioModel->getUsuarioWithPersona($idusuario);

        session()->set([
            'isLoggedIn'              => true,
            'idusuario'               => $user['idusuario'],
            'idpersona'               => $user['idpersona'],
            'nombreusuario'           => $user['nombreusuario'],
            'persona_cedula'          => $user['cedula'],
            'persona_nombres'         => $user['persona_nombres'],
            'persona_apellidos'       => $user['persona_apellidos'],
            'persona_nombre_completo' => trim($user['persona_apellidos'] . ' ' . $user['persona_nombres']),
        ]);

        return redirect()->to(base_url('home'))->with('success', '¡Registro completado exitosamente! Bienvenido/a a GIM360, ' . esc($user['persona_nombres']) . '.');
    }

    /**
     * Cierra la sesión activa
     */
    public function logout()
    {
        session()->remove([
            'isLoggedIn',
            'idusuario',
            'idpersona',
            'nombreusuario',
            'persona_cedula',
            'persona_nombres',
            'persona_apellidos',
            'persona_nombre_completo',
        ]);
        session()->regenerate(true);

        return redirect()->to(base_url('login'))->with('success', 'Sesión finalizada correctamente.');
    }
}
