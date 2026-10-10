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

        // Músculos asignados y catálogo de músculos
        $musculos = $ejercicio ? $this->ejercicioModel->getMusculos((int)$ejercicio['idejercicio']) : [];
        $todosLosMusculos = (new \App\Models\MusculoModel())->orderBy('nombre', 'ASC')->findAll();

        // Equipos asignados y catálogo de equipos
        $equipos = $ejercicio ? $this->ejercicioModel->getEquipos((int)$ejercicio['idejercicio']) : [];
        $todosLosEquipos = (new \App\Models\EquipoModel())->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'            => 'Ficha Técnica de Ejercicio: ' . ($ejercicio['nombre'] ?? ''),
            'ejercicio'        => $ejercicio,
            'parejaEjercicio'  => $parejaEjercicio,
            'youtubeId'        => $youtubeId,
            'musculos'         => $musculos,
            'todosLosMusculos' => $todosLosMusculos,
            'equipos'          => $equipos,
            'todosLosEquipos'  => $todosLosEquipos,
            'tiposEquipo'      => \App\Models\EquipoModel::getTipos(),
            'module'           => 'ejercicio',
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

        // Cargar músculos asociados en lote para optimizar consultas
        $ids = array_column($ejercicios, 'idejercicio');
        $musculosBatch = $this->ejercicioModel->getMusculosBatch($ids);

        $data = [
            'title'         => 'Catálogo de Ejercicios',
            'ejercicios'    => $ejercicios,
            'musculosBatch' => $musculosBatch,
            'pager'         => $this->ejercicioModel->pager,
            'search'        => $search,
            'total'         => $this->ejercicioModel->pager ? $this->ejercicioModel->pager->getTotal() : count($ejercicios),
            'module'        => 'ejercicio',
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
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        $path = $baseDir . '/repositorio/ejercicios/repdb-free/images/flat/' . $cleanFilename;

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
            'title'             => 'Registrar Nuevo Ejercicio',
            'todosLosMusculos'  => (new \App\Models\MusculoModel())->orderBy('nombre', 'ASC')->findAll(),
            'musculosAsignados' => [],
            'todosLosEquipos'   => (new \App\Models\EquipoModel())->orderBy('nombre', 'ASC')->findAll(),
            'equiposAsignados'  => [],
            'module'            => 'ejercicio',
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

        // Sincronizar músculos seleccionados
        $musculos = (array) ($this->request->getPost('musculos') ?? []);
        if (!empty($musculos)) {
            (new \App\Models\MusculoEjercicioModel())->syncMusculosForEjercicio($id, $musculos);
        }

        // Sincronizar equipos seleccionados
        $equipos = (array) ($this->request->getPost('equipos') ?? []);
        if (!empty($equipos)) {
            (new \App\Models\EjercicioEquipoModel())->syncEquiposForEjercicio($id, $equipos);
        }

        return redirect()->to(base_url('ejercicio/actual/' . $id))->with('success', 'Ejercicio registrado exitosamente.');
    }

    // Vista de formulario para editar ejercicio existente
    public function edit($id)
    {
        $ejercicio = $this->ejercicioModel->find($id);
        if (!$ejercicio) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ejercicio no encontrado.");
        }

        $musculoEjercicioModel = new \App\Models\MusculoEjercicioModel();
        $musculosAsignados = array_column(
            $musculoEjercicioModel->where('idejercicio', $id)->findAll(),
            'idmusculo'
        );

        $ejercicioEquipoModel = new \App\Models\EjercicioEquipoModel();
        $equiposAsignados = array_column(
            $ejercicioEquipoModel->where('idejercicio', $id)->findAll(),
            'idequipo'
        );

        $data = [
            'title'             => 'Editar Ejercicio: ' . $ejercicio['nombre'],
            'ejercicio'         => $ejercicio,
            'todosLosMusculos'  => (new \App\Models\MusculoModel())->orderBy('nombre', 'ASC')->findAll(),
            'musculosAsignados' => $musculosAsignados,
            'todosLosEquipos'   => (new \App\Models\EquipoModel())->orderBy('nombre', 'ASC')->findAll(),
            'equiposAsignados'  => $equiposAsignados,
            'module'            => 'ejercicio',
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

        // Sincronizar músculos seleccionados
        $musculos = (array) ($this->request->getPost('musculos') ?? []);
        (new \App\Models\MusculoEjercicioModel())->syncMusculosForEjercicio($id, $musculos);

        // Sincronizar equipos seleccionados
        $equipos = (array) ($this->request->getPost('equipos') ?? []);
        (new \App\Models\EjercicioEquipoModel())->syncEquiposForEjercicio($id, $equipos);

        return redirect()->to(base_url('ejercicio/actual/' . $id))->with('success', 'Ejercicio actualizado exitosamente.');
    }

    // Asignar un músculo al ejercicio directamente
    public function asignarMusculo($idejercicio)
    {
        $idmusculo = (int) $this->request->getPost('idmusculo');
        if ($idmusculo > 0) {
            (new \App\Models\MusculoEjercicioModel())->addMusculoToEjercicio((int)$idejercicio, $idmusculo);
            return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('success', 'Músculo asignado exitosamente.');
        }
        return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('error', 'Seleccione un músculo válido.');
    }

    // Desvincular un músculo del ejercicio
    public function quitarMusculo($idejercicio, $idmusculo)
    {
        (new \App\Models\MusculoEjercicioModel())->removeMusculoFromEjercicio((int)$idejercicio, (int)$idmusculo);
        return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('success', 'Músculo desvinculado del ejercicio.');
    }

    // Asignar un equipo al ejercicio directamente
    public function asignarEquipo($idejercicio)
    {
        $idequipo = (int) $this->request->getPost('idequipo');
        if ($idequipo > 0) {
            (new \App\Models\EjercicioEquipoModel())->addEquipoToEjercicio((int)$idejercicio, $idequipo);
            return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('success', 'Equipo asignado al ejercicio exitosamente.');
        }
        return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('error', 'Seleccione un equipo válido.');
    }

    // Desvincular un equipo del ejercicio
    public function quitarEquipo($idejercicio, $idequipo)
    {
        (new \App\Models\EjercicioEquipoModel())->removeEquipoFromEjercicio((int)$idejercicio, (int)$idequipo);
        return redirect()->to(base_url('ejercicio/actual/' . $idejercicio))->with('success', 'Equipo desvinculado del ejercicio.');
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
