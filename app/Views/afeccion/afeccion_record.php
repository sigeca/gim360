<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (empty($afeccion)): ?>
            <?= view('layout/empty_record', ['module' => 'afeccion']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'afeccion', 'currentId' => $afeccion['idafeccion']]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-heart-pulse-fill text-danger me-2 fs-4"></i>Afección Médica: <?= esc($afeccion['nombre']) ?>
                    </h5>
                    <span class="badge bg-danger text-white fs-6">ID #<?= $afeccion['idafeccion'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-danger bg-opacity-10 text-danger d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-bandaid fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($afeccion['nombre']) ?></h5>
                                <span class="badge bg-danger-subtle text-danger border mt-2">
                                    <?= count($afeccion['medicaciones'] ?? []) ?> Tratamientos / Medicaciones
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <th class="table-light w-35 text-muted">Nombre de la Afección</th>
                                    <td class="fs-5 fw-bold text-dark"><?= esc($afeccion['nombre']) ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Descripción Clínica</th>
                                    <td class="text-secondary"><?= !empty($afeccion['descripcion']) ? nl2br(esc($afeccion['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Síntomas Característicos</th>
                                    <td class="text-secondary"><?= !empty($afeccion['sintomas']) ? nl2br(esc($afeccion['sintomas'])) : '<span class="text-muted fst-italic">Sin síntomas registrados</span>' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicaciones recomendadas para esta afección -->
            <div class="card card-custom bg-white shadow-sm border-start border-4 border-primary mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-prescription2 text-primary me-2"></i>Medicaciones / Protocolos para esta afección
                        <span class="badge bg-primary ms-1"><?= count($afeccion['medicaciones'] ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('medicacion/add?idafeccion=' . $afeccion['idafeccion']) ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i>Crear Medicación para esta afección
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($afeccion['medicaciones'])): ?>
                        <div class="p-3 text-center text-muted small">No hay protocolos de medicación registrados para esta afección.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Medicación / Tratamiento</th>
                                        <th>Duración</th>
                                        <th>Medicamentos Contemplados</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($afeccion['medicaciones'] as $med): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">#<?= $med['idmedicacion'] ?></td>
                                            <td>
                                                <a href="<?= base_url('medicacion/actual/' . $med['idmedicacion']) ?>" class="fw-bold text-primary text-decoration-none">
                                                    <?= esc($med['nombre']) ?>
                                                </a>
                                            </td>
                                            <td><span class="badge bg-light text-dark border"><?= esc($med['duracion'] ?: 'Indefinida') ?></span></td>
                                            <td>
                                                <?php foreach ($med['medicamentos'] ?? [] as $m): ?>
                                                    <span class="badge bg-info-subtle text-dark border me-1">
                                                        <i class="bi bi-capsule me-1"></i><?= esc($m['medicamento_nombre']) ?>
                                                    </span>
                                                <?php endforeach; ?>
                                            </td>
                                            <td class="text-end pe-3">
                                                <a href="<?= base_url('medicacion/actual/' . $med['idmedicacion']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i> Ver</a>
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
