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
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm border" style="width: 85px; height: 85px;">
                                        <i class="bi bi-person-badge-fill text-primary fs-1"></i>
                                    </div>
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
                                        <i class="bi bi-clipboard2-pulse me-1"></i>Ver Programa Base
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
                                                            ID #<?= $programaCliente['idprogramaentrenamiento'] ?> &bull; <?= esc($programaCliente['motivo_nombre']) ?>
                                                        </span>
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
                                                            <a href="<?= base_url('planejercicio/actual/' . $pl['idplanejercicio']) ?>" class="small text-muted text-decoration-none">
                                                                Plan #<?= $pl['idplanejercicio'] ?>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($pl['rutina_nombre'] ?? 'General') ?>
                                                    </span>
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
                                                        <a href="<?= base_url('ejercicio/actual/' . $pl['idejercicio']) ?>" class="btn btn-outline-danger" title="Ver Ejercicio">
                                                            <i class="bi bi-fire"></i>
                                                        </a>
                                                        <a href="<?= base_url('planejercicio/actual/' . $pl['idplanejercicio']) ?>" class="btn btn-outline-primary" title="Ver Plan">
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

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
