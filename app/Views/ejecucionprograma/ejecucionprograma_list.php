<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-play-btn-fill text-warning me-2"></i>Ejecución de Programas</h2>
        <p class="text-muted mb-0">Registro de ejercicios realizados por los clientes en la tabla <code>ejecucionprograma</code>.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('ejecucionprograma/add') ?>" class="btn btn-warning fw-bold text-dark">
            <i class="bi bi-plus-circle me-1"></i> + Registrar Ejecución
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('ejecucionprograma/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por cliente, cédula, programa, ejercicio o fecha (AAAA-MM-DD)...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('ejecucionprograma/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Cliente / Programa</th>
                        <th>Ejercicio Ejecutado</th>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Duración</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ejecuciones)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">No se encontraron registros de ejecución de programas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ejecuciones as $e): ?>
                            <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($e['cliente_cedula'])) . '.jpg'; ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $e['idejecucionprograma'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?= esc($fotoUrl) ?>"
                                             alt="Foto <?= esc($e['cliente_cedula']) ?>"
                                             class="rounded-circle border shadow-sm"
                                             style="width: 38px; height: 38px; object-fit: cover;"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                        <span class="bg-light text-secondary rounded-circle border align-items-center justify-content-center" style="width: 38px; height: 38px; display: none;">
                                            <i class="bi bi-person-fill"></i>
                                        </span>
                                        <div>
                                            <a href="<?= base_url('cliente/actual/' . $e['idcliente']) ?>" class="fw-semibold text-dark text-decoration-none d-block">
                                                <?= esc(trim(($e['cliente_apellidos'] ?? '') . ' ' . ($e['cliente_nombres'] ?? ''))) ?>
                                            </a>
                                            <a href="<?= base_url('programacliente/actual/' . $e['idprogramacliente']) ?>" class="small text-primary text-decoration-none">
                                                #<?= $e['idprogramacliente'] ?> — <?= esc($e['programa_nombre']) ?>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($e['ejercicio_imagen'])): ?>
                                            <img src="<?= base_url('ejercicio/imagen/' . rawurlencode($e['ejercicio_imagen'])) ?>"
                                                 alt="<?= esc($e['ejercicio_nombreespanol']) ?>"
                                                 class="rounded border bg-light"
                                                 style="width: 44px; height: 44px; object-fit: cover;">
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?= base_url('ejercicio/actual/' . $e['idejercicio']) ?>" class="fw-semibold text-danger text-decoration-none d-block">
                                                <?= esc($e['ejercicio_nombreespanol']) ?>
                                            </a>
                                            <small class="text-muted fst-italic"><?= esc($e['ejercicio_nombreingles']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="fw-semibold text-dark">
                                    <i class="bi bi-calendar-event me-1 text-muted"></i><?= date('d/m/Y', strtotime($e['fecha'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary font-monospace"><?= date('H:i', strtotime($e['horainicio'])) ?></span>
                                </td>
                                <td>
                                    <?php if (!empty($e['horafin'])): ?>
                                        <span class="badge bg-success font-monospace"><?= date('H:i', strtotime($e['horafin'])) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-warning text-dark"><i class="bi bi-hourglass-split me-1"></i>En curso</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        if (!empty($e['horainicio']) && !empty($e['horafin'])) {
                                            $tInicio = strtotime($e['fecha'] . ' ' . $e['horainicio']);
                                            $tFin    = strtotime($e['fecha'] . ' ' . $e['horafin']);
                                            $diffSec = $tFin - $tInicio;
                                            if ($diffSec > 0) {
                                                $horas   = floor($diffSec / 3600);
                                                $minutos = floor(($diffSec % 3600) / 60);
                                                echo '<small class="text-muted fw-semibold">' . ($horas > 0 ? $horas . 'h ' : '') . $minutos . 'm</small>';
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
                                        <a href="<?= base_url('ejecucionprograma/actual/' . $e['idejecucionprograma']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejecucionprograma/edit/' . $e['idejecucionprograma']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
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
