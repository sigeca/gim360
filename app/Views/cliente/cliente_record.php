<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($cliente)): ?>
            <?= view('layout/empty_record', ['module' => 'cliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'cliente',
                'currentId' => $cliente['idcliente']
            ]) ?>

            <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($cliente['cedula'])) . '.jpg'; ?>
            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-badge-fill text-success me-2"></i>Ficha de Cliente
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="btn btn-sm btn-primary" title="Ir a la Ficha de la Persona para revisar o hacer cambios">
                            <i class="bi bi-person-vcard me-1"></i> Ver Ficha de Persona
                        </a>
                        <a href="<?= base_url('persona/edit/' . $cliente['idpersona']) ?>" class="btn btn-sm btn-outline-warning text-dark" title="Editar datos personales directamente">
                            <i class="bi bi-pencil-square me-1"></i> Editar Persona
                        </a>
                        <span class="badge bg-success text-white fs-6">ID Cliente #<?= $cliente['idcliente'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-3 text-center">
                            <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto en tamaño original" class="d-inline-block text-decoration-none">
                                <img src="<?= esc($fotoUrl) ?>"
                                     alt="Foto Cédula <?= esc($cliente['cedula']) ?>"
                                     class="img-thumbnail rounded-3 border-success shadow-sm"
                                     style="width: 140px; height: 165px; object-fit: cover;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-light text-success border rounded-3 shadow-sm align-items-center justify-content-center mx-auto" style="width: 140px; height: 165px; display: none;">
                                    <i class="bi bi-person-bounding-box fs-1"></i>
                                </div>
                            </a>
                            <div class="mt-2 small text-muted font-monospace"><?= esc($cliente['cedula']) ?></div>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-25 text-muted">ID Cliente</th>
                                            <td class="fw-bold text-success">#<?= $cliente['idcliente'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Persona Asociada</th>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                    <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="fs-5 fw-bold text-primary text-decoration-none" title="Saltar a la Ficha de la Persona">
                                                        <i class="bi bi-person-fill me-1"></i><?= esc(trim(($cliente['persona_apellidos'] ?? '') . ' ' . ($cliente['persona_nombres'] ?? ''))) ?>
                                                        <i class="bi bi-box-arrow-up-right fs-6 ms-1"></i>
                                                    </a>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="btn btn-outline-primary">
                                                            <i class="bi bi-person-lines-fill me-1"></i> Ir a Ficha de Persona (#<?= $cliente['idpersona'] ?>)
                                                        </a>
                                                        <a href="<?= base_url('persona/edit/' . $cliente['idpersona']) ?>" class="btn btn-outline-secondary" title="Modificar datos de la persona">
                                                            <i class="bi bi-pencil"></i> Editar Datos
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Cédula</th>
                                            <td class="font-monospace fs-6"><?= esc($cliente['cedula']) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Sexo</th>
                                            <td><?= !empty($cliente['sexo_nombre']) ? esc($cliente['sexo_nombre']) : '<span class="text-muted">-</span>' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha Nacimiento</th>
                                            <td><?= !empty($cliente['fechanacimiento']) ? date('d/m/Y', strtotime($cliente['fechanacimiento'])) : '<span class="text-muted">-</span>' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestañas de los 4 Programas del Cliente -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white pt-3 pb-0 border-bottom">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-grid-1x2-fill text-primary me-2"></i>Programas Asignados al Cliente
                        </h6>
                    </div>
                    <ul class="nav nav-tabs card-header-tabs" id="clienteProgramasTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold text-primary d-flex align-items-center gap-2"
                                    id="entrenamiento-tab" data-bs-toggle="tab" data-bs-target="#entrenamiento-pane"
                                    type="button" role="tab" aria-controls="entrenamiento-pane" aria-selected="true">
                                <i class="bi bi-activity"></i>
                                <span>Entrenamiento</span>
                                <span class="badge bg-primary rounded-pill"><?= !empty($programasCliente) ? count($programasCliente) : 0 ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-success d-flex align-items-center gap-2"
                                    id="alimentacion-tab" data-bs-toggle="tab" data-bs-target="#alimentacion-pane"
                                    type="button" role="tab" aria-controls="alimentacion-pane" aria-selected="false">
                                <i class="bi bi-egg-fried"></i>
                                <span>Alimentación</span>
                                <span class="badge bg-success rounded-pill"><?= !empty($planesAlimentacion) ? count($planesAlimentacion) : 0 ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-danger d-flex align-items-center gap-2"
                                    id="medicacion-tab" data-bs-toggle="tab" data-bs-target="#medicacion-pane"
                                    type="button" role="tab" aria-controls="medicacion-pane" aria-selected="false">
                                <i class="bi bi-capsule"></i>
                                <span>Medicación</span>
                                <span class="badge bg-danger rounded-pill"><?= !empty($misMedicaciones) ? count($misMedicaciones) : 0 ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-info d-flex align-items-center gap-2"
                                    id="entretenimiento-tab" data-bs-toggle="tab" data-bs-target="#entretenimiento-pane"
                                    type="button" role="tab" aria-controls="entretenimiento-pane" aria-selected="false">
                                <i class="bi bi-controller"></i>
                                <span>Entretenimiento</span>
                                <span class="badge bg-info text-dark rounded-pill"><?= !empty($misEntretenimientos) ? count($misEntretenimientos) : 0 ?></span>
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-0">
                    <div class="tab-content" id="clienteProgramasTabsContent">

                        <!-- PESTAÑA 1: Ejercitación / Entrenamiento (programacliente) -->
                        <div class="tab-pane fade show active" id="entrenamiento-pane" role="tabpanel" aria-labelledby="entrenamiento-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3 bg-light border-bottom">
                                <span class="small text-muted fw-semibold">
                                    <i class="bi bi-play-circle-fill text-primary me-1"></i>Programas de Ejercitación y Entrenamiento (<code>programacliente</code>)
                                </span>
                                <a href="<?= base_url('programacliente/add?idcliente=' . $cliente['idcliente']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Entrenamiento
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Programa de Entrenamiento</th>
                                            <th>Motivo / Rango Edad</th>
                                            <th class="text-center">Contenido</th>
                                            <th>Fecha Inicio</th>
                                            <th>Estado</th>
                                            <th class="text-end pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($programasCliente)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="bi bi-clipboard2-x fs-3 d-block mb-1"></i>
                                                    Este cliente aún no tiene programas de entrenamiento asignados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($programasCliente as $pc): ?>
                                                <?php
                                                    $badgeColor = 'bg-primary';
                                                    $estLower = strtolower($pc['estado_nombre'] ?? '');
                                                    if (str_contains($estLower, 'activo') || str_contains($estLower, 'ejecu')) $badgeColor = 'bg-success';
                                                    elseif (str_contains($estLower, 'completado') || str_contains($estLower, 'finalizado')) $badgeColor = 'bg-info text-dark';
                                                    elseif (str_contains($estLower, 'pausado') || str_contains($estLower, 'espera')) $badgeColor = 'bg-warning text-dark';
                                                    elseif (str_contains($estLower, 'cancelado') || str_contains($estLower, 'inactivo')) $badgeColor = 'bg-danger';
                                                ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold text-primary">#<?= $pc['idprogramacliente'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                            <?= esc($pc['programa_nombre']) ?>
                                                        </a>
                                                        <a href="<?= base_url('programaentrenamiento/actual/' . $pc['idprogramaentrenamiento']) ?>" class="small text-muted text-decoration-none">
                                                            <i class="bi bi-clipboard2-pulse me-1"></i>Ver Programa Base #<?= $pc['idprogramaentrenamiento'] ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark mb-1">
                                                            <i class="bi bi-bullseye me-1"></i><?= esc($pc['motivo_nombre']) ?>
                                                        </span>
                                                        <?php if (!empty($pc['rango_nombre'])): ?>
                                                            <div class="small text-muted">
                                                                <i class="bi bi-person-bounding-box me-1"></i><?= esc($pc['rango_nombre']) ?> (<?= $pc['rango_edadminima'] ?>-<?= $pc['rango_edadmaxima'] ?> años)
                                                            </div>
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
                                                    <td class="fw-semibold text-dark">
                                                        <i class="bi bi-calendar-event text-primary me-1"></i><?= !empty($pc['fechainicio']) ? date('d/m/Y', strtotime($pc['fechainicio'])) : '-' ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge <?= $badgeColor ?> px-2 py-1">
                                                            <i class="bi bi-flag-fill me-1"></i><?= esc($pc['estado_nombre']) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Ejecución del Programa">
                                                                <i class="bi bi-eye"></i> Ver Programa
                                                            </a>
                                                            <a href="<?= base_url('programacliente/edit/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-warning" title="Editar Asignación">
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

                        <!-- PESTAÑA 2: Alimentación / Nutrición (planalimentacion) -->
                        <div class="tab-pane fade" id="alimentacion-pane" role="tabpanel" aria-labelledby="alimentacion-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3 bg-light border-bottom">
                                <span class="small text-muted fw-semibold">
                                    <i class="bi bi-egg-fried text-success me-1"></i>Planes de Alimentación y Nutrición (<code>planalimentacion</code>)
                                </span>
                                <a href="<?= base_url('planalimentacion/add?idpersona=' . $cliente['idpersona']) ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Plan Alimenticio
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Plan de Alimentación</th>
                                            <th>Objetivo Nutricional</th>
                                            <th>Período de Vigencia</th>
                                            <th>Estado</th>
                                            <th class="text-end pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($planesAlimentacion)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4 text-muted">
                                                    <i class="bi bi-journal-x fs-3 d-block mb-1"></i>
                                                    Este cliente aún no tiene planes de alimentación o nutrición asignados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($planesAlimentacion as $pl): ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold text-success">#<?= $pl['idplanalimentacion'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('planalimentacion/actual/' . $pl['idplanalimentacion']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                            <i class="bi bi-bookmark-check-fill text-success me-1"></i><?= esc($pl['nombre']) ?>
                                                        </a>
                                                        <?php if (!empty($pl['objetivo'])): ?>
                                                            <div class="small text-muted text-truncate" style="max-width: 300px;">
                                                                <?= esc($pl['objetivo']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($pl['objetivonutricional_nombre'])): ?>
                                                            <a href="<?= base_url('objetivonutricional/actual/' . $pl['idobjetivonutricional']) ?>" class="badge bg-warning-subtle text-dark border border-warning text-decoration-none">
                                                                <i class="bi bi-bullseye text-warning me-1"></i><?= esc($pl['objetivonutricional_nombre']) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted small fst-italic">No especificado</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="small">
                                                        <div class="text-dark fw-semibold">
                                                            <i class="bi bi-calendar-event text-primary me-1"></i>Desde: <?= !empty($pl['fechainicio']) ? date('d/m/Y', strtotime($pl['fechainicio'])) : '-' ?>
                                                        </div>
                                                        <div class="text-muted">
                                                            <i class="bi bi-calendar2-check text-secondary me-1"></i>Hasta: <?= !empty($pl['fechafin']) ? date('d/m/Y', strtotime($pl['fechafin'])) : '<span class="fst-italic">Indefinido</span>' ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($pl['estado_info'])): ?>
                                                            <span class="badge <?= esc($pl['estado_info']['badge_class']) ?> px-2 py-1">
                                                                <i class="bi <?= esc($pl['estado_info']['icono']) ?> me-1"></i><?= esc($pl['estado_info']['etiqueta']) ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('planalimentacion/actual/' . $pl['idplanalimentacion']) ?>" class="btn btn-outline-success" title="Ver Plan de Alimentación">
                                                                <i class="bi bi-eye"></i> Ver Programa
                                                            </a>
                                                            <a href="<?= base_url('planalimentacion/edit/' . $pl['idplanalimentacion']) ?>" class="btn btn-outline-warning" title="Editar Plan">
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

                        <!-- PESTAÑA 3: Medicación (mimedicacion) -->
                        <div class="tab-pane fade" id="medicacion-pane" role="tabpanel" aria-labelledby="medicacion-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3 bg-light border-bottom">
                                <span class="small text-muted fw-semibold">
                                    <i class="bi bi-capsule text-danger me-1"></i>Programas de Medicación (<code>mimedicacion</code>)
                                </span>
                                <a href="<?= base_url('mimedicacion/add?idpersona=' . $cliente['idpersona']) ?>" class="btn btn-sm btn-danger">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Medicación
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Tratamiento / Medicación</th>
                                            <th>Afección / Médico</th>
                                            <th class="text-center">Medicamentos</th>
                                            <th>Vigencia</th>
                                            <th>Estado</th>
                                            <th class="text-end pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($misMedicaciones)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    <i class="bi bi-capsule-pill fs-3 d-block mb-1"></i>
                                                    Este cliente aún no tiene programas de medicación asignados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($misMedicaciones as $med): ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold text-danger">#<?= $med['idmimedicacion'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('mimedicacion/actual/' . $med['idmimedicacion']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                            <?= esc($med['nombre']) ?>
                                                        </a>
                                                        <?php if (!empty($med['idmedicacion'])): ?>
                                                            <a href="<?= base_url('medicacion/actual/' . $med['idmedicacion']) ?>" class="small text-muted text-decoration-none">
                                                                <i class="bi bi-journal-medical me-1"></i>Base: <?= esc($med['base_medicacion_nombre'] ?: ('#' . $med['idmedicacion'])) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="small text-muted fst-italic">Personalizado</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($med['afeccion_nombre'])): ?>
                                                            <a href="<?= base_url('afeccion/actual/' . $med['idafeccion']) ?>" class="badge bg-warning text-dark text-decoration-none mb-1">
                                                                <i class="bi bi-heart-pulse me-1"></i><?= esc($med['afeccion_nombre']) ?>
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (!empty($med['medicotratante'])): ?>
                                                            <div class="small text-muted">
                                                                <i class="bi bi-person-badge me-1"></i>Dr(a). <?= esc($med['medicotratante']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if (empty($med['afeccion_nombre']) && empty($med['medicotratante'])): ?>
                                                            <span class="text-muted small">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-danger-subtle text-danger border">
                                                            <i class="bi bi-prescription2 me-1"></i><?= (int)($med['total_medicamentos'] ?? 0) ?> med.
                                                        </span>
                                                    </td>
                                                    <td class="small">
                                                        <div class="text-dark fw-semibold">
                                                            <i class="bi bi-calendar-event text-primary me-1"></i><?= !empty($med['fechainicio']) ? date('d/m/Y', strtotime($med['fechainicio'])) : '-' ?>
                                                        </div>
                                                        <?php if (!empty($med['fechafin'])): ?>
                                                            <div class="text-muted">
                                                                <i class="bi bi-calendar2-check text-secondary me-1"></i><?= date('d/m/Y', strtotime($med['fechafin'])) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $medEstado = $med['estado'] ?: 'Activa';
                                                            $medBadge = (strtolower($medEstado) === 'activa' || strtolower($medEstado) === 'activo') ? 'bg-success' : 'bg-secondary';
                                                        ?>
                                                        <span class="badge <?= $medBadge ?> px-2 py-1">
                                                            <?= esc($medEstado) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('mimedicacion/actual/' . $med['idmimedicacion']) ?>" class="btn btn-outline-danger" title="Ver Medicación">
                                                                <i class="bi bi-eye"></i> Ver Programa
                                                            </a>
                                                            <a href="<?= base_url('mimedicacion/edit/' . $med['idmimedicacion']) ?>" class="btn btn-outline-warning" title="Editar Medicación">
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

                        <!-- PESTAÑA 4: Entretenimiento (mientretenimiento) -->
                        <div class="tab-pane fade" id="entretenimiento-pane" role="tabpanel" aria-labelledby="entretenimiento-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 px-4 py-3 bg-light border-bottom">
                                <span class="small text-muted fw-semibold">
                                    <i class="bi bi-controller text-info me-1"></i>Programas de Entretenimiento (<code>mientretenimiento</code>)
                                </span>
                                <a href="<?= base_url('mientretenimiento/add?idpersona=' . $cliente['idpersona']) ?>" class="btn btn-sm btn-info text-dark fw-semibold">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Entretenimiento
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">ID</th>
                                            <th>Programa / Lista</th>
                                            <th>Plantilla Base</th>
                                            <th class="text-center">Contenido Multimedia</th>
                                            <th class="text-end pe-4">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($misEntretenimientos)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    <i class="bi bi-music-note-list fs-3 d-block mb-1"></i>
                                                    Este cliente aún no tiene programas de entretenimiento asignados.
                                                </td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($misEntretenimientos as $ent): ?>
                                                <tr>
                                                    <td class="ps-4 fw-bold text-info">#<?= $ent['idmientretenimiento'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('mientretenimiento/actual/' . $ent['idmientretenimiento']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                            <?= esc($ent['nombre']) ?>
                                                        </a>
                                                        <?php if (!empty($ent['descripcion'])): ?>
                                                            <div class="small text-muted text-truncate" style="max-width: 300px;">
                                                                <?= esc($ent['descripcion']) ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($ent['identretenimiento'])): ?>
                                                            <a href="<?= base_url('entretenimiento/actual/' . $ent['identretenimiento']) ?>" class="badge bg-light text-dark border text-decoration-none">
                                                                <i class="bi bi-collection-play me-1"></i><?= esc($ent['base_entretenimiento_nombre'] ?: ('#' . $ent['identretenimiento'])) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted small fst-italic">Personalizado</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-danger-subtle text-danger border me-1" title="Músicas">
                                                            <i class="bi bi-music-note-beamed me-1"></i><?= (int)($ent['total_musicas'] ?? 0) ?>
                                                        </span>
                                                        <span class="badge bg-primary-subtle text-primary border me-1" title="Videos">
                                                            <i class="bi bi-film me-1"></i><?= (int)($ent['total_videos'] ?? 0) ?>
                                                        </span>
                                                        <span class="badge bg-success-subtle text-success border me-1" title="Juegos">
                                                            <i class="bi bi-controller me-1"></i><?= (int)($ent['total_juegos'] ?? 0) ?>
                                                        </span>
                                                        <span class="badge bg-warning-subtle text-dark border" title="Podcasts">
                                                            <i class="bi bi-mic-fill me-1"></i><?= (int)($ent['total_podcasts'] ?? 0) ?>
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('mientretenimiento/actual/' . $ent['idmientretenimiento']) ?>" class="btn btn-outline-info text-dark" title="Ver Entretenimiento">
                                                                <i class="bi bi-eye"></i> Ver Programa
                                                            </a>
                                                            <a href="<?= base_url('mientretenimiento/edit/' . $ent['idmientretenimiento']) ?>" class="btn btn-outline-warning" title="Editar Entretenimiento">
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
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
