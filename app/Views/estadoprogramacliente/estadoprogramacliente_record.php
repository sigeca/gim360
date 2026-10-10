<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($estado)): ?>
            <?= view('layout/empty_record', ['module' => 'estadoprogramacliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'estadoprogramacliente',
                'currentId' => $estado['idestadoprogramacliente']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-flag-fill text-info me-2"></i>Ficha de Estado de Programa de Cliente
                    </h5>
                    <span class="badge bg-info text-dark fs-6">ID #<?= $estado['idestadoprogramacliente'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-35 text-muted">ID Estado</th>
                                    <td class="fw-bold text-muted"><?= $estado['idestadoprogramacliente'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del Estado</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-2">
                                            <i class="bi bi-tag-fill me-1"></i><?= esc($estado['nombre']) ?>
                                        </span>
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
