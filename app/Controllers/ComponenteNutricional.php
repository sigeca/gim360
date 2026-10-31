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
        $imagenes  = [];
        $todasImagenes = [];
        if ($componente) {
            $idcomp    = (int)$componente['idcomponentenutricional'];
            $alimentos = $this->componenteModel->getAlimentosByComponente($idcomp);
            $recetas   = $this->componenteModel->getRecetasByComponente($idcomp);
            $imagenes  = $this->componenteModel->getImagenesByComponente($idcomp);

            $imagenModel = new \App\Models\ImagenModel();
            $todasImagenes = $imagenModel->getImagenes();
        }

        $data = [
            'title'         => 'Ficha de Componente Nutricional' . ($componente ? ': ' . $componente['nombre'] : ''),
            'componente'    => $componente,
            'alimentos'     => $alimentos,
            'recetas'       => $recetas,
            'imagenes'      => $imagenes,
            'todasImagenes' => $todasImagenes,
            'module'        => 'componentenutricional',
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

        foreach ($componentes as &$comp) {
            $imgs = $this->componenteModel->getImagenesByComponente((int)$comp['idcomponentenutricional']);
            $comp['total_imagenes'] = count($imgs);
            $comp['primera_imagen'] = !empty($imgs) ? $imgs[0] : null;
        }

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

    /**
     * Asignación rápida de una imagen a este componente
     */
    public function asignarImagen($idcomponente)
    {
        $idimagen = (int)$this->request->getPost('idimagen');
        if (empty($idimagen)) {
            return redirect()->to(base_url('componentenutricional/actual/' . $idcomponente))
                             ->with('error', 'Debe seleccionar una imagen para asociar.');
        }

        $icnModel = new \App\Models\ImagenComponenteNutricionalModel();
        $exists = $icnModel->where('idcomponentenutricional', (int)$idcomponente)
                           ->where('idimagen', $idimagen)
                           ->first();

        if ($exists) {
            return redirect()->to(base_url('componentenutricional/actual/' . $idcomponente))
                             ->with('error', 'La imagen seleccionada ya se encuentra asociada a este componente.');
        }

        $icnModel->insert([
            'idcomponentenutricional' => (int)$idcomponente,
            'idimagen'                => $idimagen,
        ]);

        return redirect()->to(base_url('componentenutricional/actual/' . $idcomponente))
                         ->with('success', 'Imagen asociada al componente nutricional correctamente.');
    }

    /**
     * Quitar una imagen de este componente
     */
    public function quitarImagen($idcomponente, $idimagen)
    {
        $icnModel = new \App\Models\ImagenComponenteNutricionalModel();
        $record = $icnModel->where('idcomponentenutricional', (int)$idcomponente)
                           ->where('idimagen', (int)$idimagen)
                           ->first();

        if ($record) {
            $icnModel->delete($record['idimagencomponentenutricional']);
            return redirect()->to(base_url('componentenutricional/actual/' . $idcomponente))
                             ->with('success', 'Imagen desvinculada del componente exitosamente.');
        }

        return redirect()->to(base_url('componentenutricional/actual/' . $idcomponente))
                         ->with('error', 'No se encontró la relación a eliminar.');
    }
}
