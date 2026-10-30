<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'alimentocomponentenutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'alimentocomponentenutricional',
                'currentId' => $rel['idalimentocomponentenutricional']
            ]) ?>

            <!-- Ficha Principal de la Asignación -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-link-45deg text-success me-2 fs-4"></i>Alimento y Componente Nutricional #<?= $rel['idalimentocomponentenutricional'] ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rel['idalimentocomponentenutricional'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-apple fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($rel['alimento_nombre']) ?></h5>
                                <?php if (!empty($rel['grupo_nombre'])): ?>
                                    <span class="badge bg-success-subtle text-success border border-success px-3 py-1 mt-1">
                                        <?= esc($rel['grupo_nombre']) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $rel['idalimentocomponentenutricional'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Alimento</th>
                                        <td>
                                            <a href="<?= base_url('alimento/actual/' . $rel['idalimento']) ?>" class="fw-bold text-decoration-none text-success fs-6">
                                                <i class="bi bi-apple me-1"></i><?= esc($rel['alimento_nombre']) ?>
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
                    <a href="<?= base_url('alimento/actual/' . $rel['idalimento']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha del Alimento
                    </a>
                    <a href="<?= base_url('alimentocomponentenutricional/add?idalimento=' . $rel['idalimento']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Asignar otro componente
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
