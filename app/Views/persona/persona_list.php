<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Personas</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>persona</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('persona/add') ?>" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-1"></i> + Nueva Persona
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('persona/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cédula, apellidos o nombres...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('persona/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4">ID</th>
                        <th>Cédula</th>
                        <th>Apellidos</th>
                        <th>Nombres</th>
                        <th>Fecha Nacimiento</th>
                        <th>Sexo</th>
                        <th>Rol</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($personas)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No se encontraron registros de personas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($personas as $p): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $p['idpersona'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6"><?= esc($p['cedula']) ?></span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/actual/' . $p['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($p['apellidos']) ?>
                                    </a>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('persona/actual/' . $p['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($p['nombres']) ?>
                                    </a>
                                </td>
                                <td>
                                    <?= !empty($p['fechanacimiento']) ? date('d/m/Y', strtotime($p['fechanacimiento'])) : '<span class="text-muted">-</span>' ?>
                                </td>
                                <td>
                                    <?= !empty($p['sexo_nombre']) ? '<span class="badge bg-info text-dark">' . esc($p['sexo_nombre']) . '</span>' : '<span class="text-muted">Sin asignar</span>' ?>
                                </td>
                                <td>
                                    <?php if (!empty($p['idcliente'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">
                                            <i class="bi bi-check-circle-fill me-1"></i> Cliente
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-2 py-1">
                                            Persona
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('persona/actual/' . $p['idpersona']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('persona/edit/' . $p['idpersona']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
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
