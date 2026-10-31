<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($cumplimiento)): ?>
            <?= view('layout/empty_record', ['module' => 'cumplimientoplanalimentacion']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'cumplimientoplanalimentacion',
                'currentId' => $cumplimiento['idcumplimientoplanalimentacion']
            ]) ?>

            <!-- Ficha Principal de Cumplimiento -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-check2-circle text-success me-2 fs-4"></i>Cumplimiento de Comida #<?= $cumplimiento['idcumplimientoplanalimentacion'] ?>
                    </h5>
                    <span class="badge bg-success-subtle text-success border border-success px-3 py-2 fs-6">
                        <i class="bi bi-calendar-check me-1"></i>Registrado
                    </span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-clock-history fs-1"></i>
                                </div>
                                <h6 class="text-muted text-uppercase small mb-1">Fecha y Hora de Ingesta</h6>
                                <h5 class="fw-bold text-success mb-2">
                                    <?= date('d/m/Y', strtotime($cumplimiento['fechahora'])) ?>
                                </h5>
                                <div class="badge bg-primary text-white fs-6 px-3 py-2 shadow-sm">
                                    <i class="bi bi-alarm-fill me-1"></i><?= date('H:i:s', strtotime($cumplimiento['fechahora'])) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $cumplimiento['idcumplimientoplanalimentacion'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Plan de Alimentación</th>
                                        <td>
                                            <a href="<?= base_url('planalimentacion/actual/' . $cumplimiento['idplanalimentacion']) ?>" class="fw-bold text-decoration-none text-dark">
                                                <i class="bi bi-journal-medical text-success me-1"></i><?= esc($cumplimiento['plan_nombre']) ?>
                                            </a>
                                            <div class="small text-muted mt-1">
                                                Persona: <?= esc($cumplimiento['apellidos']) ?>, <?= esc($cumplimiento['nombres']) ?> (C.I. <?= esc($cumplimiento['cedula']) ?>)
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Momento / Comida</th>
                                        <td>
                                            <a href="<?= base_url('comida/actual/' . $cumplimiento['idcomida']) ?>" class="fw-bold text-decoration-none">
                                                <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-1 fs-6">
                                                    <i class="bi bi-sun me-1"></i><?= esc($cumplimiento['tipocomida_nombre']) ?>
                                                </span>
                                            </a>
                                            <?php if (!empty($cumplimiento['horarecomendada'])): ?>
                                                <small class="text-muted ms-2">(Horario sugerido: <?= substr($cumplimiento['horarecomendada'], 0, 5) ?>)</small>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Receta Consumida</th>
                                        <td>
                                            <a href="<?= base_url('receta/actual/' . $cumplimiento['idreceta']) ?>" class="fs-6 fw-bold text-decoration-none text-primary">
                                                <i class="bi bi-book me-1"></i><?= esc($cumplimiento['receta_nombre']) ?>
                                            </a>
                                            <div class="small text-muted mt-1">
                                                <?= esc($cumplimiento['porciones'] ?? 1) ?> porción(es) • Prep: <?= esc($cumplimiento['tiempopreparacion'] ? $cumplimiento['tiempopreparacion'] . ' min' : 'No especificado') ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Fecha y Hora</th>
                                        <td class="fs-6 fw-bold text-dark">
                                            <i class="bi bi-calendar-event me-1 text-primary"></i><?= esc($cumplimiento['fechahora']) ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('planalimentacion/actual/' . $cumplimiento['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha del Plan Nutricional
                    </a>
                    <a href="<?= base_url('cumplimientoplanalimentacion/add?idplanalimentacion=' . $cumplimiento['idplanalimentacion']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Registrar otro cumplimiento en este plan
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
