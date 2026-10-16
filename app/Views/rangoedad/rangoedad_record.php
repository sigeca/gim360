<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rango)): ?>
            <?= view('layout/empty_record', ['module' => 'rangoedad']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'rangoedad',
                'currentId' => $rango['idrangoedad']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-bounding-box text-info me-2"></i>Ficha de Rango de Edad
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rango['idrangoedad'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <tbody>
                                <tr>
                                    <th class="table-light w-30 text-muted">ID Rango de Edad</th>
                                    <td class="fw-bold text-secondary">#<?= $rango['idrangoedad'] ?></td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Nombre del Rango</th>
                                    <td class="fs-5 fw-semibold text-dark">
                                        <i class="bi bi-tag-fill text-info me-2"></i><?= esc($rango['nombre']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Edad Mínima</th>
                                    <td class="fw-semibold text-primary">
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 fs-6">
                                            <i class="bi bi-arrow-down-circle me-1"></i><?= (int)$rango['edadminima'] ?> años
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Edad Máxima</th>
                                    <td class="fw-semibold text-danger">
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 fs-6">
                                            <i class="bi bi-arrow-up-circle me-1"></i><?= (int)$rango['edadmaxima'] ?> años
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Intervalo Etario Completo</th>
                                    <td>
                                        <span class="badge bg-info-subtle text-dark border border-info px-3 py-2 fs-6">
                                            <i class="bi bi-calendar-range text-info me-1"></i>De <?= (int)$rango['edadminima'] ?> a <?= (int)$rango['edadmaxima'] ?> años
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="table-light text-muted">Programas Asignados</th>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success px-3 py-2 fs-6">
                                            <i class="bi bi-clipboard2-pulse me-1"></i><?= !empty($programas) ? count($programas) : 0 ?> programas de entrenamiento
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Programas de Entrenamiento asociados a este Rango de Edad -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clipboard2-pulse-fill text-success me-2"></i>Programas de Entrenamiento para este Rango de Edad
                        <span class="badge bg-success ms-2"><?= !empty($programas) ? count($programas) : 0 ?></span>
                    </h6>
                    <a href="<?= base_url('programaentrenamiento/add?idrango=' . $rango['idrangoedad']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>+ Nuevo Programa para este Rango
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($programas)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-info-circle fs-3 d-block mb-2 text-secondary"></i>
                            Actualmente no hay programas de entrenamiento configurados para este rango etario.
                            <div class="mt-2">
                                <a href="<?= base_url('programaentrenamiento/add?idrango=' . $rango['idrangoedad']) ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-circle me-1"></i>Crear Programa Ahora
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID</th>
                                        <th>Nombre del Programa</th>
                                        <th>Motivo de Entrenamiento</th>
                                        <th class="text-center">Rutinas</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($programas as $p): ?>
                                        <tr>
                                            <td class="ps-3 fw-bold text-muted">#<?= $p['idprogramaentrenamiento'] ?></td>
                                            <td class="fw-semibold text-dark">
                                                <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="text-decoration-none text-dark">
                                                    <?= esc($p['nombre']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-dark border border-warning px-2 py-1">
                                                    <i class="bi bi-bullseye text-warning me-1"></i><?= esc($p['motivo_nombre']) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-info-subtle text-info border border-info">
                                                    <?= (int)($p['total_rutinas'] ?? 0) ?> rutinas
                                                </span>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="btn btn-outline-primary" title="Ver Programa">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('programaentrenamiento/edit/' . $p['idprogramaentrenamiento']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
