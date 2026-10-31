<?php

namespace App\Controllers;

use App\Models\ImagenRecetaModel;
use App\Models\RecetaModel;
use App\Models\ImagenModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ImagenReceta extends BaseController
{
    protected ImagenRecetaModel $irModel;
    protected RecetaModel $recetaModel;
    protected ImagenModel $imagenModel;

    public function __construct()
    {
        $this->irModel     = new ImagenRecetaModel();
        $this->recetaModel = new RecetaModel();
        $this->imagenModel = new ImagenModel();
        $this->ensureTable();
    }

    /**
     * Asegura de forma preventiva que la tabla y vista existan en la BD (entorno local o nube)
     */
    protected function ensureTable(): void
    {
        try {
            $db = \Config\Database::connect();
            $db->query("CREATE TABLE IF NOT EXISTS `imagenreceta` (
              `idimagenreceta` int(11) NOT NULL AUTO_INCREMENT,
              `idimagen` int(11) NOT NULL,
              `idreceta` int(11) NOT NULL,
              PRIMARY KEY (`idimagenreceta`),
              UNIQUE KEY `uk_imagen_receta` (`idimagen`, `idreceta`),
              KEY `fk_ir_imagen` (`idimagen`),
              KEY `fk_ir_receta` (`idreceta`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `ImagenReceta` AS 
                        SELECT `idimagenreceta`, `idimagen`, `idreceta` 
                        FROM `imagenreceta`;");
        } catch (\Throwable $e) {
            log_message('error', 'ImagenReceta::ensureTable: ' . $e->getMessage());
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
            $record = $this->irModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->irModel->elprimero();
            $record = $first ? $this->irModel->getRecordWithDetails((int)$first['idimagenreceta']) : null;
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
            'title'         => 'Asignación Imagen - Receta' . ($record ? " #{$record['idimagenreceta']}" : ''),
            'rel'           => $record,
            'urlImagen'     => $urlImagen,
            'urlFallback'   => $urlFallback,
            'archivoExiste' => $archivoExiste,
            'module'        => 'imagenreceta',
        ];

        return view('imagenreceta/imagenreceta_record', $data);
    }

    public function elprimero()
    {
        $first = $this->irModel->elprimero();
        return $this->actual($first ? $first['idimagenreceta'] : null);
    }

    public function elultimo()
    {
        $last = $this->irModel->elultimo();
        return $this->actual($last ? $last['idimagenreceta'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->irModel->siguiente((int)$id);
        return $this->actual($next ? $next['idimagenreceta'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->irModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idimagenreceta'] : $id);
    }

    /**
     * Listado general de asignaciones imagen-receta
     */
    public function listar()
    {
        $search   = $this->request->getGet('q');
        $idreceta = $this->request->getGet('idreceta');
        $idreceta = (!empty($idreceta) && is_numeric($idreceta)) ? (int)$idreceta : null;

        $idimagen = $this->request->getGet('idimagen');
        $idimagen = (!empty($idimagen) && is_numeric($idimagen)) ? (int)$idimagen : null;

        $records  = $this->irModel->getRecordsWithDetails($search, $idreceta, $idimagen);
        $recetas  = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $selectedReceta = null;
        if ($idreceta) {
            $selectedReceta = $this->recetaModel->find($idreceta);
        }

        $selectedImagen = null;
        if ($idimagen) {
            $selectedImagen = $this->imagenModel->find($idimagen);
        }

        $data = [
            'title'          => 'Gestión de Imágenes de Recetas',
            'records'        => $records,
            'recetas'        => $recetas,
            'imagenes'       => $imagenes,
            'search'         => $search,
            'selectedReceta' => $selectedReceta,
            'selectedImagen' => $selectedImagen,
            'idreceta'       => $idreceta,
            'idimagen'       => $idimagen,
            'module'         => 'imagenreceta',
        ];

        return view('imagenreceta/imagenreceta_list', $data);
    }

    /**
     * Formulario para vincular una imagen con una receta
     */
    public function add()
    {
        $idrecetaPre = $this->request->getGet('idreceta');
        $idimagenPre = $this->request->getGet('idimagen');

        $recetas  = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'        => 'Vincular Imagen a Receta',
            'recetas'      => $recetas,
            'imagenes'     => $imagenes,
            'idrecetaPre'  => $idrecetaPre,
            'idimagenPre'  => $idimagenPre,
            'module'       => 'imagenreceta',
        ];

        return view('imagenreceta/imagenreceta_form', $data);
    }

    /**
     * Guarda la nueva relación
     */
    public function save()
    {
        $rules = [
            'idimagen' => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idreceta' => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
        ];

        $messages = [
            'idimagen' => [
                'required'           => 'Debe seleccionar una imagen del repositorio.',
                'is_natural_no_zero' => 'La imagen seleccionada no es válida.',
                'is_not_unique'      => 'La imagen seleccionada no existe en el catálogo.',
            ],
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'La receta seleccionada no es válida.',
                'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen = (int)$this->request->getPost('idimagen');
        $idreceta = (int)$this->request->getPost('idreceta');

        // Validar unicidad (uk_imagen_receta)
        $existe = $this->irModel->where('idimagen', $idimagen)
                                ->where('idreceta', $idreceta)
                                ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('errors', [
                'idimagen' => 'Esta imagen ya se encuentra asociada a la receta seleccionada.'
            ]);
        }

        $id = $this->irModel->insert([
            'idimagen' => $idimagen,
            'idreceta' => $idreceta,
        ]);

        $fromReceta = $this->request->getPost('from_receta');
        if ($fromReceta) {
            return redirect()->to(base_url('receta/actual/' . $idreceta))
                             ->with('success', 'Imagen vinculada a la receta exitosamente.');
        }

        return redirect()->to(base_url('imagenreceta/actual/' . $id))
                         ->with('success', 'Relación imagen-receta registrada exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $rel = $this->irModel->getRecordWithDetails((int)$id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Asignación de imagen a receta no encontrada.");
        }

        $recetas  = $this->recetaModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes = $this->imagenModel->orderBy('nombre', 'ASC')->findAll();

        $data = [
            'title'    => 'Editar Asignación Imagen-Receta #' . $rel['idimagenreceta'],
            'rel'      => $rel,
            'recetas'  => $recetas,
            'imagenes' => $imagenes,
            'module'   => 'imagenreceta',
        ];

        return view('imagenreceta/imagenreceta_edit', $data);
    }

    /**
     * Actualiza la asignación
     */
    public function update($id)
    {
        $rel = $this->irModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagenreceta'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idimagen' => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idreceta' => 'required|is_natural_no_zero|is_not_unique[receta.idreceta]',
        ];

        $messages = [
            'idimagen' => [
                'required'           => 'Debe seleccionar una imagen del repositorio.',
                'is_natural_no_zero' => 'La imagen seleccionada no es válida.',
                'is_not_unique'      => 'La imagen seleccionada no existe en el catálogo.',
            ],
            'idreceta' => [
                'required'           => 'Debe seleccionar una receta.',
                'is_natural_no_zero' => 'La receta seleccionada no es válida.',
                'is_not_unique'      => 'La receta seleccionada no existe en el sistema.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen = (int)$this->request->getPost('idimagen');
        $idreceta = (int)$this->request->getPost('idreceta');

        // Validar duplicado excluyendo el registro actual
        $existe = $this->irModel->where('idimagen', $idimagen)
                                ->where('idreceta', $idreceta)
                                ->where('idimagenreceta !=', $id)
                                ->first();

        if ($existe) {
            return redirect()->back()->withInput()->with('errors', [
                'idimagen' => 'La combinación de esta imagen y receta ya existe en el sistema.'
            ]);
        }

        $this->irModel->update($id, [
            'idimagen' => $idimagen,
            'idreceta' => $idreceta,
        ]);

        return redirect()->to(base_url('imagenreceta/actual/' . $id))
                         ->with('success', 'Asignación imagen-receta actualizada exitosamente.');
    }

    /**
     * Elimina la relación
     */
    public function delete($id)
    {
        $rel = $this->irModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagenreceta'))->with('error', 'Registro no encontrado.');
        }

        $idreceta   = $rel['idreceta'];
        $fromReceta = $this->request->getGet('from_receta');

        try {
            $this->irModel->delete($id);

            if ($fromReceta) {
                return redirect()->to(base_url('receta/actual/' . $idreceta))
                                 ->with('success', 'Imagen desvinculada de la receta exitosamente.');
            }

            $first = $this->irModel->elprimero();
            $targetUrl = $first ? 'imagenreceta/actual/' . $first['idimagenreceta'] : 'imagenreceta';
            return redirect()->to(base_url($targetUrl))->with('success', 'Asignación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('imagenreceta/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
