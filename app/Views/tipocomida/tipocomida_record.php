<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <?php if (empty($tipo)): ?>
            <?= view('layout/empty_record', ['module' => 'tipocomida']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'tipocomida',
                'currentId' => $tipo['idtipocomida']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-clock-history text-warning me-2 fs-4"></i>Tipo de Comida: <?= esc($tipo['nombre']) ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $tipo['idtipocomida'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-sun-fill fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($tipo['nombre']) ?></h5>
                                <span class="badge bg-warning text-dark px-3 py-1">Momento Nutricional</span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Tipo de Comida</th>
                                        <td class="fw-bold text-secondary">#<?= $tipo['idtipocomida'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Tiempo de Comida</th>
                                        <td class="fs-5 fw-semibold text-dark">
                                            <i class="bi bi-check2-circle text-warning me-2"></i><?= esc($tipo['nombre']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Uso en la Planificación</th>
                                        <td class="text-secondary small">
                                            Define el momento o ingesta del día dentro de los planes de alimentación y dietas estructuradas.
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
