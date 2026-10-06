<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($ejercicioCliente)): ?>
            <?= view('layout/empty_record', ['module' => 'ejerciciocliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'ejerciciocliente',
                'currentId' => $ejercicioCliente['idejerciciocliente']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-walking text-primary me-2"></i>Ficha de Ejercicio Realizado por Cliente
                    </h5>
                    <span class="badge bg-primary fs-6">ID Registro #<?= $ejercicioCliente['idejerciciocliente'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Registro</th>
                                    <td class="fw-bold text-muted"><?= $ejercicioCliente['idejerciciocliente'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Cliente</th>
                                    <td>
                                        <a href="<?= base_url('cliente/actual/' . $ejercicioCliente['idcliente']) ?>" class="fs-6 fw-bold text-dark text-decoration-none">
                                            <?= esc($ejercicioCliente['cliente_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace">Cédula: <?= esc($ejercicioCliente['cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Ejercicio Asignado</th>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <?php if (!empty($ejercicioCliente['ejercicio_imagen'])): ?>
                                                <a href="<?= base_url('ejercicio/actual/' . $ejercicioCliente['idejercicio']) ?>">
                                                    <img src="<?= base_url('ejercicio/imagen/' . esc($ejercicioCliente['ejercicio_imagen'])) ?>" 
                                                         alt="<?= esc($ejercicioCliente['ejercicio_nombre']) ?>" 
                                                         class="rounded border bg-light" 
                                                         style="width: 50px; height: 50px; object-fit: contain; padding: 2px;">
                                                </a>
                                            <?php endif; ?>
                                            <div>
                                                <a href="<?= base_url('ejercicio/actual/' . $ejercicioCliente['idejercicio']) ?>" class="fs-6 fw-bold text-danger text-decoration-none">
                                                    <i class="bi bi-fire me-1"></i><?= esc($ejercicioCliente['ejercicio_nombre']) ?>
                                                </a>
                                                <?php if (!empty($ejercicioCliente['ejercicio_imagen'])): ?>
                                                    <div class="small text-muted font-monospace"><?= esc($ejercicioCliente['ejercicio_imagen']) ?></div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Fecha de Realización</th>
                                    <td class="fs-6 fw-semibold text-dark">
                                        <i class="bi bi-calendar-check text-primary me-2"></i>
                                        <?= date('d/m/Y', strtotime($ejercicioCliente['fecha'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Duración del Ejercicio</th>
                                    <td>
                                        <span class="badge bg-success fs-6 px-3 py-2 font-monospace">
                                            <i class="bi bi-stopwatch me-1"></i><?= $ejercicioCliente['duracionminutos'] ?> minutos
                                        </span>
                                    </td>
                                </tr>
                                <?php if (!empty($ejercicioCliente['urlvideo'])): ?>
                                <tr>
                                    <th class="table-light text-muted">Video Tutorial</th>
                                    <td>
                                        <a href="<?= esc($ejercicioCliente['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-youtube me-1"></i> Ver Video Tutorial <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if (!empty($ejercicioCliente['ejercicio_descripcion'])): ?>
                        <div class="mb-3">
                            <h6 class="fw-bold text-muted small text-uppercase mb-2">
                                <i class="bi bi-info-circle me-1"></i>Instrucciones Técnicas del Ejercicio:
                            </h6>
                            <div class="p-3 bg-light rounded border text-secondary small">
                                <?= nl2br(esc($ejercicioCliente['ejercicio_descripcion'])) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($youtubeId)): ?>
                        <div class="mt-4 border-top pt-3">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-play-circle-fill text-danger me-2"></i>Video Demostrativo del Ejercicio:
                            </h6>
                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                                <iframe src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" title="<?= esc($ejercicioCliente['ejercicio_nombre']) ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
