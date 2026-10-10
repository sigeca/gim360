<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($programa)): ?>
            <?= view('layout/empty_record', ['module' => 'programaentrenamiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'programaentrenamiento',
                'currentId' => $programa['idprogramaentrenamiento']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h5 class="fw-bold mb-1 text-dark">
                            <i class="bi bi-clipboard2-pulse-fill text-success me-2"></i><?= esc($programa['nombre'] ?? 'Programa de Entrenamiento') ?>
                        </h5>
                        <span class="text-muted small">Ficha detallada del programa de entrenamiento</span>
                    </div>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $programa['idprogramaentrenamiento'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Programa</th>
                                    <td class="fw-bold text-secondary">#<?= $programa['idprogramaentrenamiento'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del Programa</th>
                                    <td class="fw-bold text-dark fs-6">
                                        <i class="bi bi-tag-fill text-success me-1"></i><?= esc($programa['nombre'] ?? 'Sin nombre') ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Motivo de Entrenamiento</th>
                                    <td>
                                        <a href="<?= base_url('motivoentrenamiento/actual/' . $programa['idmotivoentrenamiento']) ?>" class="text-decoration-none fw-semibold">
                                            <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2">
                                                <i class="bi bi-bullseye text-warning me-1"></i><?= esc($programa['motivo_nombre']) ?>
                                            </span>
                                        </a>
                                        <?php if (!empty($programa['motivo_objetivo'])): ?>
                                            <div class="small text-muted mt-2 fst-italic">
                                                <i class="bi bi-info-circle me-1"></i><?= esc($programa['motivo_objetivo']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Total de Rutinas Asignadas</th>
                                    <td>
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2 fs-6">
                                            <i class="bi bi-collection-play text-info me-1"></i><?= !empty($programa['rutinas']) ? count($programa['rutinas']) : 0 ?> rutinas
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Rutinas y Planes Asociados al Programa -->
                    <div class="border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0">
                                <i class="bi bi-collection-play-fill text-info me-2"></i>Rutinas y Ejercicios Asociados a este Programa
                                <span class="badge bg-primary ms-2"><?= !empty($programa['rutinas']) ? count($programa['rutinas']) : 0 ?></span>
                            </h6>
                            <a href="<?= base_url('rutinaprograma/add?idprograma=' . $programa['idprogramaentrenamiento']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Vincular Rutina al Programa
                            </a>
                        </div>

                        <?php if (empty($programa['rutinas'])): ?>
                            <div class="alert alert-info d-flex align-items-center gap-2 mb-0">
                                <i class="bi bi-info-circle-fill fs-5"></i>
                                <div>
                                    Este programa aún no tiene rutinas de ejercicio vinculadas en la tabla <code>rutinaprograma</code>.
                                    <a href="<?= base_url('rutinaprograma/add?idprograma=' . $programa['idprogramaentrenamiento']) ?>" class="alert-link ms-1">Vincular una rutina ahora</a>.
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="d-flex flex-column gap-4">
                                <?php foreach ($programa['rutinas'] as $idx => $rutina): ?>
                                    <div class="card border shadow-sm">
                                        <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-info text-white">Rutina <?= $idx + 1 ?></span>
                                                <a href="<?= base_url('rutinaejecicio/actual/' . $rutina['idrutinaejercicio']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($rutina['rutina_nombre']) ?>
                                                </a>
                                                <span class="badge bg-light text-muted border">ID #<?= $rutina['idrutinaejercicio'] ?></span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <a href="<?= base_url('rutinaplan/add?idrutinaejercicio=' . $rutina['idrutinaejercicio']) ?>" class="btn btn-outline-primary btn-sm py-0 px-2" title="Agregar plan a esta rutina">
                                                    <i class="bi bi-plus me-1"></i>Agregar Plan
                                                </a>
                                                <a href="<?= base_url('rutinaprograma/actual/' . $rutina['idrutinaprograma']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Ver registro del vínculo">
                                                    <i class="bi bi-link-45deg me-1"></i>Vínculo #<?= $rutina['idrutinaprograma'] ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body p-0">
                                            <?php if (empty($rutina['planes'])): ?>
                                                <div class="p-3 text-muted small fst-italic">
                                                    No hay planes o ejercicios vinculados a esta rutina en <code>rutinaplan</code>.
                                                </div>
                                            <?php else: ?>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-bordered align-middle mb-0">
                                                        <thead class="table-light small">
                                                            <tr>
                                                                <th>Ejercicio</th>
                                                                <th class="text-center">Días</th>
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
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
