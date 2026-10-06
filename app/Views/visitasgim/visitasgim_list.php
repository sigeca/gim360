<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-clock-history text-success me-2"></i>Gestión de Visitas al Gimnasio</h2>
        <p class="text-muted mb-0">Control de asistencia y accesos en la tabla <code>visitasgim</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('visitasgim/add') ?>" class="btn btn-success">
            <i class="bi bi-plus-circle me-1"></i> + Registrar Nueva Visita
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('visitasgim/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cliente, cédula o fecha (AAAA-MM-DD)...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('visitasgim/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Fecha</th>
                        <th>Ingreso</th>
                        <th>Salida</th>
                        <th>Duración</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($visitas)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No se encontraron visitas registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($visitas as $v): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $v['idvisitasgim'] ?></td>
                                <td>
                                    <a href="<?= base_url('cliente/actual/' . $v['idcliente']) ?>" class="text-decoration-none fw-semibold text-primary">
                                        <?= esc($v['cliente_nombres']) ?>
                                    </a>
                                </td>
                                <td><span class="badge bg-light text-dark border font-monospace"><?= esc($v['cedula']) ?></span></td>
                                <td class="fw-semibold text-dark">
                                    <i class="bi bi-calendar-event me-1 text-muted"></i><?= date('d/m/Y', strtotime($v['fecha'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary font-monospace"><?= date('H:i', strtotime($v['horaingreso'])) ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($v['horasalida'])): ?>
                                        <span class="badge bg-secondary font-monospace"><?= date('H:i', strtotime($v['horasalida'])) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>En curso</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        if (!empty($v['horaingreso']) && !empty($v['horasalida'])) {
                                            $tIngreso = strtotime($v['fecha'] . ' ' . $v['horaingreso']);
                                            $tSalida  = strtotime($v['fecha'] . ' ' . $v['horasalida']);
                                            $diffSec  = $tSalida - $tIngreso;
                                            if ($diffSec > 0) {
                                                $horas = floor($diffSec / 3600);
                                                $minutos = floor(($diffSec % 3600) / 60);
                                                echo '<small class="text-muted fw-semibold">' . $horas . 'h ' . $minutos . 'm</small>';
                                            } else {
                                                echo '<small class="text-muted">-</small>';
                                            }
                                        } else {
                                            echo '<small class="text-muted">-</small>';
                                        }
                                    ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('visitasgim/actual/' . $v['idvisitasgim']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('visitasgim/edit/' . $v['idvisitasgim']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('visitasgim/delete/' . $v['idvisitasgim']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar este registro de visita?');">
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
