<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-heart-pulse-fill text-danger me-2"></i>Catálogo de Afecciones Médicas</h4>
                    <p class="text-muted small mb-0">Enfermedades, lesiones, afecciones musculares y respiratorias atendidas en Gim360.</p>
                </div>
                <a href="<?= base_url('afeccion/add') ?>" class="btn btn-danger"><i class="bi bi-plus-lg me-1"></i>+ Nueva Afección</a>
            </div>
        </div>

        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nombre Afección</th>
                            <th>Descripción</th>
                            <th>Síntomas</th>
                            <th class="text-center">Medicaciones</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($afecciones)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">No hay afecciones registradas</td></tr>
                        <?php else: ?>
                            <?php foreach ($afecciones as $a): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $a['idafeccion'] ?></td>
                                    <td>
                                        <a href="<?= base_url('afeccion/actual/' . $a['idafeccion']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($a['nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="text-secondary small text-truncate" style="max-width: 250px;"><?= esc($a['descripcion'] ?: '-') ?></td>
                                    <td class="text-secondary small text-truncate" style="max-width: 200px;"><?= esc($a['sintomas'] ?: '-') ?></td>
                                    <td class="text-center"><span class="badge bg-danger-subtle text-danger border"><?= (int)$a['total_medicaciones'] ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('afeccion/actual/' . $a['idafeccion']) ?>" class="btn btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('afeccion/edit/' . $a['idafeccion']) ?>" class="btn btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= base_url('afeccion/delete/' . $a['idafeccion']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar afección?');"><i class="bi bi-trash"></i></a>
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
