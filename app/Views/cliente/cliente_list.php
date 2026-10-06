<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-badge-fill text-success me-2"></i>Gestión de Clientes</h2>
        <p class="text-muted mb-0">Listado general de la tabla <code>cliente</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('cliente/add') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Cliente
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('cliente/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cédula o nombre del cliente...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('cliente/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4">ID Cliente</th>
                        <th>Cédula</th>
                        <th>Nombres y Apellidos</th>
                        <th>Sexo</th>
                        <th>Fecha Nacimiento</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($clientes)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron clientes registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-success">#<?= $c['idcliente'] ?></td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6"><?= esc($c['cedula']) ?></span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('cliente/actual/' . $c['idcliente']) ?>" class="text-decoration-none text-dark">
                                        <?= esc($c['persona_nombres']) ?>
                                    </a>
                                </td>
                                <td><?= !empty($c['sexo_nombre']) ? esc($c['sexo_nombre']) : '-' ?></td>
                                <td><?= !empty($c['fechanacimiento']) ? date('d/m/Y', strtotime($c['fechanacimiento'])) : '-' ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('cliente/actual/' . $c['idcliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Registro">
                                            <i class="bi bi-eye"></i> Ver Ficha
                                        </a>
                                        <a href="<?= base_url('cliente/edit/' . $c['idcliente']) ?>" class="btn btn-outline-warning" title="Editar">
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
