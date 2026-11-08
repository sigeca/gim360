<?php

namespace App\Controllers;

use App\Models\MiEntretenimientoModel;
use App\Models\EntretenimientoModel;
use App\Models\PersonaModel;
use App\Models\MusicaModel;
use App\Models\VideoModel;
use App\Models\JuegoModel;
use App\Models\PodcastModel;
use App\Models\MiEntretenimientoMusicaModel;
use App\Models\MiEntretenimientoVideoModel;
use App\Models\MiEntretenimientoJuegoModel;
use App\Models\MiEntretenimientoPodcastModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class MiEntretenimiento extends BaseController
{
    protected MiEntretenimientoModel $miEntretenimientoModel;

    public function __construct()
    {
        EntretenimientoModel::ensureEntertainmentTables();
        $this->miEntretenimientoModel = new MiEntretenimientoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $mientretenimiento = $this->miEntretenimientoModel->getMiEntretenimientoWithDetails((int)$id);
        } else {
            $first = $this->miEntretenimientoModel->elprimero();
            $mientretenimiento = $first ? $this->miEntretenimientoModel->getMiEntretenimientoWithDetails((int)$first['idmientretenimiento']) : null;
        }

        $data = [
            'title'             => 'Mi Entretenimiento' . ($mientretenimiento ? ': ' . $mientretenimiento['nombre'] : ''),
            'mientretenimiento' => $mientretenimiento,
            'catalogoMusicas'   => (new MusicaModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoVideos'    => (new VideoModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoJuegos'    => (new JuegoModel())->orderBy('nombre', 'ASC')->findAll(),
            'catalogoPodcasts'  => (new PodcastModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'            => 'mientretenimiento',
        ];

        return view('mientretenimiento/mientretenimiento_record', $data);
    }

    public function elprimero()
    {
        $first = $this->miEntretenimientoModel->elprimero();
        return $this->actual($first ? $first['idmientretenimiento'] : null);
    }

    public function elultimo()
    {
        $last = $this->miEntretenimientoModel->elultimo();
        return $this->actual($last ? $last['idmientretenimiento'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->miEntretenimientoModel->siguiente((int)$id);
        return $this->actual($next ? $next['idmientretenimiento'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->miEntretenimientoModel->anterior((int)$id);
        return $this->actual($prev ? $prev['idmientretenimiento'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $idpersona = $this->request->getGet('idpersona');
        $items = $this->miEntretenimientoModel->getMisEntretenimientosWithCounts($search, $idpersona ? (int)$idpersona : null);

        $data = [
            'title'               => 'Catálogo de Mi Entretenimiento',
            'misEntretenimientos' => $items,
            'search'              => $search,
            'idpersona'           => $idpersona,
            'personas'            => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'module'              => 'mientretenimiento',
        ];

        return view('mientretenimiento/mientretenimiento_list', $data);
    }

    public function add()
    {
        $identretenimiento = $this->request->getGet('identretenimiento');
        $idpersona = $this->request->getGet('idpersona') ?: session()->get('idpersona');

        $baseEntretenimiento = null;
        if (!empty($identretenimiento)) {
            $baseEntretenimiento = (new EntretenimientoModel())->find((int)$identretenimiento);
        }

        $data = [
            'title'               => 'Personalizar / Nuevo Mi Entretenimiento',
            'personas'            => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'entretenimientos'    => (new EntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'selectedIdPersona'   => $idpersona,
            'selectedIdEntre'     => $identretenimiento,
            'baseEntretenimiento' => $baseEntretenimiento,
            'module'              => 'mientretenimiento',
        ];

        return view('mientretenimiento/mientretenimiento_form', $data);
    }

    public function save()
    {
        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'nombre'    => 'required|min_length[2]|max_length[150]',
        ];

        $messages = [
            'idpersona' => [
                'required' => 'Debe seleccionar la persona propietaria.',
            ],
            'nombre' => [
                'required'   => 'El nombre de mi entretenimiento es obligatorio.',
                'min_length' => 'Debe tener al menos 2 caracteres.',
                'max_length' => 'No puede exceder los 150 caracteres.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $idpersona = (int)$this->request->getPost('idpersona');
        $identretenimiento = $this->request->getPost('identretenimiento') ? (int)$this->request->getPost('identretenimiento') : null;
        $nombre = trim((string)$this->request->getPost('nombre'));
        $descripcion = trim((string)$this->request->getPost('descripcion')) ?: null;
        $clonarContenido = (bool)$this->request->getPost('clonar_contenido');

        if (!empty($identretenimiento) && $clonarContenido) {
            try {
                $id = $this->miEntretenimientoModel->clonarDesdeEntretenimiento(
                    $identretenimiento,
                    $idpersona,
                    $nombre,
                    $descripcion
                );
                return redirect()->to(base_url('mientretenimiento/actual/' . $id))
                                 ->with('success', '¡Entretenimiento personalizado exitosamente! Se copiaron automáticamente las músicas, videos, juegos y podcasts base.');
            } catch (\Throwable $e) {
                return redirect()->back()->withInput()->with('error', 'Error al personalizar: ' . $e->getMessage());
            }
        }

        $id = $this->miEntretenimientoModel->insert([
            'idpersona'         => $idpersona,
            'identretenimiento' => $identretenimiento,
            'nombre'            => $nombre,
            'descripcion'       => $descripcion,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $id))
                         ->with('success', 'Registro de Mi Entretenimiento creado exitosamente.');
    }

    /**
     * Acción directa de 1 clic para clonar/personalizar un entretenimiento para una persona
     */
    public function personalizar($identretenimiento = null)
    {
        $identretenimiento = $identretenimiento ?: $this->request->getPost('identretenimiento');
        $idpersona = $this->request->getPost('idpersona') ?: session()->get('idpersona');

        if (empty($idpersona)) {
            // Si no hay idpersona en sesión ni por POST, redirigir al formulario para que elija la persona
            return redirect()->to(base_url('mientretenimiento/add?identretenimiento=' . $identretenimiento));
        }

        try {
            $id = $this->miEntretenimientoModel->clonarDesdeEntretenimiento(
                (int)$identretenimiento,
                (int)$idpersona
            );
            return redirect()->to(base_url('mientretenimiento/actual/' . $id))
                             ->with('success', '¡Entretenimiento personalizado guardado en Mi Entretenimiento con éxito!');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('entretenimiento/actual/' . $identretenimiento))
                             ->with('error', 'Error al personalizar: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $mientretenimiento = $this->miEntretenimientoModel->find($id);
        if (!$mientretenimiento) {
            throw PageNotFoundException::forPageNotFound("Mi Entretenimiento no encontrado.");
        }

        $data = [
            'title'             => 'Editar Mi Entretenimiento #' . $id,
            'mientretenimiento' => $mientretenimiento,
            'personas'          => (new PersonaModel())->orderBy('apellidos', 'ASC')->orderBy('nombres', 'ASC')->findAll(),
            'entretenimientos'  => (new EntretenimientoModel())->orderBy('nombre', 'ASC')->findAll(),
            'module'            => 'mientretenimiento',
        ];

        return view('mientretenimiento/mientretenimiento_edit', $data);
    }

    public function update($id)
    {
        $mientretenimiento = $this->miEntretenimientoModel->find($id);
        if (!$mientretenimiento) {
            return redirect()->to(base_url('mientretenimiento'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'idpersona' => 'required|is_natural_no_zero',
            'nombre'    => 'required|min_length[2]|max_length[150]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->miEntretenimientoModel->update($id, [
            'idpersona'         => (int)$this->request->getPost('idpersona'),
            'identretenimiento' => $this->request->getPost('identretenimiento') ? (int)$this->request->getPost('identretenimiento') : null,
            'nombre'            => trim((string)$this->request->getPost('nombre')),
            'descripcion'       => trim((string)$this->request->getPost('descripcion')) ?: null,
        ]);

        return redirect()->to(base_url('mientretenimiento/actual/' . $id))
                         ->with('success', 'Mi Entretenimiento actualizado correctamente.');
    }

    public function delete($id)
    {
        $mientretenimiento = $this->miEntretenimientoModel->find($id);
        if (!$mientretenimiento) {
            return redirect()->to(base_url('mientretenimiento'))->with('error', 'Registro no encontrado.');
        }

        try {
            $this->miEntretenimientoModel->delete($id);
            $first = $this->miEntretenimientoModel->elprimero();
            $targetUrl = $first ? 'mientretenimiento/actual/' . $first['idmientretenimiento'] : 'mientretenimiento';
            return redirect()->to(base_url($targetUrl))->with('success', 'Registro de Mi Entretenimiento eliminado exitosamente.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $id))
                             ->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }

    /**
     * Acciones rápidas para sumar más música, video, juego o podcast a Mi Entretenimiento
     */
    public function agregarMusica($idmientretenimiento)
    {
        $idmusica = $this->request->getPost('idmusica');
        if (empty($idmusica)) {
            // Si envió datos para crear una nueva música al vuelo
            $nombre = trim((string)$this->request->getPost('nuevo_nombre'));
            $enlace = trim((string)$this->request->getPost('nuevo_enlace'));
            if (!empty($nombre) && !empty($enlace)) {
                $musicaModel = new MusicaModel();
                $idmusica = $musicaModel->insert([
                    'nombre'      => $nombre,
                    'artista'     => trim((string)$this->request->getPost('nuevo_artista')) ?: null,
                    'genero'      => trim((string)$this->request->getPost('nuevo_genero')) ?: null,
                    'enlace'      => $enlace,
                    'descripcion' => trim((string)$this->request->getPost('nuevo_descripcion')) ?: null,
                ]);
            }
        }

        if (empty($idmusica)) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'Debe seleccionar una música existente o ingresar nombre y enlace.');
        }

        $model = new MiEntretenimientoMusicaModel();
        try {
            $model->ignore(true)->insert([
                'idmientretenimiento' => (int)$idmientretenimiento,
                'idmusica'            => (int)$idmusica,
            ]);
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('success', 'Música agregada exitosamente a Mi Entretenimiento.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'No se pudo agregar la música: ' . $e->getMessage());
        }
    }

    public function agregarVideo($idmientretenimiento)
    {
        $idvideo = $this->request->getPost('idvideo');
        if (empty($idvideo)) {
            $nombre = trim((string)$this->request->getPost('nuevo_nombre'));
            $enlace = trim((string)$this->request->getPost('nuevo_enlace'));
            if (!empty($nombre) && !empty($enlace)) {
                $videoModel = new VideoModel();
                $idvideo = $videoModel->insert([
                    'nombre'      => $nombre,
                    'autor'       => trim((string)$this->request->getPost('nuevo_autor')) ?: null,
                    'categoria'   => trim((string)$this->request->getPost('nuevo_categoria')) ?: null,
                    'enlace'      => $enlace,
                    'descripcion' => trim((string)$this->request->getPost('nuevo_descripcion')) ?: null,
                ]);
            }
        }

        if (empty($idvideo)) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'Debe seleccionar un video existente o ingresar nombre y enlace.');
        }

        $model = new MiEntretenimientoVideoModel();
        try {
            $model->ignore(true)->insert([
                'idmientretenimiento' => (int)$idmientretenimiento,
                'idvideo'             => (int)$idvideo,
            ]);
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('success', 'Video agregado exitosamente a Mi Entretenimiento.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'No se pudo agregar el video: ' . $e->getMessage());
        }
    }

    public function agregarJuego($idmientretenimiento)
    {
        $idjuego = $this->request->getPost('idjuego');
        if (empty($idjuego)) {
            $nombre = trim((string)$this->request->getPost('nuevo_nombre'));
            $enlace = trim((string)$this->request->getPost('nuevo_enlace'));
            if (!empty($nombre) && !empty($enlace)) {
                $juegoModel = new JuegoModel();
                $idjuego = $juegoModel->insert([
                    'nombre'      => $nombre,
                    'categoria'   => trim((string)$this->request->getPost('nuevo_categoria')) ?: null,
                    'enlace'      => $enlace,
                    'descripcion' => trim((string)$this->request->getPost('nuevo_descripcion')) ?: null,
                ]);
            }
        }

        if (empty($idjuego)) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'Debe seleccionar un juego existente o ingresar nombre y enlace.');
        }

        $model = new MiEntretenimientoJuegoModel();
        try {
            $model->ignore(true)->insert([
                'idmientretenimiento' => (int)$idmientretenimiento,
                'idjuego'             => (int)$idjuego,
            ]);
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('success', 'Juego agregado exitosamente a Mi Entretenimiento.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'No se pudo agregar el juego: ' . $e->getMessage());
        }
    }

    public function agregarPodcast($idmientretenimiento)
    {
        $idpodcast = $this->request->getPost('idpodcast');
        if (empty($idpodcast)) {
            $nombre = trim((string)$this->request->getPost('nuevo_nombre'));
            $enlace = trim((string)$this->request->getPost('nuevo_enlace'));
            if (!empty($nombre) && !empty($enlace)) {
                $podcastModel = new PodcastModel();
                $idpodcast = $podcastModel->insert([
                    'nombre'      => $nombre,
                    'presentador' => trim((string)$this->request->getPost('nuevo_presentador')) ?: null,
                    'tema'        => trim((string)$this->request->getPost('nuevo_tema')) ?: null,
                    'enlace'      => $enlace,
                    'descripcion' => trim((string)$this->request->getPost('nuevo_descripcion')) ?: null,
                ]);
            }
        }

        if (empty($idpodcast)) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'Debe seleccionar un podcast existente o ingresar nombre y enlace.');
        }

        $model = new MiEntretenimientoPodcastModel();
        try {
            $model->ignore(true)->insert([
                'idmientretenimiento' => (int)$idmientretenimiento,
                'idpodcast'           => (int)$idpodcast,
            ]);
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('success', 'Podcast agregado exitosamente a Mi Entretenimiento.');
        } catch (\Throwable $e) {
            return redirect()->to(base_url('mientretenimiento/actual/' . $idmientretenimiento))
                             ->with('error', 'No se pudo agregar el podcast: ' . $e->getMessage());
        }
    }
}
