<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-bullseye text-warning me-2"></i>Catálogo de Motivos de Entrenamiento</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>motivoentrenamiento</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('motivoentrenamiento/add') ?>" class="btn btn-warning text-dark fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Motivo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('motivoentrenamiento/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre u objetivo de entrenamiento...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-warning text-dark fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('motivoentrenamiento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th style="width: 80px;">Foto</th>
                        <th>Nombre del Motivo</th>
                        <th>Dimensión</th>
                        <th>Objetivo / Necesidad Física</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($motivos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron registros de motivos de entrenamiento.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($motivos as $m): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $m['idmotivoentrenamiento'] ?></td>
                                <td>
                                    <?php if (!empty($m['imagen'])): ?>
                                        <img src="<?= base_url('repositorio/motivos/' . esc($m['imagen'])) ?>" 
                                             onerror="this.onerror=null; this.src='<?= base_url('motivoentrenamiento/imagen/' . esc($m['imagen'])) ?>';"
                                             alt="<?= esc($m['nombre']) ?>" 
                                             class="rounded shadow-sm" 
                                             style="width: 65px; height: 45px; object-fit: cover;">
                                    <?php else: ?>
                                        <div class="bg-light rounded text-muted text-center py-2" style="width: 65px; height: 45px;">
                                            <i class="bi bi-image text-secondary"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="fw-semibold text-dark fs-6">
                                    <?= esc($m['nombre']) ?>
                                </td>
                                <td>
                                    <?php if (!empty($m['dimension'])): ?>
                                        <span class="badge <?= $m['dimension'] === 'Salud' ? 'bg-success-subtle text-success border border-success' : 'bg-primary-subtle text-primary border border-primary' ?> px-2 py-1">
                                            <i class="bi <?= $m['dimension'] === 'Salud' ? 'bi-heart-pulse' : 'bi-stars' ?> me-1"></i>
                                            <?= esc($m['dimension']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-muted small" style="max-width: 380px;">
                                    <?php if (!empty($m['objetivo'])): ?>
                                        <?= esc(mb_strimwidth($m['objetivo'], 0, 120, '...')) ?>
                                    <?php else: ?>
                                        <span class="fst-italic text-secondary">Sin descripción de objetivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('motivoentrenamiento/actual/' . $m['idmotivoentrenamiento']) ?>" class="btn btn-outline-primary" title="Ver Ficha del Registro">
                                            <i class="bi bi-eye"></i> Ficha
                                        </a>
                                        <a href="<?= base_url('motivoentrenamiento/edit/' . $m['idmotivoentrenamiento']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
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
