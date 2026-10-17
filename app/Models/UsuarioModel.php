<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    use NavigableTrait;

    protected $table            = 'usuario';
    protected $primaryKey       = 'idusuario';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['idpersona', 'nombreusuario', 'password'];

    protected $validationRules = [
        'idpersona'     => 'required|is_natural_no_zero',
        'nombreusuario' => 'required|min_length[3]|max_length[50]|is_unique[usuario.nombreusuario,idusuario,{idusuario}]',
        'password'      => 'required|min_length[4]|max_length[200]',
    ];

    protected $validationMessages = [
        'idpersona' => [
            'required'            => 'Debe seleccionar una persona.',
            'is_natural_no_zero'  => 'La persona seleccionada no es válida.',
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

    /**
     * Obtener lista de usuarios con información de la persona asociada
     */
    public function getUsuariosWithPersona(?string $search = null): array
    {
        $builder = $this->select('usuario.idusuario, usuario.idpersona, usuario.nombreusuario, usuario.password, persona.cedula, persona.nombres AS persona_nombres, persona.apellidos AS persona_apellidos')
                        ->join('persona', 'persona.idpersona = usuario.idpersona', 'inner')
                        ->orderBy('usuario.idusuario', 'DESC');

        if (!empty($search)) {
            $builder->groupStart()
                    ->like('usuario.nombreusuario', $search)
                    ->orLike('persona.cedula', $search)
                    ->orLike('persona.nombres', $search)
                    ->orLike('persona.apellidos', $search)
                    ->groupEnd();
        }

        return $builder->findAll();
    }

    /**
     * Obtener un usuario por ID con los datos de persona
     */
    public function getUsuarioWithPersona($id): ?array
    {
        return $this->select('usuario.idusuario, usuario.idpersona, usuario.nombreusuario, usuario.password, persona.cedula, persona.nombres AS persona_nombres, persona.apellidos AS persona_apellidos')
                    ->join('persona', 'persona.idpersona = usuario.idpersona', 'inner')
                    ->where('usuario.idusuario', $id)
                    ->first();
    }

    /**
     * Obtener usuarios asociados a una persona específica
     */
    public function getUsuariosByPersona($idpersona): array
    {
        return $this->where('idpersona', $idpersona)
                    ->orderBy('idusuario', 'ASC')
                    ->findAll();
    }

    /**
     * Obtener un usuario por nombre de usuario o por cédula de persona asociada
     */
    public function getUsuarioByUsernameOrCedula(string $identifier): ?array
    {
        return $this->select('usuario.idusuario, usuario.idpersona, usuario.nombreusuario, usuario.password, persona.cedula, persona.nombres AS persona_nombres, persona.apellidos AS persona_apellidos')
                    ->join('persona', 'persona.idpersona = usuario.idpersona', 'inner')
                    ->groupStart()
                        ->where('usuario.nombreusuario', $identifier)
                        ->orWhere('persona.cedula', $identifier)
                    ->groupEnd()
                    ->first();
    }

    /**
     * Obtener un usuario por nombre de usuario exacto
     */
    public function getUsuarioByUsername(string $username): ?array
    {
        return $this->select('usuario.idusuario, usuario.idpersona, usuario.nombreusuario, usuario.password, persona.cedula, persona.nombres AS persona_nombres, persona.apellidos AS persona_apellidos')
                    ->join('persona', 'persona.idpersona = usuario.idpersona', 'inner')
                    ->where('usuario.nombreusuario', $username)
                    ->first();
    }
}
