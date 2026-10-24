<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($plan)): ?>
            <?= view('layout/empty_record', ['module' => 'planalimentacion']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'planalimentacion',
                'currentId' => $plan['idplanalimentacion']
            ]) ?>

            <!-- Ficha Principal del Plan -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-journal-medical text-success fs-4"></i>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><?= esc($plan['nombre']) ?></h5>
                            <small class="text-muted">Plan Nutricional #<?= $plan['idplanalimentacion'] ?></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <?php $est = $plan['estado_info']; ?>
                        <span class="badge <?= $est['badge_class'] ?> px-3 py-2 fs-6 shadow-sm">
                            <i class="bi <?= $est['icono'] ?> me-1"></i><?= $est['etiqueta'] ?>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <!-- Columna Izquierda: Persona asignada -->
                        <div class="col-md-5">
                            <div class="p-3 bg-light rounded-4 border h-100 shadow-sm d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center" style="width: 58px; height: 58px;">
                                            <i class="bi bi-person-fill fs-2"></i>
                                        </div>
                                        <div>
                                            <span class="badge bg-secondary-subtle text-secondary small">Persona Asignada</span>
                                            <h6 class="fw-bold mb-0 text-dark">
                                                <a href="<?= base_url('persona/actual/' . $plan['idpersona']) ?>" class="text-decoration-none text-dark">
                                                    <?= esc($plan['apellidos']) ?>, <?= esc($plan['nombres']) ?>
                                                </a>
                                            </h6>
                                            <small class="text-muted">C.I. <?= esc($plan['cedula']) ?></small>
                                        </div>
                                    </div>

                                    <ul class="list-group list-group-flush small bg-transparent mb-3">
                                        <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                                            <span class="text-muted"><i class="bi bi-gender-ambiguous me-1"></i>Sexo:</span>
                                            <span class="fw-semibold"><?= esc($plan['sexo_nombre'] ?? 'No especificado') ?></span>
                                        </li>
                                        <?php if (!empty($plan['fechanacimiento'])): ?>
                                            <li class="list-group-item bg-transparent px-0 d-flex justify-content-between">
                                                <span class="text-muted"><i class="bi bi-cake2 me-1"></i>Nacimiento:</span>
                                                <span class="fw-semibold"><?= esc($plan['fechanacimiento']) ?></span>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>

                                <div class="d-grid gap-2 pt-2 border-top">
                                    <a href="<?= base_url('persona/actual/' . $plan['idpersona']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-person-vcard me-1"></i>Ver Ficha de la Persona
                                    </a>
                                    <a href="<?= base_url('perfilnutricional/listar?q=' . urlencode($plan['cedula'])) ?>" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-heart-pulse-fill me-1"></i>Evaluaciones Nutricionales
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Parámetros del Plan -->
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Registro</th>
                                            <td class="fw-bold text-secondary">#<?= $plan['idplanalimentacion'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Plan</th>
                                            <td class="fw-bold text-dark fs-6">
                                                <i class="bi bi-bookmark-check-fill text-success me-1"></i><?= esc($plan['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha de Inicio</th>
                                            <td class="fw-semibold text-dark">
                                                <i class="bi bi-calendar-check text-primary me-1"></i><?= esc($plan['fechainicio']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha de Fin</th>
                                            <td class="fw-semibold text-dark">
                                                <?php if (!empty($plan['fechafin'])): ?>
                                                    <i class="bi bi-calendar-x text-danger me-1"></i><?= esc($plan['fechafin']) ?>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-muted border">Indefinido / Permanente</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Objetivo del Plan</th>
                                            <td>
                                                <?php if (!empty($plan['objetivo'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-success text-secondary small">
                                                        <i class="bi bi-bullseye text-success me-1"></i><?= nl2br(esc($plan['objetivo'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin objetivo específico registrado.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i><?= $est['descripcion'] ?>
                    </span>
                    <a href="<?= base_url('planalimentacion/add?idpersona=' . $plan['idpersona']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>Crear otro plan para esta persona
                    </a>
                </div>
            </div>

            <!-- Estructura de Comidas Programadas en este Plan -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-calendar2-heart text-success me-2 fs-5"></i>Comidas y Tiempos del Plan
                        <span class="badge bg-success-subtle text-success border border-success ms-2"><?= count($comidas ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('comida/add?idplanalimentacion=' . $plan['idplanalimentacion']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Programar Comida
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($comidas)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar-x fs-2 d-block mb-2 text-secondary"></i>
                            <p class="mb-2">Aún no se han estructurado comidas diarias para este plan de alimentación.</p>
                            <a href="<?= base_url('comida/add?idplanalimentacion=' . $plan['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-lg me-1"></i>Programar la primera comida
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">Hora</th>
                                        <th>Momento / Tipo</th>
                                        <th>Receta Asignada</th>
                                        <th>Porciones</th>
                                        <th>Tiempo Prep.</th>
                                        <th class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($comidas as $cm): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">
                                                <?php if (!empty($cm['horarecomendada'])): ?>
                                                    <span class="badge bg-primary text-white font-monospace">
                                                        <i class="bi bi-alarm-fill me-1"></i><?= substr($cm['horarecomendada'], 0, 5) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge bg-secondary">Flexible</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                                    <?= esc($cm['tipocomida_nombre']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('receta/actual/' . $cm['idreceta']) ?>" class="fw-bold text-decoration-none text-primary">
                                                    <i class="bi bi-book me-1"></i><?= esc($cm['receta_nombre']) ?>
                                                </a>
                                            </td>
                                            <td><?= esc($cm['porciones'] ?? 1) ?> porc.</td>
                                            <td class="text-secondary small">
                                                <?= esc($cm['tiempopreparacion'] ? $cm['tiempopreparacion'] . ' min' : 'No especificado') ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('comida/actual/' . $cm['idcomida']) ?>" class="btn btn-xs btn-outline-primary" title="Ver ficha">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('comida/edit/' . $cm['idcomida']) ?>" class="btn btn-xs btn-outline-warning text-dark" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('comida/delete/' . $cm['idcomida'] . '?from_plan=1') ?>" class="btn btn-xs btn-outline-danger" title="Remover del plan" onclick="return confirm('¿Remover esta comida del plan?');">
                                                    <i class="bi bi-x-lg"></i>
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

            <!-- Otros Planes de Alimentación de la misma Persona -->
            <?php if (!empty($otrosPlanes)): ?>
                <div class="card card-custom bg-white shadow-sm mb-4">
                    <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                            <i class="bi bi-clock-history text-primary me-2"></i>Historial de Planes Nutricionales de <?= esc($plan['nombres']) ?>
                            <span class="badge bg-primary-subtle text-primary ms-2"><?= count($otrosPlanes) ?></span>
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Nombre del Plan</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Estado</th>
                                        <th class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($otrosPlanes as $op): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">#<?= $op['idplanalimentacion'] ?></td>
                                            <td class="fw-semibold text-dark"><?= esc($op['nombre']) ?></td>
                                            <td><?= esc($op['fechainicio']) ?></td>
                                            <td><?= !empty($op['fechafin']) ? esc($op['fechafin']) : '<span class="text-muted fst-italic">Indefinido</span>' ?></td>
                                            <td>
                                                <span class="badge <?= $op['estado_info']['badge_class'] ?> small">
                                                    <?= $op['estado_info']['etiqueta'] ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('planalimentacion/actual/' . $op['idplanalimentacion']) ?>" class="btn btn-xs btn-outline-primary" title="Ver plan">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
