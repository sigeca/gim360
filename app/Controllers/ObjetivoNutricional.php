<?php

namespace App\Controllers;

use App\Models\ObjetivoNutricionalModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ObjetivoNutricional extends BaseController
{
    protected ObjetivoNutricionalModel $objetivoModel;

    public function __construct()
    {
        $this->objetivoModel = new ObjetivoNutricionalModel();
        $this->ensureTable();
    }

    /**
     * Asegura de forma transparente la existencia de la tabla en local o nube
     */
    protected function ensureTable(): void
    {
        try {
            $db = \Config\Database::connect();
            $db->query("CREATE TABLE IF NOT EXISTS `objetivonutricional` (
              `idobjetivonutricional` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(500) NOT NULL,
              PRIMARY KEY (`idobjetivonutricional`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `ObjetivoNutricional` AS 
                        SELECT `idobjetivonutricional`, `nombre` 
                        FROM `objetivonutricional`;");
        } catch (\Throwable $e) {
            log_message('error', 'ObjetivoNutricional::ensureTable: ' . $e->getMessage());
        }
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    /**
     * Muestra la ficha detallada de un objetivo nutricional
     */
    public function actual($id = null)
    {
        if ($id) {
            $objetivo = $this->objetivoModel->find($id);
        } else {
            $first = $this->objetivoModel->elprimero();
            $objetivo = $first ?: null;
        }

        $planes = [];
        if ($objetivo) {
            $planes = $this->objetivoModel->getPlanesByObjetivo((int)$objetivo['idobjetivonutricional']);
        }

        $data = [
            'title'    => 'Objetivo Nutricional' . ($objetivo ? ': ' . $objetivo['nombre'] : ''),
            'objetivo' => $objetivo,
            'planes'   => $planes,
            'module'   => 'objetivonutricional',
        ];

        return view('objetivonutricional/objetivonutricional_record', $data);
    }

    public function elprimero()
    {
        $first = $this->objetivoModel->elprimero();
        return $this->actual($first ? $first['idobjetivonutricional'] : null);
    }

    public function elultimo()
    {
        $last = $this->objetivoModel->elultimo();
        return $this->actual($last ? $last['idobjetivonutricional'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->objetivoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idobjetivonutricional'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->objetivoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idobjetivonutricional'] : $id);
    }

    /**
     * Listado con buscador
     */
    public function listar()
    {
        $search = $this->request->getGet('q');
        $objetivos = $this->objetivoModel->getObjetivos($search);

        $data = [
            'title'     => 'Catálogo de Objetivos Nutricionales',
            'objetivos' => $objetivos,
            'search'    => $search,
            'module'    => 'objetivonutricional',
        ];

        return view('objetivonutricional/objetivonutricional_list', $data);
    }

    /**
     * Formulario para crear nuevo objetivo
     */
    public function add()
    {
        $data = [
            'title'  => 'Registrar Objetivo Nutricional',
            'module' => 'objetivonutricional',
        ];

        return view('objetivonutricional/objetivonutricional_form', $data);
    }

    /**
     * Guarda el nuevo objetivo nutricional
     */
    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[3]|max_length[500]|is_unique[objetivonutricional.nombre]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del objetivo nutricional es obligatorio.',
                'min_length' => 'Debe tener al menos 3 caracteres.',
                'max_length' => 'No puede exceder los 500 caracteres.',
                'is_unique'  => 'Ya existe un objetivo nutricional con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->objetivoModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('objetivonutricional/actual/' . $id))
                         ->with('success', 'Objetivo nutricional registrado exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $objetivo = $this->objetivoModel->find($id);
        if (!$objetivo) {
            throw PageNotFoundException::forPageNotFound("Objetivo nutricional no encontrado.");
        }

        $data = [
            'title'    => 'Editar Objetivo Nutricional #' . $id,
            'objetivo' => $objetivo,
            'module'   => 'objetivonutricional',
        ];

        return view('objetivonutricional/objetivonutricional_edit', $data);
    }

    /**
     * Actualiza el registro
     */
    public function update($id)
    {
        $objetivo = $this->objetivoModel->find($id);
        if (!$objetivo) {
            return redirect()->to(base_url('objetivonutricional'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[3]|max_length[500]|is_unique[objetivonutricional.nombre,idobjetivonutricional,{$id}]",
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre del objetivo nutricional es obligatorio.',
                'min_length' => 'Debe tener al menos 3 caracteres.',
                'max_length' => 'No puede exceder los 500 caracteres.',
                'is_unique'  => 'Ya existe otro objetivo con este nombre.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->objetivoModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('objetivonutricional/actual/' . $id))
                         ->with('success', 'Objetivo nutricional actualizado correctamente.');
    }

    /**
     * Elimina el registro
     */
    public function delete($id)
    {
        $objetivo = $this->objetivoModel->find($id);
        if (!$objetivo) {
            return redirect()->to(base_url('objetivonutricional'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->objetivoModel->delete($id);
            $first = $this->objetivoModel->elprimero();
            $targetUrl = $first ? 'objetivonutricional/actual/' . $first['idobjetivonutricional'] : 'objetivonutricional';
            return redirect()->to(base_url($targetUrl))->with('success', 'Objetivo nutricional eliminado exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('objetivonutricional/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
