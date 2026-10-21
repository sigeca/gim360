<?php

namespace App\Controllers;

use App\Models\DisponibilidadEquipoModel;
use App\Models\EquipoModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class DisponibilidadEquipo extends BaseController
{
    protected DisponibilidadEquipoModel $dispModel;
    protected EquipoModel $equipoModel;

    public function __construct()
    {
        $this->dispModel = new DisponibilidadEquipoModel();
        $this->equipoModel = new EquipoModel();
    }

    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $disponibilidad = $this->dispModel->find($id);
        } else {
            $last = $this->dispModel->elultimo();
            $disponibilidad = $last ? $this->dispModel->find($last['iddisponibilidadequipo']) : null;
        }

        $equiposAsociados = [];
        if (!empty($disponibilidad['iddisponibilidadequipo'])) {
            $equiposAsociados = $this->equipoModel
                ->where('iddisponibilidadequipo', $disponibilidad['iddisponibilidadequipo'])
                ->orderBy('nombre', 'ASC')
                ->findAll();
        }

        $data = [
            'title'            => 'Estado de Disponibilidad de Equipos',
            'disponibilidad'   => $disponibilidad,
            'equiposAsociados' => $equiposAsociados,
            'module'           => 'disponibilidadequipo',
        ];

        return view('disponibilidadequipo/disponibilidadequipo_record', $data);
    }

    public function elprimero()
    {
        $first = $this->dispModel->elprimero();
        return $this->actual($first ? $first['iddisponibilidadequipo'] : null);
    }

    public function elultimo()
    {
        $last = $this->dispModel->elultimo();
        return $this->actual($last ? $last['iddisponibilidadequipo'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->dispModel->siguiente($id);
        return $this->actual($next ? $next['iddisponibilidadequipo'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->dispModel->anterior($id);
        return $this->actual($prev ? $prev['iddisponibilidadequipo'] : $id);
    }

    public function listar()
    {
        $search = $this->request->getGet('q');
        $builder = $this->dispModel->orderBy('iddisponibilidadequipo', 'ASC');

        if (!empty($search)) {
            $builder->like('nombre', $search);
        }

        $disponibilidades = $builder->findAll();

        // Contar equipos en cada estado
        $db = \Config\Database::connect();
        $countsRaw = $db->table('equipo')
            ->select('iddisponibilidadequipo, COUNT(*) as total')
            ->groupBy('iddisponibilidadequipo')
            ->get()->getResultArray();

        $equipmentCounts = [];
        foreach ($countsRaw as $r) {
            $equipmentCounts[$r['iddisponibilidadequipo']] = (int)$r['total'];
        }

        $data = [
            'title'            => 'Catálogo de Disponibilidad de Equipos',
            'disponibilidades' => $disponibilidades,
            'equipmentCounts'  => $equipmentCounts,
            'search'           => $search,
            'module'           => 'disponibilidadequipo',
        ];

        return view('disponibilidadequipo/disponibilidadequipo_list', $data);
    }

    public function add()
    {
        $data = [
            'title'  => 'Registrar Estado de Disponibilidad',
            'module' => 'disponibilidadequipo',
        ];

        return view('disponibilidadequipo/disponibilidadequipo_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre' => 'required|min_length[2]|max_length[50]|is_unique[disponibilidadequipo.nombre]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $id = $this->dispModel->insert([
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('disponibilidadequipo/actual/' . $id))
                         ->with('success', 'Estado de disponibilidad registrado con éxito.');
    }

    public function edit($id)
    {
        $disponibilidad = $this->dispModel->find($id);
        if (!$disponibilidad) {
            throw PageNotFoundException::forPageNotFound("Estado de disponibilidad no encontrado.");
        }

        $data = [
            'title'          => 'Editar Estado de Disponibilidad: ' . $disponibilidad['nombre'],
            'disponibilidad' => $disponibilidad,
            'module'         => 'disponibilidadequipo',
        ];

        return view('disponibilidadequipo/disponibilidadequipo_edit', $data);
    }

    public function update($id)
    {
        $disponibilidad = $this->dispModel->find($id);
        if (!$disponibilidad) {
            return redirect()->to(base_url('disponibilidadequipo'))->with('error', 'Registro no encontrado.');
        }

        $rules = [
            'nombre' => "required|min_length[2]|max_length[50]|is_unique[disponibilidadequipo.nombre,iddisponibilidadequipo,{$id}]",
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->dispModel->update($id, [
            'nombre' => trim($this->request->getPost('nombre')),
        ]);

        return redirect()->to(base_url('disponibilidadequipo/actual/' . $id))
                         ->with('success', 'Estado de disponibilidad actualizado correctamente.');
    }

    public function delete($id)
    {
        $disponibilidad = $this->dispModel->find($id);
        if (!$disponibilidad) {
            return redirect()->to(base_url('disponibilidadequipo'))->with('error', 'Registro no encontrado.');
        }

        // Verificar si tiene equipos asignados
        $count = $this->equipoModel->where('iddisponibilidadequipo', $id)->countAllResults();
        if ($count > 0) {
            return redirect()->to(base_url('disponibilidadequipo/actual/' . $id))
                             ->with('error', "No se puede eliminar: tiene {$count} equipo(s) asociado(s).");
        }

        $this->dispModel->delete($id);

        $last = $this->dispModel->elultimo();
        $targetUrl = $last ? 'disponibilidadequipo/actual/' . $last['iddisponibilidadequipo'] : 'disponibilidadequipo';

        return redirect()->to(base_url($targetUrl))
                         ->with('success', 'Estado de disponibilidad eliminado con éxito.');
    }
}
