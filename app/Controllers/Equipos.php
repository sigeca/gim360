<?php

namespace App\Controllers;

use App\Models\EquipoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Equipos extends BaseController
{
    protected EquipoModel $equipoModel;

    public function __construct()
    {
        $this->equipoModel = new EquipoModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $equipo = $this->equipoModel->find($id);
        } else {
            $last = $this->equipoModel->elultimo();
            $equipo = $last ? $this->equipoModel->find($last['id_equipo']) : null;
        }

        $data = [
            'title'       => 'Ficha Técnica de Equipo',
            'equipo'      => $equipo,
            'tipos'       => EquipoModel::getTipos(),
            'marcas'      => EquipoModel::getMarcas(),
            'ubicaciones' => EquipoModel::getUbicaciones(),
            'estados'     => EquipoModel::getEstados(),
            'module'      => 'equipos',
        ];

        return view('equipos/equipos_record', $data);
    }

    public function elprimero()
    {
        $first = $this->equipoModel->elprimero();
        return $this->actual($first ? $first['id_equipo'] : null);
    }

    public function elultimo()
    {
        $last = $this->equipoModel->elultimo();
        return $this->actual($last ? $last['id_equipo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->equipoModel->siguiente($id);
        return $this->actual($next ? $next['id_equipo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->equipoModel->anterior($id);
        return $this->actual($prev ? $prev['id_equipo'] : $id);
    }

    // Vista para listar todos los equipos
    public function listar()
    {
        $search  = $this->request->getGet('q');
        $equipos = $this->equipoModel->getEquiposWithDetails($search);

        $data = [
            'title'       => 'Inventario de Equipos y Máquinas',
            'equipos'     => $equipos,
            'tipos'       => EquipoModel::getTipos(),
            'marcas'      => EquipoModel::getMarcas(),
            'ubicaciones' => EquipoModel::getUbicaciones(),
            'estados'     => EquipoModel::getEstados(),
            'search'      => $search,
            'module'      => 'equipos',
        ];

        return view('equipos/equipos_list', $data);
    }

    // Vista de formulario para registrar nuevo equipo
    public function add()
    {
        $data = [
            'title'           => 'Registrar Nuevo Equipo',
            'tipos'           => EquipoModel::getTipos(),
            'marcas'          => EquipoModel::getMarcas(),
            'ubicaciones'     => EquipoModel::getUbicaciones(),
            'estados'         => EquipoModel::getEstados(),
            'availableImages' => $this->equipoModel->getAvailableImages(),
            'module'          => 'equipos',
        ];

        return view('equipos/equipos_form', $data);
    }

    public function save()
    {
        $rules = [
            'codigo'            => 'required|min_length[2]|max_length[30]|is_unique[equipos.codigo]',
            'nombre'            => 'required|min_length[2]|max_length[100]',
            'imagen'            => 'permit_empty|max_length[255]',
            'id_tipo'           => 'permit_empty',
            'id_marca'          => 'permit_empty',
            'modelo'            => 'permit_empty|max_length[80]',
            'numero_serie'      => 'permit_empty|max_length[100]',
            'descripcion'       => 'permit_empty',
            'id_ubicacion'      => 'permit_empty',
            'fecha_adquisicion' => 'permit_empty|valid_date[Y-m-d]',
            'valor_adquisicion' => 'permit_empty|numeric',
            'id_estado'         => 'permit_empty',
            'activo'            => 'permit_empty|in_list[0,1]',
            'observaciones'     => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->equipoModel->insert([
            'codigo'            => strtoupper(trim($this->request->getPost('codigo'))),
            'nombre'            => trim($this->request->getPost('nombre')),
            'imagen'            => trim($this->request->getPost('imagen')) ?: null,
            'id_tipo'           => $this->request->getPost('id_tipo') ?: null,
            'id_marca'          => $this->request->getPost('id_marca') ?: null,
            'modelo'            => trim($this->request->getPost('modelo')) ?: null,
            'numero_serie'      => trim($this->request->getPost('numero_serie')) ?: null,
            'descripcion'       => trim($this->request->getPost('descripcion')) ?: null,
            'id_ubicacion'      => $this->request->getPost('id_ubicacion') ?: null,
            'fecha_adquisicion' => $this->request->getPost('fecha_adquisicion') ?: null,
            'valor_adquisicion' => $this->request->getPost('valor_adquisicion') ?: null,
            'id_estado'         => $this->request->getPost('id_estado') ?: 1,
            'activo'            => $this->request->getPost('activo') !== null ? (int)$this->request->getPost('activo') : 1,
            'observaciones'     => trim($this->request->getPost('observaciones')) ?: null,
        ]);

        return redirect()->to(base_url('equipos/actual/' . $id))->with('success', 'Equipo registrado exitosamente.');
    }

    // Vista de formulario para editar equipo existente
    public function edit($id)
    {
        $equipo = $this->equipoModel->find($id);
        if (!$equipo) {
            throw PageNotFoundException::forPageNotFound("Equipo no encontrado.");
        }

        $data = [
            'title'           => 'Editar Equipo: ' . $equipo['nombre'],
            'equipo'          => $equipo,
            'tipos'           => EquipoModel::getTipos(),
            'marcas'          => EquipoModel::getMarcas(),
            'ubicaciones'     => EquipoModel::getUbicaciones(),
            'estados'         => EquipoModel::getEstados(),
            'availableImages' => $this->equipoModel->getAvailableImages(),
            'module'          => 'equipos',
        ];

        return view('equipos/equipos_edit', $data);
    }

    public function update($id)
    {
        $equipo = $this->equipoModel->find($id);
        if (!$equipo) {
            return redirect()->to(base_url('equipos'))->with('error', 'Equipo no encontrado.');
        }

        $rules = [
            'codigo'            => "required|min_length[2]|max_length[30]|is_unique[equipos.codigo,id_equipo,{$id}]",
            'nombre'            => 'required|min_length[2]|max_length[100]',
            'imagen'            => 'permit_empty|max_length[255]',
            'id_tipo'           => 'permit_empty',
            'id_marca'          => 'permit_empty',
            'modelo'            => 'permit_empty|max_length[80]',
            'numero_serie'      => 'permit_empty|max_length[100]',
            'descripcion'       => 'permit_empty',
            'id_ubicacion'      => 'permit_empty',
            'fecha_adquisicion' => 'permit_empty|valid_date[Y-m-d]',
            'valor_adquisicion' => 'permit_empty|numeric',
            'id_estado'         => 'permit_empty',
            'activo'            => 'permit_empty|in_list[0,1]',
            'observaciones'     => 'permit_empty',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->equipoModel->update($id, [
            'codigo'            => strtoupper(trim($this->request->getPost('codigo'))),
            'nombre'            => trim($this->request->getPost('nombre')),
            'imagen'            => trim($this->request->getPost('imagen')) ?: null,
            'id_tipo'           => $this->request->getPost('id_tipo') ?: null,
            'id_marca'          => $this->request->getPost('id_marca') ?: null,
            'modelo'            => trim($this->request->getPost('modelo')) ?: null,
            'numero_serie'      => trim($this->request->getPost('numero_serie')) ?: null,
            'descripcion'       => trim($this->request->getPost('descripcion')) ?: null,
            'id_ubicacion'      => $this->request->getPost('id_ubicacion') ?: null,
            'fecha_adquisicion' => $this->request->getPost('fecha_adquisicion') ?: null,
            'valor_adquisicion' => $this->request->getPost('valor_adquisicion') ?: null,
            'id_estado'         => $this->request->getPost('id_estado') ?: 1,
            'activo'            => $this->request->getPost('activo') !== null ? (int)$this->request->getPost('activo') : 1,
            'observaciones'     => trim($this->request->getPost('observaciones')) ?: null,
        ]);

        return redirect()->to(base_url('equipos/actual/' . $id))->with('success', 'Equipo actualizado exitosamente.');
    }

    public function delete($id)
    {
        $equipo = $this->equipoModel->find($id);
        if (!$equipo) {
            return redirect()->to(base_url('equipos'))->with('error', 'Equipo no encontrado.');
        }

        $this->equipoModel->delete($id);

        $last = $this->equipoModel->elultimo();
        $targetUrl = $last ? 'equipos/actual/' . $last['id_equipo'] : 'equipos';

        return redirect()->to(base_url($targetUrl))->with('success', 'Equipo eliminado exitosamente.');
    }

    public function imagen($filename = null)
    {
        if (empty($filename)) {
            throw PageNotFoundException::forPageNotFound("Nombre de archivo no especificado.");
        }

        $cleanFilename = basename($filename);
        $baseDir = defined('ROOTPATH') ? rtrim(ROOTPATH, '/\\') : dirname(__DIR__, 2);

        $paths = [
            $baseDir . '/repositorio/images/equipment/' . $cleanFilename,
            $baseDir . '/repositorio/image/equipment/' . $cleanFilename,
            $baseDir . '/uploads/equipment/' . $cleanFilename,
        ];

        $targetPath = null;
        foreach ($paths as $p) {
            if (file_exists($p)) {
                $targetPath = $p;
                break;
            }
        }

        if (!$targetPath) {
            throw PageNotFoundException::forPageNotFound("Imagen de equipo no encontrada: " . $cleanFilename);
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
}
