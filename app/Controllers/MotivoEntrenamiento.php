<?php

namespace App\Controllers;

use App\Models\MotivoEntrenamientoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MotivoEntrenamiento extends BaseController
{
    protected MotivoEntrenamientoModel $motivoModel;

    public function __construct()
    {
        $this->motivoModel = new MotivoEntrenamientoModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $motivo = $id ? $this->motivoModel->find($id) : $this->motivoModel->elultimo();

        $data = [
            'title'  => 'Ficha de Motivo de Entrenamiento',
            'motivo' => $motivo,
            'module' => 'motivoentrenamiento',
        ];

        return view('motivoentrenamiento/motivoentrenamiento_record', $data);
    }

    public function elprimero()
    {
        $motivo = $this->motivoModel->elprimero();
        $data = [
            'title'  => 'Ficha de Motivo de Entrenamiento - Primer Registro',
            'motivo' => $motivo,
            'module' => 'motivoentrenamiento',
        ];
        return view('motivoentrenamiento/motivoentrenamiento_record', $data);
    }

    public function elultimo()
    {
        $motivo = $this->motivoModel->elultimo();
        $data = [
            'title'  => 'Ficha de Motivo de Entrenamiento - Último Registro',
            'motivo' => $motivo,
            'module' => 'motivoentrenamiento',
        ];
        return view('motivoentrenamiento/motivoentrenamiento_record', $data);
    }

    public function siguiente($id)
    {
        $motivo = $this->motivoModel->siguiente($id);
        $data = [
            'title'  => 'Ficha de Motivo de Entrenamiento',
            'motivo' => $motivo,
            'module' => 'motivoentrenamiento',
        ];
        return view('motivoentrenamiento/motivoentrenamiento_record', $data);
    }

    public function anterior($id)
    {
        $motivo = $this->motivoModel->anterior($id);
        $data = [
            'title'  => 'Ficha de Motivo de Entrenamiento',
            'motivo' => $motivo,
            'module' => 'motivoentrenamiento',
        ];
        return view('motivoentrenamiento/motivoentrenamiento_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search  = $this->request->getGet('q');
        $motivos = $this->motivoModel->getMotivos($search);

        $data = [
            'title'   => 'Catálogo de Motivos de Entrenamiento',
            'motivos' => $motivos,
            'search'  => $search,
            'module'  => 'motivoentrenamiento',
        ];

        return view('motivoentrenamiento/motivoentrenamiento_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'           => 'Nuevo Motivo de Entrenamiento',
            'availableImages' => $this->motivoModel->getAvailableImages(),
            'module'          => 'motivoentrenamiento',
        ];

        return view('motivoentrenamiento/motivoentrenamiento_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'    => 'required|min_length[2]|max_length[100]|is_unique[motivoentrenamiento.nombre]',
            'objetivo'  => 'permit_empty',
            'dimension' => 'permit_empty|max_length[50]',
            'imagen'    => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->motivoModel->insert([
            'nombre'    => trim($this->request->getPost('nombre')),
            'objetivo'  => trim($this->request->getPost('objetivo')) ?: null,
            'dimension' => trim($this->request->getPost('dimension')) ?: null,
            'imagen'    => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('motivoentrenamiento/actual/' . $id))->with('success', 'Motivo de entrenamiento registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $motivo = $this->motivoModel->find($id);
        if (!$motivo) {
            throw PageNotFoundException::forPageNotFound("Motivo de entrenamiento no encontrado.");
        }

        $data = [
            'title'           => 'Editar Motivo de Entrenamiento #' . $id,
            'motivo'          => $motivo,
            'availableImages' => $this->motivoModel->getAvailableImages(),
            'module'          => 'motivoentrenamiento',
        ];

        return view('motivoentrenamiento/motivoentrenamiento_edit', $data);
    }

    public function update($id)
    {
        $motivo = $this->motivoModel->find($id);
        if (!$motivo) {
            return redirect()->to(base_url('motivoentrenamiento'))->with('error', 'Motivo de entrenamiento no encontrado.');
        }

        $rules = [
            'nombre'    => "required|min_length[2]|max_length[100]|is_unique[motivoentrenamiento.nombre,idmotivoentrenamiento,{$id}]",
            'objetivo'  => 'permit_empty',
            'dimension' => 'permit_empty|max_length[50]',
            'imagen'    => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->motivoModel->update($id, [
            'nombre'    => trim($this->request->getPost('nombre')),
            'objetivo'  => trim($this->request->getPost('objetivo')) ?: null,
            'dimension' => trim($this->request->getPost('dimension')) ?: null,
            'imagen'    => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('motivoentrenamiento/actual/' . $id))->with('success', 'Motivo de entrenamiento actualizado exitosamente.');
    }

    // Servir imagen desde el repositorio de motivos
    public function imagen($filename = null)
    {
        if (empty($filename)) {
            throw PageNotFoundException::forPageNotFound();
        }

        $cleanFilename = basename($filename);
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

        $paths = [
            $baseDir . '/repositorio/motivos/' . $cleanFilename,
            $baseDir . '/repositorio/images/motivos/' . $cleanFilename,
            $baseDir . '/uploads/motivos/' . $cleanFilename,
        ];

        $targetPath = null;
        foreach ($paths as $p) {
            if (file_exists($p)) {
                $targetPath = $p;
                break;
            }
        }

        if (!$targetPath) {
            throw PageNotFoundException::forPageNotFound("Imagen no encontrada: " . $cleanFilename);
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

    public function delete($id)
    {
        $motivo = $this->motivoModel->find($id);
        if (!$motivo) {
            return redirect()->to(base_url('motivoentrenamiento'))->with('error', 'Motivo de entrenamiento no encontrado.');
        }

        try {
            $this->motivoModel->delete($id);
            return redirect()->to(base_url('motivoentrenamiento/elprimero'))->with('success', 'Motivo de entrenamiento eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('motivoentrenamiento/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
