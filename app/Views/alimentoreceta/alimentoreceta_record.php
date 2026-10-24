<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'alimentoreceta']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'alimentoreceta',
                'currentId' => $rel['idalimentoreceta']
            ]) ?>

            <!-- Ficha Principal de la Asignación -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-diagram-3-fill text-warning me-2 fs-4"></i>Ingrediente de Receta #<?= $rel['idalimentoreceta'] ?>
                    </h5>
                    <span class="badge bg-secondary text-white fs-6">ID #<?= $rel['idalimentoreceta'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                    <i class="bi bi-egg-fried fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($rel['alimento_nombre']) ?></h5>
                                <div class="badge bg-warning text-dark fs-6 px-3 py-2 mt-2 shadow-sm">
                                    <i class="bi bi-calculator me-1"></i><?= number_format((float)$rel['cantidad'], 2) ?> <?= esc($rel['unidad_abreviatura']) ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $rel['idalimentoreceta'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Receta Perteneciente</th>
                                        <td>
                                            <a href="<?= base_url('receta/actual/' . $rel['idreceta']) ?>" class="fw-bold text-decoration-none text-dark">
                                                <i class="bi bi-book text-warning me-1"></i><?= esc($rel['receta_nombre']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Alimento / Ingrediente</th>
                                        <td>
                                            <a href="<?= base_url('alimento/actual/' . $rel['idalimento']) ?>" class="fw-bold text-decoration-none text-success">
                                                <i class="bi bi-apple me-1"></i><?= esc($rel['alimento_nombre']) ?>
                                            </a>
                                            <?php if (!empty($rel['grupo_nombre'])): ?>
                                                <span class="badge bg-light text-muted border ms-2"><?= esc($rel['grupo_nombre']) ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Cantidad</th>
                                        <td class="fs-5 fw-bold text-primary">
                                            <?= number_format((float)$rel['cantidad'], 2) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Unidad de Medida</th>
                                        <td>
                                            <a href="<?= base_url('unidadalimento/actual/' . $rel['idunidadalimento']) ?>" class="badge bg-info-subtle text-info border border-info text-decoration-none px-3 py-1 fs-6">
                                                <?= esc($rel['unidad_nombre']) ?> (<?= esc($rel['unidad_abreviatura']) ?>)
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('receta/actual/' . $rel['idreceta']) ?>" class="btn btn-sm btn-outline-warning text-dark">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha Completa de la Receta
                    </a>
                    <a href="<?= base_url('alimentoreceta/add?idreceta=' . $rel['idreceta']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Agregar otro ingrediente
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
