<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card card-custom bg-white border-0 shadow-sm mb-4">
            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="fw-bold mb-1 text-dark"><i class="bi bi-capsule text-info me-2"></i>Medicamentos en Mi Medicación</h4>
                    <p class="text-muted small mb-0">Listado de medicamentos asignados a las prescripciones personales de cada usuario.</p>
                </div>
                <a href="<?= base_url('mimedicacionmedicamento/add') ?>" class="btn btn-info text-dark fw-bold"><i class="bi bi-plus-lg me-1"></i>+ Vincular Medicamento</a>
            </div>
        </div>
        <div class="card card-custom bg-white border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">ID</th>
                            <th>Mi Medicación</th>
                            <th>Persona</th>
                            <th>Medicamento</th>
                            <th>Dosis / Frecuencia</th>
                            <th class="text-end pe-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($relaciones)): ?>
                            <tr><td colspan="6" class="text-center py-4 text-muted">No hay registros</td></tr>
                        <?php else: ?>
                            <?php foreach ($relaciones as $r): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">#<?= $r['idmimedicacionmedicamento'] ?></td>
                                    <td><a href="<?= base_url('mimedicacion/actual/' . $r['idmimedicacion']) ?>" class="fw-bold"><?= esc($r['mimedicacion_nombre']) ?></a></td>
                                    <td><?= esc($r['persona_apellidos'] . ' ' . $r['persona_nombres']) ?></td>
                                    <td><a href="<?= base_url('medicamento/actual/' . $r['idmedicamento']) ?>" class="fw-bold text-success"><?= esc($r['medicamento_nombre']) ?></a></td>
                                    <td><?= esc($r['dosis'] ?: '-') ?> <span class="text-secondary small">(<?= esc($r['frecuencia'] ?: '-') ?>)</span></td>
                                    <td class="text-end pe-3">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('mimedicacionmedicamento/actual/' . $r['idmimedicacionmedicamento']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('mimedicacionmedicamento/delete/' . $r['idmimedicacionmedicamento']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Desvincular?');"><i class="bi bi-trash"></i></a>
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
