<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($programaCliente)): ?>
            <?= view('layout/empty_record', ['module' => 'programacliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'programacliente',
                'currentId' => $programaCliente['idprogramacliente']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-person-lines-fill text-primary me-2"></i>Programa Asignado al Cliente
                        </h5>
                        <span class="badge bg-primary fs-6">ID #<?= $programaCliente['idprogramacliente'] ?></span>
                    </div>
                    <div>
                        <?php 
                            $badgeColor = 'bg-primary';
                            $estLower = strtolower($programaCliente['estado_nombre'] ?? '');
                            if (str_contains($estLower, 'activo')) $badgeColor = 'bg-success';
                            elseif (str_contains($estLower, 'completado')) $badgeColor = 'bg-info text-dark';
                            elseif (str_contains($estLower, 'pausado') || str_contains($estLower, 'espera')) $badgeColor = 'bg-warning text-dark';
                            elseif (str_contains($estLower, 'cancelado')) $badgeColor = 'bg-danger';
                        ?>
                        <span class="badge <?= $badgeColor ?> px-3 py-2 fs-6">
                            <i class="bi bi-flag-fill me-1"></i><?= esc($programaCliente['estado_nombre'] ?? 'Sin estado') ?>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-start mb-4">
                        
                        <!-- Columna de la Tarjeta del Cliente Asignado -->
                        <div class="col-md-5 col-lg-4 text-center">
                            <div class="card bg-light border shadow-sm p-4">
                                <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($programaCliente['cliente_cedula'])) . '.jpg'; ?>
                                <div class="mb-3">
                                    <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto en tamaño original" class="d-inline-block text-decoration-none">
                                        <img src="<?= esc($fotoUrl) ?>"
                                             alt="Foto de <?= esc($programaCliente['cliente_nombres']) ?>"
                                             class="rounded-circle shadow-sm border border-2 border-primary"
                                             style="width: 95px; height: 95px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                        <div class="align-items-center justify-content-center bg-white rounded-circle shadow-sm border" style="width: 95px; height: 95px; display: none;">
                                            <i class="bi bi-person-badge-fill text-primary fs-1"></i>
                                        </div>
                                    </a>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($programaCliente['cliente_nombres']) ?></h5>
                                <div class="text-muted small mb-3">
                                    <i class="bi bi-card-heading me-1"></i>Cédula: <strong><?= esc($programaCliente['cliente_cedula']) ?></strong>
                                </div>

                                <div class="d-flex flex-column gap-2 text-start bg-white p-3 rounded border small mb-3">
                                    <div>
                                        <span class="text-muted d-block"><i class="bi bi-calendar-check text-primary me-1"></i>Fecha de Inicio:</span>
                                        <span class="fw-semibold text-dark"><?= date('d/m/Y', strtotime($programaCliente['fechainicio'])) ?></span>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block"><i class="bi bi-flag-fill text-info me-1"></i>Estado del Programa:</span>
                                        <span class="badge <?= $badgeColor ?> px-2 py-1"><?= esc($programaCliente['estado_nombre']) ?></span>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block"><i class="bi bi-collection-play text-info me-1"></i>Rutinas del Programa:</span>
                                        <span class="fw-bold text-dark"><?= !empty($programaCliente['rutinas']) ? count($programaCliente['rutinas']) : 0 ?> rutinas</span>
                                    </div>
                                    <div>
                                        <span class="text-muted d-block"><i class="bi bi-card-checklist text-success me-1"></i>Total Ejercicios/Planes:</span>
                                        <span class="fw-bold text-dark"><?= !empty($programaCliente['planes']) ? count($programaCliente['planes']) : 0 ?> planes</span>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="<?= base_url('cliente/actual/' . $programaCliente['idcliente']) ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-person-circle me-1"></i>Ver Ficha de Cliente
                                    </a>
                                    <a href="<?= base_url('programaentrenamiento/actual/' . $programaCliente['idprogramaentrenamiento']) ?>" class="btn btn-outline-success btn-sm">
                                        <i class="bi bi-clipboard2-pulse me-1"></i>Ver Programa Modelo
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Columna de Datos Técnicos y Relaciones del Programa -->
                        <div class="col-md-7 col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Asignación</th>
                                            <td class="fw-bold text-secondary">#<?= $programaCliente['idprogramacliente'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Cliente</th>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <span class="fs-6 fw-bold text-dark d-block">
                                                            <?= esc($programaCliente['cliente_nombres']) ?>
                                                        </span>
                                                        <small class="text-muted">C.I: <?= esc($programaCliente['cliente_cedula']) ?></small>
                                                    </div>
                                                    <a href="<?= base_url('cliente/actual/' . $programaCliente['idcliente']) ?>" class="btn btn-outline-primary btn-sm">
                                                        <i class="bi bi-person-badge me-1"></i>Ver Cliente
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha de Inicio</th>
                                            <td class="fw-semibold text-dark fs-6">
                                                <i class="bi bi-calendar-check text-primary me-1"></i>
                                                <?= date('d/m/Y', strtotime($programaCliente['fechainicio'])) ?>
                                                <small class="text-muted ms-2">(<?= esc($programaCliente['fechainicio']) ?>)</small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Estado del Programa</th>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <span class="badge <?= $badgeColor ?> px-3 py-2">
                                                        <?= esc($programaCliente['estado_nombre']) ?>
                                                    </span>
                                                    <a href="<?= base_url('estadoprogramacliente/actual/' . $programaCliente['idestadoprogramacliente']) ?>" class="btn btn-outline-info btn-sm">
                                                        <i class="bi bi-tag me-1"></i>Ver Estado
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Programa de Entrenamiento</th>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-between">
                                                    <div>
                                                        <span class="fw-bold text-dark fs-6"><?= esc($programaCliente['programa_nombre'] ?? ('Programa #' . $programaCliente['idprogramaentrenamiento'])) ?></span>
                                                        <span class="text-muted small d-block">
                                                            ID Modelo #<?= $programaCliente['idprogramaentrenamiento'] ?> &bull; <?= esc($programaCliente['motivo_nombre']) ?>
                                                        </span>
                                                        <?php if (!empty($programaCliente['idprogramapersonalizado'])): ?>
                                                            <span class="badge bg-success-subtle text-success border border-success mt-1">
                                                                <i class="bi bi-person-check-fill me-1"></i>Personalizado (#<?= $programaCliente['idprogramapersonalizado'] ?>) - Copia independiente
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <a href="<?= base_url('programaentrenamiento/actual/' . $programaCliente['idprogramaentrenamiento']) ?>" class="btn btn-outline-success btn-sm">
                                                        <i class="bi bi-clipboard2-pulse me-1"></i>Ver Programa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Motivo / Objetivo</th>
                                            <td>
                                                <span class="fw-semibold text-dark"><?= esc($programaCliente['motivo_nombre']) ?></span>
                                                <?php if (!empty($programaCliente['motivo_objetivo'])): ?>
                                                    <small class="d-block text-muted mt-1"><?= esc($programaCliente['motivo_objetivo']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if (!empty($programaCliente['idrangoedad'])): ?>
                                        <tr>
                                            <th class="table-light text-muted">Rango de Edad Recomendado</th>
                                            <td>
                                                <a href="<?= base_url('rangoedad/actual/' . $programaCliente['idrangoedad']) ?>" class="text-decoration-none">
                                                    <span class="badge bg-info-subtle text-dark border border-info px-3 py-2">
                                                        <i class="bi bi-person-bounding-box text-info me-1"></i><?= esc($programaCliente['rango_nombre']) ?>
                                                        (<?= (int)$programaCliente['rango_edadminima'] ?> - <?= (int)$programaCliente['rango_edadmaxima'] ?> años)
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <th class="table-light text-muted">Rutinas del Programa</th>
                                            <td>
                                                <?php if (empty($programaCliente['rutinas'])): ?>
                                                    <span class="text-muted fst-italic">Sin rutinas asociadas actualmente.</span>
                                                <?php else: ?>
                                                    <div class="d-flex flex-wrap gap-2">
                                                        <?php foreach ($programaCliente['rutinas'] as $r): ?>
                                                            <a href="<?= base_url('rutinaejecicio/actual/' . $r['idrutinaejercicio']) ?>" class="text-decoration-none">
                                                                <span class="badge bg-info-subtle text-info-emphasis border border-info px-2 py-1">
                                                                    <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($r['rutina_nombre']) ?>
                                                                </span>
                                                            </a>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <!-- Planes de Ejercicio Asociados a las Rutinas del Programa -->
                    <div class="border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-card-checklist text-primary me-2"></i>Planes y Ejercicios Incluidos en el Programa
                                <span class="badge bg-primary ms-2"><?= !empty($programaCliente['planes']) ? count($programaCliente['planes']) : 0 ?></span>
                            </h6>
                            <a href="<?= base_url('rutinaprograma/add?idprograma=' . $programaCliente['idprogramaentrenamiento']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Vincular más rutinas
                            </a>
                        </div>

                        <?php if (empty($programaCliente['planes'])): ?>
                            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                                <div>
                                    Este programa no tiene ejercicios asociados en sus rutinas actualmente.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle mb-0">
                                    <thead class="table-light small">
                                        <tr>
                                            <th>Ejercicio</th>
                                            <th>Rutina</th>
                                            <th class="text-center"><i class="bi bi-calendar-event text-primary me-1"></i>Inicio</th>
                                            <th class="text-center"><i class="bi bi-hourglass-split text-warning me-1"></i>Duración</th>
                                            <th class="text-center">Días/Sem</th>
                                            <th class="text-center">Series</th>
                                            <th class="text-center">Reps</th>
                                            <th class="text-center">Descanso</th>
                                            <th class="text-center">Peso</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($programaCliente['planes'] as $pl): ?>
                                            <?php
                                                $isPersonalizado = !empty($pl['idplanpersonalizado']);
                                                $planUrl = $isPersonalizado 
                                                    ? base_url('planpersonalizado/actual/' . $pl['idplanpersonalizado']) 
                                                    : base_url('planejercicio/actual/' . $pl['idplanejercicio']);
                                                $planEditUrl = $isPersonalizado 
                                                    ? base_url('planpersonalizado/edit/' . $pl['idplanpersonalizado']) 
                                                    : base_url('planejercicio/edit/' . $pl['idplanejercicio']);
                                                $planId = $isPersonalizado ? $pl['idplanpersonalizado'] : $pl['idplanejercicio'];
                                                $planFechaInicio = $pl['fechainicio'] ?? $pl['plan_fechainicio'] ?? $programaCliente['fechainicio'] ?? null;
                                                $planDuracion = $pl['duracionsemana'] ?? $pl['plan_duracionsemana'] ?? null;
                                            ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php if (!empty($pl['ejercicio_imagen'])): ?>
                                                            <img src="<?= base_url('ejercicio/imagen/' . esc($pl['ejercicio_imagen'])) ?>" 
                                                                 alt="" 
                                                                 class="rounded border bg-light" 
                                                                 style="width: 40px; height: 40px; object-fit: contain;">
                                                        <?php else: ?>
                                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 40px; height: 40px;">
                                                                <i class="bi bi-fire text-danger"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                        <div>
                                                            <a href="<?= base_url('ejercicio/actual/' . $pl['idejercicio']) ?>" class="fw-semibold text-dark text-decoration-none d-block">
                                                                <?= esc($pl['ejercicio_nombre']) ?>
                                                            </a>
                                                            <a href="<?= $planUrl ?>" class="small text-muted text-decoration-none">
                                                                <?= $isPersonalizado ? 'Plan Pers. #' . $planId : 'Plan #' . $planId ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($pl['rutina_nombre'] ?? 'General') ?>
                                                    </span>
                                                </td>
                                                <!-- FECHA INICIO -->
                                                <td class="text-center">
                                                    <?php if (!empty($planFechaInicio)): ?>
                                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                                            <i class="bi bi-calendar-check me-1"></i><?= esc($planFechaInicio) ?>
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <!-- DURACIÓN EN SEMANAS -->
                                                <td class="text-center">
                                                    <?php if (isset($planDuracion) && $planDuracion !== null && $planDuracion !== ''): ?>
                                                        <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1 fw-bold">
                                                            <i class="bi bi-hourglass-split text-warning me-1"></i><?= esc($planDuracion) ?> sem
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-primary-subtle text-primary border border-primary">
                                                        <?= esc($pl['plan_diassemanas'] ?? 0) ?> d
                                                    </span>
                                                </td>
                                                <td class="text-center fw-bold"><?= esc($pl['plan_series'] ?? 0) ?></td>
                                                <td class="text-center fw-bold"><?= esc($pl['plan_repeticiones'] ?? 0) ?></td>
                                                <td class="text-center text-muted small"><?= esc($pl['plan_tiempodescanso'] ?? 0) ?>s</td>
                                                <td class="text-center">
                                                    <span class="badge bg-danger-subtle text-danger border border-danger">
                                                        <?= number_format((float)($pl['plan_peso'] ?? 0), 2) ?> kg
                                                    </span>
                                                </td>
                                                <td class="text-end">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('ejecucionprograma/add?idprogramacliente=' . $programaCliente['idprogramacliente'] . '&idejercicio=' . $pl['idejercicio'] . '&series=' . urlencode((string)($pl['plan_series'] ?? '')) . '&repeticiones=' . urlencode((string)($pl['plan_repeticiones'] ?? '')) . '&tiempodescanso=' . urlencode((string)($pl['plan_tiempodescanso'] ?? '')) . '&peso=' . urlencode((string)($pl['plan_peso'] ?? ''))) ?>" class="btn btn-warning text-dark fw-semibold" title="Registrar Ejecución de este Ejercicio">
                                                            <i class="bi bi-play-fill"></i> Ejecutar
                                                        </a>
                                                        <a href="<?= base_url('ejercicio/actual/' . $pl['idejercicio']) ?>" class="btn btn-outline-danger" title="Ver Ejercicio">
                                                            <i class="bi bi-fire"></i>
                                                        </a>
                                                        <a href="<?= $planEditUrl ?>" class="btn btn-outline-secondary" title="Editar Plan y Duración">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a href="<?= $planUrl ?>" class="btn btn-outline-primary" title="Ver Plan">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>

                    <hr class="my-4">

                    <!-- Sección: Historial de Ejecución de Ejercicios de este Programa Cliente -->
                    <div>
                        <?php
                            $ejerciciosEjecutadosMap = [];
                            $fechasEjecucionMap = [];
                            $totalEjecuciones = !empty($programaCliente['ejecuciones']) ? count($programaCliente['ejecuciones']) : 0;

                            if (!empty($programaCliente['ejecuciones'])) {
                                foreach ($programaCliente['ejecuciones'] as $ejExec) {
                                    $idEj = (int)$ejExec['idejercicio'];
                                    $nombreEsp = $ejExec['ejercicio_nombreespanol'] ?? $ejExec['ejercicio_nombre'] ?? ('Ejercicio #' . $idEj);
                                    if (!isset($ejerciciosEjecutadosMap[$idEj])) {
                                        $ejerciciosEjecutadosMap[$idEj] = [
                                            'idejercicio'   => $idEj,
                                            'nombreespanol' => $nombreEsp,
                                            'nombreingles'  => $ejExec['ejercicio_nombreingles'] ?? '',
                                            'count'         => 0,
                                        ];
                                    }
                                    $ejerciciosEjecutadosMap[$idEj]['count']++;

                                    $fechaRaw = $ejExec['fecha'] ?? '';
                                    if ($fechaRaw !== '') {
                                        if (!isset($fechasEjecucionMap[$fechaRaw])) {
                                            $fechasEjecucionMap[$fechaRaw] = [
                                                'fecha'      => $fechaRaw,
                                                'formatted'  => date('d/m/Y', strtotime($fechaRaw)),
                                                'count'      => 0,
                                                'ejercicios' => [],
                                            ];
                                        }
                                        $fechasEjecucionMap[$fechaRaw]['count']++;
                                        $fechasEjecucionMap[$fechaRaw]['ejercicios'][$idEj] = $nombreEsp;
                                    }
                                }
                                uasort($ejerciciosEjecutadosMap, static fn($a, $b) => strcasecmp($a['nombreespanol'], $b['nombreespanol']));
                                krsort($fechasEjecucionMap);
                            }

                            $filtroEjercicioInicial = isset($_GET['filtro_ejercicio']) ? trim((string)$_GET['filtro_ejercicio']) : '';
                            $filtroFechaInicial     = isset($_GET['filtro_fecha']) ? trim((string)$_GET['filtro_fecha']) : '';
                        ?>

                        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-play-btn-fill text-warning me-2"></i>Registro de Ejecución de Ejercicios (<code>ejecucionprograma</code>)
                                <span class="badge bg-warning text-dark ms-1" id="badgeTotalEjecuciones"><?= $totalEjecuciones ?></span>
                            </h6>
                            <a href="<?= base_url('ejecucionprograma/add?idprogramacliente=' . $programaCliente['idprogramacliente']) ?>" class="btn btn-sm btn-warning text-dark fw-bold">
                                <i class="bi bi-plus-circle me-1"></i> + Registrar Ejecución
                            </a>
                        </div>

                        <?php if (empty($programaCliente['ejecuciones'])): ?>
                            <div class="alert alert-light border text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i> Aún no se han registrado ejecuciones de ejercicios para este programa asignado.
                            </div>
                        <?php else: ?>
                            <!-- Barra de Filtros: Por Ejercicio Ejecutado y por Fecha -->
                            <div class="card bg-light border shadow-xs mb-3">
                                <div class="card-body p-3">
                                    <form id="formFiltroEjecuciones" method="get" class="row g-2 align-items-end" onsubmit="return false;">
                                        <div class="col-md-5">
                                            <label for="filtroEjercicioEjecucion" class="form-label small fw-bold text-secondary mb-1">
                                                <i class="bi bi-fire text-danger me-1"></i>Filtrar por Ejercicio Ejecutado
                                            </label>
                                            <select id="filtroEjercicioEjecucion" name="filtro_ejercicio" class="form-select form-select-sm">
                                                <option value="">-- Todos los ejercicios ejecutados (<?= count($ejerciciosEjecutadosMap) ?>) --</option>
                                                <?php foreach ($ejerciciosEjecutadosMap as $ejItem): ?>
                                                    <option value="<?= $ejItem['idejercicio'] ?>" <?= ($filtroEjercicioInicial !== '' && (int)$filtroEjercicioInicial === $ejItem['idejercicio']) ? 'selected' : '' ?>>
                                                        <?= esc($ejItem['nombreespanol']) ?><?= !empty($ejItem['nombreingles']) ? ' (' . esc($ejItem['nombreingles']) . ')' : '' ?> — [<?= $ejItem['count'] ?> <?= $ejItem['count'] === 1 ? 'vez' : 'veces' ?>]
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-3">
                                            <label for="filtroFechaRapidaEjecucion" class="form-label small fw-bold text-secondary mb-1">
                                                <i class="bi bi-calendar-check text-primary me-1"></i>Fechas con Ejecución
                                            </label>
                                            <select id="filtroFechaRapidaEjecucion" class="form-select form-select-sm">
                                                <option value="">-- Todas las fechas (<?= count($fechasEjecucionMap) ?>) --</option>
                                                <?php foreach ($fechasEjecucionMap as $fItem): ?>
                                                    <option value="<?= esc($fItem['fecha']) ?>" <?= ($filtroFechaInicial === $fItem['fecha']) ? 'selected' : '' ?>>
                                                        <?= esc($fItem['formatted']) ?> (<?= count($fItem['ejercicios']) ?> ej. / <?= $fItem['count'] ?> reg.)
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-6 col-md-2">
                                            <label for="filtroFechaEjecucion" class="form-label small fw-bold text-secondary mb-1">
                                                <i class="bi bi-calendar-event text-primary me-1"></i>Fecha Exacta
                                            </label>
                                            <input type="date" id="filtroFechaEjecucion" name="filtro_fecha" class="form-control form-control-sm" value="<?= esc($filtroFechaInicial) ?>" title="Seleccionar una fecha específica">
                                        </div>

                                        <div class="col-md-2 d-flex gap-1">
                                            <button type="button" id="btnLimpiarFiltrosEjecucion" class="btn btn-sm btn-outline-secondary w-100" title="Mostrar todas las ejecuciones">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i>Limpiar
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Panel dinámico de resumen de resultados (Cómo se ejecutó / Cuántos y cuáles ejercicios en la fecha) -->
                                    <div id="resumenFiltroEjecuciones" class="mt-3 pt-2 border-top small">
                                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                            <div id="resumenTextoEjecuciones" class="text-dark">
                                                Mostrando <strong><?= $totalEjecuciones ?></strong> de <strong><?= $totalEjecuciones ?></strong> registros de ejecución
                                                (<strong><?= count($ejerciciosEjecutadosMap) ?></strong> ejercicios distintos en <strong><?= count($fechasEjecucionMap) ?></strong> fechas).
                                            </div>
                                            <div id="resumenMetricasEjercicio" class="d-none"></div>
                                        </div>
                                        <div id="resumenListaEjerciciosFecha" class="mt-2 d-none"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle mb-0" id="tablaEjecucionesPrograma">
                                    <thead class="table-light small">
                                        <tr>
                                            <th class="ps-3">ID</th>
                                            <th>Ejercicio Ejecutado</th>
                                            <th>Fecha</th>
                                            <th>Hora Inicio</th>
                                            <th>Hora Fin</th>
                                            <th>Duración</th>
                                            <th class="text-center">Series</th>
                                            <th class="text-center">Reps</th>
                                            <th class="text-center">Descanso</th>
                                            <th class="text-center">Peso</th>
                                            <th class="text-end pe-3">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($programaCliente['ejecuciones'] as $ejExec): ?>
                                            <?php
                                                $fechaFormateada = date('d/m/Y', strtotime($ejExec['fecha']));
                                                $duracionMinutos = 0;
                                                $duracionLabel = '-';
                                                if (!empty($ejExec['horainicio']) && !empty($ejExec['horafin'])) {
                                                    $tIni = strtotime($ejExec['fecha'] . ' ' . $ejExec['horainicio']);
                                                    $tFin = strtotime($ejExec['fecha'] . ' ' . $ejExec['horafin']);
                                                    $diff = $tFin - $tIni;
                                                    if ($diff > 0) {
                                                        $duracionMinutos = round($diff / 60, 1);
                                                        $h = floor($diff / 3600);
                                                        $m = floor(($diff % 3600) / 60);
                                                        $duracionLabel = ($h > 0 ? $h . 'h ' : '') . $m . 'm';
                                                    }
                                                }
                                            ?>
                                            <tr class="fila-ejecucion"
                                                data-idejercicio="<?= (int)$ejExec['idejercicio'] ?>"
                                                data-ejercicio-nombre="<?= esc($ejExec['ejercicio_nombreespanol']) ?>"
                                                data-fecha="<?= esc($ejExec['fecha']) ?>"
                                                data-fecha-fmt="<?= esc($fechaFormateada) ?>"
                                                data-series="<?= isset($ejExec['series']) && $ejExec['series'] !== '' ? (int)$ejExec['series'] : '' ?>"
                                                data-reps="<?= isset($ejExec['repeticiones']) && $ejExec['repeticiones'] !== '' ? (int)$ejExec['repeticiones'] : '' ?>"
                                                data-descanso="<?= isset($ejExec['tiempodescanso']) && $ejExec['tiempodescanso'] !== '' ? (int)$ejExec['tiempodescanso'] : '' ?>"
                                                data-peso="<?= isset($ejExec['peso']) && $ejExec['peso'] !== '' ? (float)$ejExec['peso'] : '' ?>"
                                                data-duracion="<?= esc($duracionLabel) ?>">
                                                <td class="ps-3 fw-bold text-muted">#<?= $ejExec['idejecucionprograma'] ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-between gap-2">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <?php if (!empty($ejExec['ejercicio_imagen'])): ?>
                                                                <img src="<?= base_url('ejercicio/imagen/' . rawurlencode($ejExec['ejercicio_imagen'])) ?>"
                                                                     alt=""
                                                                     class="rounded border bg-light"
                                                                     style="width: 38px; height: 38px; object-fit: cover;">
                                                            <?php endif; ?>
                                                            <div>
                                                                <a href="<?= base_url('ejecucionprograma/actual/' . $ejExec['idejecucionprograma']) ?>" class="fw-semibold text-dark text-decoration-none d-block">
                                                                    <?= esc($ejExec['ejercicio_nombreespanol']) ?>
                                                                </a>
                                                                <small class="text-muted fst-italic"><?= esc($ejExec['ejercicio_nombreingles']) ?></small>
                                                            </div>
                                                        </div>
                                                        <button type="button"
                                                                class="btn btn-sm btn-light border text-secondary py-0 px-1 btn-filtrar-ejercicio-fila"
                                                                data-idejercicio="<?= (int)$ejExec['idejercicio'] ?>"
                                                                title="Filtrar historial de este ejercicio">
                                                            <i class="bi bi-funnel"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold">
                                                    <div class="d-flex align-items-center justify-content-between gap-1">
                                                        <span><?= $fechaFormateada ?></span>
                                                        <button type="button"
                                                                class="btn btn-sm btn-light border text-secondary py-0 px-1 btn-filtrar-fecha-fila"
                                                                data-fecha="<?= esc($ejExec['fecha']) ?>"
                                                                title="Ver todos los ejercicios ejecutados en esta fecha">
                                                            <i class="bi bi-calendar2-day"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                                <td><span class="badge bg-primary font-monospace"><?= date('H:i', strtotime($ejExec['horainicio'])) ?></span></td>
                                                <td>
                                                    <?php if (!empty($ejExec['horafin'])): ?>
                                                        <span class="badge bg-success font-monospace"><?= date('H:i', strtotime($ejExec['horafin'])) ?></span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning text-dark">En curso</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if ($duracionLabel !== '-'): ?>
                                                        <small class="fw-semibold text-success"><?= esc($duracionLabel) ?></small>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($ejExec['series']) && $ejExec['series'] !== null && $ejExec['series'] !== ''): ?>
                                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1"><?= esc($ejExec['series']) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($ejExec['repeticiones']) && $ejExec['repeticiones'] !== null && $ejExec['repeticiones'] !== ''): ?>
                                                        <span class="fw-bold"><?= esc($ejExec['repeticiones']) ?></span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($ejExec['tiempodescanso']) && $ejExec['tiempodescanso'] !== null && $ejExec['tiempodescanso'] !== ''): ?>
                                                        <span class="text-muted small"><?= esc($ejExec['tiempodescanso']) ?>s</span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php if (isset($ejExec['peso']) && $ejExec['peso'] !== null && $ejExec['peso'] !== ''): ?>
                                                        <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1"><?= number_format((float)$ejExec['peso'], 2) ?> kg</span>
                                                    <?php else: ?>
                                                        <span class="text-muted small">-</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-end pe-3">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('ejecucionprograma/actual/' . $ejExec['idejecucionprograma']) ?>" class="btn btn-outline-primary" title="Ver Ejecución">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('ejecucionprograma/edit/' . $ejExec['idejecucionprograma']) ?>" class="btn btn-outline-warning" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr id="filaSinResultadosEjecucion" class="d-none">
                                            <td colspan="11" class="text-center py-4 text-muted">
                                                <i class="bi bi-funnel fs-4 d-block mb-1"></i>
                                                No se encontraron registros de ejecución para los filtros seleccionados.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const selectEjercicio = document.getElementById('filtroEjercicioEjecucion');
                                const selectFechaRapida = document.getElementById('filtroFechaRapidaEjecucion');
                                const inputFecha = document.getElementById('filtroFechaEjecucion');
                                const btnLimpiar = document.getElementById('btnLimpiarFiltrosEjecucion');
                                const filas = Array.from(document.querySelectorAll('#tablaEjecucionesPrograma tbody tr.fila-ejecucion'));
                                const filaSinResultados = document.getElementById('filaSinResultadosEjecucion');
                                const badgeTotal = document.getElementById('badgeTotalEjecuciones');
                                const resumenTexto = document.getElementById('resumenTextoEjecuciones');
                                const resumenMetricas = document.getElementById('resumenMetricasEjercicio');
                                const resumenListaEjerciciosFecha = document.getElementById('resumenListaEjerciciosFecha');
                                const totalGeneral = filas.length;

                                function formatearFechaISO(iso) {
                                    if (!iso || !iso.includes('-')) return iso;
                                    const partes = iso.split('-');
                                    return partes.length === 3 ? `${partes[2]}/${partes[1]}/${partes[0]}` : iso;
                                }

                                function aplicarFiltros() {
                                    const idEjercicio = selectEjercicio ? selectEjercicio.value : '';
                                    const fecha = inputFecha ? inputFecha.value : '';

                                    let visibles = 0;
                                    const ejerciciosUnicos = new Map();
                                    const fechasUnicas = new Set();
                                    let maxPeso = null;
                                    let ultimasSeries = null;
                                    let ultimasReps = null;

                                    filas.forEach(fila => {
                                        const filaEj = fila.getAttribute('data-idejercicio') || '';
                                        const filaFecha = fila.getAttribute('data-fecha') || '';
                                        const nombreEj = fila.getAttribute('data-ejercicio-nombre') || '';
                                        const seriesVal = fila.getAttribute('data-series');
                                        const repsVal = fila.getAttribute('data-reps');
                                        const pesoVal = fila.getAttribute('data-peso');

                                        const coincideEjercicio = (idEjercicio === '' || filaEj === idEjercicio);
                                        const coincideFecha = (fecha === '' || filaFecha === fecha);

                                        if (coincideEjercicio && coincideFecha) {
                                            fila.classList.remove('d-none');
                                            visibles++;
                                            fechasUnicas.add(filaFecha);

                                            if (!ejerciciosUnicos.has(filaEj)) {
                                                ejerciciosUnicos.set(filaEj, {
                                                    nombre: nombreEj,
                                                    count: 0,
                                                    detalles: []
                                                });
                                            }
                                            const infoEj = ejerciciosUnicos.get(filaEj);
                                            infoEj.count++;
                                            const partesDetalle = [];
                                            if (seriesVal !== '') partesDetalle.push(`${seriesVal} series`);
                                            if (repsVal !== '') partesDetalle.push(`${repsVal} reps`);
                                            if (pesoVal !== '') partesDetalle.push(`${parseFloat(pesoVal).toFixed(2)} kg`);
                                            if (partesDetalle.length > 0) {
                                                infoEj.detalles.push(partesDetalle.join(' × '));
                                            }

                                            if (pesoVal !== '' && !isNaN(parseFloat(pesoVal))) {
                                                const p = parseFloat(pesoVal);
                                                if (maxPeso === null || p > maxPeso) maxPeso = p;
                                            }
                                            if (ultimasSeries === null && seriesVal !== '') ultimasSeries = seriesVal;
                                            if (ultimasReps === null && repsVal !== '') ultimasReps = repsVal;
                                        } else {
                                            fila.classList.add('d-none');
                                        }
                                    });

                                    if (filaSinResultados) {
                                        filaSinResultados.classList.toggle('d-none', visibles > 0);
                                    }

                                    if (badgeTotal) {
                                        badgeTotal.textContent = (idEjercicio !== '' || fecha !== '')
                                            ? `${visibles} / ${totalGeneral}`
                                            : `${totalGeneral}`;
                                    }

                                    // Actualizar resumen principal
                                    if (resumenTexto) {
                                        if (idEjercicio === '' && fecha === '') {
                                            resumenTexto.innerHTML = `Mostrando <strong>${totalGeneral}</strong> de <strong>${totalGeneral}</strong> ejecuciones registradas (<strong>${ejerciciosUnicos.size}</strong> ejercicios distintos en <strong>${fechasUnicas.size}</strong> fechas).`;
                                        } else if (fecha !== '' && idEjercicio === '') {
                                            resumenTexto.innerHTML = `<i class="bi bi-calendar-check-fill text-primary me-1"></i>En la fecha <strong>${formatearFechaISO(fecha)}</strong> se ejecutaron <strong>${ejerciciosUnicos.size}</strong> ejercicio(s) distintos en un total de <strong>${visibles}</strong> registro(s).`;
                                        } else if (idEjercicio !== '' && fecha === '') {
                                            const nombreSel = selectEjercicio.options[selectEjercicio.selectedIndex]?.text.split(' — ')[0] || 'Ejercicio seleccionado';
                                            resumenTexto.innerHTML = `<i class="bi bi-fire text-danger me-1"></i>Historial de <strong>${nombreSel}</strong>: ejecutado <strong>${visibles}</strong> ${visibles === 1 ? 'vez' : 'veces'} en <strong>${fechasUnicas.size}</strong> fecha(s).`;
                                        } else {
                                            const nombreSel = selectEjercicio.options[selectEjercicio.selectedIndex]?.text.split(' — ')[0] || 'Ejercicio';
                                            resumenTexto.innerHTML = `<i class="bi bi-funnel-fill text-warning me-1"></i>Ejecución de <strong>${nombreSel}</strong> el <strong>${formatearFechaISO(fecha)}</strong>: <strong>${visibles}</strong> registro(s) encontrado(s).`;
                                        }
                                    }

                                    // Mostrar métricas rápidas cuando se filtra por un ejercicio
                                    if (resumenMetricas) {
                                        if (idEjercicio !== '' && visibles > 0) {
                                            const badges = [];
                                            if (ultimasSeries !== null) badges.push(`<span class="badge bg-primary-subtle text-primary border border-primary">Últ. Series: ${ultimasSeries}</span>`);
                                            if (ultimasReps !== null) badges.push(`<span class="badge bg-info-subtle text-dark border border-info">Últ. Reps: ${ultimasReps}</span>`);
                                            if (maxPeso !== null) badges.push(`<span class="badge bg-danger-subtle text-danger border border-danger">Peso Máx: ${maxPeso.toFixed(2)} kg</span>`);
                                            resumenMetricas.innerHTML = badges.join(' ');
                                            resumenMetricas.classList.remove('d-none');
                                        } else {
                                            resumenMetricas.innerHTML = '';
                                            resumenMetricas.classList.add('d-none');
                                        }
                                    }

                                    // Mostrar lista detallada de cuáles ejercicios se ejecutaron cuando se filtra por fecha (o ambos)
                                    if (resumenListaEjerciciosFecha) {
                                        if (fecha !== '' && visibles > 0) {
                                            const itemsHtml = [];
                                            ejerciciosUnicos.forEach((info, idEj) => {
                                                const detalleStr = info.detalles.length > 0 ? ` <small class="text-muted">(${info.detalles[0]})</small>` : '';
                                                const repCount = info.count > 1 ? ` <span class="badge bg-secondary ms-1">×${info.count}</span>` : '';
                                                itemsHtml.push(
                                                    `<span class="badge bg-white text-dark border shadow-xs px-2 py-1 d-inline-flex align-items-center gap-1">` +
                                                    `<i class="bi bi-check-circle-fill text-success"></i>` +
                                                    `<span>${info.nombre}</span>${detalleStr}${repCount}` +
                                                    `</span>`
                                                );
                                            });
                                            resumenListaEjerciciosFecha.innerHTML =
                                                `<div class="d-flex flex-wrap align-items-center gap-2">` +
                                                `<span class="fw-bold text-secondary"><i class="bi bi-list-check me-1"></i>Ejercicios ejecutados (${ejerciciosUnicos.size}):</span>` +
                                                itemsHtml.join('') +
                                                `</div>`;
                                            resumenListaEjerciciosFecha.classList.remove('d-none');
                                        } else {
                                            resumenListaEjerciciosFecha.innerHTML = '';
                                            resumenListaEjerciciosFecha.classList.add('d-none');
                                        }
                                    }

                                    // Actualizar parámetros en la URL sin recargar la página
                                    if (window.history && window.history.replaceState) {
                                        const url = new URL(window.location.href);
                                        if (idEjercicio !== '') {
                                            url.searchParams.set('filtro_ejercicio', idEjercicio);
                                        } else {
                                            url.searchParams.delete('filtro_ejercicio');
                                        }
                                        if (fecha !== '') {
                                            url.searchParams.set('filtro_fecha', fecha);
                                        } else {
                                            url.searchParams.delete('filtro_fecha');
                                        }
                                        window.history.replaceState({}, '', url.toString());
                                    }
                                }

                                if (selectEjercicio) {
                                    selectEjercicio.addEventListener('change', aplicarFiltros);
                                }

                                if (selectFechaRapida && inputFecha) {
                                    selectFechaRapida.addEventListener('change', function () {
                                        inputFecha.value = this.value;
                                        aplicarFiltros();
                                    });

                                    inputFecha.addEventListener('input', function () {
                                        const existeOpcion = Array.from(selectFechaRapida.options).some(opt => opt.value === this.value);
                                        selectFechaRapida.value = existeOpcion ? this.value : '';
                                        aplicarFiltros();
                                    });
                                }

                                if (btnLimpiar) {
                                    btnLimpiar.addEventListener('click', function () {
                                        if (selectEjercicio) selectEjercicio.value = '';
                                        if (selectFechaRapida) selectFechaRapida.value = '';
                                        if (inputFecha) inputFecha.value = '';
                                        aplicarFiltros();
                                    });
                                }

                                document.querySelectorAll('.btn-filtrar-ejercicio-fila').forEach(btn => {
                                    btn.addEventListener('click', function () {
                                        const idEj = this.getAttribute('data-idejercicio') || '';
                                        if (selectEjercicio) {
                                            selectEjercicio.value = (selectEjercicio.value === idEj) ? '' : idEj;
                                            aplicarFiltros();
                                        }
                                    });
                                });

                                document.querySelectorAll('.btn-filtrar-fecha-fila').forEach(btn => {
                                    btn.addEventListener('click', function () {
                                        const fechaFila = this.getAttribute('data-fecha') || '';
                                        if (inputFecha) {
                                            const nuevaFecha = (inputFecha.value === fechaFila) ? '' : fechaFila;
                                            inputFecha.value = nuevaFecha;
                                            if (selectFechaRapida) {
                                                const existeOpcion = Array.from(selectFechaRapida.options).some(opt => opt.value === nuevaFecha);
                                                selectFechaRapida.value = existeOpcion ? nuevaFecha : '';
                                            }
                                            aplicarFiltros();
                                        }
                                    });
                                });

                                // Aplicar filtros iniciales si vienen por URL
                                if ((selectEjercicio && selectEjercicio.value !== '') || (inputFecha && inputFecha.value !== '')) {
                                    aplicarFiltros();
                                }
                            });
                            </script>
                        <?php endif; ?>
                    </div>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
