<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<?php $mod = $module ?? 'rutinaejecicio'; ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-calendar2-week-fill text-info me-2"></i>Catálogo de Rutinas de Ejercicio</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>rutinaejecicio</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url($mod . '/add') ?>" class="btn btn-info text-white fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nueva Rutina
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url($mod . '/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de rutina de ejercicio...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-info text-white fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url($mod . '/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4">ID</th>
                        <th>Nombre de la Rutina</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rutinas)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No se encontraron registros de rutinas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rutinas as $r): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $r['idrutinaejercicio'] ?></td>
                                <td class="fw-semibold text-dark fs-6">
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                        <i class="bi bi-card-checklist text-info me-1"></i><?= esc($r['nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url($mod . '/actual/' . $r['idrutinaejercicio']) ?>" class="btn btn-outline-primary" title="Ver Ficha del Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url($mod . '/edit/' . $r['idrutinaejercicio']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
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
