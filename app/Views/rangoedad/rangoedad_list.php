<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-bounding-box text-info me-2"></i>Catálogo de Rangos de Edad</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>rangoedad</code> para clasificación de programas de entrenamiento.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('rangoedad/add') ?>" class="btn btn-info text-white fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Rango de Edad
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('rangoedad/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de rango, edad mínima o edad máxima...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-info text-white fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('rangoedad/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom bg-white shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nombre del Rango</th>
                        <th class="text-center">Edad Mínima</th>
                        <th class="text-center">Edad Máxima</th>
                        <th class="text-center">Intervalo Etario</th>
                        <th class="text-center">Programas Asignados</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rangos)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron registros de rangos de edad.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rangos as $r): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $r['idrangoedad'] ?></td>
                                <td class="fw-semibold text-dark fs-6">
                                    <span class="badge bg-info-subtle text-dark border border-info px-3 py-2">
                                        <i class="bi bi-tag-fill text-info me-1"></i><?= esc($r['nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-center fw-bold text-primary">
                                    <?= (int)$r['edadminima'] ?> años
                                </td>
                                <td class="text-center fw-bold text-danger">
                                    <?= (int)$r['edadmaxima'] ?> años
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark border px-2 py-1">
                                        <i class="bi bi-calendar-range text-info me-1"></i><?= (int)$r['edadminima'] ?> - <?= (int)$r['edadmaxima'] ?> años
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">
                                        <i class="bi bi-clipboard2-pulse me-1"></i><?= (int)($r['total_programas'] ?? 0) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('rangoedad/actual/' . $r['idrangoedad']) ?>" class="btn btn-outline-primary" title="Ver Ficha del Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('rangoedad/edit/' . $r['idrangoedad']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
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
