<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($ejercicio)): ?>
            <?= view('layout/empty_record', ['module' => 'ejercicio']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'ejercicio',
                'currentId' => $ejercicio['idejercicio']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-fire text-danger me-2"></i>Ficha Técnica de Ejercicio
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($ejercicio['imagen'])): ?>
                            <?php if (str_contains($ejercicio['imagen'], '-start.webp')): ?>
                                <span class="badge bg-primary"><i class="bi bi-play-circle me-1"></i>Fase Inicial</span>
                            <?php elseif (str_contains($ejercicio['imagen'], '-peak.webp')): ?>
                                <span class="badge bg-success"><i class="bi bi-bullseye me-1"></i>Fase Final / Pico</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark"><i class="bi bi-image me-1"></i>Ilustración</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span class="badge bg-danger fs-6">ID #<?= $ejercicio['idejercicio'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">

                    <div class="row g-4 mb-4 align-items-start">
                        <!-- Columna de la Imagen del Ejercicio -->
                        <div class="col-md-5 col-lg-4 text-center">
                            <div class="p-3 bg-light rounded border shadow-sm">
                                <?php if (!empty($ejercicio['imagen'])): ?>
                                    <div class="position-relative">
                                        <img src="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" 
                                             alt="<?= esc($ejercicio['nombre']) ?>" 
                                             class="img-fluid rounded" 
                                             style="max-height: 290px; width: 100%; object-fit: contain; background-color: #ffffff; border-radius: 8px;">
                                    </div>
                                    <div class="mt-2 text-start small text-muted">
                                        <i class="bi bi-file-image me-1"></i><code><?= esc($ejercicio['imagen']) ?></code>
                                    </div>
                                    <div class="d-grid gap-2 mt-2">
                                        <?php if (!empty($parejaEjercicio)): ?>
                                            <a href="<?= base_url('ejercicio/actual/' . $parejaEjercicio['idejercicio']) ?>" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-arrow-left-right me-1"></i>
                                                <?= str_contains($parejaEjercicio['imagen'], '-start.webp') ? 'Ver Fase Inicial (Start)' : 'Ver Fase Final (Peak)' ?>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" target="_blank" class="btn btn-light btn-sm border text-secondary">
                                            <i class="bi bi-arrows-fullscreen me-1"></i> Ampliar Imagen
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image display-4 d-block mb-2 text-secondary"></i>
                                        <em>Sin imagen disponible</em>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Columna de Datos Técnicos -->
                        <div class="col-md-7 col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-30 text-muted">ID Ejercicio</th>
                                            <td class="fw-bold text-muted"><?= $ejercicio['idejercicio'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Ejercicio</th>
                                            <td class="fs-5 fw-bold text-dark">
                                                <?= esc($ejercicio['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Archivo Gráfico</th>
                                            <td>
                                                <?php if (!empty($ejercicio['imagen'])): ?>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-file-earmark-image text-danger me-1"></i><?= esc($ejercicio['imagen']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted"><i class="bi bi-x-circle me-1"></i>No asignado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Demostración / Video</th>
                                            <td>
                                                <?php if (!empty($ejercicio['urlvideo'])): ?>
                                                    <a href="<?= esc($ejercicio['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-youtube me-1"></i> Ver Video Tutorial <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                    </a>
                                                    <small class="d-block text-muted font-monospace mt-1"><?= esc($ejercicio['urlvideo']) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted"><i class="bi bi-camera-video-off me-1"></i>Sin enlace de video</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Descripción y Técnica -->
                    <div class="mb-4">
                        <h6 class="fw-bold text-dark mb-2">
                            <i class="bi bi-card-text text-danger me-2"></i>Descripción y Ejecución Técnica:
                        </h6>
                        <div class="p-3 bg-light rounded border text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                            <?= !empty($ejercicio['descripcion']) ? nl2br(esc($ejercicio['descripcion'])) : '<em class="text-muted">No se ha registrado una descripción para este ejercicio.</em>' ?>
                        </div>
                    </div>

                    <!-- Reproductor de Video si es YouTube -->
                    <?php if (!empty($youtubeId)): ?>
                        <div class="mt-4 border-top pt-3">
                            <h6 class="fw-bold text-dark mb-3">
                                <i class="bi bi-play-circle-fill text-danger me-2"></i>Demostración en Video:
                            </h6>
                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm">
                                <iframe src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" title="<?= esc($ejercicio['nombre']) ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
