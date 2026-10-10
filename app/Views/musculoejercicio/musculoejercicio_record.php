<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'musculoejercicio']) ?>
        <?php else: ?>

            <!-- Toolbar de Navegación -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'musculoejercicio',
                'currentId' => $rel['idmusculoejecicio']
            ]) ?>

            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-link-45deg text-danger me-2"></i>Asignación Músculo - Ejercicio
                    </h5>
                    <span class="badge bg-danger fs-6">ID #<?= $rel['idmusculoejecicio'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <!-- Ejercicio -->
                        <div class="col-md-6 text-center border-end">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="bi bi-fire text-danger me-1"></i>Ejercicio Involucrado
                            </h6>
                            <div class="p-3 bg-light rounded-4 border shadow-sm d-inline-block w-100" style="max-width: 320px;">
                                <?php if (!empty($rel['ejercicio_imagen'])): ?>
                                    <img src="<?= base_url('ejercicio/imagen/' . esc($rel['ejercicio_imagen'])) ?>" 
                                         alt="<?= esc($rel['ejercicio_nombre']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 180px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="py-4 text-muted"><i class="bi bi-image fs-1"></i></div>
                                <?php endif; ?>
                                <h5 class="fw-bold text-dark mt-2 mb-1"><?= esc($rel['ejercicio_nombre']) ?></h5>
                                <a href="<?= base_url('ejercicio/actual/' . $rel['idejercicio']) ?>" class="btn btn-sm btn-outline-danger mt-2">
                                    <i class="bi bi-eye me-1"></i>Ver Ficha del Ejercicio
                                </a>
                            </div>
                        </div>

                        <!-- Músculo -->
                        <div class="col-md-6 text-center">
                            <h6 class="text-uppercase text-muted fw-bold mb-3 small">
                                <i class="bi bi-person-arms-up text-danger me-1"></i>Músculo Afectado
                            </h6>
                            <div class="p-3 bg-light rounded-4 border shadow-sm d-inline-block w-100" style="max-width: 320px;">
                                <?php if (!empty($rel['musculo_imagen'])): ?>
                                    <img src="<?= base_url('repositorio/images/muscles/' . esc($rel['musculo_imagen'])) ?>" 
                                         onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($rel['musculo_imagen'])) ?>';"
                                         alt="<?= esc($rel['musculo_nombre']) ?>" 
                                         class="img-fluid rounded" 
                                         style="max-height: 180px; object-fit: contain;">
                                <?php else: ?>
                                    <div class="py-4 text-muted"><i class="bi bi-image fs-1"></i></div>
                                <?php endif; ?>
                                <h5 class="fw-bold text-dark mt-2 mb-1"><?= esc($rel['musculo_nombre']) ?></h5>
                                <a href="<?= base_url('musculo/actual/' . $rel['idmusculo']) ?>" class="btn btn-sm btn-outline-primary mt-2">
                                    <i class="bi bi-eye me-1"></i>Ver Ficha del Músculo
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
