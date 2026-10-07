<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($rutina)): ?>
            <?= view('layout/empty_record', ['module' => $module ?? 'rutinaejecicio']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => $module ?? 'rutinaejecicio',
                'currentId' => $rutina['idrutinaejercicio']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-calendar2-week-fill text-info me-2"></i>Ficha de Rutina de Ejercicio
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rutina['idrutinaejercicio'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-25 text-muted">ID Rutina Ejercicio</th>
                                    <td class="fw-bold text-secondary">#<?= $rutina['idrutinaejercicio'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre de la Rutina</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <i class="bi bi-card-checklist text-info me-2"></i><?= esc($rutina['nombre']) ?>
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
