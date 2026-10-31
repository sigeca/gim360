<?php

namespace App\Controllers;

use App\Models\ImagenModel;
use App\Models\FormatoImagenModel;
use App\Models\OrdenadorModel;
use App\Models\DirectorioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Imagen extends BaseController
{
    protected ImagenModel $imagenModel;
    protected FormatoImagenModel $formatoModel;
    protected OrdenadorModel $ordenadorModel;
    protected DirectorioModel $directorioModel;
    protected string $uploadPath;

    public function __construct()
    {
        $this->imagenModel     = new ImagenModel();
        $this->formatoModel    = new FormatoImagenModel();
        $this->ordenadorModel  = new OrdenadorModel();
        $this->directorioModel = new DirectorioModel();
        $this->uploadPath      = ROOTPATH . 'repositorio/imagen/';

        if (!is_dir($this->uploadPath)) {
            @mkdir($this->uploadPath, 0777, true);
        }
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    /**
     * Ficha detallada de la imagen
     */
    public function actual($id = null)
    {
        if ($id) {
            $imagen = $this->imagenModel->getImagenWithDetails((int)$id);
        } else {
            $first = $this->imagenModel->elultimo();
            $imagen = $first ? $this->imagenModel->getImagenWithDetails((int)$first['idimagen']) : null;
        }

        $archivoExiste = false;
        $urlImagen     = null;
        if ($imagen && !empty($imagen['nombre'])) {
            $archivoRuta = $this->uploadPath . $imagen['nombre'];
            $archivoExiste = file_exists($archivoRuta);
            $urlImagen = base_url('repositorio/imagen/' . $imagen['nombre']);
        }

        $data = [
            'title'         => 'Ficha de Imagen' . ($imagen ? ' #' . $imagen['idimagen'] : ''),
            'imagen'        => $imagen,
            'archivoExiste' => $archivoExiste,
            'urlImagen'     => $urlImagen,
            'module'        => 'imagen',
        ];

        return view('imagen/imagen_record', $data);
    }

    public function elprimero()
    {
        $first = $this->imagenModel->elprimero();
        return $this->actual($first ? $first['idimagen'] : null);
    }

    public function elultimo()
    {
        $last = $this->imagenModel->elultimo();
        return $this->actual($last ? $last['idimagen'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->imagenModel->siguiente((int)$id);
        return $this->actual($next ? $next['idimagen'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->imagenModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idimagen'] : $id);
    }

    /**
     * Catálogo / Galería de imágenes
     */
    public function listar()
    {
        $search   = $this->request->getGet('q');
        $imagenes = $this->imagenModel->getImagenes($search);

        foreach ($imagenes as &$img) {
            $img['archivoExiste'] = !empty($img['nombre']) && file_exists($this->uploadPath . $img['nombre']);
            $img['urlImagen']     = !empty($img['nombre']) ? base_url('repositorio/imagen/' . $img['nombre']) : null;
        }

        $data = [
            'title'    => 'Catálogo de Imágenes',
            'imagenes' => $imagenes,
            'search'   => $search,
            'module'   => 'imagen',
        ];

        return view('imagen/imagen_list', $data);
    }

    /**
     * Formulario de nueva imagen
     */
    public function add()
    {
        $data = [
            'title'           => 'Registrar Nueva Imagen',
            'formatos'        => $this->formatoModel->getFormatos(),
            'ordenadores'     => $this->ordenadorModel->getOrdenadores(),
            'directorios'     => $this->directorioModel->getDirectorios(),
            'module'          => 'imagen',
        ];

        return view('imagen/imagen_form', $data);
    }

    /**
     * Guardar nueva imagen (con generación de nombre formato SICA y almacenamiento)
     */
    public function save()
    {
        date_default_timezone_set('America/Guayaquil');

        $file = $this->request->getFile('archivo_imagen');
        $idformato = $this->request->getPost('idformatoimagen') ? (int)$this->request->getPost('idformatoimagen') : null;

        $extension = 'jpg';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $extDetected = strtolower($file->getClientExtension());
            if (!empty($extDetected)) {
                $extension = $extDetected;
            }
        } elseif ($idformato) {
            $formatoRow = $this->formatoModel->find($idformato);
            if ($formatoRow && !empty($formatoRow['nombre'])) {
                $extension = strtolower(ltrim($formatoRow['nombre'], '.'));
            }
        }

        // Si tenemos la extensión pero no idformatoimagen, intentamos resolver el ID
        if (empty($idformato)) {
            $formatoEncontrado = $this->formatoModel->where('nombre', $extension)->first();
            if ($formatoEncontrado) {
                $idformato = (int)$formatoEncontrado['idformatoimagen'];
            }
        }

        $idordenador = $this->request->getPost('idordenador') ? (int)$this->request->getPost('idordenador') : 1;
        $iddirectorio = $this->request->getPost('iddirectorio') ? (int)$this->request->getPost('iddirectorio') : 1;

        $fechacaptura = $this->request->getPost('fechacaptura');
        if (empty($fechacaptura)) {
            $fechacaptura = date('Y-m-d H:i:s');
        } elseif (strlen($fechacaptura) === 10) {
            $fechacaptura .= ' ' . date('H:i:s');
        }

        $dataInsert = [
            'nombre'          => null,
            'idformatoimagen' => $idformato,
            'fechacaptura'    => $fechacaptura,
            'descripcion'     => $this->request->getPost('descripcion'),
            'palabrasclave'   => $this->request->getPost('palabrasclave'),
            'licencia'        => $this->request->getPost('licencia') ?: 'Propietaria',
            'fechacreacion'   => date('Y-m-d H:i:s'),
            'idordenador'     => $idordenador,
            'iddirectorio'    => $iddirectorio,
        ];

        $id = $this->imagenModel->insert($dataInsert);

        if (!$id) {
            return redirect()->back()->withInput()->with('error', 'No se pudo registrar la información de la imagen.');
        }

        // Formato SICA exacto: Ymd_His-00000.ext
        $filename = $this->imagenModel->generarNombreSica((int)$id, $extension);
        $this->imagenModel->update($id, ['nombre' => $filename]);

        // Mover archivo si fue subido
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $file->move($this->uploadPath, $filename, true);
        }

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Imagen registrada correctamente con nombre: ' . $filename);
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $imagen = $this->imagenModel->find($id);
        if (!$imagen) {
            throw PageNotFoundException::forPageNotFound('Imagen no encontrada.');
        }

        $data = [
            'title'       => 'Editar Imagen #' . $imagen['idimagen'],
            'imagen'      => $imagen,
            'formatos'    => $this->formatoModel->getFormatos(),
            'ordenadores' => $this->ordenadorModel->getOrdenadores(),
            'directorios' => $this->directorioModel->getDirectorios(),
            'module'      => 'imagen',
        ];

        return view('imagen/imagen_edit', $data);
    }

    /**
     * Actualizar datos de la imagen
     */
    public function update($id)
    {
        $imagen = $this->imagenModel->find($id);
        if (!$imagen) {
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        date_default_timezone_set('America/Guayaquil');

        $file = $this->request->getFile('archivo_imagen');
        $idformato = $this->request->getPost('idformatoimagen') ? (int)$this->request->getPost('idformatoimagen') : $imagen['idformatoimagen'];

        $filename = $imagen['nombre'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $extension = strtolower($file->getClientExtension());
            if (empty($filename)) {
                $filename = $this->imagenModel->generarNombreSica((int)$id, $extension);
            }
            $file->move($this->uploadPath, $filename, true);
        }

        $fechacaptura = $this->request->getPost('fechacaptura');
        if (!empty($fechacaptura) && strlen($fechacaptura) === 10) {
            $fechacaptura .= ' ' . date('H:i:s');
        }

        $dataUpdate = [
            'nombre'          => $filename,
            'idformatoimagen' => $idformato,
            'fechacaptura'    => $fechacaptura ?: $imagen['fechacaptura'],
            'descripcion'     => $this->request->getPost('descripcion'),
            'palabrasclave'   => $this->request->getPost('palabrasclave'),
            'licencia'        => $this->request->getPost('licencia'),
            'idordenador'     => $this->request->getPost('idordenador') ? (int)$this->request->getPost('idordenador') : $imagen['idordenador'],
            'iddirectorio'    => $this->request->getPost('iddirectorio') ? (int)$this->request->getPost('iddirectorio') : $imagen['iddirectorio'],
        ];

        $this->imagenModel->update($id, $dataUpdate);

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Imagen actualizada exitosamente.');
    }

    /**
     * Subir/reemplazar el archivo físico de imagen (directo o vía AJAX)
     */
    public function upload($id)
    {
        $imagen = $this->imagenModel->find($id);
        if (!$imagen) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Imagen no encontrada.'])->setStatusCode(404);
            }
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        $file = $this->request->getFile('archivo_imagen') ?: $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            $msg = $file ? $file->getErrorString() : 'No se seleccionó ningún archivo válido.';
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => $msg])->setStatusCode(400);
            }
            return redirect()->back()->with('error', $msg);
        }

        date_default_timezone_set('America/Guayaquil');
        $extension = strtolower($file->getClientExtension() ?: 'jpg');

        $filename = $imagen['nombre'];
        if (empty($filename)) {
            $filename = $this->imagenModel->generarNombreSica((int)$id, $extension);
            $this->imagenModel->update($id, ['nombre' => $filename]);
        }

        $file->move($this->uploadPath, $filename, true);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'    => 'success',
                'message'   => 'Imagen subida correctamente.',
                'filename'  => $filename,
                'url'       => base_url('repositorio/imagen/' . $filename),
            ]);
        }

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Archivo de imagen subido y guardado exitosamente.');
    }

    /**
     * Eliminar imagen (registro y archivo en disco)
     */
    public function delete($id)
    {
        $imagen = $this->imagenModel->find($id);
        if (!$imagen) {
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        try {
            // Eliminar archivo físico si existe en repositorio/imagen/
            if (!empty($imagen['nombre'])) {
                $filePath = $this->uploadPath . $imagen['nombre'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }

            $this->imagenModel->delete($id);

            $first = $this->imagenModel->elprimero();
            $targetUrl = $first ? 'imagen/actual/' . $first['idimagen'] : 'imagen';
            return redirect()->to(base_url($targetUrl))->with('success', 'Imagen eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('imagen/actual/' . $id))->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }
}
