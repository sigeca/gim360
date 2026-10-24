<?php

namespace App\Controllers;

use App\Models\MusculoModel;
use App\Models\EquipoMusculoModel;
use App\Models\MusculoEjercicioModel;
use App\Models\EquipoModel;
use App\Models\EjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Musculo extends BaseController
{
    protected MusculoModel $musculoModel;
    protected EquipoMusculoModel $equipoMusculoModel;
    protected MusculoEjercicioModel $musculoEjercicioModel;
    protected EquipoModel $equipoModel;
    protected EjercicioModel $ejercicioModel;

    public function __construct()
    {
        $this->musculoModel          = new MusculoModel();
        $this->equipoMusculoModel    = new EquipoMusculoModel();
        $this->musculoEjercicioModel = new MusculoEjercicioModel();
        $this->equipoModel           = new EquipoModel();
        $this->ejercicioModel        = new EjercicioModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $musculo = $this->musculoModel->getMusculoWithDetails($id);
        } else {
            $last = $this->musculoModel->elultimo();
            $musculo = $last ? $this->musculoModel->getMusculoWithDetails($last['idmusculo']) : null;
        }

        $equipos = [];
        $ejercicios = [];
        $todosLosEquipos = [];
        $todosLosEjercicios = [];

        if ($musculo) {
            $idmusculo = (int)$musculo['idmusculo'];
            // 1. Equipos y máquinas que ejercitan este músculo
            $equipos = $this->equipoMusculoModel->getEquiposByMusculo($idmusculo);

            // 2. Ejercicios que se realizan para ejercitar este músculo
            $ejercicios = $this->musculoEjercicioModel->getEjerciciosByMusculo($idmusculo);

            // 3. Catálogos para asignaciones / modales
            $todosLosEquipos = $this->equipoModel
                ->select('idequipo, codigo, nombre')
                ->orderBy('nombre', 'ASC')
                ->findAll();

            $todosLosEjercicios = $this->ejercicioModel
                ->select('idejercicio, nombreespanol, nombreingles')
                ->orderBy('nombreespanol', 'ASC')
                ->findAll();
        }

        $todosLosTrenes = (new \App\Models\TrenMuscularModel())->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'              => 'Ficha de Músculo' . ($musculo ? ': ' . $musculo['nombre'] : ''),
            'musculo'            => $musculo,
            'equipos'            => $equipos,
            'ejercicios'         => $ejercicios,
            'todosLosEquipos'    => $todosLosEquipos,
            'todosLosEjercicios' => $todosLosEjercicios,
            'todosLosTrenes'     => $todosLosTrenes,
            'module'             => 'musculo',
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
            'title'             => 'Registrar Nuevo Músculo',
            'availableImages'   => $this->musculoModel->getAvailableImages(),
            'todosLosTrenes'    => (new \App\Models\TrenMuscularModel())->orderBy('nombre', 'ASC')->findAll(),
            'idtrenPreselected' => $this->request->getGet('idtrenmuscular'),
            'module'            => 'musculo',
        ];

        return view('musculo/musculo_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'         => 'required|min_length[2]|max_length[100]',
            'imagen'         => 'permit_empty|max_length[255]',
            'idtrenmuscular' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idtren = $this->request->getPost('idtrenmuscular');

        $id = $this->musculoModel->insert([
            'nombre'         => trim($this->request->getPost('nombre')),
            'imagen'         => trim($this->request->getPost('imagen')) ?: null,
            'idtrenmuscular' => !empty($idtren) ? (int)$idtren : null,
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
            'todosLosTrenes'  => (new \App\Models\TrenMuscularModel())->orderBy('nombre', 'ASC')->findAll(),
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
            'nombre'         => 'required|min_length[2]|max_length[100]',
            'imagen'         => 'permit_empty|max_length[255]',
            'idtrenmuscular' => 'permit_empty|is_natural_no_zero',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idtren = $this->request->getPost('idtrenmuscular');

        $this->musculoModel->update($id, [
            'nombre'         => trim($this->request->getPost('nombre')),
            'imagen'         => trim($this->request->getPost('imagen')) ?: null,
            'idtrenmuscular' => !empty($idtren) ? (int)$idtren : null,
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

    /**
     * Vincula un equipo/máquina a este músculo
     */
    public function asignarEquipo($idmusculo)
    {
        $idequipo = (int) $this->request->getPost('idequipo');
        if ($idequipo <= 0) {
            return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('error', 'Seleccione un equipo válido.');
        }

        $existe = $this->equipoMusculoModel
            ->where('idequipo', $idequipo)
            ->where('idmusculo', $idmusculo)
            ->first();

        if (!$existe) {
            $this->equipoMusculoModel->insert([
                'idequipo'  => $idequipo,
                'idmusculo' => $idmusculo,
            ]);
            return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('success', 'Equipo / Máquina vinculado exitosamente.');
        }

        return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('info', 'El equipo ya se encontraba vinculado a este músculo.');
    }

    /**
     * Desvincula un equipo/máquina de este músculo
     */
    public function quitarEquipo($idmusculo, $idequipo)
    {
        $this->equipoMusculoModel
            ->where('idequipo', $idequipo)
            ->where('idmusculo', $idmusculo)
            ->delete();

        return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('success', 'Equipo / Máquina desvinculado correctamente.');
    }

    /**
     * Vincula un ejercicio a este músculo
     */
    public function asignarEjercicio($idmusculo)
    {
        $idejercicio = (int) $this->request->getPost('idejercicio');
        if ($idejercicio <= 0) {
            return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('error', 'Seleccione un ejercicio válido.');
        }

        $existe = $this->musculoEjercicioModel
            ->where('idejercicio', $idejercicio)
            ->where('idmusculo', $idmusculo)
            ->first();

        if (!$existe) {
            $this->musculoEjercicioModel->insert([
                'idejercicio' => $idejercicio,
                'idmusculo'   => $idmusculo,
            ]);
            return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('success', 'Ejercicio vinculado exitosamente a este músculo.');
        }

        return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('info', 'El ejercicio ya se encontraba vinculado a este músculo.');
    }

    /**
     * Desvincula un ejercicio de este músculo
     */
    public function quitarEjercicio($idmusculo, $idejercicio)
    {
        $this->musculoEjercicioModel
            ->where('idejercicio', $idejercicio)
            ->where('idmusculo', $idmusculo)
            ->delete();

        return redirect()->to(base_url('musculo/actual/' . $idmusculo))->with('success', 'Ejercicio desvinculado correctamente de este músculo.');
    }
}
