<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($objetivo)): ?>
            <?= view('layout/empty_record', ['module' => 'objetivonutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'objetivonutricional',
                'currentId' => $objetivo['idobjetivonutricional']
            ]) ?>

            <!-- Mensajes Flash de Sesión -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Ficha Principal del Objetivo Nutricional -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-bullseye text-warning me-2 fs-4"></i>Objetivo Nutricional: <?= esc($objetivo['nombre']) ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $objetivo['idobjetivonutricional'] ?></span>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-bullseye fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1"><?= esc($objetivo['nombre']) ?></h6>
                                <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-1 mt-1">
                                    Meta Nutricional
                                </span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Objetivo</th>
                                        <td class="fw-bold text-secondary">#<?= $objetivo['idobjetivonutricional'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Objetivo</th>
                                        <td class="fs-5 fw-semibold text-dark">
                                            <i class="bi bi-check2-circle text-warning me-2"></i><?= esc($objetivo['nombre']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Planes que usan esta meta</th>
                                        <td>
                                            <span class="badge bg-primary fs-6 px-3 py-1">
                                                <i class="bi bi-journal-medical me-1"></i><?= count($planes ?? []) ?> Planes de Alimentación
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('planalimentacion/add?idobjetivonutricional=' . $objetivo['idobjetivonutricional']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Crear Plan con este Objetivo
                    </a>
                    <a href="<?= base_url('objetivonutricional/listar') ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-table me-1"></i>Ver todos los objetivos
                    </a>
                </div>
            </div>

            <!-- Panel de Planes de Alimentación Asociados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-0">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-journal-medical text-primary me-2 fs-5"></i>Planes de Alimentación con este Objetivo
                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-2"><?= count($planes ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('planalimentacion/add?idobjetivonutricional=' . $objetivo['idobjetivonutricional']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-lg me-1"></i>Nuevo Plan
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($planes)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-journal-x fs-1 d-block mb-2 text-secondary"></i>
                            Actualmente no hay planes de alimentación que utilicen este objetivo nutricional.
                            <div class="mt-2">
                                <a href="<?= base_url('planalimentacion/add?idobjetivonutricional=' . $objetivo['idobjetivonutricional']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Crear el primer plan con este objetivo
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 70px;">ID</th>
                                        <th>Nombre del Plan</th>
                                        <th>Persona Asignada</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th class="text-end pe-4" style="width: 120px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($planes as $p): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">#<?= $p['idplanalimentacion'] ?></td>
                                            <td>
                                                <a href="<?= base_url('planalimentacion/actual/' . $p['idplanalimentacion']) ?>" class="fw-bold text-dark text-decoration-none hover-primary">
                                                    <?= esc($p['nombre']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <i class="bi bi-person text-secondary me-1"></i>
                                                <?= esc($p['apellidos'] . ' ' . $p['nombres']) ?>
                                            </td>
                                            <td class="small text-muted"><?= esc($p['fechainicio']) ?></td>
                                            <td class="small text-muted"><?= esc($p['fechafin'] ?: 'Indefinida') ?></td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('planalimentacion/actual/' . $p['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-primary" title="Ver plan">
                                                    <i class="bi bi-eye"></i>
                                                </a>
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
