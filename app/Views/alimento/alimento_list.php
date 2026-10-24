<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador, filtro de grupo y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-apple text-success me-2 fs-3"></i>Catálogo de Alimentos
                    </h4>
                    <p class="text-muted small mb-0">Listado de alimentos clasificados por grupo nutricional para la elaboración de dietas y pautas de alimentación.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('alimento/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <!-- Selector de Grupo -->
                        <select name="idgrupo" class="form-select form-select-sm" style="min-width: 170px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Grupos --</option>
                            <?php foreach ($grupos as $g): ?>
                                <option value="<?= $g['idgrupoalimento'] ?>" <?= (isset($selectedGrupo) && (string)$selectedGrupo === (string)$g['idgrupoalimento']) ? 'selected' : '' ?>>
                                    <?= esc($g['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Buscador de texto -->
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar alimento..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedGrupo)): ?>
                                <a href="<?= base_url('alimento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('alimento/add' . (!empty($selectedGrupo) ? '?idgrupo=' . $selectedGrupo : '')) ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Alimento
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
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Alimento</th>
                            <th>Grupo Nutricional</th>
                            <th>Descripción / Propiedades</th>
                            <th class="text-end pe-4" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($alimentos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron alimentos registrados con los criterios seleccionados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($alimentos as $a): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $a['idalimento'] ?></td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6 d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success me-2"></i>
                                            <?= esc($a['nombre']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if (!empty($a['grupo_nombre'])): ?>
                                            <a href="<?= base_url('alimento/listar?idgrupo=' . $a['idgrupo']) ?>" class="badge bg-success-subtle text-success border border-success text-decoration-none px-2 py-1">
                                                <i class="bi bi-egg-fried me-1"></i><?= esc($a['grupo_nombre']) ?>
                                            </a>
                                        <?php else: ?>
                                            <span class="badge bg-secondary-subtle text-secondary">Sin Grupo</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-secondary small" style="max-width: 380px;">
                                        <?= !empty($a['descripcion']) ? esc($a['descripcion']) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('alimento/actual/' . $a['idalimento']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('alimento/edit/' . $a['idalimento']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteList"
                                                    data-id="<?= $a['idalimento'] ?>"
                                                    data-nombre="<?= esc($a['nombre']) ?>">
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

<!-- Modal para eliminar desde la lista -->
<div class="modal fade" id="modalDeleteList" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteList" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar el alimento:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetNombre"></h5>
                    <p class="small text-muted mb-0 text-center">Esta acción no se puede deshacer.</p>
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
    const modalDelete = document.getElementById('modalDeleteList');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            document.getElementById('deleteTargetNombre').textContent = nombre;
            document.getElementById('formDeleteList').action = '<?= base_url('alimento/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
