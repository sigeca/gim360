<?php

namespace App\Controllers;

use App\Models\ImagenAlimentoModel;
use App\Models\AlimentoModel;
use App\Models\ImagenModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ImagenAlimento extends BaseController
{
    protected ImagenAlimentoModel $iaModel;
    protected AlimentoModel $alimentoModel;
    protected ImagenModel $imagenModel;

    public function __construct()
    {
        $this->iaModel       = new ImagenAlimentoModel();
        $this->alimentoModel = new AlimentoModel();
        $this->imagenModel   = new ImagenModel();
        $this->ensureTable();
    }

    /**
     * Asegura de forma preventiva que la tabla y vista existan en la BD (entorno local o nube)
     */
    protected function ensureTable(): void
    {
        try {
            $db = \Config\Database::connect();
            $db->query("CREATE TABLE IF NOT EXISTS `imagenalimento` (
              `idimagenalimento` int(11) NOT NULL AUTO_INCREMENT,
              `idimagen` int(11) NOT NULL,
              `idalimento` int(11) NOT NULL,
              PRIMARY KEY (`idimagenalimento`),
              UNIQUE KEY `uk_imagen_alimento` (`idimagen`, `idalimento`),
              KEY `fk_ia_imagen` (`idimagen`),
              KEY `fk_ia_alimento` (`idalimento`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `ImagenAlimento` AS 
                        SELECT `idimagenalimento`, `idimagen`, `idalimento` 
                        FROM `imagenalimento`;");
        } catch (\Throwable $e) {
            log_message('error', 'ImagenAlimento::ensureTable: ' . $e->getMessage());
        }
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    /**
     * Muestra la ficha detallada de una asignación específica
     */
    public function actual($id = null)
    {
        if ($id) {
            $record = $this->iaModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->iaModel->elprimero();
            $record = $first ? $this->iaModel->getRecordWithDetails((int)$first['idimagenalimento']) : null;
        }

        $urlImagen     = null;
        $urlFallback   = null;
        $archivoExiste = false;

        if ($record) {
            $urlImagen     = $record['urlImagen'] ?? null;
            $urlFallback   = $record['urlFallback'] ?? null;
            $archivoExiste = $record['archivoExiste'] ?? false;
        }

        $data = [
            'title'         => 'Asignación Imagen - Alimento' . ($record ? " #{$record['idimagenalimento']}" : ''),
            'rel'           => $record,
            'urlImagen'     => $urlImagen,
            'urlFallback'   => $urlFallback,
            'archivoExiste' => $archivoExiste,
            'module'        => 'imagenalimento',
        ];

        return view('imagenalimento/imagenalimento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->iaModel->elprimero();
        return $this->actual($first ? $first['idimagenalimento'] : null);
    }

    public function elultimo()
    {
        $last = $this->iaModel->elultimo();
        return $this->actual($last ? $last['idimagenalimento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->iaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idimagenalimento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->iaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idimagenalimento'] : $id);
    }

    /**
     * Listado general de asignaciones imagen-alimento
     */
    public function listar()
    {
        $search     = $this->request->getGet('q');
        $idalimento = $this->request->getGet('idalimento');
        $idalimento = (!empty($idalimento) && is_numeric($idalimento)) ? (int)$idalimento : null;

        $idimagen = $this->request->getGet('idimagen');
        $idimagen = (!empty($idimagen) && is_numeric($idimagen)) ? (int)$idimagen : null;

        $records   = $this->iaModel->getRecordsWithDetails($search, $idalimento, $idimagen);
        $alimentos = $this->alimentoModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes  = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $selectedAlimento = null;
        if ($idalimento) {
            $selectedAlimento = $this->alimentoModel->find($idalimento);
        }

        $selectedImagen = null;
        if ($idimagen) {
            $selectedImagen = $this->imagenModel->find($idimagen);
        }

        $data = [
            'title'            => 'Gestión de Imágenes de Alimentos',
            'records'          => $records,
            'alimentos'        => $alimentos,
            'imagenes'         => $imagenes,
            'search'           => $search,
            'selectedAlimento' => $selectedAlimento,
            'selectedImagen'   => $selectedImagen,
            'idalimento'       => $idalimento,
            'idimagen'         => $idimagen,
            'module'           => 'imagenalimento',
        ];

        return view('imagenalimento/imagenalimento_list', $data);
    }

    /**
     * Formulario para vincular una imagen con un alimento
     */
    public function add()
    {
        $idalimentoPre = $this->request->getGet('idalimento');
        $idimagenPre   = $this->request->getGet('idimagen');

        $alimentos = $this->alimentoModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes  = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'         => 'Vincular Imagen a Alimento',
            'alimentos'     => $alimentos,
            'imagenes'      => $imagenes,
            'idalimentoPre' => $idalimentoPre,
            'idimagenPre'   => $idimagenPre,
            'module'        => 'imagenalimento',
        ];

        return view('imagenalimento/imagenalimento_form', $data);
    }

    /**
     * Guarda la nueva relación
     */
    public function save()
    {
        $rules = [
            'idimagen'   => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idalimento' => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
        ];

        $messages = [
            'idimagen' => [
                'required'           => 'Debe seleccionar una imagen del repositorio.',
                'is_natural_no_zero' => 'La imagen seleccionada no es válida.',
                'is_not_unique'      => 'La imagen seleccionada no existe en el catálogo.',
            ],
            'idalimento' => [
                'required'           => 'Debe seleccionar un alimento.',
                'is_natural_no_zero' => 'El alimento seleccionado no es válido.',
                'is_not_unique'      => 'El alimento seleccionado no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen   = (int)$this->request->getPost('idimagen');
        $idalimento = (int)$this->request->getPost('idalimento');

        // Validar unicidad (uk_imagen_alimento)
        $existe = $this->iaModel->where('idimagen', $idimagen)
                                ->where('idalimento', $idalimento)
                                ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('errors', [
                'idimagen' => 'Esta imagen ya se encuentra asociada al alimento seleccionado.'
            ]);
        }

        $id = $this->iaModel->insert([
            'idimagen'   => $idimagen,
            'idalimento' => $idalimento,
        ]);

        $fromAlimento = $this->request->getPost('from_alimento');
        if ($fromAlimento) {
            return redirect()->to(base_url('alimento/actual/' . $idalimento))
                             ->with('success', 'Imagen vinculada al alimento exitosamente.');
        }

        return redirect()->to(base_url('imagenalimento/actual/' . $id))
                         ->with('success', 'Relación imagen-alimento registrada exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $rel = $this->iaModel->getRecordWithDetails((int)$id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Asignación de imagen a alimento no encontrada.");
        }

        $alimentos = $this->alimentoModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes  = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'     => 'Editar Asignación Imagen-Alimento #' . $rel['idimagenalimento'],
            'rel'       => $rel,
            'alimentos' => $alimentos,
            'imagenes'  => $imagenes,
            'module'    => 'imagenalimento',
        ];

        return view('imagenalimento/imagenalimento_edit', $data);
    }

    /**
     * Actualiza la asignación
     */
    public function update($id)
    {
        $rel = $this->iaModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagenalimento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idimagen'   => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idalimento' => 'required|is_natural_no_zero|is_not_unique[alimento.idalimento]',
        ];

        $messages = [
            'idimagen' => [
                'required'           => 'Debe seleccionar una imagen del repositorio.',
                'is_natural_no_zero' => 'La imagen seleccionada no es válida.',
                'is_not_unique'      => 'La imagen seleccionada no existe en el catálogo.',
            ],
            'idalimento' => [
                'required'           => 'Debe seleccionar un alimento.',
                'is_natural_no_zero' => 'El alimento seleccionado no es válido.',
                'is_not_unique'      => 'El alimento seleccionado no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen   = (int)$this->request->getPost('idimagen');
        $idalimento = (int)$this->request->getPost('idalimento');

        // Validar duplicado excluyendo el registro actual
        $existe = $this->iaModel->where('idimagen', $idimagen)
                                ->where('idalimento', $idalimento)
                                ->where('idimagenalimento !=', $id)
                                ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('errors', [
                'idimagen' => 'La combinación de esta imagen y alimento ya existe en el sistema.'
            ]);
        }

        $this->iaModel->update($id, [
            'idimagen'   => $idimagen,
            'idalimento' => $idalimento,
        ]);

        return redirect()->to(base_url('imagenalimento/actual/' . $id))
                         ->with('success', 'Asignación imagen-alimento actualizada exitosamente.');
    }

    /**
     * Elimina la relación
     */
    public function delete($id)
    {
        $rel = $this->iaModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagenalimento'))->with('error', 'Registro no encontrado.');
        }

        $idalimento   = $rel['idalimento'];
        $fromAlimento = $this->request->getGet('from_alimento');

        try {
            $this->iaModel->delete($id);

            if ($fromAlimento) {
                return redirect()->to(base_url('alimento/actual/' . $idalimento))
                                 ->with('success', 'Imagen desvinculada del alimento exitosamente.');
            }

            $first = $this->iaModel->elprimero();
            $targetUrl = $first ? 'imagenalimento/actual/' . $first['idimagenalimento'] : 'imagenalimento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('imagenalimento/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
