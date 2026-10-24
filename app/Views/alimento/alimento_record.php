<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($alimento)): ?>
            <?= view('layout/empty_record', ['module' => 'alimento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'alimento',
                'currentId' => $alimento['idalimento']
            ]) ?>

            <!-- Ficha Principal del Alimento -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-apple text-success me-2 fs-4"></i>Ficha de Alimento: <?= esc($alimento['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $alimento['idalimento'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                                    <i class="bi bi-basket3-fill fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($alimento['nombre']) ?></h5>
                                <?php if (!empty($alimento['grupo_nombre'])): ?>
                                    <a href="<?= base_url('grupoalimento/actual/' . $alimento['idgrupo']) ?>" class="badge bg-success text-decoration-none px-3 py-1 mt-1 shadow-sm">
                                        <i class="bi bi-egg-fried me-1"></i><?= esc($alimento['grupo_nombre']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-1">Sin Grupo</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Alimento</th>
                                            <td class="fw-bold text-secondary">#<?= $alimento['idalimento'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Alimento</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-tag-fill text-success me-2"></i><?= esc($alimento['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Grupo Nutricional</th>
                                            <td>
                                                <?php if (!empty($alimento['grupo_nombre'])): ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <span class="fw-bold text-success">
                                                            <i class="bi bi-diagram-3 me-1"></i><?= esc($alimento['grupo_nombre']) ?>
                                                        </span>
                                                        <a href="<?= base_url('grupoalimento/actual/' . $alimento['idgrupo']) ?>" class="btn btn-xs btn-outline-success py-0 px-2 small" title="Ver ficha del grupo">
                                                            Ver Grupo <i class="bi bi-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No asignado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción y Propiedades</th>
                                            <td>
                                                <?php if (!empty($alimento['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-success text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($alimento['descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción ni información nutricional adicional.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between align-items-center py-2 px-4">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Alimento disponible para planes dietéticos.
                    </span>
                    <a href="<?= base_url('alimento/listar?idgrupo=' . $alimento['idgrupo']) ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-filter me-1"></i>Ver todos los de este grupo
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
