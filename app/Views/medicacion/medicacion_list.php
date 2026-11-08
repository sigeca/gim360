<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-prescription2 text-primary me-2"></i>Catálogo de Medicaciones / Protocolos Terapéuticos</h4>
                    <p class="text-muted small mb-0">Protocolos médicos y recetas recomendadas para tratar y aliviar afecciones.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('medicacion/add') ?>" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>+ Nueva Medicación</a>
                    <a href="<?= base_url('mimedicacion') ?>" class="btn btn-outline-info text-dark"><i class="bi bi-person-heart me-1"></i>Mi Medicación</a>
                </div>
            </div>
        </div>

        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Medicación / Protocolo</th>
                            <th>Afección Asociada</th>
                            <th>Duración</th>
                            <th class="text-center">Medicamentos</th>
                            <th class="text-center">Personalizaciones</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($medicaciones)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">No hay medicaciones registradas</td></tr>
                        <?php else: ?>
                            <?php foreach ($medicaciones as $m): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $m['idmedicacion'] ?></td>
                                    <td>
                                        <a href="<?= base_url('medicacion/actual/' . $m['idmedicacion']) ?>" class="fw-bold text-primary text-decoration-none">
                                            <?= esc($m['nombre']) ?>
                                        </a>
                                        <div class="text-muted small text-truncate" style="max-width: 250px;"><?= esc($m['descripcion'] ?: '') ?></div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('afeccion/actual/' . $m['idafeccion']) ?>" class="badge bg-danger-subtle text-danger border text-decoration-none">
                                            <i class="bi bi-heart-pulse me-1"></i><?= esc($m['afeccion_nombre']) ?>
                                        </a>
                                    </td>
                                    <td><span class="badge bg-light text-dark border"><?= esc($m['duracion'] ?: '-') ?></span></td>
                                    <td class="text-center"><span class="badge bg-success-subtle text-success border"><?= (int)$m['total_medicamentos'] ?></span></td>
                                    <td class="text-center"><span class="badge bg-info-subtle text-info border"><?= (int)$m['total_personalizaciones'] ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('mimedicacion/add?idmedicacion=' . $m['idmedicacion']) ?>" class="btn btn-outline-info" title="Personalizar en Mi Medicación"><i class="bi bi-person-check"></i></a>
                                            <a href="<?= base_url('medicacion/actual/' . $m['idmedicacion']) ?>" class="btn btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('medicacion/edit/' . $m['idmedicacion']) ?>" class="btn btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= base_url('medicacion/delete/' . $m['idmedicacion']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar medicación?');"><i class="bi bi-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
