<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($correo)): ?>
            <?= view('layout/empty_record', ['module' => 'correo']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'correo',
                'currentId' => $correo['idcorreo']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-envelope-at-fill text-info me-2"></i>Ficha de Correo Electrónico
                    </h5>
                    <span class="badge bg-info text-dark fs-6">ID Correo #<?= $correo['idcorreo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Correo</th>
                                    <td class="fw-bold text-muted"><?= $correo['idcorreo'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Correo Electrónico</th>
                                    <td class="fs-5 fw-bold font-monospace text-primary">
                                        <i class="bi bi-envelope me-1"></i><?= esc($correo['correo']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Persona Asignada</th>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $correo['idpersona']) ?>" class="fs-6 fw-semibold text-dark text-decoration-none">
                                            <?= esc($correo['persona_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace"><?= esc($correo['cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Fecha de Obtención</th>
                                    <td>
                                        <?= !empty($correo['fechaoptencion']) ? '<i class="bi bi-calendar-event me-1 text-muted"></i>' . date('d/m/Y', strtotime($correo['fechaoptencion'])) : '<span class="text-muted">-</span>' ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
