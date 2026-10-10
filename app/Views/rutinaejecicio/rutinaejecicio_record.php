<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rutina)): ?>
            <?= view('layout/empty_record', ['module' => $module ?? 'rutinaejecicio']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => $module ?? 'rutinaejecicio',
                'currentId' => $rutina['idrutinaejercicio']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar2-week-fill text-info me-2"></i>Ficha de Rutina de Ejercicio
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rutina['idrutinaejercicio'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Rutina Ejercicio</th>
                                    <td class="fw-bold text-secondary">#<?= $rutina['idrutinaejercicio'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre de la Rutina</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <i class="bi bi-card-checklist text-info me-2"></i><?= esc($rutina['nombre']) ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Programas de Entrenamiento Asociados -->
                    <div class="border-top pt-4 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-clipboard2-pulse text-success me-2"></i>Programas de Entrenamiento que Incluyen esta Rutina
                                <span class="badge bg-success ms-2"><?= !empty($rutina['programas']) ? count($rutina['programas']) : 0 ?></span>
                            </h6>
                            <a href="<?= base_url('rutinaprograma/add?idrutinaejercicio=' . $rutina['idrutinaejercicio']) ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-circle me-1"></i>Vincular a un Programa
                            </a>
                        </div>

                        <?php if (empty($rutina['programas'])): ?>
                            <div class="alert alert-light border small text-muted mb-0">
                                <i class="bi bi-info-circle me-1"></i>Esta rutina no está asociada a ningún programa de entrenamiento actualmente.
                            </div>
                        <?php else: ?>
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($rutina['programas'] as $p): ?>
                                    <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="text-decoration-none">
                                        <div class="badge bg-success-subtle text-success-emphasis border border-success p-2">
                                            <i class="bi bi-clipboard2-pulse me-1"></i><?= esc($p['programa_nombre']) ?> 
                                            <small class="text-muted ms-1">(<?= esc($p['motivo_nombre']) ?>)</small>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Planes y Ejercicios Asociados a esta Rutina -->
                    <div class="border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-card-checklist text-primary me-2"></i>Planes y Ejercicios Asociados a esta Rutina
                                <span class="badge bg-primary ms-2"><?= !empty($rutina['planes']) ? count($rutina['planes']) : 0 ?></span>
                            </h6>
                            <a href="<?= base_url('rutinaplan/add?idrutinaejercicio=' . $rutina['idrutinaejercicio']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Vincular Plan
                            </a>
                        </div>

                        <?php if (empty($rutina['planes'])): ?>
                            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                                <div>
                                    Esta rutina aún no tiene planes de ejercicio asociados.
                                    <a href="<?= base_url('rutinaplan/add?idrutinaejercicio=' . $rutina['idrutinaejercicio']) ?>" class="alert-link ms-1">Vincular un plan ahora</a>.
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
                                        <?php foreach ($rutina['planes'] as $pl): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-2">
                                                        <?php if (!empty($pl['ejercicio_imagen'])): ?>
                                                            <img src="<?= base_url('ejercicio/imagen/' . esc($pl['ejercicio_imagen'])) ?>" 
                                                                 alt="" 
                                                                 class="rounded border bg-light" 
                                                                 style="width: 36px; height: 36px; object-fit: contain;">
                                                        <?php else: ?>
                                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 36px; height: 36px;">
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
