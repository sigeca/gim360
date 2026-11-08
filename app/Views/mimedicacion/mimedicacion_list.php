<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-11">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-person-heart text-info me-2"></i>Catálogo de Mi Medicación</h4>
                    <p class="text-muted small mb-0">Tratamientos y medicamentos personalizados por persona/cliente para aliviar afecciones.</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="<?= base_url('mimedicacion/add') ?>" class="btn btn-info text-dark fw-bold"><i class="bi bi-plus-lg me-1"></i>+ Personalizar Nuevo</a>
                    <a href="<?= base_url('medicacion') ?>" class="btn btn-outline-primary"><i class="bi bi-prescription2 me-1"></i>Medicaciones Base</a>
                </div>
            </div>
        </div>

        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Persona Propietaria</th>
                            <th>Tratamiento Personal</th>
                            <th>Afección</th>
                            <th>Medicación Base</th>
                            <th class="text-center">Medicamentos</th>
                            <th>Estado</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($misMedicaciones)): ?>
                            <tr><td colspan="8" class="text-center py-4 text-muted">No hay registros de Mi Medicación</td></tr>
                        <?php else: ?>
                            <?php foreach ($misMedicaciones as $m): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $m['idmimedicacion'] ?></td>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $m['idpersona']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($m['persona_apellidos'] . ' ' . $m['persona_nombres']) ?>
                                        </a>
                                        <div class="text-muted small">C.I. <?= esc($m['persona_cedula']) ?></div>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('mimedicacion/actual/' . $m['idmimedicacion']) ?>" class="fw-bold text-primary text-decoration-none">
                                            <?= esc($m['nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php if (!empty($m['afeccion_nombre'])): ?>
                                            <span class="badge bg-danger-subtle text-danger border"><?= esc($m['afeccion_nombre']) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($m['idmedicacion'])): ?>
                                            <span class="badge bg-light text-dark border"><?= esc($m['base_medicacion_nombre'] ?: ('#' . $m['idmedicacion'])) ?></span>
                                        <?php else: ?>
                                            <span class="text-muted small fst-italic">Desde cero</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center"><span class="badge bg-success-subtle text-success border"><?= (int)$m['total_medicamentos'] ?></span></td>
                                    <td><span class="badge bg-<?= ($m['estado'] === 'Activa') ? 'success' : 'secondary' ?>"><?= esc($m['estado'] ?: 'Activa') ?></span></td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('mimedicacion/actual/' . $m['idmimedicacion']) ?>" class="btn btn-outline-primary" title="Ver"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('mimedicacion/edit/' . $m['idmimedicacion']) ?>" class="btn btn-outline-secondary" title="Editar"><i class="bi bi-pencil"></i></a>
                                            <a href="<?= base_url('mimedicacion/delete/' . $m['idmimedicacion']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar tratamiento de Mi Medicación?');"><i class="bi bi-trash"></i></a>
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
