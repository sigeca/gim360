<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($cliente)): ?>
            <?= view('layout/empty_record', ['module' => 'cliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'cliente',
                'currentId' => $cliente['idcliente']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-badge-fill text-success me-2"></i>Ficha de Cliente
                    </h5>
                    <span class="badge bg-success text-white fs-6">ID Cliente #<?= $cliente['idcliente'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Cliente</th>
                                    <td class="fw-bold text-success">#<?= $cliente['idcliente'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Persona Asociada</th>
                                    <td>
                                        <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="fs-5 fw-bold text-dark text-decoration-none">
                                            <?= esc($cliente['persona_nombres']) ?> <i class="bi bi-box-arrow-up-right fs-6 text-primary"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Cédula</th>
                                    <td class="font-monospace fs-6"><?= esc($cliente['cedula']) ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Sexo</th>
                                    <td><?= !empty($cliente['sexo_nombre']) ? esc($cliente['sexo_nombre']) : '<span class="text-muted">-</span>' ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Fecha Nacimiento</th>
                                    <td><?= !empty($cliente['fechanacimiento']) ? date('d/m/Y', strtotime($cliente['fechanacimiento'])) : '<span class="text-muted">-</span>' ?></td>
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
