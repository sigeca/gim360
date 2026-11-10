<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

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
                                        <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($visita['cedula'])) . '.jpg'; ?>
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto en tamaño original" class="text-decoration-none">
                                                <img src="<?= esc($fotoUrl) ?>"
                                                     alt="Foto <?= esc($visita['cedula']) ?>"
                                                     class="rounded-circle border border-success shadow-sm"
                                                     style="width: 48px; height: 48px; object-fit: cover;"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                <span class="bg-light text-success rounded-circle border align-items-center justify-content-center" style="width: 48px; height: 48px; display: none;">
                                                    <i class="bi bi-person-fill fs-5"></i>
                                                </span>
                                            </a>
                                            <div>
                                                <a href="<?= base_url('cliente/actual/' . $visita['idcliente']) ?>" class="fs-6 fw-bold text-dark text-decoration-none">
                                                    <?= esc($visita['cliente_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                                </a>
                                                <span class="badge bg-light text-dark border ms-2 font-monospace">Cédula: <?= esc($visita['cedula']) ?></span>
                                            </div>
                                        </div>
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

            <!-- Cuadro del Programa de Entrenamiento Asignado al Cliente -->
            <div class="card card-custom bg-white border-top border-4 border-primary mt-4 shadow-sm">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clipboard2-pulse-fill text-primary me-2"></i>Programa de Entrenamiento Asignado
                    </h5>
                    <?php if (!empty($programasCliente)): ?>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary fs-6"><?= count($programasCliente) ?> <?= count($programasCliente) === 1 ? 'programa' : 'programas' ?></span>
                            <a href="<?= base_url('programacliente/add?idcliente=' . $visita['idcliente']) ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Asignar Otro
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($programasCliente)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-clipboard2-x fs-2 d-block mb-2 text-secondary"></i>
                            <p class="mb-2">Este cliente no tiene ningún programa de entrenamiento asignado.</p>
                            <a href="<?= base_url('programacliente/add?idcliente=' . $visita['idcliente']) ?>" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i> Asignar Programa de Entrenamiento
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Programa de Entrenamiento</th>
                                        <th>Motivo / Objetivo</th>
                                        <th>Rango de Edad</th>
                                        <th class="text-center">Contenido</th>
                                        <th class="text-center">Fecha Inicio</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programasCliente as $pc): ?>
                                        <?php
                                            $estLower = strtolower($pc['estado_nombre'] ?? '');
                                            $badgeColor = 'bg-secondary';
                                            if (str_contains($estLower, 'activo') || str_contains($estLower, 'ejecu')) $badgeColor = 'bg-success';
                                            elseif (str_contains($estLower, 'completado') || str_contains($estLower, 'finalizado')) $badgeColor = 'bg-info text-dark';
                                            elseif (str_contains($estLower, 'pausado') || str_contains($estLower, 'espera')) $badgeColor = 'bg-warning text-dark';
                                            elseif (str_contains($estLower, 'cancelado') || str_contains($estLower, 'inactivo')) $badgeColor = 'bg-danger';
                                        ?>
                                        <tr>
                                            <td class="ps-4">
                                                <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                    <?= esc($pc['programa_nombre']) ?>
                                                </a>
                                                <small class="text-muted">
                                                    <a href="<?= base_url('programaentrenamiento/actual/' . $pc['idprogramaentrenamiento']) ?>" class="text-muted text-decoration-none">
                                                        <i class="bi bi-clipboard2-pulse me-1"></i>Base #<?= $pc['idprogramaentrenamiento'] ?>
                                                    </a>
                                                    <?php if (!empty($pc['rutinas_nombres'])): ?>
                                                        • <span class="text-primary"><i class="bi bi-list-check me-1"></i><?= esc($pc['rutinas_nombres']) ?></span>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                                    <i class="bi bi-bullseye me-1"></i><?= esc($pc['motivo_nombre']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if (!empty($pc['rango_nombre'])): ?>
                                                    <span class="small text-muted">
                                                        <i class="bi bi-person-badge me-1"></i><?= esc($pc['rango_nombre']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border me-1" title="Rutinas incluidas">
                                                    <i class="bi bi-calendar2-week text-info me-1"></i><?= (int)($pc['total_rutinas'] ?? 0) ?> rutinas
                                                </span>
                                                <span class="badge bg-light text-dark border" title="Planes de ejercicio">
                                                    <i class="bi bi-card-checklist text-success me-1"></i><?= (int)($pc['total_planes'] ?? 0) ?> planes
                                                </span>
                                            </td>
                                            <td class="text-center fw-semibold text-dark">
                                                <i class="bi bi-calendar-check text-primary me-1"></i><?= !empty($pc['fechainicio']) ? date('d/m/Y', strtotime($pc['fechainicio'])) : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge <?= $badgeColor ?> px-2 py-1">
                                                    <i class="bi bi-flag-fill me-1"></i><?= esc($pc['estado_nombre']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="btn btn-sm btn-outline-primary" title="Ver Detalle del Programa">
                                                    <i class="bi bi-eye me-1"></i>Ver Programa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Tabla de Ejercicios Realizados en el Día -->
            <div class="card card-custom bg-white border-top border-4 border-success mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-activity text-success me-2"></i>Ejercicios Realizados en este Día
                    </h5>
                    <span class="badge bg-success fs-6"><?= count($ejercicios ?? []) ?> <?= (count($ejercicios ?? []) === 1) ? 'ejercicio' : 'ejercicios' ?></span>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($ejercicios)): ?>
                        <div class="text-center py-5 text-muted">
                            <i class="bi bi-clipboard-x fs-1 d-block mb-2 text-secondary"></i>
                            <p class="mb-0">No se registraron ejercicios realizados por el cliente en este día (<?= date('d/m/Y', strtotime($visita['fecha'])) ?>).</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 text-center" style="width: 80px;">Imagen</th>
                                        <th>Ejercicio</th>
                                        <th class="text-center">Hora Inicio</th>
                                        <th class="text-center">Hora Fin</th>
                                        <th class="text-center">Series</th>
                                        <th class="text-center">Repeticiones</th>
                                        <th class="text-center pe-4">Descanso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ejercicios as $ej): ?>
                                        <tr>
                                            <td class="ps-4 text-center">
                                                <?php if (!empty($ej['ejercicio_imagen'])): ?>
                                                    <img src="<?= base_url('ejercicio/imagen/' . rawurlencode($ej['ejercicio_imagen'])) ?>"
                                                         alt="<?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?>"
                                                         class="rounded border bg-light shadow-sm"
                                                         style="width: 48px; height: 48px; object-fit: cover;"
                                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                                                    <span class="bg-light text-secondary rounded border align-items-center justify-content-center" style="width: 48px; height: 48px; display: none;">
                                                        <i class="bi bi-activity fs-5"></i>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="bg-light text-secondary rounded border d-inline-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                                        <i class="bi bi-activity fs-5 text-muted"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark"><?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?></div>
                                                <?php if (!empty($ej['nombreingles']) && $ej['nombreingles'] !== ($ej['nombreespanol'] ?? '')): ?>
                                                    <small class="text-muted fst-italic"><?= esc($ej['nombreingles']) ?></small>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($ej['horainicio'])): ?>
                                                    <span class="badge bg-primary font-monospace px-2 py-1" title="<?= esc($ej['horainicio']) ?>">
                                                        <i class="bi bi-play-circle me-1"></i><?= date('H:i', strtotime($ej['horainicio'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (!empty($ej['horafin'])): ?>
                                                    <span class="badge bg-success font-monospace px-2 py-1" title="<?= esc($ej['horafin']) ?>">
                                                        <i class="bi bi-check-circle me-1"></i><?= date('H:i', strtotime($ej['horafin'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning text-dark px-2 py-1">
                                                        <i class="bi bi-hourglass-split me-1"></i>En curso
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($ej['series']) && $ej['series'] !== null && $ej['series'] !== ''): ?>
                                                    <span class="badge bg-primary-subtle text-primary border border-primary px-2 py-1 fw-bold"><?= esc($ej['series']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <?php if (isset($ej['repeticiones']) && $ej['repeticiones'] !== null && $ej['repeticiones'] !== ''): ?>
                                                    <span class="fw-bold fs-6 text-dark"><?= esc($ej['repeticiones']) ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center pe-4">
                                                <?php if (isset($ej['tiempodescanso']) && $ej['tiempodescanso'] !== null && $ej['tiempodescanso'] !== ''): ?>
                                                    <span class="badge bg-light text-dark border px-2 py-1 font-monospace">
                                                        <i class="bi bi-stopwatch text-warning me-1"></i><?= esc($ej['tiempodescanso']) ?> s
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted small">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
