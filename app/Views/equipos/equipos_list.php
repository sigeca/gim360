<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-gear-wide-connected text-primary me-2"></i>Inventario de Equipos</h2>
        <p class="text-muted mb-0">Gestión de máquinas, aparatos y equipamiento de la tabla <code>equipos</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('equipos/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> + Registrar Nuevo Equipo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('equipos/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por código, nombre, modelo o número de serie...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('equipos/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4">Código</th>
                        <th>Nombre del Equipo</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Ubicación</th>
                        <th>Estado</th>
                        <th>Activo</th>
                        <th>Valor Adq.</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($equipos)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">No se encontraron equipos registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($equipos as $e): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary font-monospace"><?= esc($e['codigo']) ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('equipos/actual/' . $e['id_equipo']) ?>" class="fw-bold text-dark text-decoration-none">
                                        <?= esc($e['nombre']) ?>
                                    </a>
                                    <?php if (!empty($e['modelo'])): ?>
                                        <small class="d-block text-muted">Mod: <?= esc($e['modelo']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        <?= esc($tipos[$e['id_tipo']] ?? '-') ?>
                                    </span>
                                </td>
                                <td><?= esc($marcas[$e['id_marca']] ?? '-') ?></td>
                                <td>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1 text-danger"></i><?= esc($ubicaciones[$e['id_ubicacion']] ?? '-') ?></small>
                                </td>
                                <td>
                                    <?php
                                        $estadoId = $e['id_estado'] ?? 1;
                                        $estadoName = $estados[$estadoId] ?? 'Desconocido';
                                        $badgeClass = match((int)$estadoId) {
                                            1 => 'bg-success',
                                            2 => 'bg-info text-dark',
                                            3 => 'bg-warning text-dark',
                                            4 => 'bg-danger',
                                            5 => 'bg-secondary',
                                            default => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= esc($estadoName) ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($e['activo'])): ?>
                                        <span class="badge bg-success-subtle text-success border border-success"><i class="bi bi-check-circle me-1"></i>Sí</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger-subtle text-danger border border-danger"><i class="bi bi-x-circle me-1"></i>No</span>
                                    <?php endif; ?>
                                </td>
                                <td class="font-monospace fw-semibold text-muted">
                                    <?= !empty($e['valor_adquisicion']) ? '$' . number_format($e['valor_adquisicion'], 2) : '-' ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('equipos/actual/' . $e['id_equipo']) ?>" class="btn btn-outline-primary" title="Ver Ficha Técnica">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('equipos/edit/' . $e['id_equipo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('equipos/delete/' . $e['id_equipo']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar este equipo?');">
                                            <i class="bi bi-trash"></i>
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
