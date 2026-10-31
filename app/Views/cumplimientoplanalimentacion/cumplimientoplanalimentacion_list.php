<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador, filtros y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-check2-circle text-success me-2 fs-3"></i>Cumplimiento de Planes de Alimentación
                    </h4>
                    <p class="text-muted small mb-0">Seguimiento histórico de ingestas y comidas efectivas cumplidas según el plan nutricional asignado.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('cumplimientoplanalimentacion/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Filtro por Plan -->
                        <select name="idplanalimentacion" class="form-select form-select-sm" style="min-width: 180px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Planes --</option>
                            <?php foreach ($planes as $pl): ?>
                                <option value="<?= $pl['idplanalimentacion'] ?>" <?= (isset($selectedPlan) && (string)$selectedPlan === (string)$pl['idplanalimentacion']) ? 'selected' : '' ?>>
                                    <?= esc($pl['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Filtro por Fecha -->
                        <input type="date" name="fecha" class="form-control form-control-sm" value="<?= esc($selectedFecha ?? '') ?>" onchange="this.form.submit()" title="Filtrar por fecha">

                        <!-- Buscador de texto -->
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedPlan) || !empty($selectedFecha)): ?>
                                <a href="<?= base_url('cumplimientoplanalimentacion/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('cumplimientoplanalimentacion/add' . (!empty($selectedPlan) ? '?idplanalimentacion=' . $selectedPlan : '')) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Registrar Cumplimiento
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Registros -->
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th>Plan Nutricional</th>
                            <th>Persona</th>
                            <th>Momento / Tipo</th>
                            <th>Receta</th>
                            <th>Fecha y Hora</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($cumplimientos)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron registros de cumplimiento con los filtros seleccionados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($cumplimientos as $c): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $c['idcumplimientoplanalimentacion'] ?></td>
                                    <td>
                                        <a href="<?= base_url('planalimentacion/actual/' . $c['idplanalimentacion']) ?>" class="fw-semibold text-decoration-none text-dark">
                                            <i class="bi bi-journal-medical text-success me-1"></i><?= esc($c['plan_nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark"><?= esc($c['apellidos']) ?>, <?= esc($c['nombres']) ?></div>
                                        <small class="text-muted">C.I. <?= esc($c['cedula']) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                            <?= esc($c['tipocomida_nombre']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="bi bi-book me-1 text-primary"></i>
                                        <span class="fw-semibold"><?= esc($c['receta_nombre']) ?></span>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <i class="bi bi-calendar-check me-1 text-success"></i><?= esc($c['fechahora']) ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('cumplimientoplanalimentacion/actual/' . $c['idcumplimientoplanalimentacion']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('cumplimientoplanalimentacion/edit/' . $c['idcumplimientoplanalimentacion']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteCumplimiento"
                                                    data-id="<?= $c['idcumplimientoplanalimentacion'] ?>"
                                                    data-plan="<?= esc($c['plan_nombre']) ?>"
                                                    data-receta="<?= esc($c['receta_nombre']) ?>"
                                                    data-fecha="<?= esc($c['fechahora']) ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
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

<!-- Modal para eliminar cumplimiento -->
<div class="modal fade" id="modalDeleteCumplimiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteCumplimiento" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar este registro de cumplimiento?</p>
                    <div class="p-3 bg-light rounded border text-center my-3">
                        <strong class="d-block text-secondary small" id="deleteTargetPlan"></strong>
                        <h6 class="text-danger fw-bold my-1" id="deleteTargetReceta"></h6>
                        <small class="text-muted d-block" id="deleteTargetFecha"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-1"></i>Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalDelete = document.getElementById('modalDeleteCumplimiento');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const plan = button.getAttribute('data-plan');
            const receta = button.getAttribute('data-receta');
            const fecha = button.getAttribute('data-fecha');
            document.getElementById('deleteTargetPlan').textContent = 'Plan: ' + plan;
            document.getElementById('deleteTargetReceta').textContent = 'Receta: ' + receta;
            document.getElementById('deleteTargetFecha').textContent = 'Fecha/Hora: ' + fecha;
            document.getElementById('formDeleteCumplimiento').action = '<?= rtrim(base_url('cumplimientoplanalimentacion/delete'), '/') ?>/' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
