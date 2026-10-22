<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-person-check-fill text-primary me-2"></i>Planes de Ejercicio Personalizados
        </h2>
        <p class="text-muted mb-0">Gestión de planes personalizados por cliente (<code>planejerciciopersonalizado</code>) con fecha de inicio y duración.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('planpersonalizado/add') ?>" class="btn btn-primary fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Plan Personalizado
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('planpersonalizado/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por plan, cliente, cédula, ejercicio, rutina, duración...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-primary fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('planpersonalizado/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Plan & Cliente</th>
                        <th>Ejercicio Asignado</th>
                        <th class="text-center">Fecha Inicio</th>
                        <th class="text-center">Duración</th>
                        <th class="text-center">Días/Sem</th>
                        <th class="text-center">Series</th>
                        <th class="text-center">Reps</th>
                        <th class="text-center">Peso</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($planes)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-5 text-muted">No se encontraron planes de ejercicio personalizados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($planes as $p): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $p['idplanpersonalizado'] ?></td>
                                <td>
                                    <a href="<?= base_url('planpersonalizado/actual/' . $p['idplanpersonalizado']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                        <i class="bi bi-tag text-primary me-1"></i><?= esc($p['nombre'] ?? 'Plan #' . $p['idplanpersonalizado']) ?>
                                    </a>
                                    <?php if (!empty($p['cliente_nombres'])): ?>
                                        <div class="small text-muted">
                                            <i class="bi bi-person text-secondary me-1"></i><?= esc($p['cliente_nombres']) ?>
                                            <?php if (!empty($p['rutina_nombre'])): ?>
                                                &bull; <span class="badge bg-light text-dark border"><?= esc($p['rutina_nombre']) ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($p['ejercicio_imagen'])): ?>
                                            <a href="<?= base_url('ejercicio/actual/' . $p['idejercicio']) ?>" title="Ver ejercicio">
                                                <img src="<?= base_url('ejercicio/imagen/' . esc($p['ejercicio_imagen'])) ?>" 
                                                     alt="" 
                                                     class="rounded border" 
                                                     style="width: 38px; height: 38px; object-fit: cover;">
                                            </a>
                                        <?php else: ?>
                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 38px; height: 38px;">
                                                <i class="bi bi-fire text-danger"></i>
                                            </div>
                                        <?php endif; ?>
                                        <a href="<?= base_url('ejercicio/actual/' . $p['idejercicio']) ?>" class="text-decoration-none text-secondary fw-semibold">
                                            <?= esc($p['ejercicio_nombre']) ?>
                                        </a>
                                    </div>
                                </td>
                                <!-- FECHA INICIO -->
                                <td class="text-center">
                                    <?php if (!empty($p['fechainicio'])): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                            <i class="bi bi-calendar-event me-1"></i><?= esc($p['fechainicio']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">No definida</span>
                                    <?php endif; ?>
                                </td>
                                <!-- DURACIÓN SEMANAS -->
                                <td class="text-center">
                                    <?php if (isset($p['duracionsemana']) && $p['duracionsemana'] !== null && $p['duracionsemana'] !== ''): ?>
                                        <span class="badge bg-warning text-dark border border-warning px-2 py-1 fw-bold">
                                            <i class="bi bi-hourglass-split me-1"></i><?= esc($p['duracionsemana']) ?> sem
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small fst-italic">No definida</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (!empty($p['diassemanas'])): ?>
                                        <span class="badge bg-light text-dark border px-2 py-1">
                                            <?= esc($p['diassemanas']) ?> d
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center fw-semibold">
                                    <?= esc($p['series'] ?? '-') ?>
                                </td>
                                <td class="text-center fw-semibold">
                                    <?= esc($p['repeticiones'] ?? '-') ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($p['peso']) && $p['peso'] !== null && $p['peso'] !== ''): ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-2 py-1">
                                            <?= number_format((float)$p['peso'], 2) ?> kg
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('planpersonalizado/actual/' . $p['idplanpersonalizado']) ?>" class="btn btn-outline-primary" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('planpersonalizado/edit/' . $p['idplanpersonalizado']) ?>" class="btn btn-outline-secondary" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $p['idplanpersonalizado'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Confirmar Eliminación -->
                                    <div class="modal fade" id="deleteModal<?= $p['idplanpersonalizado'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content text-start">
                                                <div class="modal-header border-0 pb-0">
                                                    <h5 class="modal-title text-danger fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-target="#deleteModal<?= $p['idplanpersonalizado'] ?>" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body py-3">
                                                    ¿Está seguro de que desea eliminar el plan de ejercicio personalizado <strong>#<?= $p['idplanpersonalizado'] ?> - <?= esc($p['nombre'] ?? '') ?></strong>?
                                                </div>
                                                <div class="modal-footer border-0 pt-0">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('planpersonalizado/delete/' . $p['idplanpersonalizado']) ?>" class="d-inline">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger fw-semibold">Eliminar</button>
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
