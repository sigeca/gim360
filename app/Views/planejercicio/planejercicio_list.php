<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-card-checklist text-info me-2"></i>Planes de Ejercicio</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>planejercicio</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('planejercicio/add') ?>" class="btn btn-info text-white fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Plan
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('planejercicio/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre del ejercicio, días, repeticiones, series...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-info text-white fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('planejercicio/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Ejercicio Asignado</th>
                        <th class="text-center" title="Días por Semana">Días/Sem</th>
                        <th class="text-center">Reps</th>
                        <th class="text-center">Series</th>
                        <th class="text-center">Descanso</th>
                        <th class="text-center">Peso</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($planes)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No se encontraron registros de planes de ejercicio.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($planes as $p): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $p['idplanejercicio'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($p['ejercicio_imagen'])): ?>
                                            <img src="<?= base_url('ejercicio/imagen/' . esc($p['ejercicio_imagen'])) ?>" 
                                                 alt="" 
                                                 class="rounded border" 
                                                 style="width: 38px; height: 38px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px;">
                                                <i class="bi bi-fire text-danger"></i>
                                            </div>
                                        <?php endif; ?>
                                        <span class="fw-semibold text-dark"><?= esc($p['ejercicio_nombre']) ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php $diasVal = $p['diassemanas'] ?? $p['dias'] ?? null; ?>
                                    <?php if ($diasVal !== null && $diasVal !== ''): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1" title="<?= esc($diasVal) ?> días por semana">
                                            <i class="bi bi-calendar3 me-1"></i><?= esc($diasVal) ?> d/sem
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p['repeticiones']) && $p['repeticiones'] !== null && $p['repeticiones'] !== ''): ?>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success px-2 py-1">
                                            <i class="bi bi-repeat me-1"></i><?= esc($p['repeticiones']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p['series']) && $p['series'] !== null && $p['series'] !== ''): ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1">
                                            <i class="bi bi-layers me-1"></i><?= esc($p['series']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p['tiempodescanso']) && $p['tiempodescanso'] !== null && $p['tiempodescanso'] !== ''): ?>
                                        <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                            <i class="bi bi-stopwatch me-1"></i><?= esc($p['tiempodescanso']) ?>s
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p['peso']) && $p['peso'] !== null && $p['peso'] !== ''): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">
                                            <i class="bi bi-speedometer2 me-1"></i><?= number_format((float)$p['peso'], 2) ?> kg
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('planejercicio/actual/' . $p['idplanejercicio']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('planejercicio/edit/' . $p['idplanejercicio']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
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
