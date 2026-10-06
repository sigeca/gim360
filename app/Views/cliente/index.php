<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-badge-fill text-success me-2"></i>Gestión de Clientes</h2>
        <p class="text-muted mb-0">Listado de personas registradas como clientes en la tabla <code>cliente</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('cliente/new') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> Asignar Nuevo Cliente
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('cliente') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cédula o nombre del cliente...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('cliente') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<!-- Tabla de Clientes -->
<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">ID Cliente</th>
                        <th>Cédula Persona</th>
                        <th>Nombres y Apellidos</th>
                        <th>Sexo</th>
                        <th>Fecha Nacimiento</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No se encontraron clientes registrados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-success">#<?= $c['idcliente'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6">
                                        <?= esc($c['cedula']) ?>
                                    </span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/show/' . $c['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($c['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= !empty($c['sexo_nombre']) ? '<span class="badge bg-info text-dark">' . esc($c['sexo_nombre']) . '</span>' : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <?= !empty($c['fechanacimiento']) ? date('d/m/Y', strtotime($c['fechanacimiento'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('persona/show/' . $c['idpersona']) ?>" class="btn btn-outline-primary" title="Ver Perfil Completo">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar Cliente" data-bs-toggle="modal" data-bs-target="#delCli<?= $c['idcliente'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal Confirmar Eliminación -->
                                    <div class="modal fade text-start" id="delCli<?= $c['idcliente'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Cliente</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Desea retirar a <strong><?= esc($c['persona_nombres']) ?></strong> de la lista de clientes?
                                                    <p class="text-muted small mt-2 mb-0">La persona continuará registrada en el sistema, únicamente dejará de ser cliente.</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('cliente/delete/' . $c['idcliente']) ?>">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Confirmar Eliminación</button>
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
