<?php

namespace App\Controllers;

use App\Models\MusculoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Musculo extends BaseController
{
    protected MusculoModel $musculoModel;

    public function __construct()
    {
        $this->musculoModel = new MusculoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $musculo = $this->musculoModel->find($id);
        } else {
            $last = $this->musculoModel->elultimo();
            $musculo = $last ?: null;
        }

        $data = [
            'title'   => 'Ficha de Músculo' . ($musculo ? ': ' . $musculo['nombre'] : ''),
            'musculo' => $musculo,
            'module'  => 'musculo',
        ];

        return view('musculo/musculo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->musculoModel->elprimero();
        return $this->actual($first ? $first['idmusculo'] : null);
    }

    public function elultimo()
    {
        $last = $this->musculoModel->elultimo();
        return $this->actual($last ? $last['idmusculo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->musculoModel->siguiente($id);
        return $this->actual($next ? $next['idmusculo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->musculoModel->anterior($id);
        return $this->actual($prev ? $prev['idmusculo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $vista  = $this->request->getGet('vista') ?? 'grid';
        $musculos = $this->musculoModel->getMusculos($search);

        $data = [
            'title'    => 'Catálogo de Músculos',
            'musculos' => $musculos,
            'search'   => $search,
            'vista'    => $vista,
            'module'   => 'musculo',
        ];

        return view('musculo/musculo_list', $data);
    }

    public function galeria()
    {
        $musculos = $this->musculoModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'    => 'Galería Visual de Músculos',
            'musculos' => $musculos,
            'module'   => 'musculo',
        ];

        return view('musculo/musculo_gallery', $data);
    }

    // Servir imagen del músculo desde el directorio repositorio/images/muscles
    public function imagen($filename = null)
    {
        if (empty($filename)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $cleanFilename = basename($filename);
        
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        
        $paths = [
            $baseDir . '/repositorio/images/muscles/' . $cleanFilename,
            $baseDir . '/repositorio/images/muscle/' . $cleanFilename,
            $baseDir . '/uploads/muscles/' . $cleanFilename,
        ];

        $targetPath = null;
        foreach ($paths as $p) {
            if (file_exists($p)) {
                $targetPath = $p;
                break;
            }
        }

        if (!$targetPath) {
            throw PageNotFoundException::forPageNotFound("Imagen de músculo no encontrada: " . $cleanFilename);
        }

        $extension = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'webp' => 'image/webp',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'svg'  => 'image/svg+xml',
        ];
        $contentType = $mimeTypes[$extension] ?? 'image/webp';

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($targetPath));
    }

    public function add()
    {
        $data = [
            'title'           => 'Registrar Nuevo Músculo',
            'availableImages' => $this->musculoModel->getAvailableImages(),
            'module'          => 'musculo',
        ];

        return view('musculo/musculo_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'imagen' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->musculoModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
            'imagen' => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('musculo/actual/' . $id))->with('success', 'Músculo registrado exitosamente.');
    }

    public function edit($id)
    {
        $musculo = $this->musculoModel->find($id);
        if (!$musculo) {
            throw PageNotFoundException::forPageNotFound("Músculo no encontrado.");
        }

        $data = [
            'title'           => 'Editar Músculo: ' . $musculo['nombre'],
            'musculo'         => $musculo,
            'availableImages' => $this->musculoModel->getAvailableImages(),
            'module'          => 'musculo',
        ];

        return view('musculo/musculo_edit', $data);
    }

    public function update($id)
    {
        $musculo = $this->musculoModel->find($id);
        if (!$musculo) {
            return redirect()->to(base_url('musculo'))->with('error', 'Músculo no encontrado.');
        }

        $rules = [
            'nombre' => 'required|min_length[2]|max_length[100]',
            'imagen' => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->musculoModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
            'imagen' => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('musculo/actual/' . $id))->with('success', 'Músculo actualizado exitosamente.');
    }

    public function delete($id)
    {
        $musculo = $this->musculoModel->find($id);
        if (!$musculo) {
            return redirect()->to(base_url('musculo'))->with('error', 'Músculo no encontrado.');
        }

        try {
            $this->musculoModel->delete($id);
            return redirect()->to(base_url('musculo/elprimero'))->with('success', 'Músculo eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('musculo/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
