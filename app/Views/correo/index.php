<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-envelope-at-fill text-info me-2"></i>Gestión de Correos</h2>
        <p class="text-muted mb-0">Listado de correos electrónicos registrados en la tabla <code>correo</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('correo/new') ?>" class="btn btn-info text-white">
            <i class="bi bi-plus-circle me-1"></i> Registrar Correo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('correo') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por correo, cédula o nombre...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('correo') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Correos -->
<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Correo Electrónico</th>
                        <th>Persona Asignada</th>
                        <th>Cédula</th>
                        <th>Fecha Obtención</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($correos)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No se encontraron correos registrados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($correos as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $c['idcorreo'] ?></td>
                                <td class="font-monospace">
                                    <a href="mailto:<?= esc($c['correo']) ?>" class="text-decoration-none">
                                        <?= esc($c['correo']) ?>
                                    </a>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/show/' . $c['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($c['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace"><?= esc($c['cedula']) ?></span>
                                </td>
                                <td>
                                    <?= !empty($c['fechaoptencion']) ? date('d/m/Y', strtotime($c['fechaoptencion'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('correo/edit/' . $c['idcorreo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delCor<?= $c['idcorreo'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="delCor<?= $c['idcorreo'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Correo</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar el correo <strong><?= esc($c['correo']) ?></strong> de <strong><?= esc($c['persona_nombres']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('correo/delete/' . $c['idcorreo']) ?>">
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
