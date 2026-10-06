<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($estadoCivil)): ?>
            <?= view('layout/empty_record', ['module' => 'estadocivil']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'estadocivil',
                'currentId' => $estadoCivil['idestadocivil']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-danger">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-heart-fill text-danger me-2"></i>Ficha de Estado Civil
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $estadoCivil['idestadocivil'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Estado Civil</th>
                                    <td class="fw-bold"><?= $estadoCivil['idestadocivil'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <i class="bi bi-heart text-danger me-1"></i><?= esc($estadoCivil['nombre']) ?>
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
