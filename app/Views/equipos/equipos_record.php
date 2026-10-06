<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($equipo)): ?>
            <?= view('layout/empty_record', ['module' => 'equipos']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'equipos',
                'currentId' => $equipo['id_equipo']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <div>
                        <span class="badge bg-primary font-monospace fs-6 me-2"><?= esc($equipo['codigo']) ?></span>
                        <span class="fw-bold text-dark fs-5"><?= esc($equipo['nombre']) ?></span>
                    </div>
                    <div>
                        <?php if (!empty($equipo['activo'])): ?>
                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                                <i class="bi bi-check-circle me-1"></i>Activo
                            </span>
                        <?php else: ?>
                            <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2">
                                <i class="bi bi-slash-circle me-1"></i>Inactivo
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 mb-3">
                        <div class="col-md-6">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Equipo</th>
                                        <td class="fw-bold text-muted"><?= $equipo['id_equipo'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Código Interno</th>
                                        <td class="font-monospace fw-bold text-primary"><?= esc($equipo['codigo']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Equipo</th>
                                        <td class="fw-bold text-dark"><?= esc($equipo['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Tipo / Categoría</th>
                                        <td>
                                            <span class="badge bg-info-subtle text-dark border border-info">
                                                <i class="bi bi-tag-fill text-info me-1"></i>
                                                <?= esc($tipos[$equipo['id_tipo']] ?? 'No especificado') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Marca</th>
                                        <td class="fw-semibold text-secondary">
                                            <?= esc($marcas[$equipo['id_marca']] ?? 'No especificada') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Modelo</th>
                                        <td><?= !empty($equipo['modelo']) ? esc($equipo['modelo']) : '<span class="text-muted">-</span>' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Número de Serie</th>
                                        <td class="font-monospace text-muted"><?= !empty($equipo['numero_serie']) ? esc($equipo['numero_serie']) : '-' ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">Ubicación en Gimnasio</th>
                                        <td>
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <?= esc($ubicaciones[$equipo['id_ubicacion']] ?? 'No asignada') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Estado Operativo</th>
                                        <td>
                                            <?php
                                                $estadoId = $equipo['id_estado'] ?? 1;
                                                $estadoName = $estados[$estadoId] ?? 'Desconocido';
                                                $badgeClass = match((int)$estadoId) {
                                                    1 => 'bg-success',
                                                    2 => 'bg-info text-dark',
                                                    3 => 'bg-warning text-dark',
                                                    4 => 'bg-danger',
                                                    5 => 'bg-secondary',
                                                    default => 'bg-secondary'
                                                };
                                            ?>
                                            <span class="badge <?= $badgeClass ?> px-3 py-1">
                                                <?= esc($estadoName) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Fecha de Adquisición</th>
                                        <td>
                                            <?= !empty($equipo['fecha_adquisicion']) ? '<i class="bi bi-calendar3 me-1 text-muted"></i>' . date('d/m/Y', strtotime($equipo['fecha_adquisicion'])) : '<span class="text-muted">-</span>' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Valor de Adquisición</th>
                                        <td class="fs-6 fw-bold text-success font-monospace">
                                            <?= !empty($equipo['valor_adquisicion']) ? '$ ' . number_format($equipo['valor_adquisicion'], 2) : '<span class="text-muted">-</span>' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Fecha de Registro</th>
                                        <td class="text-muted small">
                                            <?= !empty($equipo['fecha_registro']) ? date('d/m/Y H:i', strtotime($equipo['fecha_registro'])) : '-' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Descripción y Observaciones -->
                    <?php if (!empty($equipo['descripcion']) || !empty($equipo['observaciones'])): ?>
                        <div class="row g-3 border-top pt-3">
                            <?php if (!empty($equipo['descripcion'])): ?>
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-muted small text-uppercase mb-1"><i class="bi bi-info-circle me-1"></i>Descripción Técnica</h6>
                                    <div class="p-3 bg-light rounded border text-secondary small">
                                        <?= nl2br(esc($equipo['descripcion'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($equipo['observaciones'])): ?>
                                <div class="col-md-6">
                                    <h6 class="fw-bold text-muted small text-uppercase mb-1"><i class="bi bi-clipboard2-check me-1"></i>Observaciones / Mantenimiento</h6>
                                    <div class="p-3 bg-light rounded border text-secondary small">
                                        <?= nl2br(esc($equipo['observaciones'])) ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
