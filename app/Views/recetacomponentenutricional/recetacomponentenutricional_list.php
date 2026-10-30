<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con filtros y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-book-half text-warning me-2 fs-3"></i>Componentes Nutricionales por Receta
                    </h4>
                    <p class="text-muted small mb-0">Gestión del perfil y componentes nutricionales clave de cada preparación y receta saludable.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('recetacomponentenutricional/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <select name="idreceta" class="form-select form-select-sm" style="max-width: 220px;" onchange="this.form.submit()">
                            <option value="">-- Todas las Recetas --</option>
                            <?php foreach ($recetas as $rec): ?>
                                <option value="<?= $rec['idreceta'] ?>" <?= ($selectedReceta == $rec['idreceta']) ? 'selected' : '' ?>>
                                    <?= esc($rec['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar receta o componente..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedReceta)): ?>
                                <a href="<?= base_url('recetacomponentenutricional/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('recetacomponentenutricional/add' . (!empty($selectedReceta) ? '?idreceta=' . $selectedReceta : '')) ?>" class="btn btn-warning text-dark fw-semibold btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Asignar a Receta
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
                            <th>Receta</th>
                            <th>Porciones</th>
                            <th>Componente Nutricional</th>
                            <th>Descripción / Función</th>
                            <th class="text-end pe-4" style="width: 160px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listado)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron asignaciones de componentes para recetas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listado as $item): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $item['idrecetacomponentenutricional'] ?></td>
                                    <td>
                                        <a href="<?= base_url('receta/actual/' . $item['idreceta']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <i class="bi bi-journal-text text-warning me-1"></i><?= esc($item['receta_nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-secondary border">
                                            <?= $item['porciones'] ?? 1 ?> <?= (($item['porciones'] ?? 1) == 1) ? 'porción' : 'porciones' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('componentenutricional/actual/' . $item['idcomponentenutricional']) ?>" class="badge bg-info-subtle text-info border border-info text-decoration-none px-2 py-1">
                                            <i class="bi bi-pie-chart-fill me-1"></i><?= esc($item['componente_nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="text-secondary small" style="max-width: 380px;">
                                        <?= !empty($item['componente_descripcion']) ? esc(mb_strimwidth($item['componente_descripcion'], 0, 90, '...')) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('recetacomponentenutricional/actual/' . $item['idrecetacomponentenutricional']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('recetacomponentenutricional/edit/' . $item['idrecetacomponentenutricional']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteList"
                                                    data-id="<?= $item['idrecetacomponentenutricional'] ?>"
                                                    data-nombre="<?= esc($item['receta_nombre'] . ' — ' . $item['componente_nombre']) ?>">
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
                    <p class="mb-2">¿Está seguro de que desea eliminar la asignación:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetNombre"></h5>
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
            document.getElementById('formDeleteList').action = '<?= base_url('recetacomponentenutricional/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
