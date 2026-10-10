<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rutinaplan)): ?>
            <?= view('layout/empty_record', ['module' => 'rutinaplan']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'rutinaplan',
                'currentId' => $rutinaplan['id_rutina_plan']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-diagram-3 text-warning me-2"></i>Ficha de Rutina y Plan
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rutinaplan['id_rutina_plan'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Rutina-Plan</th>
                                            <td class="fw-bold text-secondary">#<?= $rutinaplan['id_rutina_plan'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Rutina de Ejercicio</th>
                                            <td>
                                                <a href="<?= base_url('rutinaejecicio/actual/' . $rutinaplan['idrutinaejercicio']) ?>" class="text-decoration-none fw-semibold">
                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                                        <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($rutinaplan['rutina_nombre']) ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Plan de Ejercicio</th>
                                            <td>
                                                <a href="<?= base_url('planejercicio/actual/' . $rutinaplan['idplanejercicio']) ?>" class="text-decoration-none fw-semibold">
                                                    <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2">
                                                        <i class="bi bi-card-checklist me-1"></i>Plan #<?= $rutinaplan['idplanejercicio'] ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ejercicio Asignado</th>
                                            <td>
                                                <a href="<?= base_url('ejercicio/actual/' . $rutinaplan['idejercicio']) ?>" class="text-decoration-none fw-bold text-dark fs-6">
                                                    <i class="bi bi-fire text-danger me-1"></i><?= esc($rutinaplan['ejercicio_nombre']) ?>
                                                </a>
                                                <?php if (!empty($rutinaplan['ejercicio_descripcion'])): ?>
                                                    <div class="small text-muted mt-1">
                                                        <?= esc(mb_strimwidth($rutinaplan['ejercicio_descripcion'], 0, 160, '...')) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Días de Entrenamiento</th>
                                            <td>
                                                <?php if (isset($rutinaplan['plan_dias']) && $rutinaplan['plan_dias'] !== null && $rutinaplan['plan_dias'] !== ''): ?>
                                                    <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 fs-6">
                                                        <i class="bi bi-calendar3 me-1"></i><?= esc($rutinaplan['plan_dias']) ?> <?= (int)$rutinaplan['plan_dias'] === 1 ? 'día' : 'días' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Repeticiones</th>
                                            <td>
                                                <?php if (isset($rutinaplan['plan_repeticiones']) && $rutinaplan['plan_repeticiones'] !== null && $rutinaplan['plan_repeticiones'] !== ''): ?>
                                                    <span class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2 fs-6">
                                                        <i class="bi bi-repeat me-1"></i><?= esc($rutinaplan['plan_repeticiones']) ?> <?= (int)$rutinaplan['plan_repeticiones'] === 1 ? 'repetición' : 'repeticiones' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Series</th>
                                            <td>
                                                <?php if (isset($rutinaplan['plan_series']) && $rutinaplan['plan_series'] !== null && $rutinaplan['plan_series'] !== ''): ?>
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 fs-6">
                                                        <i class="bi bi-layers me-1"></i><?= esc($rutinaplan['plan_series']) ?> <?= (int)$rutinaplan['plan_series'] === 1 ? 'serie' : 'series' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Tiempo de Descanso</th>
                                            <td>
                                                <?php if (isset($rutinaplan['plan_tiempodescanso']) && $rutinaplan['plan_tiempodescanso'] !== null && $rutinaplan['plan_tiempodescanso'] !== ''): ?>
                                                    <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2 fs-6">
                                                        <i class="bi bi-stopwatch text-warning me-1"></i><?= esc($rutinaplan['plan_tiempodescanso']) ?> seg
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Peso Asignado</th>
                                            <td>
                                                <?php if (isset($rutinaplan['plan_peso']) && $rutinaplan['plan_peso'] !== null && $rutinaplan['plan_peso'] !== ''): ?>
                                                    <span class="badge bg-danger-subtle text-danger-emphasis border border-danger px-3 py-2 fs-6">
                                                        <i class="bi bi-speedometer2 me-1"></i><?= number_format((float)$rutinaplan['plan_peso'], 2) ?> kg
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Panel Lateral: Imagen y Video del Ejercicio -->
                        <div class="col-md-5">
                            <div class="card h-100 bg-light border">
                                <div class="card-header bg-white py-2 fw-semibold text-secondary small">
                                    <i class="bi bi-image me-1"></i>Multimedia del Ejercicio
                                </div>
                                <div class="card-body text-center p-3 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($rutinaplan['ejercicio_imagen'])): ?>
                                        <img src="<?= base_url('ejercicio/imagen/' . esc($rutinaplan['ejercicio_imagen'])) ?>" 
                                             alt="<?= esc($rutinaplan['ejercicio_nombre']) ?>" 
                                             class="img-fluid rounded shadow-sm mb-3" 
                                             style="max-height: 200px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="p-4 bg-white border rounded text-muted mb-3 w-100">
                                            <i class="bi bi-image fs-1 d-block text-secondary mb-2"></i>
                                            <small>Sin imagen registrada</small>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($youtubeId)): ?>
                                        <div class="w-100 mt-2">
                                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                                                <iframe src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" 
                                                        title="Video del Ejercicio" 
                                                        allowfullscreen></iframe>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="d-grid gap-2 w-100 mt-3">
                                        <a href="<?= base_url('ejercicio/actual/' . $rutinaplan['idejercicio']) ?>" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-fire me-1"></i>Ver Ficha del Ejercicio
                                        </a>
                                        <a href="<?= base_url('planejercicio/actual/' . $rutinaplan['idplanejercicio']) ?>" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-card-checklist me-1"></i>Ver Plan de Ejercicio
                                        </a>
                                        <a href="<?= base_url('rutinaejecicio/actual/' . $rutinaplan['idrutinaejercicio']) ?>" class="btn btn-outline-info btn-sm">
                                            <i class="bi bi-calendar2-week me-1"></i>Ver Rutina de Ejercicio
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
