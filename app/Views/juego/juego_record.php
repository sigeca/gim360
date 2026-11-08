<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($juego)): ?>
            <?= view('layout/empty_record', ['module' => 'juego']) ?>
        <?php else: ?>

            <?= view('layout/nav_toolbar', [
                'module'    => 'juego',
                'currentId' => $juego['idjuego']
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-joystick text-success me-2 fs-4"></i>Juego Tradicional: <?= esc($juego['nombre']) ?>
                    </h5>
                    <span class="badge bg-success text-white fs-6">ID #<?= $juego['idjuego'] ?></span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-joystick fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1"><?= esc($juego['nombre']) ?></h6>
                                <span class="badge bg-success-subtle text-success border border-success-subtle mb-2"><?= esc($juego['categoria'] ?: 'Tradicional') ?></span>
                                <a href="<?= esc($juego['enlace']) ?>" target="_blank" rel="noopener" class="btn btn-success btn-sm w-100 mt-2">
                                    <i class="bi bi-controller me-1"></i>Jugar Ahora
                                </a>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Juego</th>
                                        <td class="fw-bold text-secondary">#<?= $juego['idjuego'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Juego</th>
                                        <td class="fs-5 fw-bold text-dark"><?= esc($juego['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Categoría</th>
                                        <td><span class="badge bg-success-subtle text-success border"><?= esc($juego['categoria'] ?: 'Tradicional Básico') ?></span></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Enlace (URL)</th>
                                        <td>
                                            <a href="<?= esc($juego['enlace']) ?>" target="_blank" rel="noopener" class="text-break">
                                                <i class="bi bi-box-arrow-up-right me-1"></i><?= esc($juego['enlace']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Descripción</th>
                                        <td class="text-secondary small"><?= !empty($juego['descripcion']) ? nl2br(esc($juego['descripcion'])) : '-' ?></td>
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
                        <i class="bi bi-controller text-primary me-2"></i>Entretenimientos que incluyen este Juego
                        <span class="badge bg-primary ms-1"><?= count($entretenimientos ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientojuego/add?idjuego=' . $juego['idjuego']) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i>Asignar a Entretenimiento
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimientos)): ?>
                        <div class="p-4 text-center text-muted small">Este juego aún no está vinculado a ningún paquete de entretenimiento.</div>
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
                                            <td class="ps-4 fw-bold text-muted">#<?= $e['identretenimientojuego'] ?></td>
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
