<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador, filtros y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-calendar2-heart text-success me-2 fs-3"></i>Comidas en Planes Nutricionales
                    </h4>
                    <p class="text-muted small mb-0">Estructuración diaria de recetas, tipos de comida y horarios recomendados por cada plan de alimentación.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('comida/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Filtro por Plan -->
                        <select name="idplanalimentacion" class="form-select form-select-sm" style="min-width: 170px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Planes --</option>
                            <?php foreach ($planes as $pl): ?>
                                <option value="<?= $pl['idplanalimentacion'] ?>" <?= (isset($selectedPlan) && (string)$selectedPlan === (string)$pl['idplanalimentacion']) ? 'selected' : '' ?>>
                                    <?= esc($pl['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Filtro por Tipo de Comida -->
                        <select name="idtipocomida" class="form-select form-select-sm" style="min-width: 140px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Tiempos --</option>
                            <?php foreach ($tipos as $tp): ?>
                                <option value="<?= $tp['idtipocomida'] ?>" <?= (isset($selectedTipo) && (string)$selectedTipo === (string)$tp['idtipocomida']) ? 'selected' : '' ?>>
                                    <?= esc($tp['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Buscador de texto -->
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar comida..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedPlan) || !empty($selectedTipo)): ?>
                                <a href="<?= base_url('comida/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('comida/add' . (!empty($selectedPlan) ? '?idplanalimentacion=' . $selectedPlan : '')) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Programar Comida
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
                            <th>Plan de Alimentación</th>
                            <th>Titular</th>
                            <th>Momento / Tipo</th>
                            <th>Receta Asignada</th>
                            <th>Hora Sugerida</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($comidas)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron comidas programadas con los filtros seleccionados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($comidas as $cm): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $cm['idcomida'] ?></td>
                                    <td>
                                        <a href="<?= base_url('planalimentacion/actual/' . $cm['idplanalimentacion']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <i class="bi bi-journal-medical text-success me-1"></i><?= esc($cm['plan_nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="small">
                                        <?= esc($cm['apellidos']) ?>, <?= esc($cm['nombres']) ?>
                                        <div class="text-muted"><i class="bi bi-credit-card-2-front me-1"></i><?= esc($cm['cedula']) ?></div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-dark border border-warning">
                                            <?= esc($cm['tipocomida_nombre']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('receta/actual/' . $cm['idreceta']) ?>" class="fw-semibold text-primary text-decoration-none">
                                            <i class="bi bi-book me-1"></i><?= esc($cm['receta_nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <?php if (!empty($cm['horarecomendada'])): ?>
                                            <i class="bi bi-clock me-1 text-primary"></i><?= substr($cm['horarecomendada'], 0, 5) ?>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic small">Flexible</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('comida/actual/' . $cm['idcomida']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('comida/edit/' . $cm['idcomida']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteComida"
                                                    data-id="<?= $cm['idcomida'] ?>"
                                                    data-plan="<?= esc($cm['plan_nombre']) ?>"
                                                    data-tipo="<?= esc($cm['tipocomida_nombre']) ?>"
                                                    data-receta="<?= esc($cm['receta_nombre']) ?>">
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

<!-- Modal para eliminar comida -->
<div class="modal fade" id="modalDeleteComida" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteComida" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar la comida del plan?</p>
                    <div class="p-3 bg-light rounded border text-center my-3">
                        <strong class="d-block text-secondary small" id="deleteTargetPlan"></strong>
                        <span class="badge bg-warning text-dark my-1" id="deleteTargetTipo"></span>
                        <h6 class="text-danger fw-bold mb-0 mt-1" id="deleteTargetReceta"></h6>
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
    const modalDelete = document.getElementById('modalDeleteComida');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const plan = button.getAttribute('data-plan');
            const tipo = button.getAttribute('data-tipo');
            const receta = button.getAttribute('data-receta');
            document.getElementById('deleteTargetPlan').textContent = 'Plan: ' + plan;
            document.getElementById('deleteTargetTipo').textContent = tipo;
            document.getElementById('deleteTargetReceta').textContent = receta;
            document.getElementById('formDeleteComida').action = '<?= base_url('comida/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
