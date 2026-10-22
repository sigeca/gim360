<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($plan)): ?>
            <?= view('layout/empty_record', ['module' => 'planpersonalizado']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'planpersonalizado',
                'currentId' => $plan['idplanpersonalizado']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-person-check-fill text-primary me-2"></i><?= esc($plan['nombre'] ?? 'Plan de Ejercicio Personalizado') ?>
                        </h5>
                        <small class="text-muted">Plan personalizado asignado a cliente</small>
                    </div>
                    <span class="badge bg-primary text-white fs-6">Plan Personalizado #<?= $plan['idplanpersonalizado'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Plan Personalizado</th>
                                            <td class="fw-bold text-secondary">#<?= $plan['idplanpersonalizado'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Plan</th>
                                            <td class="fs-5 fw-bold text-dark">
                                                <i class="bi bi-tag text-primary me-1"></i><?= esc($plan['nombre'] ?? 'Sin nombre asignado') ?>
                                            </td>
                                        </tr>
                                        <?php if (!empty($plan['cliente_nombres'])): ?>
                                        <tr>
                                            <th class="table-light text-muted">Cliente Asignado</th>
                                            <td>
                                                <a href="<?= base_url('cliente/actual/' . $plan['idcliente']) ?>" class="fw-bold text-primary text-decoration-none">
                                                    <i class="bi bi-person me-1"></i><?= esc($plan['cliente_nombres']) ?>
                                                </a>
                                                <?php if (!empty($plan['cliente_cedula'])): ?>
                                                    <span class="text-muted small ms-1">(C.I: <?= esc($plan['cliente_cedula']) ?>)</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($plan['rutina_nombre'])): ?>
                                        <tr>
                                            <th class="table-light text-muted">Rutina Personalizada</th>
                                            <td>
                                                <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-1">
                                                    <i class="bi bi-calendar2-week me-1"></i><?= esc($plan['rutina_nombre']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                        <?php if (!empty($plan['programa_nombre'])): ?>
                                        <tr>
                                            <th class="table-light text-muted">Programa Base</th>
                                            <td class="fw-semibold text-secondary">
                                                <i class="bi bi-journal-bookmark me-1"></i><?= esc($plan['programa_nombre']) ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
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
                                        <!-- NUEVOS CAMPOS: FECHA INICIO Y DURACIÓN SEMANAS -->
                                        <tr class="table-primary-subtle">
                                            <th class="table-primary text-primary-emphasis fw-bold">
                                                <i class="bi bi-calendar-check text-primary me-1"></i>Fecha de Inicio
                                            </th>
                                            <td>
                                                <?php if (!empty($plan['fechainicio'])): ?>
                                                    <span class="badge bg-primary text-white px-3 py-2 fs-6">
                                                        <i class="bi bi-calendar-event me-1"></i><?= esc($plan['fechainicio']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No asignada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr class="table-warning-subtle">
                                            <th class="table-warning text-warning-emphasis fw-bold">
                                                <i class="bi bi-hourglass-split text-warning me-1"></i>Duración (Semanas)
                                            </th>
                                            <td>
                                                <?php if (isset($plan['duracionsemana']) && $plan['duracionsemana'] !== null && $plan['duracionsemana'] !== ''): ?>
                                                    <span class="badge bg-warning text-dark border border-warning px-3 py-2 fs-6">
                                                        <i class="bi bi-clock-history me-1"></i><?= esc($plan['duracionsemana']) ?> <?= (int)$plan['duracionsemana'] === 1 ? 'semana' : 'semanas' ?>
                                                    </span>
                                                    <?php if (!empty($fechaFinEstimada)): ?>
                                                        <span class="small text-muted ms-2">
                                                            (Finaliza aprox.: <strong><?= esc($fechaFinEstimada) ?></strong>)
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Días por Semana</th>
                                            <td>
                                                <?php $diasVal = $plan['diassemanas'] ?? null; ?>
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
                                            <th class="table-light text-muted">Tiempo de Descanso</th>
                                            <td>
                                                <?php if (isset($plan['tiempodescanso']) && $plan['tiempodescanso'] !== null && $plan['tiempodescanso'] !== ''): ?>
                                                    <span class="badge bg-info-subtle text-dark border border-info px-3 py-2 fs-6">
                                                        <i class="bi bi-stopwatch text-info me-1"></i><?= esc($plan['tiempodescanso']) ?> seg
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

                                    <a href="<?= base_url('ejercicio/actual/' . $plan['idejercicio']) ?>" class="btn btn-outline-danger btn-sm mb-2">
                                        <i class="bi bi-eye me-1"></i> Ver Ficha Técnica del Ejercicio
                                    </a>

                                    <a href="<?= base_url('planpersonalizado/edit/' . $plan['idplanpersonalizado']) ?>" class="btn btn-primary btn-sm">
                                        <i class="bi bi-pencil me-1"></i> Modificar Plan y Duración
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
