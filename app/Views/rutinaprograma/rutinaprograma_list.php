<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-collection-play-fill text-info me-2"></i>Rutinas en Programas
        </h2>
        <p class="text-muted mb-0">Gestión de rutinas de ejercicio asignadas a cada programa de entrenamiento.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('rutinaprograma/add') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-circle me-1"></i> + Vincular Rutina a Programa
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('rutinaprograma/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de programa, motivo o rutina...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-primary fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('rutinaprograma/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 70px;">ID</th>
                        <th>Programa de Entrenamiento</th>
                        <th>Motivo</th>
                        <th>Rutina de Ejercicio</th>
                        <th class="text-center">Planes en Rutina</th>
                        <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rutinasprogramas)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron rutinas vinculadas a programas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rutinasprogramas as $rp): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $rp['idrutinaprograma'] ?></td>
                                <td>
                                    <div class="fw-bold text-dark">
                                        <a href="<?= base_url('rutinaprograma/actual/' . $rp['idrutinaprograma']) ?>" class="text-decoration-none text-dark">
                                            <?= esc($rp['programa_nombre']) ?>
                                        </a>
                                    </div>
                                    <small class="text-muted">Programa #<?= $rp['idprogramaentrenamiento'] ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-dark border border-warning">
                                        <i class="bi bi-bullseye text-warning me-1"></i><?= esc($rp['motivo_nombre']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info px-2 py-1">
                                            <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($rp['rutina_nombre']) ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                        <i class="bi bi-card-checklist me-1"></i><?= $rp['total_planes'] ?? 0 ?> <?= ($rp['total_planes'] ?? 0) == 1 ? 'plan' : 'planes' ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('rutinaprograma/actual/' . $rp['idrutinaprograma']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('rutinaprograma/edit/' . $rp['idrutinaprograma']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalDelete_<?= $rp['idrutinaprograma'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade text-start" id="modalDelete_<?= $rp['idrutinaprograma'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Vínculo</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro de desvincular la rutina <strong><?= esc($rp['rutina_nombre']) ?></strong> del programa <strong><?= esc($rp['programa_nombre']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('rutinaprograma/delete/' . $rp['idrutinaprograma']) ?>">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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

<?= $this->endSection() ?>
