<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($ejecucion)): ?>
            <?= view('layout/empty_record', ['module' => 'ejecucionprograma']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'ejecucionprograma',
                'currentId' => $ejecucion['idejecucionprograma']
            ]) ?>

            <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($ejecucion['cliente_cedula'])) . '.jpg'; ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-play-btn-fill text-warning me-2"></i>Ficha de Ejecución de Programa
                    </h5>
                    <span class="badge bg-warning text-dark fs-6">ID Ejecución #<?= $ejecucion['idejecucionprograma'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <!-- Imagen Animada del Ejercicio Ejecutado -->
                        <div class="col-md-4 text-center">
                            <div class="border rounded-3 p-3 bg-light shadow-sm">
                                <?php if (!empty($ejecucion['ejercicio_imagen'])): ?>
                                    <a href="<?= base_url('ejercicio/actual/' . $ejecucion['idejercicio']) ?>" class="text-decoration-none d-block">
                                        <img src="<?= base_url('ejercicio/imagen/' . rawurlencode($ejecucion['ejercicio_imagen'])) ?>"
                                             alt="<?= esc($ejecucion['ejercicio_nombreespanol']) ?>"
                                             class="img-fluid rounded"
                                             style="max-height: 200px; object-fit: contain;">
                                    </a>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-activity fs-1 d-block mb-2"></i>
                                        Sin ilustración
                                    </div>
                                <?php endif; ?>
                                <div class="mt-2 fw-bold text-dark small"><?= esc($ejecucion['ejercicio_nombreespanol']) ?></div>
                                <div class="text-muted small fst-italic"><?= esc($ejecucion['ejercicio_nombreingles']) ?></div>
                            </div>
                        </div>

                        <!-- Tabla de Detalles de la Ejecución -->
                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Ejecución</th>
                                            <td class="fw-bold text-dark">#<?= $ejecucion['idejecucionprograma'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Programa Cliente</th>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                    <div>
                                                        <a href="<?= base_url('programacliente/actual/' . $ejecucion['idprogramacliente']) ?>" class="fw-bold text-primary text-decoration-none d-block">
                                                            #<?= $ejecucion['idprogramacliente'] ?> — <?= esc($ejecucion['programa_nombre']) ?>
                                                            <i class="bi bi-box-arrow-up-right small ms-1"></i>
                                                        </a>
                                                        <?php if (!empty($ejecucion['estado_nombre'])): ?>
                                                            <span class="badge bg-info text-dark small"><?= esc($ejecucion['estado_nombre']) ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <a href="<?= base_url('programacliente/actual/' . $ejecucion['idprogramacliente']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-person-lines-fill me-1"></i>Ver Programa Cliente
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Cliente</th>
                                            <td>
                                                <div class="d-flex align-items-center gap-3">
                                                    <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto en tamaño original" class="text-decoration-none">
                                                        <img src="<?= esc($fotoUrl) ?>"
                                                             alt="Foto <?= esc($ejecucion['cliente_cedula']) ?>"
                                                             class="rounded-circle border border-success shadow-sm"
                                                             style="width: 44px; height: 44px; object-fit: cover;"
                                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                        <span class="bg-light text-success rounded-circle border align-items-center justify-content-center" style="width: 44px; height: 44px; display: none;">
                                                            <i class="bi bi-person-fill"></i>
                                                        </span>
                                                    </a>
                                                    <div>
                                                        <a href="<?= base_url('cliente/actual/' . $ejecucion['idcliente']) ?>" class="fw-bold text-dark text-decoration-none">
                                                            <?= esc(trim(($ejecucion['cliente_apellidos'] ?? '') . ' ' . ($ejecucion['cliente_nombres'] ?? ''))) ?>
                                                            <i class="bi bi-box-arrow-up-right small text-primary ms-1"></i>
                                                        </a>
                                                        <div class="small text-muted font-monospace">C.I: <?= esc($ejecucion['cliente_cedula']) ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ejercicio Ejecutado</th>
                                            <td>
                                                <a href="<?= base_url('ejercicio/actual/' . $ejecucion['idejercicio']) ?>" class="fw-bold text-danger text-decoration-none d-block">
                                                    #<?= $ejecucion['idejercicio'] ?> — <?= esc($ejecucion['ejercicio_nombreespanol']) ?>
                                                    <i class="bi bi-box-arrow-up-right small ms-1"></i>
                                                </a>
                                                <span class="small text-muted fst-italic"><?= esc($ejecucion['ejercicio_nombreingles']) ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha</th>
                                            <td class="fs-6 fw-semibold text-dark">
                                                <i class="bi bi-calendar3 text-primary me-2"></i><?= date('d/m/Y', strtotime($ejecucion['fecha'])) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Hora de Inicio</th>
                                            <td>
                                                <span class="badge bg-primary fs-6 px-3 py-2 font-monospace">
                                                    <i class="bi bi-play-fill me-1"></i><?= date('H:i', strtotime($ejecucion['horainicio'])) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Hora de Fin</th>
                                            <td>
                                                <?php if (!empty($ejecucion['horafin'])): ?>
                                                    <span class="badge bg-success fs-6 px-3 py-2 font-monospace">
                                                        <i class="bi bi-stop-fill me-1"></i><?= date('H:i', strtotime($ejecucion['horafin'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                        <i class="bi bi-hourglass-split me-1"></i>En ejecución
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if (!empty($ejecucion['horainicio']) && !empty($ejecucion['horafin'])): ?>
                                        <tr>
                                            <th class="table-light text-muted">Duración</th>
                                            <td>
                                                <?php
                                                    $tInicio = strtotime($ejecucion['fecha'] . ' ' . $ejecucion['horainicio']);
                                                    $tFin    = strtotime($ejecucion['fecha'] . ' ' . $ejecucion['horafin']);
                                                    $diffSec = $tFin - $tInicio;
                                                    if ($diffSec > 0) {
                                                        $horas   = floor($diffSec / 3600);
                                                        $minutos = floor(($diffSec % 3600) / 60);
                                                        echo '<span class="fw-bold text-success"><i class="bi bi-stopwatch me-1"></i>' . ($horas > 0 ? $horas . ' h ' : '') . $minutos . ' min</span>';
                                                    } else {
                                                        echo '<span class="text-muted">-</span>';
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
