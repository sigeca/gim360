<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador, filtros y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-diagram-3-fill text-warning me-2 fs-3"></i>Ingredientes por Receta
                    </h4>
                    <p class="text-muted small mb-0">Relación de alimentos, cantidades y unidades de medida requeridas en cada preparación culinaria.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('alimentoreceta/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Filtro por Receta -->
                        <select name="idreceta" class="form-select form-select-sm" style="min-width: 170px;" onchange="this.form.submit()">
                            <option value="">-- Todas las Recetas --</option>
                            <?php foreach ($recetas as $rec): ?>
                                <option value="<?= $rec['idreceta'] ?>" <?= (isset($selectedReceta) && (string)$selectedReceta === (string)$rec['idreceta']) ? 'selected' : '' ?>>
                                    <?= esc($rec['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Filtro por Alimento -->
                        <select name="idalimento" class="form-select form-select-sm" style="min-width: 170px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Alimentos --</option>
                            <?php foreach ($alimentos as $ali): ?>
                                <option value="<?= $ali['idalimento'] ?>" <?= (isset($selectedAlimento) && (string)$selectedAlimento === (string)$ali['idalimento']) ? 'selected' : '' ?>>
                                    <?= esc($ali['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Buscador de texto -->
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedReceta) || !empty($selectedAlimento)): ?>
                                <a href="<?= base_url('alimentoreceta/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('alimentoreceta/add' . (!empty($selectedReceta) ? '?idreceta=' . $selectedReceta : '')) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Asignar Ingrediente
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
                            <th>Receta</th>
                            <th>Alimento / Ingrediente</th>
                            <th>Cantidad</th>
                            <th>Unidad de Medida</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($registros)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron ingredientes registrados con los filtros seleccionados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($registros as $rg): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $rg['idalimentoreceta'] ?></td>
                                    <td>
                                        <a href="<?= base_url('receta/actual/' . $rg['idreceta']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <i class="bi bi-book text-warning me-1"></i><?= esc($rg['receta_nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('alimento/actual/' . $rg['idalimento']) ?>" class="fw-semibold text-success text-decoration-none">
                                            <i class="bi bi-apple me-1"></i><?= esc($rg['alimento_nombre']) ?>
                                        </a>
                                        <?php if (!empty($rg['grupo_nombre'])): ?>
                                            <span class="badge bg-light text-muted border ms-1 small"><?= esc($rg['grupo_nombre']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="fw-bold text-primary">
                                        <?= number_format((float)$rg['cantidad'], 2) ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-subtle text-info border border-info font-monospace">
                                            <?= esc($rg['unidad_nombre']) ?> (<?= esc($rg['unidad_abreviatura']) ?>)
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('alimentoreceta/actual/' . $rg['idalimentoreceta']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('alimentoreceta/edit/' . $rg['idalimentoreceta']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteAR"
                                                    data-id="<?= $rg['idalimentoreceta'] ?>"
                                                    data-receta="<?= esc($rg['receta_nombre']) ?>"
                                                    data-alimento="<?= esc($rg['alimento_nombre']) ?>">
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

<!-- Modal para eliminar ingrediente de receta -->
<div class="modal fade" id="modalDeleteAR" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteAR" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea remover el ingrediente de la receta?</p>
                    <div class="p-3 bg-light rounded border text-center my-3">
                        <strong class="d-block text-dark fs-6" id="deleteTargetReceta"></strong>
                        <span class="text-danger fw-bold fs-5" id="deleteTargetAlimento"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-1"></i>Remover</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalDelete = document.getElementById('modalDeleteAR');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const receta = button.getAttribute('data-receta');
            const alimento = button.getAttribute('data-alimento');
            document.getElementById('deleteTargetReceta').textContent = 'Receta: ' + receta;
            document.getElementById('deleteTargetAlimento').textContent = alimento;
            document.getElementById('formDeleteAR').action = '<?= base_url('alimentoreceta/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
