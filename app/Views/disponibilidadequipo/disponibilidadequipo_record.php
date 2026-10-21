<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($disponibilidad)): ?>
            <?= view('layout/empty_record', ['module' => 'disponibilidadequipo']) ?>
        <?php else: ?>

            <!-- Toolbar de Navegación -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'disponibilidadequipo',
                'currentId' => $disponibilidad['iddisponibilidadequipo']
            ]) ?>

            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-clock-history text-info me-2"></i>Estado de Disponibilidad
                    </h5>
                    <span class="badge bg-info-subtle text-dark border border-info fs-6">ID #<?= $disponibilidad['iddisponibilidadequipo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center mb-3 mb-md-0">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-inline-flex align-items-center justify-content-center p-4" style="width: 90px; height: 90px;">
                                <i class="bi bi-activity fs-1"></i>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <table class="table table-bordered mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Disponibilidad</th>
                                        <td class="fw-bold text-muted">#<?= $disponibilidad['iddisponibilidadequipo'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Estado</th>
                                        <td class="fw-bold fs-5 text-dark"><?= esc($disponibilidad['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Equipos en este Estado</th>
                                        <td>
                                            <span class="badge bg-primary px-3 py-2 fs-6">
                                                <?= count($equiposAsociados ?? []) ?> <?= count($equiposAsociados ?? []) === 1 ? 'equipo' : 'equipos' ?>
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Listado de Equipos en este Estado -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mt-4">
                <div class="card-header bg-white py-3 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-gear-wide-connected text-primary me-2"></i>Equipos actualmente con disponibilidad: <strong><?= esc($disponibilidad['nombre']) ?></strong>
                    </h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($equiposAsociados)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-info-circle fs-3 d-block mb-1 text-secondary opacity-50"></i>
                            <p class="mb-0">Actualmente ningún equipo tiene asignado este estado de disponibilidad.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3" style="width: 60px;">Foto</th>
                                        <th>Código</th>
                                        <th>Nombre del Equipo</th>
                                        <th>Modelo</th>
                                        <th class="text-end pe-3">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($equiposAsociados as $eq): ?>
                                        <tr>
                                            <td class="ps-3">
                                                <?php if (!empty($eq['imagen'])): ?>
                                                    <img src="<?= base_url('repositorio/images/equipment/' . esc($eq['imagen'])) ?>" 
                                                         onerror="this.onerror=null; this.src='<?= base_url('equipo/imagen/' . esc($eq['imagen'])) ?>';"
                                                         alt="<?= esc($eq['nombre']) ?>" 
                                                         class="rounded border bg-light shadow-xs" 
                                                         style="width: 40px; height: 40px; object-fit: contain; padding: 2px;">
                                                <?php else: ?>
                                                    <i class="bi bi-gear text-muted fs-4"></i>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary font-monospace border">
                                                    <?= esc($eq['codigo']) ?>
                                                </span>
                                            </td>
                                            <td class="fw-bold text-dark">
                                                <a href="<?= base_url('equipo/actual/' . $eq['idequipo']) ?>" class="text-primary text-decoration-none">
                                                    <?= esc($eq['nombre']) ?>
                                                </a>
                                            </td>
                                            <td class="text-muted small"><?= esc($eq['modelo'] ?? '-') ?></td>
                                            <td class="text-end pe-3">
                                                <a href="<?= base_url('equipo/actual/' . $eq['idequipo']) ?>" class="btn btn-outline-primary btn-sm px-2 py-1">
                                                    <i class="bi bi-eye me-1"></i>Ver Ficha
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
