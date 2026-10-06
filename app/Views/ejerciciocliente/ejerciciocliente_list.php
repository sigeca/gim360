<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-walking text-primary me-2"></i>Ejercicios por Cliente</h2>
        <p class="text-muted mb-0">Control y registro de actividades físicas en la tabla <code>ejerciciocliente</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('ejerciciocliente/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> + Asignar Ejercicio a Cliente
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('ejerciciocliente/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cliente, cédula, ejercicio o fecha (AAAA-MM-DD)...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('ejerciciocliente/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Cliente</th>
                        <th>Cédula</th>
                        <th>Ejercicio Asignado</th>
                        <th>Fecha</th>
                        <th>Duración</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($asignaciones)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron registros de ejercicios para clientes.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($asignaciones as $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $item['idejerciciocliente'] ?></td>
                                <td>
                                    <a href="<?= base_url('cliente/actual/' . $item['idcliente']) ?>" class="text-decoration-none fw-semibold text-primary">
                                        <?= esc($item['cliente_nombres']) ?>
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($item['cedula']) ?></span></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['ejercicio_imagen'])): ?>
                                            <img src="<?= base_url('ejercicio/imagen/' . esc($item['ejercicio_imagen'])) ?>" 
                                                 alt="" 
                                                 class="rounded border bg-light" 
                                                 style="width: 32px; height: 32px; object-fit: contain; padding: 1px;">
                                        <?php endif; ?>
                                        <a href="<?= base_url('ejercicio/actual/' . $item['idejercicio']) ?>" class="text-decoration-none fw-bold text-dark">
                                            <i class="bi bi-fire text-danger me-1"></i><?= esc($item['ejercicio_nombre']) ?>
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <i class="bi bi-calendar-event me-1 text-muted"></i><?= date('d/m/Y', strtotime($item['fecha'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success font-monospace">
                                        <i class="bi bi-stopwatch me-1"></i><?= $item['duracionminutos'] ?> min
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('ejerciciocliente/actual/' . $item['idejerciciocliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejerciciocliente/edit/' . $item['idejerciciocliente']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('ejerciciocliente/delete/' . $item['idejerciciocliente']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar este registro?');">
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
