<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($grupo)): ?>
            <?= view('layout/empty_record', ['module' => 'grupoalimento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'grupoalimento',
                'currentId' => $grupo['idgrupoalimento']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-egg-fried text-success me-2 fs-4"></i>Ficha de Grupo de Alimento: <?= esc($grupo['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $grupo['idgrupoalimento'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                                    <i class="bi bi-basket2-fill fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($grupo['nombre']) ?></h5>
                                <span class="badge bg-success-subtle text-success border border-success px-3 py-1">Nutrición & Dieta</span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Grupo</th>
                                            <td class="fw-bold text-secondary">#<?= $grupo['idgrupoalimento'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Grupo</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-tag-fill text-success me-2"></i><?= esc($grupo['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción y Características</th>
                                            <td>
                                                <?php if (!empty($grupo['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-success text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($grupo['descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción registrada.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Alimentos que pertenecen a este Grupo -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-apple text-success me-2 fs-5"></i>Alimentos en este Grupo
                        <span class="badge bg-success-subtle text-success border border-success ms-2"><?= count($alimentos ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('alimento/add?idgrupo=' . $grupo['idgrupoalimento']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Agregar Alimento
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($alimentos)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-basket3 fs-2 d-block mb-2 text-secondary"></i>
                            <p class="mb-2">No hay alimentos registrados en este grupo nutricional todavía.</p>
                            <a href="<?= base_url('alimento/add?idgrupo=' . $grupo['idgrupoalimento']) ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-plus-lg me-1"></i>Registrar el primer alimento
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4" style="width: 70px;">ID</th>
                                        <th>Alimento</th>
                                        <th>Descripción</th>
                                        <th class="text-end pe-4" style="width: 140px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($alimentos as $ali): ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-muted">#<?= $ali['idalimento'] ?></td>
                                            <td class="fw-semibold text-dark">
                                                <i class="bi bi-check2 text-success me-1"></i>
                                                <?= esc($ali['nombre']) ?>
                                            </td>
                                            <td class="text-secondary small">
                                                <?= !empty($ali['descripcion']) ? esc($ali['descripcion']) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                            </td>
                                            <td class="text-end pe-4">
                                                <a href="<?= base_url('alimento/actual/' . $ali['idalimento']) ?>" class="btn btn-xs btn-outline-primary" title="Ver ficha">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= base_url('alimento/edit/' . $ali['idalimento']) ?>" class="btn btn-xs btn-outline-warning text-dark" title="Editar">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
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
