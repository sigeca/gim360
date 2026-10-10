<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($plan)): ?>
            <?= view('layout/empty_record', ['module' => 'planejercicio']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'planejercicio',
                'currentId' => $plan['idplanejercicio']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-card-checklist text-info me-2"></i>Ficha de Plan de Ejercicio
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $plan['idplanejercicio'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Plan</th>
                                            <td class="fw-bold text-secondary">#<?= $plan['idplanejercicio'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ejercicio Asignado</th>
                                            <td>
                                                <a href="<?= base_url('ejercicio/actual/' . $plan['idejercicio']) ?>" class="text-decoration-none fw-bold text-dark fs-6">
                                                    <i class="bi bi-fire text-danger me-1"></i><?= esc($plan['ejercicio_nombre']) ?>
                                                </a>
                                                <?php if (!empty($plan['ejercicio_descripcion'])): ?>
                                                    <div class="small text-muted mt-1">
                                                        <?= esc(mb_strimwidth($plan['ejercicio_descripcion'], 0, 160, '...')) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Días por Semana</th>
                                            <td>
                                                <?php $diasVal = $plan['diassemanas'] ?? $plan['dias'] ?? null; ?>
                                                <?php if ($diasVal !== null && $diasVal !== ''): ?>
                                                    <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 fs-6">
                                                        <i class="bi bi-calendar3 me-1"></i><?= esc($diasVal) ?> <?= (int)$diasVal === 1 ? 'día por semana' : 'días por semana' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Repeticiones</th>
                                            <td>
                                                <?php if (isset($plan['repeticiones']) && $plan['repeticiones'] !== null && $plan['repeticiones'] !== ''): ?>
                                                    <span class="badge bg-success-subtle text-success-emphasis border border-success px-3 py-2 fs-6">
                                                        <i class="bi bi-repeat me-1"></i><?= esc($plan['repeticiones']) ?> <?= (int)$plan['repeticiones'] === 1 ? 'repetición' : 'repeticiones' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Series</th>
                                            <td>
                                                <?php if (isset($plan['series']) && $plan['series'] !== null && $plan['series'] !== ''): ?>
                                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary px-3 py-2 fs-6">
                                                        <i class="bi bi-layers me-1"></i><?= esc($plan['series']) ?> <?= (int)$plan['series'] === 1 ? 'serie' : 'series' ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Tiempo de Descanso</th>
                                            <td>
                                                <?php if (isset($plan['tiempodescanso']) && $plan['tiempodescanso'] !== null && $plan['tiempodescanso'] !== ''): ?>
                                                    <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2 fs-6">
                                                        <i class="bi bi-stopwatch text-warning me-1"></i><?= esc($plan['tiempodescanso']) ?> seg
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Peso Asignado</th>
                                            <td>
                                                <?php if (isset($plan['peso']) && $plan['peso'] !== null && $plan['peso'] !== ''): ?>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 fs-6">
                                                        <i class="bi bi-speedometer2 me-1"></i><?= number_format((float)$plan['peso'], 2) ?> kg
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

                        <!-- Columna de Media / Ejercicio Preview -->
                        <div class="col-md-5">
                            <div class="card bg-light border-0 h-100">
                                <div class="card-body text-center p-3 d-flex flex-column justify-content-center align-items-center">
                                    <?php if (!empty($plan['ejercicio_imagen'])): ?>
                                        <img src="<?= base_url('ejercicio/imagen/' . esc($plan['ejercicio_imagen'])) ?>" 
                                             alt="<?= esc($plan['ejercicio_nombre']) ?>" 
                                             class="img-fluid rounded shadow-sm mb-3" 
                                             style="max-height: 200px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="text-muted py-4">
                                            <i class="bi bi-image text-secondary fs-1 d-block mb-2"></i>
                                            <span>Sin imagen del ejercicio</span>
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= base_url('ejercicio/actual/' . $plan['idejercicio']) ?>" class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-eye me-1"></i> Ver Ficha Técnica del Ejercicio
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($youtubeId)): ?>
                        <div class="mt-4 pt-3 border-top">
                            <h6 class="fw-bold text-dark mb-3"><i class="bi bi-youtube text-danger me-2"></i>Video Demostrativo del Ejercicio</h6>
                            <div class="ratio ratio-16x9 shadow-sm rounded overflow-hidden" style="max-height: 380px;">
                                <iframe src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" title="YouTube video" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
