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
                        <th>Foto</th>
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
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron clientes registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($clientes as $c): ?>
                            <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($c['cedula'])) . '.jpg'; ?>
                            <tr>
                                <td class="ps-4 fw-bold text-success">#<?= $c['idcliente'] ?></td>
                                <td>
                                    <a href="<?= base_url('cliente/actual/' . $c['idcliente']) ?>" class="text-decoration-none d-inline-block">
                                        <img src="<?= esc($fotoUrl) ?>"
                                             alt="Foto <?= esc($c['cedula']) ?>"
                                             class="rounded-circle border border-success shadow-sm"
                                             style="width: 42px; height: 42px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                        <span class="bg-light text-success rounded-circle border align-items-center justify-content-center" style="width: 42px; height: 42px; display: none;">
                                            <i class="bi bi-person-fill"></i>
                                        </span>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace fs-6"><?= esc($c['cedula']) ?></span>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <a href="<?= base_url('cliente/actual/' . $c['idcliente']) ?>" class="text-decoration-none text-dark">
                                        <?= esc(trim(($c['persona_apellidos'] ?? '') . ' ' . ($c['persona_nombres'] ?? ''))) ?>
                                    </a>
                                </td>
                                <td><?= !empty($c['sexo_nombre']) ? esc($c['sexo_nombre']) : '-' ?></td>
                                <td><?= !empty($c['fechanacimiento']) ? date('d/m/Y', strtotime($c['fechanacimiento'])) : '-' ?></td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('cliente/actual/' . $c['idcliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Cliente">
                                            <i class="bi bi-eye"></i> Ver Cliente
                                        </a>
                                        <a href="<?= base_url('persona/actual/' . $c['idpersona']) ?>" class="btn btn-outline-info text-dark" title="Ir a Ficha de la Persona">
                                            <i class="bi bi-person-vcard"></i> Ficha Persona
                                        </a>
                                        <a href="<?= base_url('cliente/edit/' . $c['idcliente']) ?>" class="btn btn-outline-warning" title="Editar Asignación">
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
