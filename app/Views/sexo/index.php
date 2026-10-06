<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-gender-ambiguous text-danger me-2"></i>Catálogo de Sexos</h2>
        <p class="text-muted mb-0">Gestión de la tabla <code>sexo</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('sexo/new') ?>" class="btn btn-danger">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Sexo
        </a>
    </div>
</div>

<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Nombre del Sexo</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($sexos)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No hay registros de sexo.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($sexos as $s): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $s['idsexo'] ?></td>
                                <td class="fw-semibold text-dark fs-6">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-2">
                                        <?= esc($s['nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('sexo/edit/' . $s['idsexo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delSex<?= $s['idsexo'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="delSex<?= $s['idsexo'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Sexo</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar el registro <strong>"<?= esc($s['nombre']) ?>"</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('sexo/delete/' . $s['idsexo']) ?>">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
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
