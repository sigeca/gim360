<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-capsule text-success me-2"></i>Catálogo de Medicamentos</h4>
                    <p class="text-muted small mb-0">Medicamentos para el cuidado, recuperación muscular y alivio de afecciones en deportistas.</p>
                </div>
                <a href="<?= base_url('medicamento/add') ?>" class="btn btn-success"><i class="bi bi-plus-lg me-1"></i>+ Nuevo Medicamento</a>
            </div>
        </div>

        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Medicamento</th>
                            <th>Principio Activo</th>
                            <th>Concentración / Forma</th>
                            <th>Laboratorio</th>
                            <th class="text-center">En Protocolos</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($medicamentos)): ?>
                            <tr><td colspan="7" class="text-center py-4 text-muted">No hay medicamentos registrados</td></tr>
                        <?php else: ?>
                            <?php foreach ($medicamentos as $m): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $m['idmedicamento'] ?></td>
                                    <td>
                                        <a href="<?= base_url('medicamento/actual/' . $m['idmedicamento']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($m['nombre']) ?>
                                        </a>
                                    </td>
                                    <td><span class="text-primary fw-semibold"><?= esc($m['principioactivo'] ?: '-') ?></span></td>
                                    <td><?= esc($m['concentracion'] ?: '-') ?> <span class="badge bg-light text-dark border"><?= esc($m['presentacion'] ?: '-') ?></span></td>
                                    <td class="text-secondary small"><?= esc($m['laboratorio'] ?: '-') ?></td>
                                    <td class="text-center"><span class="badge bg-success-subtle text-success border"><?= (int)$m['total_medicaciones'] ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('medicamento/actual/' . $m['idmedicamento']) ?>" class="btn btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('medicamento/edit/' . $m['idmedicamento']) ?>" class="btn btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= base_url('medicamento/delete/' . $m['idmedicamento']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar medicamento?');"><i class="bi bi-trash"></i></a>
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
