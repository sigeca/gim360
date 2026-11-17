<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($pais)): ?>
            <?= view('layout/empty_record', ['module' => 'pais']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'pais',
                'currentId' => $pais['idpais']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-globe-americas text-primary me-2"></i>Ficha de País
                    </h5>
                    <span class="badge bg-primary text-white fs-6">ID #<?= $pais['idpais'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID País</th>
                                    <td class="fw-bold"><?= $pais['idpais'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del País</th>
                                    <td class="fs-5 fw-semibold text-primary">
                                        <i class="bi bi-flag-fill me-1"></i><?= esc($pais['nombre']) ?>
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
