<?php

namespace App\Controllers;

use App\Models\EjecucionProgramaModel;
use App\Models\ProgramaClienteModel;
use App\Models\EjercicioModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class EjecucionPrograma extends BaseController
{
    protected EjecucionProgramaModel $ejecucionModel;
    protected ProgramaClienteModel $programaClienteModel;
    protected EjercicioModel $ejercicioModel;

    public function __construct()
    {
        $this->ejecucionModel       = new EjecucionProgramaModel();
        $this->programaClienteModel = new ProgramaClienteModel();
        $this->ejercicioModel       = new EjercicioModel();
    }

    // Vista Principal: Presenta un registro actual con toolbar de navegación
    public function index($id = null)
    {
        return $this->actual($id);
    }

    public function actual($id = null)
    {
        if ($id) {
            $ejecucion = $this->ejecucionModel->getEjecucionWithDetails($id);
        } else {
            $last = $this->ejecucionModel->elultimo();
            $ejecucion = $last ? $this->ejecucionModel->getEjecucionWithDetails($last['idejecucionprograma']) : null;
        }

        $data = [
            'title'     => 'Ficha de Ejecución de Programa',
            'ejecucion' => $ejecucion,
            'module'    => 'ejecucionprograma',
        ];

        return view('ejecucionprograma/ejecucionprograma_record', $data);
    }

    public function elprimero()
    {
        $first = $this->ejecucionModel->elprimero();
        return $this->actual($first ? $first['idejecucionprograma'] : null);
    }

    public function elultimo()
    {
        $last = $this->ejecucionModel->elultimo();
        return $this->actual($last ? $last['idejecucionprograma'] : null);
    }

    public function siguiente($id)
    {
        $next = $this->ejecucionModel->siguiente($id);
        return $this->actual($next ? $next['idejecucionprograma'] : $id);
    }

    public function anterior($id)
    {
        $prev = $this->ejecucionModel->anterior($id);
        return $this->actual($prev ? $prev['idejecucionprograma'] : $id);
    }

    // Vista para listar todas las ejecuciones de programas
    public function listar()
    {
        $search      = $this->request->getGet('q');
        $ejecuciones = $this->ejecucionModel->getEjecucionesWithDetails($search);

        $data = [
            'title'       => 'Listado de Ejecución de Programas',
            'ejecuciones' => $ejecuciones,
            'search'      => $search,
            'module'      => 'ejecucionprograma',
        ];

        return view('ejecucionprograma/ejecucionprograma_list', $data);
    }

    // Formulario para registrar nueva ejecución de programa
    public function add()
    {
        $idProgramaClientePreselected = $this->request->getGet('idprogramacliente');
        $idEjercicioPreselected       = $this->request->getGet('idejercicio');
        $seriesPreselected            = $this->request->getGet('series');
        $repeticionesPreselected      = $this->request->getGet('repeticiones');
        $tiempodescansoPreselected    = $this->request->getGet('tiempodescanso');
        $pesoPreselected              = $this->request->getGet('peso');

        // Si se reciben programa y ejercicio pero no se recibieron los parámetros de carga/volumen, buscarlos del plan
        if ($idProgramaClientePreselected && $idEjercicioPreselected && ($seriesPreselected === null || $repeticionesPreselected === null)) {
            $defaults = $this->ejecucionModel->getPlanDefaults((int)$idProgramaClientePreselected, (int)$idEjercicioPreselected);
            if ($defaults) {
                if ($seriesPreselected === null && isset($defaults['series'])) $seriesPreselected = $defaults['series'];
                if ($repeticionesPreselected === null && isset($defaults['repeticiones'])) $repeticionesPreselected = $defaults['repeticiones'];
                if ($tiempodescansoPreselected === null && isset($defaults['tiempodescanso'])) $tiempodescansoPreselected = $defaults['tiempodescanso'];
                if ($pesoPreselected === null && isset($defaults['peso'])) $pesoPreselected = $defaults['peso'];
            }
        }

        $programasClientes = $this->programaClienteModel->getProgramasClientesWithDetails();
        $ejercicios        = $this->ejercicioModel->getEjercicios(null, 0);

        $data = [
            'title'                        => 'Registrar Ejecución de Programa',
            'programasClientes'            => $programasClientes,
            'ejercicios'                   => $ejercicios,
            'idProgramaClientePreselected' => $idProgramaClientePreselected,
            'idEjercicioPreselected'       => $idEjercicioPreselected,
            'seriesPreselected'            => $seriesPreselected,
            'repeticionesPreselected'      => $repeticionesPreselected,
            'tiempodescansoPreselected'    => $tiempodescansoPreselected,
            'pesoPreselected'              => $pesoPreselected,
            'module'                       => 'ejecucionprograma',
        ];

        return view('ejecucionprograma/ejecucionprograma_form', $data);
    }

    /**
     * Endpoint auxiliar AJAX para obtener los valores predeterminados de un plan de ejercicio
     */
    public function planDefaults()
    {
        $idProgCliente = (int)$this->request->getGet('idprogramacliente');
        $idEjercicio   = (int)$this->request->getGet('idejercicio');
        $defaults = $this->ejecucionModel->getPlanDefaults($idProgCliente, $idEjercicio);
        return $this->response->setJSON($defaults ?: []);
    }

    public function save()
    {
        $rules = [
            'idprogramacliente' => 'required|is_natural_no_zero',
            'idejercicio'       => 'required|is_natural_no_zero',
            'fecha'             => 'required|valid_date[Y-m-d]',
            'horainicio'        => 'required',
            'horafin'           => 'permit_empty',
            'series'            => 'permit_empty|is_natural',
            'repeticiones'      => 'permit_empty|is_natural',
            'tiempodescanso'    => 'permit_empty|is_natural',
            'peso'              => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $horafin        = $this->request->getPost('horafin');
        $series         = $this->request->getPost('series');
        $repeticiones   = $this->request->getPost('repeticiones');
        $tiempodescanso = $this->request->getPost('tiempodescanso');
        $peso           = $this->request->getPost('peso');

        $idProgCliente = (int)$this->request->getPost('idprogramacliente');
        $idEjercicio   = (int)$this->request->getPost('idejercicio');

        // Si los campos de volumen/carga vienen vacíos, auto-completar desde el plan de entrenamiento
        if ($series === '' || $series === null || $repeticiones === '' || $repeticiones === null || $tiempodescanso === '' || $tiempodescanso === null || $peso === '' || $peso === null) {
            $defaults = $this->ejecucionModel->getPlanDefaults($idProgCliente, $idEjercicio);
            if ($defaults) {
                if (($series === '' || $series === null) && isset($defaults['series'])) $series = $defaults['series'];
                if (($repeticiones === '' || $repeticiones === null) && isset($defaults['repeticiones'])) $repeticiones = $defaults['repeticiones'];
                if (($tiempodescanso === '' || $tiempodescanso === null) && isset($defaults['tiempodescanso'])) $tiempodescanso = $defaults['tiempodescanso'];
                if (($peso === '' || $peso === null) && isset($defaults['peso'])) $peso = $defaults['peso'];
            }
        }

        $id = $this->ejecucionModel->insert([
            'idprogramacliente' => $idProgCliente,
            'idejercicio'       => $idEjercicio,
            'fecha'             => $this->request->getPost('fecha'),
            'horainicio'        => $this->request->getPost('horainicio'),
            'horafin'           => !empty($horafin) ? $horafin : null,
            'series'            => ($series !== '' && $series !== null) ? (int)$series : null,
            'repeticiones'      => ($repeticiones !== '' && $repeticiones !== null) ? (int)$repeticiones : null,
            'tiempodescanso'    => ($tiempodescanso !== '' && $tiempodescanso !== null) ? (int)$tiempodescanso : null,
            'peso'              => ($peso !== '' && $peso !== null) ? (float)$peso : null,
        ]);

        return redirect()->to(base_url('ejecucionprograma/actual/' . $id))->with('success', 'Ejecución de ejercicio registrada exitosamente.');
    }

    // Formulario para editar ejecución existente
    public function edit($id)
    {
        $ejecucion = $this->ejecucionModel->find($id);
        if (!$ejecucion) {
            throw PageNotFoundException::forPageNotFound("Registro de ejecución no encontrado.");
        }

        $programasClientes = $this->programaClienteModel->getProgramasClientesWithDetails();
        $ejercicios        = $this->ejercicioModel->getEjercicios(null, 0);

        $data = [
            'title'             => 'Editar Ejecución de Programa #' . $id,
            'ejecucion'         => $ejecucion,
            'programasClientes' => $programasClientes,
            'ejercicios'        => $ejercicios,
            'module'            => 'ejecucionprograma',
        ];

        return view('ejecucionprograma/ejecucionprograma_edit', $data);
    }

    public function update($id)
    {
        $ejecucion = $this->ejecucionModel->find($id);
        if (!$ejecucion) {
            return redirect()->to(base_url('ejecucionprograma'))->with('error', 'Registro de ejecución no encontrado.');
        }

        $rules = [
            'idprogramacliente' => 'required|is_natural_no_zero',
            'idejercicio'       => 'required|is_natural_no_zero',
            'fecha'             => 'required|valid_date[Y-m-d]',
            'horainicio'        => 'required',
            'horafin'           => 'permit_empty',
            'series'            => 'permit_empty|is_natural',
            'repeticiones'      => 'permit_empty|is_natural',
            'tiempodescanso'    => 'permit_empty|is_natural',
            'peso'              => 'permit_empty|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $horafin        = $this->request->getPost('horafin');
        $series         = $this->request->getPost('series');
        $repeticiones   = $this->request->getPost('repeticiones');
        $tiempodescanso = $this->request->getPost('tiempodescanso');
        $peso           = $this->request->getPost('peso');

        $this->ejecucionModel->update($id, [
            'idprogramacliente' => $this->request->getPost('idprogramacliente'),
            'idejercicio'       => $this->request->getPost('idejercicio'),
            'fecha'             => $this->request->getPost('fecha'),
            'horainicio'        => $this->request->getPost('horainicio'),
            'horafin'           => !empty($horafin) ? $horafin : null,
            'series'            => ($series !== '' && $series !== null) ? (int)$series : null,
            'repeticiones'      => ($repeticiones !== '' && $repeticiones !== null) ? (int)$repeticiones : null,
            'tiempodescanso'    => ($tiempodescanso !== '' && $tiempodescanso !== null) ? (int)$tiempodescanso : null,
            'peso'              => ($peso !== '' && $peso !== null) ? (float)$peso : null,
        ]);

        return redirect()->to(base_url('ejecucionprograma/actual/' . $id))->with('success', 'Ejecución de programa actualizada exitosamente.');
    }

    public function delete($id)
    {
        $ejecucion = $this->ejecucionModel->find($id);
        if (!$ejecucion) {
            return redirect()->to(base_url('ejecucionprograma'))->with('error', 'Registro de ejecución no encontrado.');
        }

        $this->ejecucionModel->delete($id);

        $last = $this->ejecucionModel->elultimo();
        $targetUrl = $last ? 'ejecucionprograma/actual/' . $last['idejecucionprograma'] : 'ejecucionprograma';

        return redirect()->to(base_url($targetUrl))->with('success', 'Registro de ejecución eliminado exitosamente.');
    }
}
