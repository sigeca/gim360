<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rutinaprograma)): ?>
            <?= view('layout/empty_record', ['module' => 'rutinaprograma']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'rutinaprograma',
                'currentId' => $rutinaprograma['idrutinaprograma']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-collection-play-fill text-info me-2"></i>Ficha de Rutina en Programa
                        </h5>
                        <span class="text-muted small">Asignación de rutina de ejercicio a un programa de entrenamiento</span>
                    </div>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rutinaprograma['idrutinaprograma'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Registro</th>
                                    <td class="fw-bold text-secondary">#<?= $rutinaprograma['idrutinaprograma'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Programa de Entrenamiento</th>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <a href="<?= base_url('programaentrenamiento/actual/' . $rutinaprograma['idprogramaentrenamiento']) ?>" class="fw-bold text-dark text-decoration-none fs-6">
                                                    <i class="bi bi-clipboard2-pulse text-success me-1"></i><?= esc($rutinaprograma['programa_nombre']) ?>
                                                </a>
                                                <small class="text-muted d-block mt-1">ID #<?= $rutinaprograma['idprogramaentrenamiento'] ?></small>
                                            </div>
                                            <a href="<?= base_url('programaentrenamiento/actual/' . $rutinaprograma['idprogramaentrenamiento']) ?>" class="btn btn-outline-success btn-sm">
                                                <i class="bi bi-eye me-1"></i>Ver Programa
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Motivo de Entrenamiento</th>
                                    <td>
                                        <a href="<?= base_url('motivoentrenamiento/actual/' . $rutinaprograma['idmotivoentrenamiento']) ?>" class="text-decoration-none">
                                            <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2">
                                                <i class="bi bi-bullseye text-warning me-1"></i><?= esc($rutinaprograma['motivo_nombre']) ?>
                                            </span>
                                        </a>
                                        <?php if (!empty($rutinaprograma['motivo_objetivo'])): ?>
                                            <div class="small text-muted mt-2 fst-italic">
                                                <?= esc($rutinaprograma['motivo_objetivo']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Rutina de Ejercicio</th>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div>
                                                <a href="<?= base_url('rutinaejecicio/actual/' . $rutinaprograma['idrutinaejercicio']) ?>" class="text-decoration-none">
                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2 fs-6">
                                                        <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($rutinaprograma['rutina_nombre']) ?>
                                                    </span>
                                                </a>
                                                <small class="text-muted d-block mt-1">ID #<?= $rutinaprograma['idrutinaejercicio'] ?></small>
                                            </div>
                                            <a href="<?= base_url('rutinaejecicio/actual/' . $rutinaprograma['idrutinaejercicio']) ?>" class="btn btn-outline-info btn-sm">
                                                <i class="bi bi-calendar-event me-1"></i>Ver Rutina
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Planes y Ejercicios Asociados a esta Rutina -->
                    <div class="border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-card-checklist text-primary me-2"></i>Planes y Ejercicios Incluidos en esta Rutina
                                <span class="badge bg-primary ms-2"><?= !empty($rutinaprograma['planes']) ? count($rutinaprograma['planes']) : 0 ?></span>
                            </h6>
                            <a href="<?= base_url('rutinaplan/add?idrutinaejercicio=' . $rutinaprograma['idrutinaejercicio']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Vincular más planes a esta rutina
                            </a>
                        </div>

                        <?php if (empty($rutinaprograma['planes'])): ?>
                            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                                <div>
                                    Esta rutina aún no tiene planes de ejercicio asociados en la tabla <code>rutinaplan</code>.
                                    <a href="<?= base_url('rutinaplan/add?idrutinaejercicio=' . $rutinaprograma['idrutinaejercicio']) ?>" class="alert-link ms-1">Vincular un plan ahora</a>.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered align-middle mb-0">
                                    <thead class="table-light small">
                                        <tr>
                                            <th>Ejercicio</th>
                                            <th class="text-center">Días/Sem</th>
                                            <th class="text-center">Series</th>
                                            <th class="text-center">Reps</th>
                                            <th class="text-center">Descanso</th>
                                            <th class="text-center">Peso</th>
                                            <th class="text-end">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($rutinaprograma['planes'] as $pl): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php if (!empty($pl['ejercicio_imagen'])): ?>
                                                            <img src="<?= base_url('ejercicio/imagen/' . esc($pl['ejercicio_imagen'])) ?>" 
                                                                 alt="" 
                                                                 class="rounded border bg-light" 
                                                                 style="width: 38px; height: 38px; object-fit: contain;">
                                                        <?php else: ?>
                                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px;">
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
