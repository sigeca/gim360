<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-egg-fried text-success me-2 fs-3"></i>Catálogo de Grupos de Alimentos
                    </h4>
                    <p class="text-muted small mb-0">Categorización para la planificación de dietas, macronutrientes y planes nutricionales.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('grupoalimento/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o descripción..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('grupoalimento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('grupoalimento/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Grupo
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
                            <th>Nombre del Grupo</th>
                            <th>Descripción</th>
                            <th class="text-end pe-4" style="width: 180px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($grupos)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron grupos de alimentos registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($grupos as $g): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $g['idgrupoalimento'] ?></td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6 d-flex align-items-center">
                                            <i class="bi bi-check2-circle text-success me-2"></i>
                                            <?= esc($g['nombre']) ?>
                                        </div>
                                    </td>
                                    <td class="text-secondary small" style="max-width: 420px;">
                                        <?= !empty($g['descripcion']) ? esc($g['descripcion']) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('grupoalimento/actual/' . $g['idgrupoalimento']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('grupoalimento/edit/' . $g['idgrupoalimento']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteList"
                                                    data-id="<?= $g['idgrupoalimento'] ?>"
                                                    data-nombre="<?= esc($g['nombre']) ?>">
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
                    <p class="mb-2">¿Está seguro de que desea eliminar el grupo de alimento:</p>
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
            document.getElementById('formDeleteList').action = '<?= base_url('grupoalimento/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
