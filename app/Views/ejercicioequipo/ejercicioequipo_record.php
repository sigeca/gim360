<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'ejercicioequipo']) ?>
        <?php else: ?>

            <!-- Toolbar de Navegación -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'ejercicioequipo',
                'currentId' => $rel['idejercicioequipo']
            ]) ?>

            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-gear-wide-connected text-primary me-2"></i>Asignación Ejercicio - Equipamiento
                    </h5>
                    <span class="badge bg-primary fs-6">ID #<?= $rel['idejercicioequipo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Ejercicio -->
                        <div class="col-md-6 text-center border-end">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="bi bi-activity text-primary me-1"></i>Ejercicio Realizado
                            </h6>
                            <div class="p-3 bg-light rounded-4 border shadow-sm d-inline-block w-100" style="max-width: 320px;">
                                <?php if (!empty($rel['ejercicio_imagen'])): ?>
                                    <img src="<?= base_url('ejercicio/imagen/' . esc($rel['ejercicio_imagen'])) ?>" 
                                         alt="<?= esc($rel['ejercicio_nombre']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 180px; width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <div class="py-4 text-muted"><i class="bi bi-image fs-1"></i></div>
                                <?php endif; ?>
                                <h5 class="fw-bold text-dark mt-2 mb-1"><?= esc($rel['ejercicio_nombre']) ?></h5>
                                <div class="mt-2">
                                    <a href="<?= base_url('ejercicio/actual/' . $rel['idejercicio']) ?>" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-eye me-1"></i>Ver Ficha del Ejercicio
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Equipo / Máquina -->
                        <div class="col-md-6 text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="bi bi-gear-fill text-primary me-1"></i>Equipo / Máquina Empleada
                            </h6>
                            <div class="p-3 bg-light rounded-4 border shadow-sm d-inline-block w-100" style="max-width: 320px;">
                                <?php if (!empty($rel['equipo_imagen'])): ?>
                                    <img src="<?= base_url('repositorio/images/equipment/' . esc($rel['equipo_imagen'])) ?>" 
                                         onerror="this.onerror=null; this.src='<?= base_url('equipos/imagen/' . esc($rel['equipo_imagen'])) ?>';"
                                         alt="<?= esc($rel['equipo_nombre']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 180px; width: 100%; object-fit: contain;">
                                <?php else: ?>
                                    <div class="py-4 text-muted"><i class="bi bi-image fs-1"></i></div>
                                <?php endif; ?>
                                <div class="mt-2">
                                    <span class="badge bg-primary font-monospace"><?= esc($rel['equipo_codigo']) ?></span>
                                    <h5 class="fw-bold text-dark mt-1 mb-1"><?= esc($rel['equipo_nombre']) ?></h5>
                                    <?php if (!empty($rel['equipo_modelo'])): ?>
                                        <small class="text-muted d-block">Mod: <?= esc($rel['equipo_modelo']) ?></small>
                                    <?php endif; ?>
                                    <?php if (!empty($rel['equipo_tipo']) && isset($tipos[$rel['equipo_tipo']])): ?>
                                        <span class="badge bg-info-subtle text-dark border border-info mt-1"><?= esc($tipos[$rel['equipo_tipo']]) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-2">
                                    <a href="<?= base_url('equipos/actual/' . $rel['idequipo']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Ver Ficha del Equipo
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
