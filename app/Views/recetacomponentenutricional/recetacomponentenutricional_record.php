<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'recetacomponentenutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'recetacomponentenutricional',
                'currentId' => $rel['idrecetacomponentenutricional']
            ]) ?>

            <!-- Ficha Principal de la Asignación -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-book-half text-warning me-2 fs-4"></i>Receta y Componente Nutricional #<?= $rel['idrecetacomponentenutricional'] ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rel['idrecetacomponentenutricional'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-journal-bookmark-fill fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($rel['receta_nombre']) ?></h5>
                                <?php if (!empty($rel['porciones'])): ?>
                                    <span class="badge bg-warning text-dark border px-3 py-1 mt-1">
                                        <i class="bi bi-people-fill me-1"></i><?= $rel['porciones'] ?> <?= ($rel['porciones'] == 1) ? 'Porción' : 'Porciones' ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $rel['idrecetacomponentenutricional'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Receta Saludable</th>
                                        <td>
                                            <a href="<?= base_url('receta/actual/' . $rel['idreceta']) ?>" class="fw-bold text-decoration-none text-dark fs-6">
                                                <i class="bi bi-book text-warning me-1"></i><?= esc($rel['receta_nombre']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Componente Nutricional</th>
                                        <td>
                                            <a href="<?= base_url('componentenutricional/actual/' . $rel['idcomponentenutricional']) ?>" class="badge bg-info text-white text-decoration-none px-3 py-2 fs-6">
                                                <i class="bi bi-pie-chart-fill me-1"></i><?= esc($rel['componente_nombre']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted align-top">Descripción del Componente</th>
                                        <td class="text-secondary small">
                                            <?= !empty($rel['componente_descripcion']) ? nl2br(esc($rel['componente_descripcion'])) : '<span class="text-muted fst-italic">Sin descripción registrada</span>' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('receta/actual/' . $rel['idreceta']) ?>" class="btn btn-sm btn-outline-warning text-dark">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha de la Receta
                    </a>
                    <a href="<?= base_url('recetacomponentenutricional/add?idreceta=' . $rel['idreceta']) ?>" class="btn btn-sm btn-warning text-dark fw-semibold">
                        <i class="bi bi-plus-circle me-1"></i>Asignar otro componente
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
