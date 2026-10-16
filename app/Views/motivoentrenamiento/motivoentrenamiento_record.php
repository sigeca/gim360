<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($motivo)): ?>
            <?= view('layout/empty_record', ['module' => 'motivoentrenamiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'motivoentrenamiento',
                'currentId' => $motivo['idmotivoentrenamiento']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-bullseye text-warning me-2 fs-4"></i>Ficha de Motivo: <?= esc($motivo['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($motivo['dimension'])): ?>
                            <span class="badge <?= $motivo['dimension'] === 'Salud' ? 'bg-success' : 'bg-primary' ?> fs-6">
                                <i class="bi <?= $motivo['dimension'] === 'Salud' ? 'bi-heart-pulse-fill' : 'bi-stars' ?> me-1"></i>
                                <?= esc($motivo['dimension']) ?>
                            </span>
                        <?php endif; ?>
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $motivo['idmotivoentrenamiento'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Panel de Presentación de la Imagen / Foto que representa la necesidad física -->
                        <div class="col-md-5 text-center">
                            <div class="p-2 bg-light rounded-4 border shadow-sm position-relative overflow-hidden">
                                <?php if (!empty($motivo['imagen'])): ?>
                                    <img src="<?= base_url('repositorio/motivos/' . esc($motivo['imagen'])) ?>" 
                                         onerror="this.onerror=null; this.src='<?= base_url('motivoentrenamiento/imagen/' . esc($motivo['imagen'])) ?>';"
                                         alt="<?= esc($motivo['nombre']) ?>" 
                                         class="img-fluid rounded-3 shadow-sm w-100" 
                                         style="max-height: 280px; object-fit: cover;">
                                    <div class="mt-2 text-muted small fst-italic">
                                        <i class="bi bi-person-bounding-box me-1"></i><?= esc($motivo['imagen']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <span>Sin imagen registrada</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Detalles e Información del Motivo -->
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Motivo</th>
                                            <td class="fw-bold text-secondary">#<?= $motivo['idmotivoentrenamiento'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Motivo</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-flag-fill text-warning me-2"></i><?= esc($motivo['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Dimensión</th>
                                            <td>
                                                <?php if (!empty($motivo['dimension'])): ?>
                                                    <span class="badge <?= $motivo['dimension'] === 'Salud' ? 'bg-success-subtle text-success border border-success' : 'bg-primary-subtle text-primary border border-primary' ?> px-3 py-1">
                                                        <i class="bi <?= $motivo['dimension'] === 'Salud' ? 'bi-heart-pulse' : 'bi-stars' ?> me-1"></i>
                                                        <?= esc($motivo['dimension']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción / Necesidad</th>
                                            <td>
                                                <?php if (!empty($motivo['objetivo'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-warning text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($motivo['objetivo'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción registrada</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-grid gap-2 mt-3">
                                <a href="<?= base_url('motivoentrenamiento/listar') ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list-task me-1"></i>Ver Catálogo Completo
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
