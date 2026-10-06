<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-geo-alt-fill text-warning me-2"></i>Gestión de Direcciones</h2>
        <p class="text-muted mb-0">Listado de direcciones registradas en la tabla <code>direccion</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('direccion/new') ?>" class="btn btn-warning">
            <i class="bi bi-plus-circle me-1"></i> Registrar Dirección
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('direccion') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por dirección, cédula o nombre...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('direccion') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Direcciones -->
<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Dirección Domiciliaria / Contacto</th>
                        <th>Persona Asignada</th>
                        <th>Cédula</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($direcciones)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No se encontraron direcciones registradas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($direcciones as $d): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $d['iddireccion'] ?></td>
                                <td class="fw-semibold text-dark">
                                    <i class="bi bi-pin-map text-warning me-1"></i>
                                    <?= esc($d['direccion']) ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('persona/show/' . $d['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($d['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace"><?= esc($d['cedula']) ?></span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('direccion/edit/' . $d['iddireccion']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delDir<?= $d['iddireccion'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="delDir<?= $d['iddireccion'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Dirección</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea eliminar la dirección <strong>"<?= esc($d['direccion']) ?>"</strong> de <strong><?= esc($d['persona_nombres']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('direccion/delete/' . $d['iddireccion']) ?>">
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
