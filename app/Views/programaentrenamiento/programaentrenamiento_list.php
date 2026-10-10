<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-clipboard2-pulse-fill text-success me-2"></i>Programas de Entrenamiento</h2>
        <p class="text-muted mb-0">Listado general de la tabla relacional <code>programaentrenamiento</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('programaentrenamiento/add') ?>" class="btn btn-success fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Programa
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('programaentrenamiento/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de programa, motivo, rutina o ejercicio...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-success fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('programaentrenamiento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Nombre del Programa</th>
                        <th>Motivo de Entrenamiento</th>
                        <th>Rutinas Asignadas</th>
                        <th class="text-center">Total Planes</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($programas)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron registros de programas de entrenamiento.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($programas as $p): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $p['idprogramaentrenamiento'] ?></td>
                                <td>
                                    <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="fw-bold text-dark text-decoration-none">
                                        <?= esc($p['nombre'] ?? 'Sin nombre') ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-2">
                                        <i class="bi bi-bullseye text-warning me-1"></i><?= esc($p['motivo_nombre']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?= base_url('rutinaprograma?q=' . urlencode($p['nombre'])) ?>" class="text-decoration-none" title="Ver rutinas asignadas a este programa">
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                            <i class="bi bi-collection-play text-info me-1"></i><?= (int)($p['total_rutinas'] ?? 0) ?> <?= (int)($p['total_rutinas'] ?? 0) === 1 ? 'rutina' : 'rutinas' ?>
                                        </span>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2">
                                        <i class="bi bi-card-checklist me-1"></i><?= (int)($p['total_planes'] ?? 0) ?> <?= (int)($p['total_planes'] ?? 0) === 1 ? 'plan' : 'planes' ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('programaentrenamiento/edit/' . $p['idprogramaentrenamiento']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
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
