<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($perfil)): ?>
            <?= view('layout/empty_record', ['module' => 'perfilnutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'perfilnutricional',
                'currentId' => $perfil['idperfilnutricional']
            ]) ?>

            <?php 
                $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($perfil['cedula'] ?? '')) . '.jpg';
                $imc = $perfil['imc'] ?? null;
                $clasif = $perfil['clasificacion'] ?? ['categoria' => 'No disponible', 'badge_class' => 'bg-secondary', 'descripcion' => ''];
                $rango = $perfil['rango_saludable'] ?? ['min' => 0, 'max' => 0];
            ?>

            <!-- Ficha Principal de Evaluación Nutricional -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom">
                    <div class="d-flex align-items-center gap-3">
                        <img src="<?= esc($fotoUrl) ?>"
                             alt="Foto de <?= esc($perfil['nombres']) ?>"
                             class="rounded-circle border border-2 border-success shadow-sm"
                             style="width: 52px; height: 52px; object-fit: cover;"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="bg-success text-white rounded-circle p-2 fs-4 align-items-center justify-content-center shadow-sm" style="width: 52px; height: 52px; display: none;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">
                                Control Nutricional: <?= esc($perfil['apellidos'] . ' ' . $perfil['nombres']) ?>
                            </h5>
                            <span class="text-muted small">
                                <i class="bi bi-card-text me-1"></i>C.I. <?= esc($perfil['cedula']) ?> | 
                                <i class="bi bi-calendar-event me-1"></i>Fecha: <?= !empty($perfil['fechamedicion']) ? date('d/m/Y', strtotime($perfil['fechamedicion'])) : '-' ?>
                            </span>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2 mt-2 mt-md-0">
                        <a href="<?= base_url('persona/actual/' . $perfil['idpersona']) ?>" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-person-vcard me-1"></i> Ficha de Persona
                        </a>
                        <a href="<?= base_url('perfilnutricional/add?idpersona=' . $perfil['idpersona']) ?>" class="btn btn-success btn-sm">
                            <i class="bi bi-plus-circle me-1"></i> Nueva Medición
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    
                    <!-- Tarjetas de Métricas Principales (Peso, Estatura, IMC) -->
                    <div class="row g-3 mb-4">
                        
                        <!-- Peso -->
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-light border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                <span class="text-muted small fw-semibold text-uppercase">
                                    <i class="bi bi-speedometer2 text-primary me-1"></i>Peso Corporal
                                </span>
                                <h2 class="fw-bold text-dark my-2"><?= number_format((float)$perfil['peso_kg'], 2) ?> <span class="fs-6 text-muted">kg</span></h2>
                                <span class="small text-muted">≈ <?= number_format((float)$perfil['peso_kg'] * 2.20462, 1) ?> lbs</span>
                            </div>
                        </div>

                        <!-- Estatura -->
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-light border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                <span class="text-muted small fw-semibold text-uppercase">
                                    <i class="bi bi-rulers text-info me-1"></i>Estatura
                                </span>
                                <h2 class="fw-bold text-dark my-2"><?= number_format((float)$perfil['estatura_cm'], 1) ?> <span class="fs-6 text-muted">cm</span></h2>
                                <span class="small text-muted"><?= number_format((float)$perfil['estatura_cm'] / 100, 2) ?> metros</span>
                            </div>
                        </div>

                        <!-- IMC Calculado -->
                        <div class="col-md-3 col-sm-6">
                            <div class="card border-0 shadow-sm rounded-4 text-center p-3 h-100" style="background-color: #f0fdf4;">
                                <span class="text-muted small fw-semibold text-uppercase">
                                    <i class="bi bi-heart-pulse-fill text-success me-1"></i>Índice Masa Corporal (IMC)
                                </span>
                                <h2 class="fw-bold text-success my-2"><?= $imc !== null ? number_format($imc, 2) : '-' ?></h2>
                                <div>
                                    <span class="badge <?= esc($clasif['badge_class']) ?> px-2 py-1">
                                        <?= esc($clasif['categoria']) ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Peso Saludable Recomendado -->
                        <div class="col-md-3 col-sm-6">
                            <div class="card bg-light border-0 shadow-sm rounded-4 text-center p-3 h-100">
                                <span class="text-muted small fw-semibold text-uppercase">
                                    <i class="bi bi-bullseye text-warning me-1"></i>Rango Peso Ideal
                                </span>
                                <h4 class="fw-bold text-dark my-2">
                                    <?= number_format((float)$rango['min'], 1) ?> - <?= number_format((float)$rango['max'], 1) ?> <span class="fs-6 text-muted">kg</span>
                                </h4>
                                <span class="small text-muted" style="font-size: 0.78rem;">Para estatura de <?= number_format((float)$perfil['estatura_cm'], 0) ?> cm</span>
                            </div>
                        </div>

                    </div>

                    <!-- Datos Complementarios y Observaciones -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-40 text-muted">ID Registro</th>
                                            <td class="fw-bold text-muted">#<?= $perfil['idperfilnutricional'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha de Evaluación</th>
                                            <td class="fw-semibold">
                                                <i class="bi bi-calendar-check text-success me-1"></i>
                                                <?= !empty($perfil['fechamedicion']) ? date('d/m/Y', strtotime($perfil['fechamedicion'])) : '-' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Porcentaje de Grasa Corporal</th>
                                            <td>
                                                <?php if ($perfil['porcentajegrasa'] !== null): ?>
                                                    <span class="fw-bold text-dark"><?= number_format((float)$perfil['porcentajegrasa'], 1) ?> %</span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No evaluado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Porcentaje de Masa Muscular</th>
                                            <td>
                                                <?php if ($perfil['porcentajemusculo'] !== null): ?>
                                                    <span class="fw-bold text-dark"><?= number_format((float)$perfil['porcentajemusculo'], 1) ?> %</span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No evaluado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 bg-light border">
                                <div class="card-header bg-light border-bottom py-2">
                                    <h6 class="fw-bold text-dark mb-0 small">
                                        <i class="bi bi-chat-left-text me-1 text-primary"></i>Observaciones y Diagnóstico Nutricional
                                    </h6>
                                </div>
                                <div class="card-body p-3">
                                    <?php if (!empty($perfil['observaciones'])): ?>
                                        <p class="mb-0 text-secondary" style="white-space: pre-wrap;"><?= esc($perfil['observaciones']) ?></p>
                                    <?php else: ?>
                                        <p class="text-muted fst-italic mb-0">Sin observaciones registradas para esta evaluación.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Historial de Mediciones de la Persona -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-primary me-2"></i>Historial de Mediciones de <?= esc($perfil['nombres']) ?> (<?= count($historial) ?>)
                    </h6>
                    <a href="<?= base_url('perfilnutricional/add?idpersona=' . $perfil['idpersona']) ?>" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-plus-lg me-1"></i> Registrar Nueva Medición
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">ID</th>
                                    <th>Fecha</th>
                                    <th>Peso (kg)</th>
                                    <th>Estatura (cm)</th>
                                    <th>IMC</th>
                                    <th>Clasificación</th>
                                    <th>% Grasa</th>
                                    <th>% Músculo</th>
                                    <th class="text-end pe-3">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($historial as $h): ?>
                                    <tr class="<?= $h['idperfilnutricional'] == $perfil['idperfilnutricional'] ? 'table-active' : '' ?>">
                                        <td class="ps-3 fw-bold text-muted">#<?= $h['idperfilnutricional'] ?></td>
                                        <td class="fw-semibold">
                                            <?= !empty($h['fechamedicion']) ? date('d/m/Y', strtotime($h['fechamedicion'])) : '-' ?>
                                        </td>
                                        <td class="fw-bold"><?= number_format((float)$h['peso_kg'], 2) ?> kg</td>
                                        <td><?= number_format((float)$h['estatura_cm'], 1) ?> cm</td>
                                        <td class="fw-bold text-success"><?= $h['imc'] !== null ? number_format($h['imc'], 2) : '-' ?></td>
                                        <td>
                                            <span class="badge <?= esc($h['clasificacion']['badge_class']) ?>">
                                                <?= esc($h['clasificacion']['categoria']) ?>
                                            </span>
                                        </td>
                                        <td><?= $h['porcentajegrasa'] !== null ? number_format((float)$h['porcentajegrasa'], 1) . '%' : '-' ?></td>
                                        <td><?= $h['porcentajemusculo'] !== null ? number_format((float)$h['porcentajemusculo'], 1) . '%' : '-' ?></td>
                                        <td class="text-end pe-3">
                                            <a href="<?= base_url('perfilnutricional/actual/' . $h['idperfilnutricional']) ?>" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
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

    </div>
</div>

<?= $this->endSection() ?>
