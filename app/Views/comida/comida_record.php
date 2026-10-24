<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($comida)): ?>
            <?= view('layout/empty_record', ['module' => 'comida']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'comida',
                'currentId' => $comida['idcomida']
            ]) ?>

            <!-- Ficha Principal de la Comida Programada -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-calendar2-heart text-success me-2 fs-4"></i>Comida en Plan #<?= $comida['idcomida'] ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $comida['idcomida'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-clock-history fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($comida['tipocomida_nombre']) ?></h5>
                                <?php if (!empty($comida['horarecomendada'])): ?>
                                    <div class="badge bg-primary text-white fs-6 px-3 py-2 mt-2 shadow-sm">
                                        <i class="bi bi-alarm-fill me-1"></i><?= substr($comida['horarecomendada'], 0, 5) ?>
                                    </div>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-1 mt-2">Hora flexible</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $comida['idcomida'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Plan de Alimentación</th>
                                        <td>
                                            <a href="<?= base_url('planalimentacion/actual/' . $comida['idplanalimentacion']) ?>" class="fw-bold text-decoration-none text-dark">
                                                <i class="bi bi-journal-medical text-success me-1"></i><?= esc($comida['plan_nombre']) ?>
                                            </a>
                                            <div class="small text-muted mt-1">
                                                Titular: <?= esc($comida['apellidos']) ?>, <?= esc($comida['nombres']) ?> (<?= esc($comida['cedula']) ?>)
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Tipo / Momento</th>
                                        <td>
                                            <span class="badge bg-warning-subtle text-dark border border-warning px-3 py-1 fs-6">
                                                <i class="bi bi-sun me-1"></i><?= esc($comida['tipocomida_nombre']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Receta Asignada</th>
                                        <td>
                                            <a href="<?= base_url('receta/actual/' . $comida['idreceta']) ?>" class="fs-6 fw-bold text-decoration-none text-primary">
                                                <i class="bi bi-book me-1"></i><?= esc($comida['receta_nombre']) ?>
                                            </a>
                                            <div class="small text-muted mt-1">
                                                Rinde <?= esc($comida['porciones'] ?? 1) ?> porción(es) • Prep: <?= esc($comida['tiempopreparacion'] ? $comida['tiempopreparacion'] . ' min' : 'No especificado') ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Hora Recomendada</th>
                                        <td class="fs-5 fw-bold text-dark">
                                            <?= !empty($comida['horarecomendada']) ? substr($comida['horarecomendada'], 0, 5) : '<span class="text-muted fst-italic">Sin hora específica</span>' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('planalimentacion/actual/' . $comida['idplanalimentacion']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha del Plan
                    </a>
                    <a href="<?= base_url('comida/add?idplanalimentacion=' . $comida['idplanalimentacion']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Programar otra comida en este plan
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
