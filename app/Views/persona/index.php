<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Personas</h2>
        <p class="text-muted mb-0">Listado general de personas registradas en la tabla <code>persona</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('persona/new') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-1"></i> Nueva Persona
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('persona') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cédula o nombres...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('persona') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Resultados -->
<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID</th>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Sexo</th>
                        <th>Rol / Estado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($personas)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No se encontraron registros de personas.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($personas as $p): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $p['idpersona'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6">
                                        <?= esc($p['cedula']) ?>
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/show/' . $p['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($p['nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?php if (!empty($p['fechanacimiento'])): ?>
                                        <i class="bi bi-calendar3 me-1 text-muted"></i><?= date('d/m/Y', strtotime($p['fechanacimiento'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">No especificada</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($p['sexo_nombre'])): ?>
                                        <span class="badge bg-info text-dark"><?= esc($p['sexo_nombre']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-light text-secondary border">Sin asignar</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($p['idcliente'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Cliente Gym
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                            Persona
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('persona/show/' . $p['idpersona']) ?>" class="btn btn-outline-primary" title="Ver Detalles y Relaciones">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="<?= base_url('persona/edit/' . $p['idpersona']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalDelete<?= $p['idpersona'] ?>">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Eliminar -->
                                    <div class="modal fade text-start" id="modalDelete<?= $p['idpersona'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro de que desea eliminar a <strong><?= esc($p['nombres']) ?></strong> (Cédula: <?= esc($p['cedula']) ?>)?
                                                    <div class="alert alert-warning mt-3 mb-0 small">
                                                        <i class="bi bi-info-circle me-1"></i> Al eliminar esta persona, se eliminarán en cascada sus correos, direcciones, estados civiles y registros de cliente asociados.
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('persona/delete/' . $p['idpersona']) ?>">
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
