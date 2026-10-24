<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-7">

        <?php if (empty($dia)): ?>
            <?= view('layout/empty_record', ['module' => 'diasemana']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'diasemana',
                'currentId' => $dia['iddiasemana']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-calendar3 text-primary me-2 fs-4"></i>Día de la Semana: <?= esc($dia['nombre']) ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">Día #<?= $dia['iddiasemana'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-calendar-event fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($dia['nombre']) ?></h5>
                                <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-1">
                                    Día <?= $dia['iddiasemana'] ?> de 7
                                </span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Secuencial</th>
                                        <td class="fw-bold text-secondary">#<?= $dia['iddiasemana'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Día</th>
                                        <td class="fs-5 fw-semibold text-dark">
                                            <i class="bi bi-check-circle-fill text-success me-2"></i><?= esc($dia['nombre']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Uso en la Planificación</th>
                                        <td class="text-secondary small">
                                            Utilizado para estructurar divisiones de entrenamiento semanal (split de rutinas), distribución de grupos musculares y menús dietéticos por día.
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
