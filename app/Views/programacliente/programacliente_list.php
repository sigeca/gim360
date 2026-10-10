<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-person-lines-fill text-primary me-2"></i>Programas de Clientes</h2>
        <p class="text-muted mb-0">Gestión de programas de entrenamiento asignados a los clientes del gimnasio.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('programacliente/add') ?>" class="btn btn-primary fw-bold">
            <i class="bi bi-plus-circle me-1"></i> + Asignar Programa a Cliente
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('programacliente/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cliente, cédula, nombre de programa, motivo, rutina, ejercicio...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-primary fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('programacliente/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4" style="width: 70px;">ID</th>
                        <th>Cliente</th>
                        <th>Fecha Inicio</th>
                        <th>Estado</th>
                        <th>Programa Asignado</th>
                        <th>Planes en Rutina</th>
                        <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($programasClientes)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron asignaciones de programa registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($programasClientes as $pc): ?>
                            <?php 
                                $badgeColor = 'bg-primary';
                                $estLower = strtolower($pc['estado_nombre'] ?? '');
                                if (str_contains($estLower, 'activo')) $badgeColor = 'bg-success';
                                elseif (str_contains($estLower, 'completado')) $badgeColor = 'bg-info text-dark';
                                elseif (str_contains($estLower, 'pausado') || str_contains($estLower, 'espera')) $badgeColor = 'bg-warning text-dark';
                                elseif (str_contains($estLower, 'cancelado')) $badgeColor = 'bg-danger';
                            ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $pc['idprogramacliente'] ?></td>
                                <td>
                                    <div class="fw-bold text-dark">
                                        <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="text-decoration-none text-dark">
                                            <?= esc($pc['cliente_nombres']) ?>
                                        </a>
                                    </div>
                                    <small class="text-muted">C.I: <?= esc($pc['cliente_cedula']) ?></small>
                                </td>
                                <td>
                                    <span class="small fw-semibold text-secondary">
                                        <i class="bi bi-calendar-event me-1 text-primary"></i>
                                        <?= date('d/m/Y', strtotime($pc['fechainicio'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeColor ?> px-2 py-1">
                                        <?= esc($pc['estado_nombre']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark small">
                                        <?= esc($pc['programa_nombre'] ?? $pc['motivo_nombre']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <i class="bi bi-bullseye me-1 text-warning"></i><?= esc($pc['motivo_nombre']) ?> &bull; <i class="bi bi-collection-play me-1 text-info"></i><?= $pc['total_rutinas'] ?? 0 ?> rutinas
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1">
                                        <i class="bi bi-card-checklist me-1"></i><?= $pc['total_planes'] ?? 0 ?> <?= ($pc['total_planes'] ?? 0) == 1 ? 'plan' : 'planes' ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('programacliente/edit/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalDelete_<?= $pc['idprogramacliente'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade text-start" id="modalDelete_<?= $pc['idprogramacliente'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Asignación</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro de eliminar el programa del cliente <strong><?= esc($pc['cliente_nombres']) ?></strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form method="post" action="<?= base_url('programacliente/delete/' . $pc['idprogramacliente']) ?>">
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
