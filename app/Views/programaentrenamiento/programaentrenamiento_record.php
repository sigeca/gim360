<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($programa)): ?>
            <?= view('layout/empty_record', ['module' => 'programaentrenamiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'programaentrenamiento',
                'currentId' => $programa['idprogramaentrenamiento']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clipboard2-pulse-fill text-success me-2"></i>Ficha de Programa de Entrenamiento
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $programa['idprogramaentrenamiento'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Programa</th>
                                            <td class="fw-bold text-secondary">#<?= $programa['idprogramaentrenamiento'] ?></td>
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
                                            <th class="table-light text-muted">Rutina de Ejercicio</th>
                                            <td>
                                                <a href="<?= base_url('rutinaejecicio/actual/' . $programa['idrutinaejercicio']) ?>" class="text-decoration-none fw-semibold">
                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                                        <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($programa['rutina_nombre']) ?>
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ejercicio Asignado</th>
                                            <td>
                                                <a href="<?= base_url('ejercicio/actual/' . $programa['idejercicio']) ?>" class="text-decoration-none fw-bold text-dark fs-6">
                                                    <i class="bi bi-fire text-danger me-1"></i><?= esc($programa['ejercicio_nombre']) ?>
                                                </a>
                                                <?php if (!empty($programa['ejercicio_descripcion'])): ?>
                                                    <div class="small text-muted mt-1">
                                                        <?= esc(mb_strimwidth($programa['ejercicio_descripcion'], 0, 160, '...')) ?>
                                                    </div>
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
                                    <?php if (!empty($programa['ejercicio_imagen'])): ?>
                                        <img src="<?= base_url('ejercicio/imagen/' . esc($programa['ejercicio_imagen'])) ?>" 
                                             alt="<?= esc($programa['ejercicio_nombre']) ?>" 
                                             class="img-fluid rounded shadow-sm mb-3" 
                                             style="max-height: 200px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="text-muted py-4">
                                            <i class="bi bi-image text-secondary fs-1 d-block mb-2"></i>
                                            <span>Sin imagen del ejercicio</span>
                                        </div>
                                    <?php endif; ?>

                                    <a href="<?= base_url('ejercicio/actual/' . $programa['idejercicio']) ?>" class="btn btn-outline-danger btn-sm">
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
