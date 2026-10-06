<?php

namespace App\Controllers;

use App\Models\EjercicioModel;

class Ejercicio extends BaseController
{
    protected EjercicioModel $ejercicioModel;

    public function __construct()
    {
        $this->ejercicioModel = new EjercicioModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $ejercicio = $this->ejercicioModel->find($id);
        } else {
            $first = $this->ejercicioModel->elprimero();
            $ejercicio = $first ? $this->ejercicioModel->find($first['idejercicio']) : null;
        }

        $youtubeId = null;
        if (!empty($ejercicio['urlvideo'])) {
            // Extraer ID de YouTube para embed si aplica
            if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $ejercicio['urlvideo'], $matches)) {
                $youtubeId = $matches[1];
            }
        }

        // Detectar si el ejercicio cuenta con contraparte de fase (Inicio <-> Final)
        $parejaEjercicio = null;
        if (!empty($ejercicio['imagen'])) {
            $fn = $ejercicio['imagen'];
            if (str_contains($fn, '-start.webp')) {
                $parejaFn = str_replace('-start.webp', '-peak.webp', $fn);
                $parejaEjercicio = $this->ejercicioModel->where('imagen', $parejaFn)->first();
            } elseif (str_contains($fn, '-peak.webp')) {
                $parejaFn = str_replace('-peak.webp', '-start.webp', $fn);
                $parejaEjercicio = $this->ejercicioModel->where('imagen', $parejaFn)->first();
            }
        }

        $data = [
            'title'           => 'Ficha Técnica de Ejercicio: ' . ($ejercicio['nombre'] ?? ''),
            'ejercicio'       => $ejercicio,
            'parejaEjercicio' => $parejaEjercicio,
            'youtubeId'       => $youtubeId,
            'module'          => 'ejercicio',
        ];

        return view('ejercicio/ejercicio_record', $data);
    }

    public function elprimero()
    {
        $first = $this->ejercicioModel->elprimero();
        return $this->actual($first ? $first['idejercicio'] : null);
    }

    public function elultimo()
    {
        $last = $this->ejercicioModel->elultimo();
        return $this->actual($last ? $last['idejercicio'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->ejercicioModel->siguiente($id);
        return $this->actual($next ? $next['idejercicio'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->ejercicioModel->anterior($id);
        return $this->actual($prev ? $prev['idejercicio'] : $id);
    }

    // Vista para listar todos los ejercicios con paginación y búsqueda
    public function listar()
    {
        $search     = $this->request->getGet('q');
        $ejercicios = $this->ejercicioModel->getEjercicios($search, 20);

        $data = [
            'title'      => 'Catálogo de Ejercicios',
            'ejercicios' => $ejercicios,
            'pager'      => $this->ejercicioModel->pager,
            'search'     => $search,
            'total'      => $this->ejercicioModel->pager ? $this->ejercicioModel->pager->getTotal() : count($ejercicios),
            'module'     => 'ejercicio',
        ];

        return view('ejercicio/ejercicio_list', $data);
    }

    // Servir imagen de ejercicio de manera segura vía controlador
    public function imagen($filename = null)
    {
        if (empty($filename)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $cleanFilename = basename($filename);
        $path = '/var/www/html/gim360/repositorio/ejercicios/repdb-free/images/flat/' . $cleanFilename;

        if (!file_exists($path)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Imagen no encontrada.");
        }

        return $this->response
            ->setHeader('Content-Type', 'image/webp')
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($path));
    }

    // Vista de formulario para registrar nuevo ejercicio
    public function add()
    {
        $data = [
            'title'  => 'Registrar Nuevo Ejercicio',
            'module' => 'ejercicio',
        ];

        return view('ejercicio/ejercicio_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'      => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'permit_empty',
            'urlvideo'    => 'permit_empty|max_length[255]',
            'imagen'      => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->ejercicioModel->insert([
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
            'urlvideo'    => trim($this->request->getPost('urlvideo')) ?: null,
            'imagen'      => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('ejercicio/actual/' . $id))->with('success', 'Ejercicio registrado exitosamente.');
    }

    // Vista de formulario para editar ejercicio existente
    public function edit($id)
    {
        $ejercicio = $this->ejercicioModel->find($id);
        if (!$ejercicio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ejercicio no encontrado.");
        }

        $data = [
            'title'     => 'Editar Ejercicio: ' . $ejercicio['nombre'],
            'ejercicio' => $ejercicio,
            'module'    => 'ejercicio',
        ];

        return view('ejercicio/ejercicio_edit', $data);
    }

    public function update($id)
    {
        $ejercicio = $this->ejercicioModel->find($id);
        if (!$ejercicio) {
            return redirect()->to(base_url('ejercicio'))->with('error', 'Ejercicio no encontrado.');
        }

        $rules = [
            'nombre'      => 'required|min_length[3]|max_length[150]',
            'descripcion' => 'permit_empty',
            'urlvideo'    => 'permit_empty|max_length[255]',
            'imagen'      => 'permit_empty|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->ejercicioModel->update($id, [
            'nombre'      => trim($this->request->getPost('nombre')),
            'descripcion' => trim($this->request->getPost('descripcion')) ?: null,
            'urlvideo'    => trim($this->request->getPost('urlvideo')) ?: null,
            'imagen'      => trim($this->request->getPost('imagen')) ?: null,
        ]);

        return redirect()->to(base_url('ejercicio/actual/' . $id))->with('success', 'Ejercicio actualizado exitosamente.');
    }

    public function delete($id)
    {
        $ejercicio = $this->ejercicioModel->find($id);
        if (!$ejercicio) {
            return redirect()->to(base_url('ejercicio'))->with('error', 'Ejercicio no encontrado.');
        }

        $this->ejercicioModel->delete($id);

        $first = $this->ejercicioModel->elprimero();
        $targetUrl = $first ? 'ejercicio/actual/' . $first['idejercicio'] : 'ejercicio';

        return redirect()->to(base_url($targetUrl))->with('success', 'Ejercicio eliminado exitosamente.');
    }
}
