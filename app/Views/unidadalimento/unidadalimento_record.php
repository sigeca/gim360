<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <?php if (empty($unidad)): ?>
            <?= view('layout/empty_record', ['module' => 'unidadalimento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'unidadalimento',
                'currentId' => $unidad['idunidadalimento']
            ]) ?>

            <!-- Ficha Principal de la Unidad -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-rulers text-info me-2 fs-4"></i>Ficha de Unidad: <?= esc($unidad['nombre']) ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $unidad['idunidadalimento'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-speedometer fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($unidad['nombre']) ?></h5>
                                <span class="badge bg-primary fs-6 px-3 py-1"><?= esc($unidad['abreviatura']) ?></span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Unidad</th>
                                        <td class="fw-bold text-secondary">#<?= $unidad['idunidadalimento'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre de la Unidad</th>
                                        <td class="fs-5 fw-semibold text-dark"><?= esc($unidad['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Símbolo / Abreviatura</th>
                                        <td>
                                            <span class="badge bg-info-subtle text-info border border-info px-3 py-1 fs-6 font-monospace">
                                                <?= esc($unidad['abreviatura']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
