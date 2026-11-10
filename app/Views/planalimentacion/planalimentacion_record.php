<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($plan)): ?>
            <?= view('layout/empty_record', ['module' => 'planalimentacion']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'planalimentacion',
                'currentId' => $plan['idplanalimentacion']
            ]) ?>

            <?php 
                $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($plan['cedula'] ?? '')) . '.jpg';
                $est = $plan['estado_info'];
            ?>

            <!-- Ficha Principal del Plan -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto de <?= esc($plan['nombres']) ?>" class="text-decoration-none flex-shrink-0">
                            <img src="<?= esc($fotoUrl) ?>"
                                 alt="Foto de <?= esc($plan['nombres']) ?>"
                                 class="rounded-circle border border-2 border-success shadow-sm"
                                 style="width: 52px; height: 52px; object-fit: cover;"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="bg-success text-white rounded-circle p-2 fs-4 align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; display: none;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        </a>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><?= esc($plan['nombre']) ?></h5>
                            <small class="text-muted">
                                <i class="bi bi-person-fill me-1 text-success"></i><?= esc($plan['apellidos'] . ', ' . $plan['nombres']) ?> 
                                (C.I. <?= esc($plan['cedula']) ?>) • Plan Nutricional #<?= $plan['idplanalimentacion'] ?>
                            </small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
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
                                        <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto de <?= esc($plan['nombres']) ?>" class="text-decoration-none flex-shrink-0">
                                            <img src="<?= esc($fotoUrl) ?>"
                                                 alt="Foto de <?= esc($plan['nombres']) ?>"
                                                 class="rounded-circle border border-2 border-success shadow-sm"
                                                 style="width: 62px; height: 62px; object-fit: cover;"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center border border-success-subtle shadow-sm" style="width: 62px; height: 62px; display: none;">
                                                <i class="bi bi-person-fill fs-2"></i>
                                            </div>
                                        </a>
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
                                            <th class="table-light text-muted">Objetivo Nutricional</th>
                                            <td>
                                                <?php if (!empty($plan['idobjetivonutricional']) && !empty($plan['objetivonutricional_nombre'])): ?>
                                                    <a href="<?= base_url('objetivonutricional/actual/' . $plan['idobjetivonutricional']) ?>" class="badge bg-warning-subtle text-dark border border-warning text-decoration-none py-2 px-3 fw-bold">
                                                        <i class="bi bi-bullseye text-warning me-1"></i><?= esc($plan['objetivonutricional_nombre']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small fst-italic">Sin clasificar</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Detalles / Observaciones</th>
                                            <td>
                                                <?php if (!empty($plan['objetivo'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-success text-secondary small">
                                                        <i class="bi bi-journal-text text-success me-1"></i><?= nl2br(esc($plan['objetivo'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin observaciones registradas.</span>
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

            <?php
                // Configuración de los 7 días de la semana
                $diasSemana = [
                    1 => ['nombre' => 'Lunes',     'slug' => 'lunes'],
                    2 => ['nombre' => 'Martes',    'slug' => 'martes'],
                    3 => ['nombre' => 'Miércoles', 'slug' => 'miercoles'],
                    4 => ['nombre' => 'Jueves',    'slug' => 'jueves'],
                    5 => ['nombre' => 'Viernes',   'slug' => 'viernes'],
                    6 => ['nombre' => 'Sábado',    'slug' => 'sabado'],
                    7 => ['nombre' => 'Domingo',   'slug' => 'domingo'],
                ];

                // Agrupar comidas por día de la semana
                $comidasPorDia = [];
                foreach ($diasSemana as $diaId => $info) {
                    $comidasPorDia[$diaId] = [];
                }
                $comidasOtras = [];

                foreach ($comidas ?? [] as $cm) {
                    $diaId = !empty($cm['iddiasemana']) ? (int)$cm['iddiasemana'] : 0;
                    if (isset($comidasPorDia[$diaId])) {
                        $comidasPorDia[$diaId][] = $cm;
                    } else {
                        $comidasOtras[] = $cm;
                    }
                }

                // Determinar pestaña activa: primer día con comidas o Lunes (1)
                $activeDiaId = 1;
                foreach ($diasSemana as $diaId => $info) {
                    if (!empty($comidasPorDia[$diaId])) {
                        $activeDiaId = $diaId;
                        break;
                    }
                }
            ?>

            <!-- Estructura de Comidas Programadas en este Plan Organizadas por Días de la Semana -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white pt-3 pb-0 border-bottom">
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                            <i class="bi bi-calendar2-heart text-success me-2 fs-5"></i>Comidas y Tiempos del Plan
                            <span class="badge bg-success-subtle text-success border border-success ms-2"><?= count($comidas ?? []) ?> comidas</span>
                        </h6>
                        <a href="<?= base_url('comida/add?idplanalimentacion=' . $plan['idplanalimentacion']) ?>" class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Programar Comida
                        </a>
                    </div>

                    <!-- Pestañas de los días de la semana de Lunes a Domingo -->
                    <ul class="nav nav-tabs card-header-tabs border-bottom-0" id="diasSemanaTabs" role="tablist">
                        <?php foreach ($diasSemana as $diaId => $diaInfo): ?>
                            <?php 
                                $isActive = ($diaId === $activeDiaId);
                                $cant = count($comidasPorDia[$diaId]);
                            ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $isActive ? 'active fw-bold text-success' : 'text-secondary' ?>" 
                                        id="tab-dia-<?= $diaInfo['slug'] ?>" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#pane-dia-<?= $diaInfo['slug'] ?>" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="pane-dia-<?= $diaInfo['slug'] ?>" 
                                        aria-selected="<?= $isActive ? 'true' : 'false' ?>">
                                    <i class="bi bi-calendar-event me-1"></i><?= esc($diaInfo['nombre']) ?>
                                    <span class="badge <?= $cant > 0 ? 'bg-success text-white' : 'bg-light text-muted border' ?> rounded-pill ms-1" style="font-size: 0.72rem;">
                                        <?= $cant ?>
                                    </span>
                                </button>
                            </li>
                        <?php endforeach; ?>

                        <?php if (!empty($comidasOtras)): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-secondary" 
                                        id="tab-dia-otros" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#pane-dia-otros" 
                                        type="button" 
                                        role="tab" 
                                        aria-controls="pane-dia-otros" 
                                        aria-selected="false">
                                    <i class="bi bi-calendar-plus me-1"></i>Otros / Festivos
                                    <span class="badge bg-warning text-dark rounded-pill ms-1" style="font-size: 0.72rem;">
                                        <?= count($comidasOtras) ?>
                                    </span>
                                </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body p-0">
                    <div class="tab-content" id="diasSemanaContent">
                        <?php foreach ($diasSemana as $diaId => $diaInfo): ?>
                            <?php 
                                $isActive = ($diaId === $activeDiaId);
                                $listaDia = $comidasPorDia[$diaId];
                            ?>
                            <div class="tab-pane fade <?= $isActive ? 'show active' : '' ?>" 
                                 id="pane-dia-<?= $diaInfo['slug'] ?>" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-dia-<?= $diaInfo['slug'] ?>">
                                
                                <?php if (empty($listaDia)): ?>
                                    <div class="text-center py-5 text-muted">
                                        <i class="bi bi-cup-hot fs-2 d-block mb-2 text-secondary"></i>
                                        <p class="mb-2">No hay comidas programadas para el día <strong><?= esc($diaInfo['nombre']) ?></strong>.</p>
                                        <a href="<?= base_url('comida/add?idplanalimentacion=' . $plan['idplanalimentacion'] . '&iddiasemana=' . $diaId) ?>" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-plus-lg me-1"></i> Programar comida para el <?= esc($diaInfo['nombre']) ?>
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
                                                    <th>Porción</th>
                                                    <th>Tiempo Prep.</th>
                                                    <th class="text-end pe-4">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($listaDia as $cm): ?>
                                                    <tr>
                                                        <td class="ps-4 fw-bold text-dark">
                                                            <?php if (!empty($cm['horarecomendada'])): ?>
                                                                <span class="badge bg-secondary text-white font-monospace">
                                                                    <i class="bi bi-alarm-fill me-1"></i><?= substr($cm['horarecomendada'], 0, 5) ?>
                                                                </span>
                                                            <?php else: ?>
                                                                <span class="badge bg-light text-muted border">Flexible</span>
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
                                                            <?php if (!empty($cm['receta_video'])): ?>
                                                                <a href="<?= esc($cm['receta_video']) ?>" target="_blank" class="badge bg-danger-subtle text-danger border border-danger-subtle text-decoration-none ms-1" title="Ver video de la receta en YouTube">
                                                                    <i class="bi bi-youtube me-1"></i>Video
                                                                </a>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><span class="fw-semibold"><?= esc($cm['porciones'] ?? 1) ?></span> porc.</td>
                                                        <td class="text-secondary small">
                                                            <?= esc(!empty($cm['tiempopreparacion']) ? $cm['tiempopreparacion'] . ' min' : 'No especificado') ?>
                                                        </td>
                                                        <td class="text-end pe-4">
                                                            <a href="<?= base_url('planalimentacion/marcar-cumplimiento/' . $plan['idplanalimentacion'] . '/' . $cm['idcomida']) ?>" class="btn btn-xs btn-success text-white me-1" title="Registrar que se consumió esta comida ahora" onclick="return confirm('¿Registrar consumo de \'<?= esc($cm['receta_nombre']) ?>\' en este momento?');">
                                                                <i class="bi bi-check-lg"></i> Cumplir
                                                            </a>
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
                        <?php endforeach; ?>

                        <?php if (!empty($comidasOtras)): ?>
                            <div class="tab-pane fade" 
                                 id="pane-dia-otros" 
                                 role="tabpanel" 
                                 aria-labelledby="tab-dia-otros">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Día / Estado</th>
                                                <th>Hora</th>
                                                <th>Momento / Tipo</th>
                                                <th>Receta Asignada</th>
                                                <th>Porción</th>
                                                <th>Tiempo Prep.</th>
                                                <th class="text-end pe-4">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($comidasOtras as $cm): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <span class="badge bg-secondary-subtle text-secondary border">
                                                            <?= esc($cm['diasemana_nombre'] ?? 'Sin día asignado') ?>
                                                        </span>
                                                    </td>
                                                    <td class="fw-bold text-dark">
                                                        <?php if (!empty($cm['horarecomendada'])): ?>
                                                            <span class="badge bg-secondary text-white font-monospace">
                                                                <i class="bi bi-alarm-fill me-1"></i><?= substr($cm['horarecomendada'], 0, 5) ?>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="badge bg-light text-muted border">Flexible</span>
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
                                                        <?php if (!empty($cm['receta_video'])): ?>
                                                            <a href="<?= esc($cm['receta_video']) ?>" target="_blank" class="badge bg-danger-subtle text-danger border border-danger-subtle text-decoration-none ms-1" title="Ver video de la receta en YouTube">
                                                                <i class="bi bi-youtube me-1"></i>Video
                                                            </a>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><span class="fw-semibold"><?= esc($cm['porciones'] ?? 1) ?></span> porc.</td>
                                                    <td class="text-secondary small">
                                                        <?= esc(!empty($cm['tiempopreparacion']) ? $cm['tiempopreparacion'] . ' min' : 'No especificado') ?>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <a href="<?= base_url('planalimentacion/marcar-cumplimiento/' . $plan['idplanalimentacion'] . '/' . $cm['idcomida']) ?>" class="btn btn-xs btn-success text-white me-1" title="Registrar que se consumió esta comida ahora" onclick="return confirm('¿Registrar consumo de \'<?= esc($cm['receta_nombre']) ?>\' en este momento?');">
                                                            <i class="bi bi-check-lg"></i> Cumplir
                                                        </a>
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
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Registro de Cumplimiento de Comidas del Plan -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 border-bottom d-flex flex-wrap justify-content-between align-items-center gap-2">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-check2-circle text-success me-2 fs-5"></i>Registro de Cumplimiento de Ingestas
                        <span class="badge bg-success text-white ms-2"><?= count($cumplimientos ?? []) ?></span>
                    </h6>
                    <div class="d-flex gap-2">
                        <a href="<?= base_url('cumplimientoplanalimentacion/add?idplanalimentacion=' . $plan['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-success">
                            <i class="bi bi-plus-circle me-1"></i> Registrar Cumplimiento Manual
                        </a>
                        <a href="<?= base_url('cumplimientoplanalimentacion/listar?idplanalimentacion=' . $plan['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-list-check me-1"></i> Ver Todos
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($cumplimientos)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-calendar2-check fs-2 d-block mb-2 text-secondary"></i>
                            <p class="mb-2">No se han registrado cumplimientos de comidas para este plan aún.</p>
                            <small class="text-muted">Puede marcar cumplimientos rápidamente con el botón <strong>Cumplir</strong> en las comidas programadas arriba o registrar con fecha y hora personalizada.</small>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4">ID</th>
                                        <th>Fecha y Hora</th>
                                        <th>Momento / Tipo</th>
                                        <th>Receta Consumida</th>
                                        <th>Hora Sugerida</th>
                                        <th class="text-end pe-4">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cumplimientos as $cp): ?>
                                        <tr>
                                            <td class="ps-4 text-muted small">#<?= $cp['idcumplimientoplanalimentacion'] ?></td>
                                            <td class="fw-bold text-success">
                                                <i class="bi bi-calendar-check me-1"></i><?= esc($cp['fechahora']) ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                                    <?= esc($cp['tipocomida_nombre']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <a href="<?= base_url('receta/actual/' . $cp['idreceta']) ?>" class="fw-semibold text-decoration-none text-primary">
                                                    <i class="bi bi-book me-1"></i><?= esc($cp['receta_nombre']) ?>
                                                </a>
                                            </td>
                                            <td class="text-muted small">
                                                <?= !empty($cp['horarecomendada']) ? substr($cp['horarecomendada'], 0, 5) : 'Flexible' ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('cumplimientoplanalimentacion/actual/' . $cp['idcumplimientoplanalimentacion']) ?>" class="btn btn-xs btn-outline-primary" title="Ver detalle de cumplimiento">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('cumplimientoplanalimentacion/edit/' . $cp['idcumplimientoplanalimentacion']) ?>" class="btn btn-xs btn-outline-warning text-dark" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <a href="<?= base_url('cumplimientoplanalimentacion/delete/' . $cp['idcumplimientoplanalimentacion'] . '?from_plan=1') ?>" class="btn btn-xs btn-outline-danger" title="Eliminar registro" onclick="return confirm('¿Eliminar este registro de cumplimiento?');">
                                                    <i class="bi bi-trash"></i>
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
