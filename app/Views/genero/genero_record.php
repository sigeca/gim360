<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($genero)): ?>
            <?= view('layout/empty_record', ['module' => 'genero']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'genero',
                'currentId' => $genero['idgenero']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-lines-fill text-primary me-2"></i>Ficha de Identidad de Género
                    </h5>
                    <span class="badge bg-primary text-white fs-6">ID #<?= $genero['idgenero'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Género</th>
                                    <td class="fw-bold"><?= $genero['idgenero'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre de Género</th>
                                    <td class="fs-5 fw-semibold text-primary">
                                        <i class="bi bi-check2-circle me-1"></i><?= esc($genero['nombre']) ?>
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
