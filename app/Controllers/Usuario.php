<?php

namespace App\Controllers;

use App\Models\UsuarioModel;
use App\Models\PersonaModel;

class Usuario extends BaseController
{
    protected UsuarioModel $usuarioModel;
    protected PersonaModel $personaModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
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
            $usuario = $this->usuarioModel->getUsuarioWithPersona($id);
        } else {
            $last = $this->usuarioModel->elultimo();
            $usuario = $last ? $this->usuarioModel->getUsuarioWithPersona($last['idusuario']) : null;
        }

        $data = [
            'title'   => 'Ficha de Usuario',
            'usuario' => $usuario,
            'module'  => 'usuario',
        ];

        return view('usuario/usuario_record', $data);
    }

    public function elprimero()
    {
        $first = $this->usuarioModel->elprimero();
        return $this->actual($first ? $first['idusuario'] : null);
    }

    public function elultimo()
    {
        $last = $this->usuarioModel->elultimo();
        return $this->actual($last ? $last['idusuario'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->usuarioModel->siguiente($id);
        return $this->actual($next ? $next['idusuario'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->usuarioModel->anterior($id);
        return $this->actual($prev ? $prev['idusuario'] : $id);
    }

    // Listado general de usuarios con buscador
    public function listar()
    {
        $search = $this->request->getGet('q');
        $usuarios = $this->usuarioModel->getUsuariosWithPersona($search);

        $data = [
            'title'    => 'Listado de Usuarios Registrados',
            'usuarios' => $usuarios,
            'search'   => $search,
            'module'   => 'usuario',
        ];

        return view('usuario/usuario_list', $data);
    }

    // Formulario de creación
    public function add()
    {
        $idpersonaPreselected = $this->request->getGet('idpersona');

        $data = [
            'title'                => 'Registrar Nuevo Usuario',
            'personas'             => $this->personaModel->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'idpersonaPreselected' => $idpersonaPreselected,
            'module'               => 'usuario',
        ];

        return view('usuario/usuario_form', $data);
    }

    // Procesar inserción
    public function save()
    {
        $rules = [
            'idpersona'     => 'required|is_natural_no_zero',
            'nombreusuario' => 'required|min_length[3]|max_length[50]|is_unique[usuario.nombreusuario]',
            'password'      => 'required|min_length[4]|max_length[200]',
        ];

        $messages = [
            'idpersona' => [
                'required'           => 'Debe seleccionar una persona.',
                'is_natural_no_zero' => 'La persona seleccionada no es válida.',
            ],
            'nombreusuario' => [
                'required'   => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de usuario no puede exceder 50 caracteres.',
                'is_unique'  => 'El nombre de usuario ya está registrado en el sistema.',
            ],
            'password' => [
                'required'   => 'La contraseña es obligatoria.',
                'min_length' => 'La contraseña debe tener al menos 4 caracteres.',
                'max_length' => 'La contraseña no puede exceder 200 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $rawPassword = $this->request->getPost('password');
        $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT);

        $id = $this->usuarioModel->insert([
            'idpersona'     => $this->request->getPost('idpersona'),
            'nombreusuario' => trim($this->request->getPost('nombreusuario')),
            'password'      => $hashedPassword,
        ]);

        return redirect()->to(base_url('usuario/actual/' . $id))->with('success', 'Usuario registrado exitosamente.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuario no encontrado.");
        }

        $data = [
            'title'    => 'Editar Usuario #' . $id,
            'usuario'  => $usuario,
            'personas' => $this->personaModel->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'module'   => 'usuario',
        ];

        return view('usuario/usuario_edit', $data);
    }

    // Procesar actualización
    public function update($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to(base_url('usuario'))->with('error', 'Usuario no encontrado.');
        }

        $rules = [
            'idpersona'     => 'required|is_natural_no_zero',
            'nombreusuario' => "required|min_length[3]|max_length[50]|is_unique[usuario.nombreusuario,idusuario,{$id}]",
            'password'      => 'permit_empty|min_length[4]|max_length[200]',
        ];

        $messages = [
            'idpersona' => [
                'required'           => 'Debe seleccionar una persona.',
                'is_natural_no_zero' => 'La persona seleccionada no es válida.',
            ],
            'nombreusuario' => [
                'required'   => 'El nombre de usuario es obligatorio.',
                'min_length' => 'El nombre de usuario debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre de usuario no puede exceder 50 caracteres.',
                'is_unique'  => 'El nombre de usuario ya está registrado para otra cuenta.',
            ],
            'password' => [
                'min_length' => 'La contraseña debe tener al menos 4 caracteres.',
                'max_length' => 'La contraseña no puede exceder 200 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'idpersona'     => $this->request->getPost('idpersona'),
            'nombreusuario' => trim($this->request->getPost('nombreusuario')),
        ];

        $newPassword = $this->request->getPost('password');
        if (!empty($newPassword)) {
            $updateData['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->usuarioModel->update($id, $updateData);

        return redirect()->to(base_url('usuario/actual/' . $id))->with('success', 'Usuario actualizado exitosamente.');
    }

    // Eliminar usuario
    public function delete($id)
    {
        $usuario = $this->usuarioModel->find($id);
        if (!$usuario) {
            return redirect()->to(base_url('usuario'))->with('error', 'Usuario no encontrado.');
        }

        $this->usuarioModel->delete($id);

        return redirect()->to(base_url('usuario/elprimero'))->with('success', 'Usuario eliminado correctamente.');
    }
}
