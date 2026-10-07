<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($motivo)): ?>
            <?= view('layout/empty_record', ['module' => 'motivoentrenamiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'motivoentrenamiento',
                'currentId' => $motivo['idmotivoentrenamiento']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-bullseye text-warning me-2"></i>Ficha de Motivo de Entrenamiento
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $motivo['idmotivoentrenamiento'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Motivo</th>
                                    <td class="fw-bold text-secondary">#<?= $motivo['idmotivoentrenamiento'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del Motivo</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <i class="bi bi-flag-fill text-warning me-2"></i><?= esc($motivo['nombre']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted align-top">Objetivo</th>
                                    <td>
                                        <?php if (!empty($motivo['objetivo'])): ?>
                                            <div class="p-3 bg-light rounded border-start border-3 border-warning text-secondary">
                                                <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($motivo['objetivo'])) ?>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-muted fst-italic">Sin objetivo registrado</span>
                                        <?php endif; ?>
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
