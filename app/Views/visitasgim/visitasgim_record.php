<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($visita)): ?>
            <?= view('layout/empty_record', ['module' => 'visitasgim']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'visitasgim',
                'currentId' => $visita['idvisitasgim']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-success me-2"></i>Ficha de Visita al Gimnasio
                    </h5>
                    <span class="badge bg-success fs-6">ID Visita #<?= $visita['idvisitasgim'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Visita</th>
                                    <td class="fw-bold text-muted"><?= $visita['idvisitasgim'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Cliente</th>
                                    <td>
                                        <a href="<?= base_url('cliente/actual/' . $visita['idcliente']) ?>" class="fs-6 fw-bold text-dark text-decoration-none">
                                            <?= esc($visita['cliente_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace">Cédula: <?= esc($visita['cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Fecha de Visita</th>
                                    <td class="fs-6 fw-semibold text-dark">
                                        <i class="bi bi-calendar3 text-primary me-2"></i>
                                        <?= date('d/m/Y', strtotime($visita['fecha'])) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Hora de Ingreso</th>
                                    <td>
                                        <span class="badge bg-primary fs-6 px-3 py-2 font-monospace">
                                            <i class="bi bi-box-arrow-in-right me-1"></i><?= date('H:i', strtotime($visita['horaingreso'])) ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Hora de Salida</th>
                                    <td>
                                        <?php if (!empty($visita['horasalida'])): ?>
                                            <span class="badge bg-secondary fs-6 px-3 py-2 font-monospace">
                                                <i class="bi bi-box-arrow-right me-1"></i><?= date('H:i', strtotime($visita['horasalida'])) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                <i class="bi bi-hourglass-split me-1"></i> En entrenamiento (Activo)
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php if (!empty($visita['horaingreso']) && !empty($visita['horasalida'])): ?>
                                <tr>
                                    <th class="table-light text-muted">Tiempo de Estadía</th>
                                    <td>
                                        <?php
                                            $tIngreso = strtotime($visita['fecha'] . ' ' . $visita['horaingreso']);
                                            $tSalida  = strtotime($visita['fecha'] . ' ' . $visita['horasalida']);
                                            $diffSec  = $tSalida - $tIngreso;
                                            if ($diffSec > 0) {
                                                $horas = floor($diffSec / 3600);
                                                $minutos = floor(($diffSec % 3600) / 60);
                                                echo '<span class="fw-bold text-success"><i class="bi bi-stopwatch me-1"></i>' . $horas . ' h ' . $minutos . ' min</span>';
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

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
