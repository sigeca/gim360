<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-people-fill text-primary me-2"></i>Gestión de Usuarios</h2>
        <p class="text-muted mb-0">Listado general de cuentas en la tabla <code>usuario</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('usuario/add') ?>" class="btn btn-primary text-white">
            <i class="bi bi-person-plus-fill me-1"></i> + Nuevo Usuario
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('usuario/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por usuario, cédula, nombres o apellidos...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('usuario/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Nombre de Usuario</th>
                        <th>Persona Asignada</th>
                        <th>Cédula</th>
                        <th>Seguridad</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($usuarios)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                No se encontraron usuarios registrados.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($usuarios as $u): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $u['idusuario'] ?></td>
                                <td class="font-monospace fw-bold text-primary">
                                    <i class="bi bi-person-circle me-1"></i><?= esc($u['nombreusuario']) ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('persona/actual/' . $u['idpersona']) ?>" class="text-decoration-none text-dark fw-semibold">
                                        <?= esc($u['persona_apellidos'] . ' ' . $u['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($u['cedula']) ?></span></td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success border-opacity-25">
                                        <i class="bi bi-shield-check me-1"></i>Hashed
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('usuario/actual/' . $u['idusuario']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('usuario/edit/' . $u['idusuario']) ?>" class="btn btn-outline-warning" title="Editar">
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
