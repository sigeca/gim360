<?php

namespace App\Controllers;

use App\Models\ComponenteNutricionalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ComponenteNutricional extends BaseController
{
    protected ComponenteNutricionalModel $componenteModel;

    public function __construct()
    {
        $this->componenteModel = new ComponenteNutricionalModel();
    }

    /**
     * Entrada principal al módulo (muestra el registro actual o primero)
     */
    public function index($id = null)
    {
        return $this->actual($id);
    }

    /**
     * Muestra la ficha detallada de un registro específico
     */
    public function actual($id = null)
    {
        if ($id) {
            $componente = $this->componenteModel->find($id);
        } else {
            $first = $this->componenteModel->elprimero();
            $componente = $first ?: null;
        }

        $alimentos = [];
        $recetas   = [];
        if ($componente) {
            $idcomp    = (int)$componente['idcomponentenutricional'];
            $alimentos = $this->componenteModel->getAlimentosByComponente($idcomp);
            $recetas   = $this->componenteModel->getRecetasByComponente($idcomp);
        }

        $data = [
            'title'      => 'Ficha de Componente Nutricional' . ($componente ? ': ' . $componente['nombre'] : ''),
            'componente' => $componente,
            'alimentos'  => $alimentos,
            'recetas'    => $recetas,
            'module'     => 'componentenutricional',
        ];

        return view('componentenutricional/componentenutricional_record', $data);
    }

    /**
     * Navegación: Ir al primer registro
     */
    public function elprimero()
    {
        $first = $this->componenteModel->elprimero();
        return $this->actual($first ? $first['idcomponentenutricional'] : null);
    }

    /**
     * Navegación: Ir al último registro
     */
    public function elultimo()
    {
        $last = $this->componenteModel->elultimo();
        return $this->actual($last ? $last['idcomponentenutricional'] : null);
    }

    /**
     * Navegación: Ir al siguiente registro respecto al ID dado
     */
    public function siguiente($id)
    {
        $next = $this->componenteModel->siguiente($id);
        return $this->actual($next ? $next['idcomponentenutricional'] : $id);
    }

    /**
     * Navegación: Ir al registro anterior respecto al ID dado
     */
    public function anterior($id)
    {
        $prev = $this->componenteModel->anterior($id);
        return $this->actual($prev ? $prev['idcomponentenutricional'] : $id);
    }

    /**
     * Vista en tabla de todos los registros con buscador
     */
    public function listar()
    {
        $search = $this->request->getGet('q');
        $componentes = $this->componenteModel->getComponentes($search);

        $data = [
            'title'       => 'Catálogo de Componentes Nutricionales',
            'componentes' => $componentes,
            'search'      => $search,
            'module'      => 'componentenutricional',
        ];

        return view('componentenutricional/componentenutricional_list', $data);
    }

    /**
     * Formulario para registrar un nuevo componente nutricional
     */
    public function add()
    {
        $data = [
            'title'  => 'Registrar Componente Nutricional',
            'module' => 'componentenutricional',
        ];

        return view('componentenutricional/componentenutricional_form', $data);
    }

    /**
     * Procesa y almacena un nuevo componente nutricional
     */
    public function save()
    {
        $rules = [
            'nombre'      => 'required|min_length[2]|max_length[100]|is_unique[componentenutricional.nombre]',
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del componente nutricional es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 100 caracteres.',
                'is_unique'  => 'Ya existe un componente nutricional registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->componenteModel->insert([
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('componentenutricional/actual/' . $id))
                         ->with('success', 'Componente nutricional registrado exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $componente = $this->componenteModel->find($id);
        if (!$componente) {
            throw PageNotFoundException::forPageNotFound("Componente nutricional no encontrado.");
        }

        $data = [
            'title'      => 'Editar Componente Nutricional: ' . $componente['nombre'],
            'componente' => $componente,
            'module'     => 'componentenutricional',
        ];

        return view('componentenutricional/componentenutricional_edit', $data);
    }

    /**
     * Actualiza el registro en la base de datos
     */
    public function update($id)
    {
        $componente = $this->componenteModel->find($id);
        if (!$componente) {
            return redirect()->to(base_url('componentenutricional'))->with('error', 'Componente no encontrado.');
        }

        $rules = [
            'nombre'      => "required|min_length[2]|max_length[100]|is_unique[componentenutricional.nombre,idcomponentenutricional,{$id}]",
            'descripcion' => 'permit_empty',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del componente nutricional es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede superar los 100 caracteres.',
                'is_unique'  => 'Ya existe otro componente registrado con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->componenteModel->update($id, [
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('componentenutricional/actual/' . $id))
                         ->with('success', 'Componente nutricional actualizado exitosamente.');
    }

    /**
     * Elimina el registro
     */
    public function delete($id)
    {
        $componente = $this->componenteModel->find($id);
        if (!$componente) {
            return redirect()->to(base_url('componentenutricional'))->with('error', 'Componente no encontrado.');
        }

        try {
            $this->componenteModel->delete($id);
            $first = $this->componenteModel->elprimero();
            $targetUrl = $first ? 'componentenutricional/actual/' . $first['idcomponentenutricional'] : 'componentenutricional';
            return redirect()->to(base_url($targetUrl))->with('success', 'Componente nutricional eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('componentenutricional/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
