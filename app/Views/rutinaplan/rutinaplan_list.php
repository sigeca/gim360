<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-diagram-3 text-warning me-2"></i>Rutinas y Planes de Ejercicio</h2>
        <p class="text-muted mb-0">Gestión de la tabla <code>rutinaplan</code> (relación entre rutinas y planes).</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('rutinaplan/add') ?>" class="btn btn-warning text-dark fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Asignar Plan a Rutina
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('rutinaplan/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de rutina, ejercicio, días, repeticiones...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-warning text-dark fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('rutinaplan/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Rutina de Ejercicio</th>
                        <th>Plan / Ejercicio Asignado</th>
                        <th class="text-center">Días</th>
                        <th class="text-center">Reps</th>
                        <th class="text-center">Series</th>
                        <th class="text-center">Descanso</th>
                        <th class="text-center">Peso</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rutinaplanes)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">No se encontraron registros de relación entre rutinas y planes.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rutinaplanes as $rp): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $rp['id_rutina_plan'] ?></td>
                                <td>
                                    <a href="<?= base_url('rutinaejecicio/actual/' . $rp['idrutinaejercicio']) ?>" class="text-decoration-none fw-semibold">
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info px-2 py-1">
                                            <i class="bi bi-calendar2-week text-info me-1"></i><?= esc($rp['rutina_nombre']) ?>
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($rp['ejercicio_imagen'])): ?>
                                            <img src="<?= base_url('ejercicio/imagen/' . esc($rp['ejercicio_imagen'])) ?>" 
                                                 alt="" 
                                                 class="rounded border" 
                                                 style="width: 34px; height: 34px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 34px; height: 34px;">
                                                <i class="bi bi-fire text-danger"></i>
                                            </div>
                                        <?php endif; ?>
                                        <div>
                                            <span class="fw-semibold text-dark d-block"><?= esc($rp['ejercicio_nombre']) ?></span>
                                            <span class="badge bg-primary-subtle text-primary border border-primary px-1" style="font-size: 0.75rem;">
                                                Plan #<?= $rp['idplanejercicio'] ?>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($rp['plan_dias']) && $rp['plan_dias'] !== null && $rp['plan_dias'] !== ''): ?>
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                            <i class="bi bi-calendar3 me-1"></i><?= esc($rp['plan_dias']) ?> d
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($rp['plan_repeticiones']) && $rp['plan_repeticiones'] !== null && $rp['plan_repeticiones'] !== ''): ?>
                                        <span class="badge bg-success-subtle text-success-emphasis border border-success px-2 py-1">
                                            <i class="bi bi-repeat me-1"></i><?= esc($rp['plan_repeticiones']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($rp['plan_series']) && $rp['plan_series'] !== null && $rp['plan_series'] !== ''): ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary px-2 py-1">
                                            <i class="bi bi-layers me-1"></i><?= esc($rp['plan_series']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($rp['plan_tiempodescanso']) && $rp['plan_tiempodescanso'] !== null && $rp['plan_tiempodescanso'] !== ''): ?>
                                        <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                            <i class="bi bi-stopwatch text-warning me-1"></i><?= esc($rp['plan_tiempodescanso']) ?>s
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if (isset($rp['plan_peso']) && $rp['plan_peso'] !== null && $rp['plan_peso'] !== ''): ?>
                                        <span class="badge bg-danger-subtle text-danger-emphasis border border-danger px-2 py-1">
                                            <i class="bi bi-speedometer2 me-1"></i><?= number_format((float)$rp['plan_peso'], 1) ?> kg
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('rutinaplan/actual/' . $rp['id_rutina_plan']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('rutinaplan/edit/' . $rp['id_rutina_plan']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $rp['id_rutina_plan'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar fila -->
                                    <div class="modal fade text-start" id="deleteModal<?= $rp['id_rutina_plan'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Relación Rutina-Plan</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Confirma que desea eliminar el registro de Rutina-Plan <strong>#<?= $rp['id_rutina_plan'] ?></strong>?<br>
                                                    <span class="text-muted small">Rutina: <strong><?= esc($rp['rutina_nombre']) ?></strong> | Ejercicio: <strong><?= esc($rp['ejercicio_nombre']) ?></strong></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="<?= base_url('rutinaplan/delete/' . $rp['id_rutina_plan']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
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
