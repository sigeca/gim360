<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <?php if (empty($medicamento)): ?>
            <?= view('layout/empty_record', ['module' => 'medicamento']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'medicamento', 'currentId' => $medicamento['idmedicamento']]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-capsule text-success me-2 fs-4"></i>Medicamento: <?= esc($medicamento['nombre']) ?>
                    </h5>
                    <span class="badge bg-success text-white fs-6">ID #<?= $medicamento['idmedicamento'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-prescription fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($medicamento['nombre']) ?></h5>
                                <div class="text-muted small"><?= esc($medicamento['presentacion'] ?: 'Sin presentación') ?></div>
                                <span class="badge bg-success-subtle text-success border mt-2">
                                    Conc.: <?= esc($medicamento['concentracion'] ?: 'N/A') ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <th class="table-light w-35 text-muted">Principio Activo</th>
                                    <td class="fs-6 fw-bold text-primary"><?= esc($medicamento['principioactivo'] ?: '-') ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Concentración y Presentación</th>
                                    <td><?= esc($medicamento['concentracion'] ?: '-') ?> | <?= esc($medicamento['presentacion'] ?: '-') ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Laboratorio Fabricante</th>
                                    <td><?= esc($medicamento['laboratorio'] ?: '-') ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Descripción</th>
                                    <td class="text-secondary"><?= !empty($medicamento['descripcion']) ? nl2br(esc($medicamento['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Indicaciones Terapéuticas</th>
                                    <td class="text-secondary"><?= !empty($medicamento['indicaciones']) ? nl2br(esc($medicamento['indicaciones'])) : '<span class="text-muted fst-italic">Sin indicaciones</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Contraindicaciones</th>
                                    <td class="text-danger small"><?= !empty($medicamento['contraindicaciones']) ? nl2br(esc($medicamento['contraindicaciones'])) : '<span class="text-muted fst-italic">Ninguna conocida</span>' ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medicaciones donde se receta este medicamento -->
            <div class="card card-custom bg-white shadow-sm border-start border-4 border-info mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-diagram-3-fill text-info me-2"></i>Medicaciones y Tratamientos donde se prescribe este medicamento
                    </h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($medicamento['medicaciones'])): ?>
                        <div class="p-3 text-center text-muted small">Este medicamento aún no está vinculado a ninguna medicación protocolizada.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Medicación / Protocolo</th>
                                        <th>Afección Asociada</th>
                                        <th>Dosis e Instrucciones</th>
                                        <th class="text-end pe-3">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($medicamento['medicaciones'] as $med): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">#<?= $med['idmedicacionmedicamento'] ?></td>
                                            <td><a href="<?= base_url('medicacion/actual/' . $med['idmedicacion']) ?>" class="fw-bold text-primary"><?= esc($med['medicacion_nombre']) ?></a></td>
                                            <td><span class="badge bg-danger-subtle text-danger border"><?= esc($med['afeccion_nombre']) ?></span></td>
                                            <td class="small text-secondary"><?= esc($med['dosis'] ?: '-') ?> (<?= esc($med['frecuencia'] ?: '-') ?>)</td>
                                            <td class="text-end pe-3">
                                                <a href="<?= base_url('medicacion/actual/' . $med['idmedicacion']) ?>" class="btn btn-sm btn-outline-primary"><i class="bi bi-eye"></i></a>
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
