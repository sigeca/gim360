<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-heart-fill text-danger me-2"></i>Catálogo de Estados Civiles</h2>
        <p class="text-muted mb-0">Gestión de la tabla <code>estadocivil</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('estadocivil/new') ?>" class="btn btn-secondary">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Estado Civil
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
                        <th>Nombre del Estado Civil</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($estadosCiviles)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">No hay estados civiles registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($estadosCiviles as $ec): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $ec['idestadocivil'] ?></td>
                                <td class="fw-semibold text-dark fs-6">
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">
                                        <?= esc($ec['nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('estadocivil/edit/' . $ec['idestadocivil']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delEC<?= $ec['idestadocivil'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="delEC<?= $ec['idestadocivil'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Estado Civil</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar el estado civil <strong>"<?= esc($ec['nombre']) ?>"</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('estadocivil/delete/' . $ec['idestadocivil']) ?>">
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
