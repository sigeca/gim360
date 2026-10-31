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

        $this->ensureTables();
        $this->ensureUploadDirectory();
    }

    /**
     * Asegura de forma preventiva y transparente que las tablas existan en la BD
     */
    protected function ensureTables(): void
    {
        try {
            $db = \Config\Database::connect();

            // 1. formatoimagen
            $db->query("CREATE TABLE IF NOT EXISTS `formatoimagen` (
              `idformatoimagen` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`idformatoimagen`),
              UNIQUE KEY `uk_formatoimagen_nombre` (`nombre`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `FormatoImagen` AS SELECT `idformatoimagen`, `nombre` FROM `formatoimagen`;");
            @$db->query("INSERT IGNORE INTO `formatoimagen` (`idformatoimagen`, `nombre`) VALUES (1,'jpg'),(2,'png'),(3,'webp'),(4,'gif'),(5,'jpeg');");

            // 2. ordenador
            $db->query("CREATE TABLE IF NOT EXISTS `ordenador` (
              `idordenador` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(45) DEFAULT NULL,
              PRIMARY KEY (`idordenador`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `Ordenador` AS SELECT `idordenador`, `nombre` FROM `ordenador`;");
            @$db->query("INSERT IGNORE INTO `ordenador` (`idordenador`, `nombre`) VALUES (1, 'Servidor Local gim360');");

            // 3. directorio
            $db->query("CREATE TABLE IF NOT EXISTS `directorio` (
              `iddirectorio` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(45) DEFAULT NULL,
              `ruta` varchar(200) DEFAULT NULL,
              `descripcion` text DEFAULT NULL,
              `idordenador` int(11) NOT NULL DEFAULT 1,
              PRIMARY KEY (`iddirectorio`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `Directorio` AS SELECT `iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador` FROM `directorio`;");
            @$db->query("INSERT IGNORE INTO `directorio` (`iddirectorio`, `nombre`, `ruta`, `descripcion`, `idordenador`) VALUES 
              (1, 'Imagenes Gim360', 'repositorio/imagen', 'Directorio principal de almacenamiento de imágenes', 1),
              (2, 'Equipos', 'repositorio/images/equipment', 'Directorio de imágenes de equipos y máquinas', 1),
              (3, 'Músculos', 'repositorio/images/muscles', 'Directorio de imágenes anatómicas de músculos', 1),
              (4, 'Ejercicios', 'repositorio/ejercicios', 'Directorio de imágenes y animaciones de ejercicios', 1),
              (5, 'Motivos', 'repositorio/motivos', 'Directorio de imágenes de motivos de entrenamiento', 1);");

            // 4. imagen
            $db->query("CREATE TABLE IF NOT EXISTS `imagen` (
              `idimagen` int(11) NOT NULL AUTO_INCREMENT,
              `nombre` varchar(255) DEFAULT NULL,
              `idformatoimagen` int(11) DEFAULT NULL,
              `fechacaptura` datetime DEFAULT NULL,
              `descripcion` text DEFAULT NULL,
              `palabrasclave` text DEFAULT NULL,
              `licencia` varchar(50) DEFAULT NULL,
              `fechacreacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
              `idordenador` int(11) DEFAULT 1,
              `iddirectorio` int(11) DEFAULT 1,
              PRIMARY KEY (`idimagen`),
              KEY `idx_imagen_formato` (`idformatoimagen`),
              KEY `idx_imagen_ordenador` (`idordenador`),
              KEY `idx_imagen_directorio` (`iddirectorio`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;");

            @$db->query("CREATE OR REPLACE VIEW `Imagen` AS SELECT `idimagen`, `nombre`, `idformatoimagen`, `fechacaptura`, `descripcion`, `palabrasclave`, `licencia`, `fechacreacion`, `idordenador`, `iddirectorio` FROM `imagen`;");
        } catch (\Throwable $e) {
            log_message('error', 'Imagen::ensureTables notice: ' . $e->getMessage());
        }
    }

    /**
     * Asegura que el directorio exista físicamente y tenga permisos de lectura/escritura
     */
    protected function ensureUploadDirectory(?string $subDir = null): string
    {
        $relPath = !empty($subDir) ? trim($subDir, '/\\') : 'repositorio/imagen';
        $fullPath = ROOTPATH . $relPath . '/';
        try {
            $baseRepo = ROOTPATH . 'repositorio/';
            if (!is_dir($baseRepo)) {
                @mkdir($baseRepo, 0777, true);
            }

            if (!is_dir($fullPath)) {
                @mkdir($fullPath, 0777, true);
            }

            @chmod($fullPath, 0777);

            // Asegurar symlink público si aplica
            $publicRepo = FCPATH . 'repositorio';
            if (!file_exists($publicRepo) && is_dir($baseRepo)) {
                @symlink('../repositorio', $publicRepo);
            }

            return $fullPath;
        } catch (\Throwable $e) {
            log_message('error', 'ensureUploadDirectory notice: ' . $e->getMessage());
            return $this->uploadPath;
        }
    }

    /**
     * Obtiene la ruta relativa del directorio asignado a un iddirectorio
     */
    public function getDirectorioRuta(?int $iddirectorio): string
    {
        return $this->directorioModel->getRutaDirectorio($iddirectorio);
    }

    /**
     * Localiza la ruta física absoluta de un archivo en el repositorio respetando su directorio
     */
    public function getRutaArchivo(?string $filename, ?string $directorioRuta = null): ?string
    {
        if (empty($filename)) {
            return null;
        }

        $cleanFilename = basename(trim($filename));
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

        // Si no se proporcionó la ruta del directorio, buscar el directorio asignado en la BD
        if (empty($directorioRuta)) {
            try {
                $img = $this->imagenModel->select('directorio.ruta')
                    ->join('directorio', 'directorio.iddirectorio = imagen.iddirectorio', 'left')
                    ->where('imagen.nombre', $cleanFilename)
                    ->first();
                if ($img && !empty($img['ruta'])) {
                    $directorioRuta = $img['ruta'];
                }
            } catch (\Throwable $e) {
                // Ignore
            }
        }

        $candidates = [];

        // 1. Ruta prioritaria: la del directorio configurado para la imagen
        if (!empty($directorioRuta)) {
            $dirClean = trim($directorioRuta, '/\\');
            $candidates[] = $baseDir . '/' . $dirClean . '/' . $cleanFilename;
            $candidates[] = FCPATH . $dirClean . '/' . $cleanFilename;
            $candidates[] = ROOTPATH . $dirClean . '/' . $cleanFilename;

            if (strpos($dirClean, 'repositorio') !== 0) {
                $candidates[] = $baseDir . '/repositorio/' . $dirClean . '/' . $cleanFilename;
                $candidates[] = FCPATH . 'repositorio/' . $dirClean . '/' . $cleanFilename;
            }
        }

        // 2. Rutas conocidas en el repositorio como fallback
        $candidates[] = $this->uploadPath . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/imagen/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/images/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/images/equipment/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/images/muscles/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/ejercicios/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/motivos/' . $cleanFilename;
        $candidates[] = $baseDir . '/repositorio/' . $cleanFilename;
        $candidates[] = FCPATH . 'repositorio/imagen/' . $cleanFilename;
        $candidates[] = FCPATH . 'repositorio/' . $cleanFilename;

        foreach ($candidates as $cand) {
            if (file_exists($cand) && is_file($cand)) {
                return $cand;
            }
        }

        return null;
    }

    /**
     * Servir archivo de imagen con Content-Type y Cache-Control adecuados
     * Permite visualizar la imagen en cualquier servidor (local o nube)
     */
    public function imagen($filename = null)
    {
        return $this->archivo($filename);
    }

    public function archivo($filename = null)
    {
        if (empty($filename)) {
            throw PageNotFoundException::forPageNotFound("Nombre de archivo no especificado.");
        }

        $targetPath = $this->getRutaArchivo($filename);

        if (!$targetPath) {
            throw PageNotFoundException::forPageNotFound("Archivo no encontrado en repositorio/imagen/: " . basename($filename));
        }

        $extension = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'webp' => 'image/webp',
            'png'  => 'image/png',
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'gif'  => 'image/gif',
            'svg'  => 'image/svg+xml',
            'bmp'  => 'image/bmp',
            'ico'  => 'image/x-icon',
        ];

        $contentType = $mimeTypes[$extension] ?? (mime_content_type($targetPath) ?: 'image/jpeg');

        return $this->response
            ->setHeader('Content-Type', $contentType)
            ->setHeader('Content-Length', (string)filesize($targetPath))
            ->setHeader('Cache-Control', 'public, max-age=86400')
            ->setBody(file_get_contents($targetPath));
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

        $archivoExiste  = false;
        $urlImagen      = null;
        $urlFallback    = null;
        $directorioRuta = 'repositorio/imagen';

        if ($imagen && !empty($imagen['nombre'])) {
            if (!empty($imagen['directorio_ruta'])) {
                $directorioRuta = trim($imagen['directorio_ruta'], '/\\');
            }
            $targetPath    = $this->getRutaArchivo($imagen['nombre'], $directorioRuta);
            $archivoExiste = ($targetPath !== null);
            $cleanName     = basename(trim($imagen['nombre']));
            // Se utiliza el directorio asignado a la imagen para visualizarla
            $urlImagen     = base_url($directorioRuta . '/' . $cleanName);
            $urlFallback   = base_url('imagen/imagen/' . $cleanName);
        }

        $data = [
            'title'          => 'Ficha de Imagen' . ($imagen ? ' #' . $imagen['idimagen'] : ''),
            'imagen'         => $imagen,
            'archivoExiste'  => $archivoExiste,
            'urlImagen'      => $urlImagen,
            'urlFallback'    => $urlFallback,
            'directorioRuta' => $directorioRuta,
            'module'         => 'imagen',
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
            $dirRuta = !empty($img['directorio_ruta']) ? trim($img['directorio_ruta'], '/\\') : 'repositorio/imagen';
            $imgExiste = !empty($img['nombre']) && ($this->getRutaArchivo($img['nombre'], $dirRuta) !== null);
            $img['archivoExiste']   = $imgExiste;
            $img['directorio_ruta'] = $dirRuta;
            $cleanName              = !empty($img['nombre']) ? basename(trim($img['nombre'])) : '';
            // Se utiliza el directorio configurado para visualizar la imagen
            $img['urlImagen']       = !empty($cleanName) ? base_url($dirRuta . '/' . $cleanName) : null;
            $img['urlFallback']     = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;
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
        $this->ensureTables();

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
        $this->ensureTables();

        $file = $this->request->getFile('archivo_imagen');
        $idformato = $this->request->getPost('idformatoimagen') ? (int)$this->request->getPost('idformatoimagen') : null;

        $extension = 'jpg';
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $extDetected = strtolower($file->getClientExtension());
            if (!empty($extDetected)) {
                $extension = $extDetected;
            }
        } elseif ($idformato) {
            try {
                $formatoRow = $this->formatoModel->find($idformato);
                if ($formatoRow && !empty($formatoRow['nombre'])) {
                    $extension = strtolower(ltrim($formatoRow['nombre'], '.'));
                }
            } catch (\Throwable $e) {
                // Ignore
            }
        }

        // Si tenemos la extensión pero no idformatoimagen, intentamos resolver el ID
        if (empty($idformato)) {
            try {
                $formatoEncontrado = $this->formatoModel->where('nombre', $extension)->first();
                if ($formatoEncontrado) {
                    $idformato = (int)$formatoEncontrado['idformatoimagen'];
                }
            } catch (\Throwable $e) {
                $idformato = 1;
            }
        }

        $idordenador = $this->request->getPost('idordenador') ? (int)$this->request->getPost('idordenador') : 1;
        $iddirectorio = $this->request->getPost('iddirectorio') ? (int)$this->request->getPost('iddirectorio') : 1;
        $dirRuta = $this->directorioModel->getRutaDirectorio($iddirectorio);
        $targetUploadPath = $this->ensureUploadDirectory($dirRuta);

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

        try {
            $id = $this->imagenModel->insert($dataInsert);
        } catch (\Throwable $e) {
            log_message('error', 'Error al insertar imagen: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error al guardar en base de datos: ' . $e->getMessage());
        }

        if (!$id) {
            return redirect()->back()->withInput()->with('error', 'No se pudo registrar la información de la imagen.');
        }

        // Formato SICA exacto: Ymd_His-00000.ext
        $filename = $this->imagenModel->generarNombreSica((int)$id, $extension);
        try {
            $this->imagenModel->update($id, ['nombre' => $filename]);
        } catch (\Throwable $e) {
            log_message('error', 'Error al actualizar nombre de imagen: ' . $e->getMessage());
        }

        // Mover archivo si fue subido en el directorio correspondiente
        if ($file && $file->isValid() && !$file->hasMoved()) {
            try {
                $file->move($targetUploadPath, $filename, true);
            } catch (\Throwable $e) {
                log_message('error', 'Aviso al mover archivo en directorio: ' . $e->getMessage());
                return redirect()->to(base_url('imagen/actual/' . $id))
                    ->with('warning', 'Registro guardado como #' . $id . ', pero verifique los permisos de escritura en la carpeta ' . $dirRuta . '/.');
            }
        }

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Imagen registrada correctamente con nombre: ' . $filename);
    }

    /**
     * Formulario de edición
     */
    public function edit($id)
    {
        $this->ensureTables();

        $imagen = $this->imagenModel->getImagenWithDetails((int)$id);
        if (!$imagen) {
            throw PageNotFoundException::forPageNotFound('Imagen no encontrada.');
        }

        $directorioRuta = !empty($imagen['directorio_ruta']) ? trim($imagen['directorio_ruta'], '/\\') : 'repositorio/imagen';
        $archivoExiste  = !empty($imagen['nombre']) && ($this->getRutaArchivo($imagen['nombre'], $directorioRuta) !== null);
        $cleanName      = !empty($imagen['nombre']) ? basename(trim($imagen['nombre'])) : '';
        $urlImagen      = !empty($cleanName) ? base_url($directorioRuta . '/' . $cleanName) : null;
        $urlFallback    = !empty($cleanName) ? base_url('imagen/imagen/' . $cleanName) : null;

        $data = [
            'title'          => 'Editar Imagen #' . $imagen['idimagen'],
            'imagen'         => $imagen,
            'archivoExiste'  => $archivoExiste,
            'urlImagen'      => $urlImagen,
            'urlFallback'    => $urlFallback,
            'directorioRuta' => $directorioRuta,
            'formatos'       => $this->formatoModel->getFormatos(),
            'ordenadores'    => $this->ordenadorModel->getOrdenadores(),
            'directorios'    => $this->directorioModel->getDirectorios(),
            'module'         => 'imagen',
        ];

        return view('imagen/imagen_edit', $data);
    }

    /**
     * Actualizar datos de la imagen
     */
    public function update($id)
    {
        $imagen = $this->imagenModel->getImagenWithDetails((int)$id);
        if (!$imagen) {
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        date_default_timezone_set('America/Guayaquil');

        $iddirectorio = $this->request->getPost('iddirectorio') ? (int)$this->request->getPost('iddirectorio') : (int)($imagen['iddirectorio'] ?? 1);
        $dirRuta = $this->directorioModel->getRutaDirectorio($iddirectorio);
        $targetUploadPath = $this->ensureUploadDirectory($dirRuta);

        $file = $this->request->getFile('archivo_imagen');
        $idformato = $this->request->getPost('idformatoimagen') ? (int)$this->request->getPost('idformatoimagen') : $imagen['idformatoimagen'];

        $filename = $imagen['nombre'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $extension = strtolower($file->getClientExtension());
            if (empty($filename)) {
                $filename = $this->imagenModel->generarNombreSica((int)$id, $extension);
            }
            try {
                $file->move($targetUploadPath, $filename, true);
            } catch (\Throwable $e) {
                log_message('error', 'Error al mover archivo reemplazado: ' . $e->getMessage());
            }
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
            'iddirectorio'    => $iddirectorio,
        ];

        try {
            $this->imagenModel->update($id, $dataUpdate);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Imagen actualizada exitosamente.');
    }

    /**
     * Subir/reemplazar el archivo físico de imagen (directo o vía AJAX)
     */
    public function upload($id)
    {
        $imagen = $this->imagenModel->getImagenWithDetails((int)$id);
        if (!$imagen) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Imagen no encontrada.'])->setStatusCode(404);
            }
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        $iddirectorio = (int)($imagen['iddirectorio'] ?? 1);
        $dirRuta = $this->directorioModel->getRutaDirectorio($iddirectorio);
        $targetUploadPath = $this->ensureUploadDirectory($dirRuta);

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

        try {
            $file->move($targetUploadPath, $filename, true);
        } catch (\Throwable $e) {
            $msg = 'Error al guardar archivo en el servidor: ' . $e->getMessage();
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['status' => 'error', 'message' => $msg])->setStatusCode(500);
            }
            return redirect()->back()->with('error', $msg);
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status'    => 'success',
                'message'   => 'Imagen subida correctamente.',
                'filename'  => $filename,
                'url'       => base_url($dirRuta . '/' . $filename),
                'repoUrl'   => base_url($dirRuta . '/' . $filename),
            ]);
        }

        return redirect()->to(base_url('imagen/actual/' . $id))->with('success', 'Archivo de imagen subido y guardado exitosamente en ' . $dirRuta . '/.');
    }

    /**
     * Eliminar imagen (registro y archivo en disco)
     */
    public function delete($id)
    {
        $imagen = $this->imagenModel->getImagenWithDetails((int)$id);
        if (!$imagen) {
            return redirect()->to(base_url('imagen'))->with('error', 'Imagen no encontrada.');
        }

        try {
            // Eliminar archivo físico si existe en el directorio asignado o repositorio/imagen/
            if (!empty($imagen['nombre'])) {
                $dirRuta = !empty($imagen['directorio_ruta']) ? trim($imagen['directorio_ruta'], '/\\') : 'repositorio/imagen';
                $filePath = ROOTPATH . $dirRuta . '/' . $imagen['nombre'];
                if (file_exists($filePath)) {
                    @unlink($filePath);
                } elseif (file_exists($this->uploadPath . $imagen['nombre'])) {
                    @unlink($this->uploadPath . $imagen['nombre']);
                }
            }

            $this->imagenModel->delete($id);

            $first = $this->imagenModel->elprimero();
            $targetUrl = $first ? 'imagen/actual/' . $first['idimagen'] : 'imagen';
            return redirect()->to(base_url($targetUrl))->with('success', 'Imagen eliminada exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('imagen/actual/' . $id))->with('error', 'Error al eliminar imagen: ' . $e->getMessage());
        }
    }
}
