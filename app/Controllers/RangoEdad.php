<?php

namespace App\Controllers;

use App\Models\RangoEdadModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class RangoEdad extends BaseController
{
    protected RangoEdadModel $rangoEdadModel;

    public function __construct()
    {
        $this->rangoEdadModel = new RangoEdadModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        $rango = $id ? $this->rangoEdadModel->find($id) : $this->rangoEdadModel->elultimo();
        $programas = [];

        if ($rango) {
            $programas = $this->rangoEdadModel->getProgramasByRango((int)$rango['idrangoedad']);
        }

        $data = [
            'title'     => 'Ficha de Rango de Edad',
            'rango'     => $rango,
            'programas' => $programas,
            'module'    => 'rangoedad',
        ];

        return view('rangoedad/rangoedad_record', $data);
    }

    public function elprimero()
    {
        $rango = $this->rangoEdadModel->elprimero();
        $programas = $rango ? $this->rangoEdadModel->getProgramasByRango((int)$rango['idrangoedad']) : [];

        $data = [
            'title'     => 'Ficha de Rango de Edad - Primer Registro',
            'rango'     => $rango,
            'programas' => $programas,
            'module'    => 'rangoedad',
        ];
        return view('rangoedad/rangoedad_record', $data);
    }

    public function elultimo()
    {
        $rango = $this->rangoEdadModel->elultimo();
        $programas = $rango ? $this->rangoEdadModel->getProgramasByRango((int)$rango['idrangoedad']) : [];

        $data = [
            'title'     => 'Ficha de Rango de Edad - Último Registro',
            'rango'     => $rango,
            'programas' => $programas,
            'module'    => 'rangoedad',
        ];
        return view('rangoedad/rangoedad_record', $data);
    }

    public function siguiente($id)
    {
        $rango = $this->rangoEdadModel->siguiente($id);
        $programas = $rango ? $this->rangoEdadModel->getProgramasByRango((int)$rango['idrangoedad']) : [];

        $data = [
            'title'     => 'Ficha de Rango de Edad',
            'rango'     => $rango,
            'programas' => $programas,
            'module'    => 'rangoedad',
        ];
        return view('rangoedad/rangoedad_record', $data);
    }

    public function anterior($id)
    {
        $rango = $this->rangoEdadModel->anterior($id);
        $programas = $rango ? $this->rangoEdadModel->getProgramasByRango((int)$rango['idrangoedad']) : [];

        $data = [
            'title'     => 'Ficha de Rango de Edad',
            'rango'     => $rango,
            'programas' => $programas,
            'module'    => 'rangoedad',
        ];
        return view('rangoedad/rangoedad_record', $data);
    }

    // Vista para listar todos los registros
    public function listar()
    {
        $search = $this->request->getGet('q');
        $rangos = $this->rangoEdadModel->getRangos($search);

        $data = [
            'title'  => 'Catálogo de Rangos de Edad',
            'rangos' => $rangos,
            'search' => $search,
            'module' => 'rangoedad',
        ];

        return view('rangoedad/rangoedad_list', $data);
    }

    // Vista de formulario para nuevo registro
    public function add()
    {
        $data = [
            'title'  => 'Nuevo Rango de Edad',
            'module' => 'rangoedad',
        ];

        return view('rangoedad/rangoedad_form', $data);
    }

    public function save()
    {
        $rules = [
            'nombre'     => 'required|min_length[2]|max_length[100]|is_unique[rangoedad.nombre]',
            'edadminima' => 'required|is_natural',
            'edadmaxima' => 'required|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $min = (int)$this->request->getPost('edadminima');
        $max = (int)$this->request->getPost('edadmaxima');

        if ($max < $min) {
            return redirect()->back()->withInput()->with('error', 'La edad máxima (' . $max . ') debe ser mayor o igual a la edad mínima (' . $min . ').');
        }

        $id = $this->rangoEdadModel->insert([
            'nombre'     => trim($this->request->getPost('nombre')),
            'edadminima' => $min,
            'edadmaxima' => $max,
        ]);

        return redirect()->to(base_url('rangoedad/actual/' . $id))->with('success', 'Rango de edad registrado exitosamente.');
    }

    // Vista de formulario para editar
    public function edit($id)
    {
        $rango = $this->rangoEdadModel->find($id);
        if (!$rango) {
            throw PageNotFoundException::forPageNotFound("Rango de edad no encontrado.");
        }

        $data = [
            'title'  => 'Editar Rango de Edad #' . $id,
            'rango'  => $rango,
            'module' => 'rangoedad',
        ];

        return view('rangoedad/rangoedad_edit', $data);
    }

    public function update($id)
    {
        $rango = $this->rangoEdadModel->find($id);
        if (!$rango) {
            return redirect()->to(base_url('rangoedad'))->with('error', 'Rango de edad no encontrado.');
        }

        $rules = [
            'nombre'     => "required|min_length[2]|max_length[100]|is_unique[rangoedad.nombre,idrangoedad,{$id}]",
            'edadminima' => 'required|is_natural',
            'edadmaxima' => 'required|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $min = (int)$this->request->getPost('edadminima');
        $max = (int)$this->request->getPost('edadmaxima');

        if ($max < $min) {
            return redirect()->back()->withInput()->with('error', 'La edad máxima (' . $max . ') debe ser mayor o igual a la edad mínima (' . $min . ').');
        }

        $this->rangoEdadModel->update($id, [
            'nombre'     => trim($this->request->getPost('nombre')),
            'edadminima' => $min,
            'edadmaxima' => $max,
        ]);

        return redirect()->to(base_url('rangoedad/actual/' . $id))->with('success', 'Rango de edad actualizado exitosamente.');
    }

    public function delete($id)
    {
        $rango = $this->rangoEdadModel->find($id);
        if (!$rango) {
            return redirect()->to(base_url('rangoedad'))->with('error', 'Rango de edad no encontrado.');
        }

        try {
            $this->rangoEdadModel->delete($id);
            return redirect()->to(base_url('rangoedad/elprimero'))->with('success', 'Rango de edad eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->to(base_url('rangoedad/actual/' . $id))->with('error', 'No se puede eliminar el registro: ' . $e->getMessage());
        }
    }
}
