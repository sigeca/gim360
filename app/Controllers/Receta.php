<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\ComponenteNutricionalModel;
use App\Models\RecetaComponenteNutricionalModel;
use App\Models\ImagenModel;
use App\Models\FormatoImagenModel;
use App\Models\ImagenRecetaModel;
use App\Libraries\GeminiVisionService;
use CodeIgniter\Exceptions\PageNotFoundException;

class Receta extends BaseController
{
    protected RecetaModel $recetaModel;

    public function __construct()
    {
        $this->recetaModel = new RecetaModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $receta = $this->recetaModel->getRecetaWithDetails((int)$id);
        } else {
            $first = $this->recetaModel->elprimero();
            $receta = $first ? $this->recetaModel->getRecetaWithDetails((int)$first['idreceta']) : null;
        }

        $ingredientes  = [];
        $componentes   = [];
        $imagenes      = [];
        $todasImagenes = [];
        if ($receta) {
            $idreceta = (int)$receta['idreceta'];
            $arModel  = new \App\Models\AlimentoRecetaModel();
            $rcnModel = new \App\Models\RecetaComponenteNutricionalModel();
            $ingredientes  = $arModel->getIngredientesByReceta($idreceta);
            $componentes   = $rcnModel->getComponentesByReceta($idreceta);
            $imagenes      = $this->recetaModel->getImagenesByReceta($idreceta);

            $imagenModel   = new \App\Models\ImagenModel();
            $todasImagenes = $imagenModel->getImagenes();
        }

        $data = [
            'title'         => 'Ficha de Receta' . ($receta ? ': ' . $receta['nombre'] : ''),
            'receta'        => $receta,
            'ingredientes'  => $ingredientes,
            'componentes'   => $componentes,
            'imagenes'      => $imagenes,
            'todasImagenes' => $todasImagenes,
            'module'        => 'receta',
        ];

        return view('receta/receta_record', $data);
    }

    public function elprimero()
    {
        $first = $this->recetaModel->elprimero();
        return $this->actual($first ? $first['idreceta'] : null);
    }

    public function elultimo()
    {
        $last = $this->recetaModel->elultimo();
        return $this->actual($last ? $last['idreceta'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->recetaModel->siguiente((int)$id);
        return $this->actual($next ? $next['idreceta'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->recetaModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idreceta'] : $id);
    }

    public function listar()
    {
        $search  = $this->request->getGet('q');
        $recetas = $this->recetaModel->getRecetas($search);

        $data = [
            'title'   => 'Catálogo de Recetas Saludables',
            'recetas' => $recetas,
            'search'  => $search,
            'module'  => 'receta',
        ];

        return view('receta/receta_list', $data);
    }

    public function add()
    {
        $cnModel = new ComponenteNutricionalModel();
        $componentes = $cnModel->getComponentes();

        $data = [
            'title'       => 'Registrar Nueva Receta',
            'componentes' => $componentes,
            'module'      => 'receta',
        ];

        return view('receta/receta_form', $data);
    }

    /**
     * Endpoint AJAX para analizar foto de plato de comida con IA Gemini Vision
     * Extrae nombre, porciones, tiempo, modo de preparación y componentes nutricionales
     */
    public function analizarFoto()
    {
        try {
            $cnModel = new ComponenteNutricionalModel();
            $allComponents = $cnModel->getComponentes();
            $compNames = array_column($allComponents, 'nombre');

            $file = $this->request->getFile('foto');
            $base64 = $this->request->getPost('foto_base64');

            $service = new GeminiVisionService();

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $tempPath = $file->getTempName();
                $mimeType = $file->getClientMimeType() ?: 'image/jpeg';
                $result = $service->analizarPlatoComida($tempPath, $mimeType, $compNames);
            } elseif (!empty($base64)) {
                $result = $service->analizarPlatoComida($base64, 'image/jpeg', $compNames);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'No se recibió ninguna imagen para analizar.'
                ])->setStatusCode(400);
            }

            // Mapear los componentes detectados por la IA con los IDs de la base de datos gim360
            $matchedComponentIds = [];
            $matchedComponents = [];
            if (!empty($result['componentes']) && is_array($result['componentes'])) {
                foreach ($result['componentes'] as $detected) {
                    $normDetected = mb_strtolower(trim($detected));
                    foreach ($allComponents as $comp) {
                        $normComp = mb_strtolower(trim($comp['nombre']));
                        // Coincidencia exacta o por subcadena
                        if ($normDetected === $normComp || 
                            stripos($normComp, $normDetected) !== false || 
                            stripos($normDetected, $normComp) !== false) {
                            $id = (int)$comp['idcomponentenutricional'];
                            if (!in_array($id, $matchedComponentIds)) {
                                $matchedComponentIds[] = $id;
                                $matchedComponents[] = [
                                    'id'     => $id,
                                    'nombre' => $comp['nombre'],
                                ];
                            }
                        }
                    }
                }
            }

            $result['matched_component_ids'] = $matchedComponentIds;
            $result['matched_components']    = $matchedComponents;

            return $this->response->setJSON([
                'success' => true,
                'data'    => $result,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Error en Receta::analizarFoto: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage(),
            ])->setStatusCode(500);
        }
    }

    public function save()
    {
        $rules = [
            'nombre'            => 'required|min_length[3]|max_length[150]',
            'instrucciones'     => 'permit_empty',
            'porciones'         => 'permit_empty|is_natural_no_zero|less_than[100]',
            'tiempopreparacion' => 'permit_empty|is_natural|less_than[1440]',
            'video'             => 'permit_empty|max_length[300]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la receta es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'porciones' => [
                'is_natural_no_zero' => 'Las porciones deben ser un número entero mayor a 0.',
                'less_than'          => 'Las porciones deben ser menores a 100.',
            ],
            'tiempopreparacion' => [
                'is_natural' => 'El tiempo de preparación debe ser un número entero en minutos (0 o más).',
                'less_than'  => 'El tiempo no puede superar los 1440 minutos.',
            ],
            'video' => [
                'max_length' => 'La URL del video no puede superar los 300 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $porciones = $this->request->getPost('porciones');
        $tiempo    = $this->request->getPost('tiempopreparacion');
        $video     = trim($this->request->getPost('video'));

        $id = $this->recetaModel->insert([
            'nombre'            => trim($this->request->getPost('nombre')),
            'instrucciones'     => trim($this->request->getPost('instrucciones')) ?: null,
            'porciones'         => (!empty($porciones) && is_numeric($porciones)) ? (int)$porciones : 1,
            'tiempopreparacion' => ($tiempo !== '' && $tiempo !== null && is_numeric($tiempo)) ? (int)$tiempo : null,
            'video'             => !empty($video) ? $video : null,
        ]);

        $nutriCount = 0;
        $fotoMsg = '';

        if ($id) {
            // 1. Guardar componentes nutricionales extraídos/seleccionados
            $componentesSeleccionados = $this->request->getPost('componentes');
            if (!empty($componentesSeleccionados) && is_array($componentesSeleccionados)) {
                $rcnModel = new RecetaComponenteNutricionalModel();
                foreach ($componentesSeleccionados as $idcomp) {
                    $idcomp = (int)$idcomp;
                    if ($idcomp > 0) {
                        try {
                            $rcnModel->insert([
                                'idreceta'                => (int)$id,
                                'idcomponentenutricional' => $idcomp,
                            ]);
                            $nutriCount++;
                        } catch (\Throwable $e) {
                            // Ignorar duplicados
                        }
                    }
                }
            }

            // 2. Guardar la fotografía del platillo (archivo o base64 capturado por cámara)
            $file = $this->request->getFile('foto');
            $fotoBase64 = $this->request->getPost('foto_base64_data');

            $idImagen = null;
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $idImagen = $this->guardarImagenReceta((int)$id, $file, null, trim($this->request->getPost('nombre')));
            } elseif (!empty($fotoBase64)) {
                $idImagen = $this->guardarImagenReceta((int)$id, null, $fotoBase64, trim($this->request->getPost('nombre')));
            }

            if ($idImagen) {
                $fotoMsg = ' y fotografía asociada en la galería';
            }
        }

        $mensaje = "Receta registrada exitosamente" . ($nutriCount > 0 ? " con {$nutriCount} componentes nutricionales" : "") . "{$fotoMsg}.";

        return redirect()->to(base_url('receta/actual/' . $id))->with('success', $mensaje);
    }

    /**
     * Guarda la fotografía analizada y la asocia en imagenreceta con nomenclatura oficial SICA
     */
    protected function guardarImagenReceta(int $idreceta, $file = null, ?string $base64Data = null, ?string $nombrePlato = null): ?int
    {
        try {
            $imagenModel  = new ImagenModel();
            $formatoModel = new FormatoImagenModel();
            $irModel      = new ImagenRecetaModel();

            $uploadDir = ROOTPATH . 'repositorio/imagen/';
            if (!is_dir($uploadDir)) {
                @mkdir($uploadDir, 0777, true);
            }

            $extension = 'jpg';
            if ($file && $file->isValid()) {
                $ext = strtolower($file->getClientExtension());
                if (!empty($ext)) $extension = $ext;
            } elseif (!empty($base64Data) && preg_match('#^data:image/(\w+);base64,#i', $base64Data, $m)) {
                $extension = strtolower($m[1] === 'jpeg' ? 'jpg' : $m[1]);
            }

            // Identificar idformatoimagen
            $idformato = 1;
            try {
                $formatoRow = $formatoModel->where('nombre', $extension)->first();
                if ($formatoRow) {
                    $idformato = (int)$formatoRow['idformatoimagen'];
                }
            } catch (\Throwable $e) {
                $idformato = 1;
            }

            date_default_timezone_set('America/Guayaquil');
            $idimagen = $imagenModel->insert([
                'nombre'          => null,
                'idformatoimagen' => $idformato,
                'fechacaptura'    => date('Y-m-d H:i:s'),
                'descripcion'     => 'Fotografía de plato: ' . ($nombrePlato ?: 'Receta #' . $idreceta),
                'palabrasclave'   => 'receta, plato, comida, nutricion, gemini vision, IA',
                'licencia'        => 'Propietaria',
                'fechacreacion'   => date('Y-m-d H:i:s'),
                'idordenador'     => 1,
                'iddirectorio'    => 1,
            ]);

            if (!$idimagen) {
                return null;
            }

            $filename = $imagenModel->generarNombreSica($idimagen, $extension);
            $destination = $uploadDir . $filename;

            if ($file && $file->isValid()) {
                $file->move($uploadDir, $filename, true);
            } elseif (!empty($base64Data)) {
                $cleanBase64 = preg_replace('#^data:image/\w+;base64,#i', '', $base64Data);
                $binary = base64_decode($cleanBase64);
                if ($binary !== false) {
                    file_put_contents($destination, $binary);
                }
            }

            if (file_exists($destination)) {
                @chmod($destination, 0777);
                $imagenModel->update($idimagen, ['nombre' => $filename]);

                // Asociar a la receta
                $irModel->insert([
                    'idreceta' => $idreceta,
                    'idimagen' => $idimagen,
                ]);

                return $idimagen;
            }
        } catch (\Throwable $e) {
            log_message('error', 'Receta::guardarImagenReceta error: ' . $e->getMessage());
        }
        return null;
    }

    public function edit($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            throw PageNotFoundException::forPageNotFound("Receta no encontrada.");
        }

        $data = [
            'title'  => 'Editar Receta: ' . $receta['nombre'],
            'receta' => $receta,
            'module' => 'receta',
        ];

        return view('receta/receta_edit', $data);
    }

    public function update($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            return redirect()->to(base_url('receta'))->with('error', 'Receta no encontrada.');
        }

        $rules = [
            'nombre'            => 'required|min_length[3]|max_length[150]',
            'instrucciones'     => 'permit_empty',
            'porciones'         => 'permit_empty|is_natural_no_zero|less_than[100]',
            'tiempopreparacion' => 'permit_empty|is_natural|less_than[1440]',
            'video'             => 'permit_empty|max_length[300]',
        ];

        $messages = [
            'nombre' => [
                'required'   => 'El nombre de la receta es obligatorio.',
                'min_length' => 'El nombre debe tener al menos 3 caracteres.',
                'max_length' => 'El nombre no puede superar los 150 caracteres.',
            ],
            'porciones' => [
                'is_natural_no_zero' => 'Las porciones deben ser un número entero mayor a 0.',
                'less_than'          => 'Las porciones deben ser menores a 100.',
            ],
            'tiempopreparacion' => [
                'is_natural' => 'El tiempo de preparación debe ser un número entero en minutos (0 o más).',
                'less_than'  => 'El tiempo no puede superar los 1440 minutos.',
            ],
            'video' => [
                'max_length' => 'La URL del video no puede superar los 300 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $porciones = $this->request->getPost('porciones');
        $tiempo    = $this->request->getPost('tiempopreparacion');
        $video     = trim($this->request->getPost('video'));

        $this->recetaModel->update($id, [
            'nombre'            => trim($this->request->getPost('nombre')),
            'instrucciones'     => trim($this->request->getPost('instrucciones')) ?: null,
            'porciones'         => (!empty($porciones) && is_numeric($porciones)) ? (int)$porciones : 1,
            'tiempopreparacion' => ($tiempo !== '' && $tiempo !== null && is_numeric($tiempo)) ? (int)$tiempo : null,
            'video'             => !empty($video) ? $video : null,
        ]);

        return redirect()->to(base_url('receta/actual/' . $id))->with('success', 'Receta actualizada exitosamente.');
    }

    public function delete($id)
    {
        $receta = $this->recetaModel->find($id);
        if (!$receta) {
            return redirect()->to(base_url('receta'))->with('error', 'Receta no encontrada.');
        }

        try {
            $this->recetaModel->delete($id);
            $first = $this->recetaModel->elprimero();
            $targetUrl = $first ? 'receta/actual/' . $first['idreceta'] : 'receta';
            return redirect()->to(base_url($targetUrl))->with('success', 'Receta eliminada exitosamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('receta/actual/' . $id))->with('error', 'No se puede eliminar la receta: ' . $e->getMessage());
        }
    }

    /**
     * Asignación rápida de una imagen a esta receta
     */
    public function asignarImagen($idreceta)
    {
        $idimagen = (int)$this->request->getPost('idimagen');
        if (empty($idimagen)) {
            return redirect()->to(base_url('receta/actual/' . $idreceta))
                             ->with('error', 'Debe seleccionar una imagen para asociar.');
        }

        $irModel = new \App\Models\ImagenRecetaModel();
        $exists = $irModel->where('idreceta', (int)$idreceta)
                          ->where('idimagen', $idimagen)
                          ->first();

        if ($exists) {
            return redirect()->to(base_url('receta/actual/' . $idreceta))
                             ->with('error', 'La imagen seleccionada ya se encuentra asociada a esta receta.');
        }

        $irModel->insert([
            'idreceta' => (int)$idreceta,
            'idimagen' => $idimagen,
        ]);

        return redirect()->to(base_url('receta/actual/' . $idreceta))
                         ->with('success', 'Imagen asociada a la receta correctamente.');
    }

    /**
     * Quitar una imagen de esta receta
     */
    public function quitarImagen($idreceta, $idimagen)
    {
        $irModel = new \App\Models\ImagenRecetaModel();
        $record = $irModel->where('idreceta', (int)$idreceta)
                          ->where('idimagen', (int)$idimagen)
                          ->first();

        if ($record) {
            $irModel->delete($record['idimagenreceta']);
            return redirect()->to(base_url('receta/actual/' . $idreceta))
                             ->with('success', 'Imagen desvinculada de la receta exitosamente.');
        }

        return redirect()->to(base_url('receta/actual/' . $idreceta))
                         ->with('error', 'No se encontró la relación a eliminar.');
    }
}
