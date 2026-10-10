<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-flag-fill text-info me-2"></i>Estados de Programa de Cliente</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>estadoprogramacliente</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('estadoprogramacliente/add') ?>" class="btn btn-info text-dark fw-bold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Estado
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('estadoprogramacliente/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de estado...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-info text-dark fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('estadoprogramacliente/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4" style="width: 100px;">ID</th>
                        <th>Nombre del Estado</th>
                        <th class="text-end pe-4" style="width: 180px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($estados)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No se encontraron estados registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($estados as $est): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $est['idestadoprogramacliente'] ?></td>
                                <td class="fw-semibold text-dark fs-6">
                                    <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                        <i class="bi bi-tag-fill me-1"></i><?= esc($est['nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('estadoprogramacliente/actual/' . $est['idestadoprogramacliente']) ?>" class="btn btn-outline-info" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('estadoprogramacliente/edit/' . $est['idestadoprogramacliente']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalDelete_<?= $est['idestadoprogramacliente'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar en lista -->
                                    <div class="modal fade text-start" id="modalDelete_<?= $est['idestadoprogramacliente'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Estado</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro de eliminar el estado <strong><?= esc($est['nombre']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('estadoprogramacliente/delete/' . $est['idestadoprogramacliente']) ?>">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
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
