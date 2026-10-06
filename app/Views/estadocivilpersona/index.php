<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-arrow-left-right text-dark me-2"></i>Estado Civil - Persona</h2>
        <p class="text-muted mb-0">Gestión de asignaciones en la tabla <code>estadocivilpersona</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('estadocivilpersona/new') ?>" class="btn btn-dark">
            <i class="bi bi-plus-circle me-1"></i> Asignar Estado Civil
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('estadocivilpersona') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por estado civil, cédula o persona...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('estadocivilpersona') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4">ID Asignación</th>
                        <th>Cédula</th>
                        <th>Persona</th>
                        <th>Estado Civil Asignado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($asignaciones)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">No hay asignaciones registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($asignaciones as $a): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $a['idestadocivilpersona'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace"><?= esc($a['cedula']) ?></span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/show/' . $a['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($a['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                        <i class="bi bi-heart me-1"></i><?= esc($a['estadocivil_nombre']) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-outline-danger btn-sm" title="Eliminar Asignación" data-bs-toggle="modal" data-bs-target="#delECP<?= $a['idestadocivilpersona'] ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="delECP<?= $a['idestadocivilpersona'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Asignación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar la asignación de <strong>"<?= esc($a['estadocivil_nombre']) ?>"</strong> para <strong><?= esc($a['persona_nombres']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('estadocivilpersona/delete/' . $a['idestadocivilpersona']) ?>">
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
