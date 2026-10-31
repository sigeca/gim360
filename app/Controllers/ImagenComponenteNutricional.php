<?php

namespace App\Controllers;

use App\Models\ImagenComponenteNutricionalModel;
use App\Models\ComponenteNutricionalModel;
use App\Models\ImagenModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class ImagenComponenteNutricional extends BaseController
{
    protected ImagenComponenteNutricionalModel $icnModel;
    protected ComponenteNutricionalModel $componenteModel;
    protected ImagenModel $imagenModel;

    public function __construct()
    {
        $this->icnModel        = new ImagenComponenteNutricionalModel();
        $this->componenteModel = new ComponenteNutricionalModel();
        $this->imagenModel     = new ImagenModel();
        $this->ensureTable();
    }

    /**
     * Asegura de forma preventiva que la tabla exista en la BD (entorno local o nube)
     */
    protected function ensureTable(): void
    {
        try {
            $db = \Config\Database::connect();
            $db->query("CREATE TABLE IF NOT EXISTS `imagencomponentenutricional` (
              `idimagencomponentenutricional` int(11) NOT NULL AUTO_INCREMENT,
              `idimagen` int(11) NOT NULL,
              `idcomponentenutricional` int(11) NOT NULL,
              PRIMARY KEY (`idimagencomponentenutricional`),
              UNIQUE KEY `uk_imagen_componentenutricional` (`idimagen`, `idcomponentenutricional`),
              KEY `fk_icn_imagen` (`idimagen`),
              KEY `fk_icn_componentenutricional` (`idcomponentenutricional`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `ImagenComponenteNutricional` AS 
                        SELECT `idimagencomponentenutricional`, `idimagen`, `idcomponentenutricional` 
                        FROM `imagencomponentenutricional`;");
        } catch (\Throwable $e) {
            log_message('error', 'ImagenComponenteNutricional::ensureTable: ' . $e->getMessage());
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
            $record = $this->icnModel->getRecordWithDetails((int)$id);
        } else {
            $first = $this->icnModel->elprimero();
            $record = $first ? $this->icnModel->getRecordWithDetails((int)$first['idimagencomponentenutricional']) : null;
        }

        $urlImagen = null;
        $urlFallback = null;
        $archivoExiste = false;

        if ($record && !empty($record['imagen_nombre'])) {
            $cleanName = basename(trim($record['imagen_nombre']));
            $dirRuta = !empty($record['directorio_ruta']) ? trim($record['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $urlImagen = base_url($dirRuta . '/' . $cleanName);
            $urlFallback = base_url('imagen/imagen/' . $cleanName);

            $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
            $targetPath = $baseDir . '/' . $dirRuta . '/' . $cleanName;
            $archivoExiste = file_exists($targetPath);
        }

        $data = [
            'title'         => 'Relación Imagen - Componente Nutricional' . ($record ? ': #' . $record['idimagencomponentenutricional'] : ''),
            'rel'           => $record,
            'urlImagen'     => $urlImagen,
            'urlFallback'   => $urlFallback,
            'archivoExiste' => $archivoExiste,
            'module'        => 'imagencomponentenutricional',
        ];

        return view('imagencomponentenutricional/imagencomponentenutricional_record', $data);
    }

    public function elprimero()
    {
        $first = $this->icnModel->elprimero();
        return $this->actual($first ? $first['idimagencomponentenutricional'] : null);
    }

    public function elultimo()
    {
        $last = $this->icnModel->elultimo();
        return $this->actual($last ? $last['idimagencomponentenutricional'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->icnModel->siguiente((int)$id);
        return $this->actual($next ? $next['idimagencomponentenutricional'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->icnModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idimagencomponentenutricional'] : $id);
    }

    /**
     * Listado con filtros y buscador
     */
    public function listar()
    {
        $search       = $this->request->getGet('q');
        $idcomponente = $this->request->getGet('idcomponente');
        $idimagen     = $this->request->getGet('idimagen');

        $idcomponente = (!empty($idcomponente) && is_numeric($idcomponente)) ? (int)$idcomponente : null;
        $idimagen     = (!empty($idimagen) && is_numeric($idimagen)) ? (int)$idimagen : null;

        $listado     = $this->icnModel->getRecordsWithDetails($search, $idcomponente, $idimagen);
        $componentes = $this->componenteModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes    = $this->imagenModel->orderBy('idimagen', 'DESC')->findAll();

        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);
        foreach ($listado as &$item) {
            $dirRuta = !empty($item['directorio_ruta']) ? trim($item['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $cleanName = !empty($item['imagen_nombre']) ? basename(trim($item['imagen_nombre'])) : '';
            $item['urlImagen'] = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
            $item['urlFallback'] = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
            $item['archivoExiste'] = !empty($cleanName) && file_exists($baseDir . '/' . $dirRuta . '/' . $cleanName);
        }

        $data = [
            'title'              => 'Catálogo de Imágenes por Componente Nutricional',
            'listado'            => $listado,
            'componentes'        => $componentes,
            'imagenes'           => $imagenes,
            'selectedComponente'=> $idcomponente,
            'selectedImagen'     => $idimagen,
            'search'             => $search,
            'module'             => 'imagencomponentenutricional',
        ];

        return view('imagencomponentenutricional/imagencomponentenutricional_list', $data);
    }

    /**
     * Formulario para registrar una nueva relación imagen-componente
     */
    public function add()
    {
        $componentes = $this->componenteModel->orderBy('nombre', 'ASC')->findAll();
        $imagenes    = $this->imagenModel->getImagenes();

        $data = [
            'title'                 => 'Asignar Imagen a Componente Nutricional',
            'componentes'           => $componentes,
            'imagenes'              => $imagenes,
            'preselectedComponente' => $this->request->getGet('idcomponente') ?: $this->request->getGet('idcomponentenutricional'),
            'preselectedImagen'     => $this->request->getGet('idimagen'),
            'module'                => 'imagencomponentenutricional',
        ];

        return view('imagencomponentenutricional/imagencomponentenutricional_form', $data);
    }

    /**
     * Guarda la nueva relación en la base de datos
     */
    public function save()
    {
        $rules = [
            'idimagen'                => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        $messages = [
            'idimagen' => [
                'required'           => 'Debe seleccionar una imagen.',
                'is_natural_no_zero' => 'Seleccione una imagen válida.',
                'is_not_unique'      => 'La imagen seleccionada no existe.',
            ],
            'idcomponentenutricional' => [
                'required'           => 'Debe seleccionar un componente nutricional.',
                'is_natural_no_zero' => 'Seleccione un componente nutricional válido.',
                'is_not_unique'      => 'El componente nutricional no existe.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen     = (int)$this->request->getPost('idimagen');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar unicidad
        $exists = $this->icnModel->where('idimagen', $idimagen)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Esta imagen ya está asignada a este componente nutricional.');
        }

        $id = $this->icnModel->insert([
            'idimagen'                => $idimagen,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('imagencomponentenutricional/actual/' . $id))
                         ->with('success', 'Imagen asignada al componente nutricional exitosamente.');
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $rel = $this->icnModel->find($id);
        if (!$rel) {
            throw PageNotFoundException::forPageNotFound("Registro no encontrado.");
        }

        $data = [
            'title'       => 'Editar Asignación de Imagen a Componente #' . $id,
            'rel'         => $rel,
            'componentes' => $this->componenteModel->orderBy('nombre', 'ASC')->findAll(),
            'imagenes'    => $this->imagenModel->getImagenes(),
            'module'      => 'imagencomponentenutricional',
        ];

        return view('imagencomponentenutricional/imagencomponentenutricional_edit', $data);
    }

    /**
     * Actualiza la relación
     */
    public function update($id)
    {
        $rel = $this->icnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagencomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idimagen'                => 'required|is_natural_no_zero|is_not_unique[imagen.idimagen]',
            'idcomponentenutricional' => 'required|is_natural_no_zero|is_not_unique[componentenutricional.idcomponentenutricional]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idimagen     = (int)$this->request->getPost('idimagen');
        $idcomponente = (int)$this->request->getPost('idcomponentenutricional');

        // Validar que no se duplique con otra relación
        $exists = $this->icnModel->where('idimagen', $idimagen)
                                 ->where('idcomponentenutricional', $idcomponente)
                                 ->where('idimagencomponentenutricional !=', $id)
                                 ->first();

        if ($exists) {
            return redirect()->back()->withInput()->with('error', 'Ya existe otra asignación con esa misma imagen y componente.');
        }

        $this->icnModel->update($id, [
            'idimagen'                => $idimagen,
            'idcomponentenutricional' => $idcomponente,
        ]);

        return redirect()->to(base_url('imagencomponentenutricional/actual/' . $id))
                         ->with('success', 'Relación actualizada correctamente.');
    }

    /**
     * Elimina la relación
     */
    public function delete($id)
    {
        $rel = $this->icnModel->find($id);
        if (!$rel) {
            return redirect()->to(base_url('imagencomponentenutricional'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->icnModel->delete($id);
            $first = $this->icnModel->elprimero();
            $targetUrl = $first ? 'imagencomponentenutricional/actual/' . $first['idimagencomponentenutricional'] : 'imagencomponentenutricional';
            return redirect()->to(base_url($targetUrl))->with('success', 'Relación eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('imagencomponentenutricional/actual/' . $id))
                             ->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
