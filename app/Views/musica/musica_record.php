<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($musica)): ?>
            <?= view('layout/empty_record', ['module' => 'musica']) ?>
        <?php else: ?>

            <?= view('layout/nav_toolbar', [
                'module'    => 'musica',
                'currentId' => $musica['idmusica']
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-music-note-beamed text-danger me-2 fs-4"></i>Música: <?= esc($musica['nombre']) ?>
                    </h5>
                    <span class="badge bg-danger text-white fs-6">ID #<?= $musica['idmusica'] ?></span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-music-note-beamed fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1"><?= esc($musica['nombre']) ?></h6>
                                <?php if (!empty($musica['artista'])): ?>
                                    <div class="text-muted small mb-2"><?= esc($musica['artista']) ?></div>
                                <?php endif; ?>
                                <a href="<?= esc($musica['enlace']) ?>" target="_blank" rel="noopener" class="btn btn-danger btn-sm w-100 mt-2">
                                    <i class="bi bi-play-circle-fill me-1"></i>Abrir Enlace de Música
                                </a>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Música</th>
                                        <td class="fw-bold text-secondary">#<?= $musica['idmusica'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Título / Nombre</th>
                                        <td class="fs-5 fw-bold text-dark"><?= esc($musica['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Artista / Intérprete</th>
                                        <td><?= esc($musica['artista'] ?: '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Género</th>
                                        <td><span class="badge bg-danger-subtle text-danger border border-danger-subtle"><?= esc($musica['genero'] ?: 'General') ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Enlace (URL)</th>
                                        <td>
                                            <a href="<?= esc($musica['enlace']) ?>" target="_blank" rel="noopener" class="text-break">
                                                <i class="bi bi-box-arrow-up-right me-1"></i><?= esc($musica['enlace']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Descripción</th>
                                        <td class="text-secondary small"><?= !empty($musica['descripcion']) ? nl2br(esc($musica['descripcion'])) : '-' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Entretenimientos Asociados -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-controller text-primary me-2"></i>Entretenimientos que incluyen esta Música
                        <span class="badge bg-primary ms-1"><?= count($entretenimientos ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientomusica/add?idmusica=' . $musica['idmusica']) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i>Asignar a Entretenimiento
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimientos)): ?>
                        <div class="p-4 text-center text-muted small">Esta música aún no está vinculada a ningún paquete de entretenimiento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-4">ID Relación</th>
                                        <th>Entretenimiento</th>
                                        <th>Descripción</th>
                                        <th class="text-end pe-4">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entretenimientos as $e): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">#<?= $e['identretenimientomusica'] ?></td>
                                            <td>
                                                <a href="<?= base_url('entretenimiento/actual/' . $e['identretenimiento']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($e['entretenimiento_nombre']) ?>
                                                </a>
                                            </td>
                                            <td class="small text-muted"><?= esc($e['entretenimiento_descripcion'] ?: '-') ?></td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('entretenimiento/actual/' . $e['identretenimiento']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
