<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($sexo)): ?>
            <?= view('layout/empty_record', ['module' => 'sexo']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'sexo',
                'currentId' => $sexo['idsexo']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-danger">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-gender-ambiguous text-danger me-2"></i>Ficha de Sexo
                    </h5>
                    <span class="badge bg-danger text-white fs-6">ID #<?= $sexo['idsexo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Sexo</th>
                                    <td class="fw-bold"><?= $sexo['idsexo'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del Sexo</th>
                                    <td class="fs-5 fw-semibold text-danger">
                                        <i class="bi bi-check2-circle me-1"></i><?= esc($sexo['nombre']) ?>
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
