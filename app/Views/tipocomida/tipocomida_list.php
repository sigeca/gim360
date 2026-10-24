<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-clock-history text-warning me-2 fs-3"></i>Catálogo de Tipos de Comida
                    </h4>
                    <p class="text-muted small mb-0">Tiempos e ingestas del día para organizar la alimentación (desayunos, almuerzos, snacks, pre y post-entreno).</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('tipocomida/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar tipo de comida..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('tipocomida/listar') ?>" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('tipocomida/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Tipo
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
                            <th>Tiempo / Tipo de Comida</th>
                            <th>Momento</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($tipos)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron tipos de comida registrados.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($tipos as $t): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $t['idtipocomida'] ?></td>
                                    <td>
                                        <div class="fw-bold text-dark fs-6 d-flex align-items-center">
                                            <i class="bi bi-cup-hot-fill text-warning me-2"></i>
                                            <?= esc($t['nombre']) ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                            <i class="bi bi-calendar3 me-1"></i>Pauta Diaria
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('tipocomida/actual/' . $t['idtipocomida']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('tipocomida/edit/' . $t['idtipocomida']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteTipo"
                                                    data-id="<?= $t['idtipocomida'] ?>"
                                                    data-nombre="<?= esc($t['nombre']) ?>">
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

<!-- Modal para eliminar tipo de comida -->
<div class="modal fade" id="modalDeleteTipo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteTipo" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar el tipo de comida:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetTipo"></h5>
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
    const modalDelete = document.getElementById('modalDeleteTipo');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            document.getElementById('deleteTargetTipo').textContent = nombre;
            document.getElementById('formDeleteTipo').action = '<?= base_url('tipocomida/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
