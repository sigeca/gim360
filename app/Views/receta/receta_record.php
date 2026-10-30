<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($receta)): ?>
            <?= view('layout/empty_record', ['module' => 'receta']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'receta',
                'currentId' => $receta['idreceta']
            ]) ?>

            <!-- Ficha Principal de la Receta -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-book-half text-warning fs-3"></i>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><?= esc($receta['nombre']) ?></h5>
                            <small class="text-muted">Receta Nutricional #<?= $receta['idreceta'] ?></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <?php $cat = $receta['categoria_tiempo']; ?>
                        <span class="badge <?= $cat['badge_class'] ?> px-3 py-2 fs-6 shadow-sm">
                            <i class="bi <?= $cat['icono'] ?> me-1"></i><?= $cat['etiqueta'] ?>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">

                    <!-- Tarjetas de Resumen Rápido -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-people-fill text-primary me-1"></i>Rendimiento / Porciones</span>
                                <h4 class="fw-bold text-dark mb-0"><?= esc($receta['porciones'] ?? 1) ?> <span class="fs-6 fw-normal text-muted">porción(es)</span></h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-stopwatch text-danger me-1"></i>Tiempo de Preparación</span>
                                <h4 class="fw-bold text-dark mb-0"><?= esc($receta['tiempo_texto']) ?></h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-heart-pulse-fill text-success me-1"></i>Aporte Nutricional</span>
                                <span class="badge bg-success-subtle text-success border border-success mt-1 px-3 py-1">Dieta & Fitness</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ingredientes Requeridos (alimentoreceta) -->
                    <div class="card border border-warning-subtle shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-basket3 text-warning me-2 fs-5"></i>Ingredientes Requeridos
                                <span class="badge bg-warning text-dark ms-2"><?= count($ingredientes ?? []) ?></span>
                            </h6>
                            <a href="<?= base_url('alimentoreceta/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Agregar Ingrediente
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($ingredientes)): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-basket2 fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-2">Aún no se han asignado ingredientes específicos a esta receta.</p>
                                    <a href="<?= base_url('alimentoreceta/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-plus-lg me-1"></i>Asignar primer ingrediente
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Alimento / Ingrediente</th>
                                                <th>Grupo Nutricional</th>
                                                <th>Cantidad</th>
                                                <th>Unidad</th>
                                                <th class="text-end pe-4">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ingredientes as $ing): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <a href="<?= base_url('alimento/actual/' . $ing['idalimento']) ?>" class="fw-bold text-success text-decoration-none">
                                                            <i class="bi bi-apple me-1"></i><?= esc($ing['alimento_nombre']) ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-muted border"><?= esc($ing['grupo_nombre'] ?? 'General') ?></span>
                                                    </td>
                                                    <td class="fw-bold text-primary fs-6">
                                                        <?= number_format((float)$ing['cantidad'], 2) ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info-subtle text-info border border-info font-monospace">
                                                            <?= esc($ing['unidad_nombre']) ?> (<?= esc($ing['unidad_abreviatura']) ?>)
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <a href="<?= base_url('alimentoreceta/edit/' . $ing['idalimentoreceta']) ?>" class="btn btn-xs btn-outline-warning text-dark" title="Editar cantidad">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="<?= base_url('alimentoreceta/delete/' . $ing['idalimentoreceta'] . '?from_receta=1') ?>" class="btn btn-xs btn-outline-danger" title="Remover" onclick="return confirm('¿Remover este ingrediente de la receta?');">
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

                    <!-- Instrucciones y Modo de Preparación -->
                    <div class="card border border-warning-subtle shadow-sm mb-4">
                        <div class="card-header bg-warning bg-opacity-10 py-3 border-bottom border-warning-subtle">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-card-checklist text-warning me-2 fs-5"></i>Instrucciones de Preparación
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <?php if (!empty($receta['instrucciones'])): ?>
                                <div class="bg-light p-3 rounded-3 border text-secondary" style="white-space: pre-line; line-height: 1.7; font-size: 0.95rem;">
                                    <?= esc($receta['instrucciones']) ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-file-earmark-text fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-0">No se han registrado pasos o instrucciones para esta receta.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Componentes Nutricionales de la Receta -->
                    <div class="card border border-info-subtle shadow-sm mb-4">
                        <div class="card-header bg-info bg-opacity-10 py-3 d-flex justify-content-between align-items-center border-bottom border-info-subtle">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-pie-chart-fill text-info me-2 fs-5"></i>Componentes Nutricionales Destacados
                                <span class="badge bg-info-subtle text-info border border-info ms-2"><?= count($componentes ?? []) ?></span>
                            </h6>
                            <a href="<?= base_url('recetacomponentenutricional/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-plus-circle me-1"></i> Asignar Componente
                            </a>
                        </div>
                        <div class="card-body p-3">
                            <?php if (empty($componentes)): ?>
                                <div class="text-center py-3 text-muted">
                                    <i class="bi bi-pie-chart fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-2 small">No se han asociado componentes nutricionales a esta receta.</p>
                                    <a href="<?= base_url('recetacomponentenutricional/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-plus-lg me-1"></i>Asignar primer nutriente
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($componentes as $comp): ?>
                                        <div class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2 shadow-sm">
                                            <i class="bi bi-check-circle-fill text-info"></i>
                                            <span class="fw-semibold"><?= esc($comp['componente_nombre']) ?></span>
                                            <a href="<?= base_url('recetacomponentenutricional/actual/' . $comp['idrecetacomponentenutricional']) ?>" class="text-primary text-decoration-none" title="Ver asignación">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Receta disponible para ser incluida en planes nutricionales y recomendaciones dietéticas.
                    </span>
                    <a href="<?= base_url('receta/add') ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>Registrar otra receta
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
