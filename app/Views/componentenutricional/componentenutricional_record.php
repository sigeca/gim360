<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($componente)): ?>
            <?= view('layout/empty_record', ['module' => 'componentenutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'componentenutricional',
                'currentId' => $componente['idcomponentenutricional']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill text-info me-2 fs-4"></i>Componente Nutricional: <?= esc($componente['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $componente['idcomponentenutricional'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                                    <i class="bi bi-heart-pulse-fill fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($componente['nombre']) ?></h5>
                                <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-1">Valor Nutricional</span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Componente</th>
                                            <td class="fw-bold text-secondary">#<?= $componente['idcomponentenutricional'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Componente</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-check2-circle text-info me-2"></i><?= esc($componente['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción y Función</th>
                                            <td>
                                                <?php if (!empty($componente['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-info text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($componente['descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción registrada.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
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
