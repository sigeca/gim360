<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($asignacion)): ?>
            <?= view('layout/empty_record', ['module' => 'estadocivilpersona']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'estadocivilpersona',
                'currentId' => $asignacion['idestadocivilpersona']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-secondary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-heart text-secondary me-2"></i>Ficha de Asignación: Estado Civil a Persona
                    </h5>
                    <span class="badge bg-secondary fs-6">ID Asignación #<?= $asignacion['idestadocivilpersona'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Asignación</th>
                                    <td class="fw-bold text-muted"><?= $asignacion['idestadocivilpersona'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Persona Asignada</th>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $asignacion['idpersona']) ?>" class="fs-6 fw-semibold text-dark text-decoration-none">
                                            <?= esc($asignacion['persona_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace"><?= esc($asignacion['cedula']) ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Estado Civil</th>
                                    <td>
                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                            <i class="bi bi-heart me-1"></i><?= esc($asignacion['estadocivil_nombre']) ?>
                                        </span>
                                        <a href="<?= base_url('estadocivil/actual/' . $asignacion['idestadocivil']) ?>" class="btn btn-sm btn-link text-decoration-none ms-2">
                                            Ver Catálogo <i class="bi bi-arrow-right"></i>
                                        </a>
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
