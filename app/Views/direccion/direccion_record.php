<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($direccion)): ?>
            <?= view('layout/empty_record', ['module' => 'direccion']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'direccion',
                'currentId' => $direccion['iddireccion']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-geo-alt-fill text-warning me-2"></i>Ficha de Dirección
                    </h5>
                    <span class="badge bg-warning text-dark fs-6">ID Dirección #<?= $direccion['iddireccion'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Dirección</th>
                                    <td class="fw-bold text-muted"><?= $direccion['iddireccion'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Dirección Domiciliaria</th>
                                    <td class="fs-5 fw-bold text-dark">
                                        <i class="bi bi-geo-alt text-danger me-1"></i><?= esc($direccion['direccion']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Persona Asignada</th>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $direccion['idpersona']) ?>" class="fs-6 fw-semibold text-dark text-decoration-none">
                                            <?= esc($direccion['persona_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                        <span class="badge bg-light text-dark border ms-2 font-monospace"><?= esc($direccion['cedula']) ?></span>
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
