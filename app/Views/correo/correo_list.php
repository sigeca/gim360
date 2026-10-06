<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-envelope-at-fill text-info me-2"></i>Gestión de Correos</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>correo</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('correo/add') ?>" class="btn btn-info text-white">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Correo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('correo/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por correo, cédula o nombre...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('correo/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron correos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($correos as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $c['idcorreo'] ?></td>
                                <td class="font-monospace fw-semibold text-primary">
                                    <?= esc($c['correo']) ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('persona/actual/' . $c['idpersona']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($c['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($c['cedula']) ?></span></td>
                                <td><?= !empty($c['fechaoptencion']) ? date('d/m/Y', strtotime($c['fechaoptencion'])) : '-' ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('correo/actual/' . $c['idcorreo']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('correo/edit/' . $c['idcorreo']) ?>" class="btn btn-outline-warning" title="Editar">
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
