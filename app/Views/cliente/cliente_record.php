<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($cliente)): ?>
            <?= view('layout/empty_record', ['module' => 'cliente']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'cliente',
                'currentId' => $cliente['idcliente']
            ]) ?>

            <?php $fotoUrl = 'https://educaysoft.org/descargar.php?archivo=fotos/' . rawurlencode(trim($cliente['cedula'])) . '.jpg'; ?>
            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-success mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom gap-2">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-person-badge-fill text-success me-2"></i>Ficha de Cliente
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="btn btn-sm btn-primary" title="Ir a la Ficha de la Persona para revisar o hacer cambios">
                            <i class="bi bi-person-vcard me-1"></i> Ver Ficha de Persona
                        </a>
                        <a href="<?= base_url('persona/edit/' . $cliente['idpersona']) ?>" class="btn btn-sm btn-outline-warning text-dark" title="Editar datos personales directamente">
                            <i class="bi bi-pencil-square me-1"></i> Editar Persona
                        </a>
                        <span class="badge bg-success text-white fs-6">ID Cliente #<?= $cliente['idcliente'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-3 text-center">
                            <a href="<?= esc($fotoUrl) ?>" target="_blank" title="Ver foto en tamaño original" class="d-inline-block text-decoration-none">
                                <img src="<?= esc($fotoUrl) ?>"
                                     alt="Foto Cédula <?= esc($cliente['cedula']) ?>"
                                     class="img-thumbnail rounded-3 border-success shadow-sm"
                                     style="width: 140px; height: 165px; object-fit: cover;"
                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-light text-success border rounded-3 shadow-sm align-items-center justify-content-center mx-auto" style="width: 140px; height: 165px; display: none;">
                                    <i class="bi bi-person-bounding-box fs-1"></i>
                                </div>
                            </a>
                            <div class="mt-2 small text-muted font-monospace"><?= esc($cliente['cedula']) ?></div>
                        </div>
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-25 text-muted">ID Cliente</th>
                                            <td class="fw-bold text-success">#<?= $cliente['idcliente'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Persona Asociada</th>
                                            <td>
                                                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                                                    <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="fs-5 fw-bold text-primary text-decoration-none" title="Saltar a la Ficha de la Persona">
                                                        <i class="bi bi-person-fill me-1"></i><?= esc(trim(($cliente['persona_apellidos'] ?? '') . ' ' . ($cliente['persona_nombres'] ?? ''))) ?>
                                                        <i class="bi bi-box-arrow-up-right fs-6 ms-1"></i>
                                                    </a>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('persona/actual/' . $cliente['idpersona']) ?>" class="btn btn-outline-primary">
                                                            <i class="bi bi-person-lines-fill me-1"></i> Ir a Ficha de Persona (#<?= $cliente['idpersona'] ?>)
                                                        </a>
                                                        <a href="<?= base_url('persona/edit/' . $cliente['idpersona']) ?>" class="btn btn-outline-secondary" title="Modificar datos de la persona">
                                                            <i class="bi bi-pencil"></i> Editar Datos
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Cédula</th>
                                            <td class="font-monospace fs-6"><?= esc($cliente['cedula']) ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Sexo</th>
                                            <td><?= !empty($cliente['sexo_nombre']) ? esc($cliente['sexo_nombre']) : '<span class="text-muted">-</span>' ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha Nacimiento</th>
                                            <td><?= !empty($cliente['fechanacimiento']) ? date('d/m/Y', strtotime($cliente['fechanacimiento'])) : '<span class="text-muted">-</span>' ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de Programas Ejecutados o en Ejecución por el Cliente -->
            <div class="card card-custom bg-white border-top border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center border-bottom gap-2">
                    <div class="d-flex align-items-center gap-2">
                        <h6 class="fw-bold mb-0 text-dark">
                            <i class="bi bi-play-circle-fill text-primary me-2"></i>Programas Ejecutados y en Ejecución (<code>programacliente</code>)
                        </h6>
                        <span class="badge bg-primary rounded-pill"><?= !empty($programasCliente) ? count($programasCliente) : 0 ?></span>
                    </div>
                    <a href="<?= base_url('programacliente/add?idcliente=' . $cliente['idcliente']) ?>" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> + Asignar Programa
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">ID</th>
                                    <th>Programa de Entrenamiento</th>
                                    <th>Motivo / Rango Edad</th>
                                    <th class="text-center">Contenido</th>
                                    <th>Fecha Inicio</th>
                                    <th>Estado</th>
                                    <th class="text-end pe-4">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($programasCliente)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            <i class="bi bi-clipboard2-x fs-3 d-block mb-1"></i>
                                            Este cliente aún no tiene programas de entrenamiento en ejecución ni registrados en su historial.
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($programasCliente as $pc): ?>
                                        <?php
                                            $badgeColor = 'bg-primary';
                                            $estLower = strtolower($pc['estado_nombre'] ?? '');
                                            if (str_contains($estLower, 'activo') || str_contains($estLower, 'ejecu')) $badgeColor = 'bg-success';
                                            elseif (str_contains($estLower, 'completado') || str_contains($estLower, 'finalizado')) $badgeColor = 'bg-info text-dark';
                                            elseif (str_contains($estLower, 'pausado') || str_contains($estLower, 'espera')) $badgeColor = 'bg-warning text-dark';
                                            elseif (str_contains($estLower, 'cancelado') || str_contains($estLower, 'inactivo')) $badgeColor = 'bg-danger';
                                        ?>
                                        <tr>
                                            <td class="ps-4 fw-bold text-primary">#<?= $pc['idprogramacliente'] ?></td>
                                            <td>
                                                <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                    <?= esc($pc['programa_nombre']) ?>
                                                </a>
                                                <a href="<?= base_url('programaentrenamiento/actual/' . $pc['idprogramaentrenamiento']) ?>" class="small text-muted text-decoration-none">
                                                    <i class="bi bi-clipboard2-pulse me-1"></i>Ver Programa Base #<?= $pc['idprogramaentrenamiento'] ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-warning text-dark mb-1">
                                                    <i class="bi bi-bullseye me-1"></i><?= esc($pc['motivo_nombre']) ?>
                                                </span>
                                                <?php if (!empty($pc['rango_nombre'])): ?>
                                                    <div class="small text-muted">
                                                        <i class="bi bi-person-bounding-box me-1"></i><?= esc($pc['rango_nombre']) ?> (<?= $pc['rango_edadminima'] ?>-<?= $pc['rango_edadmaxima'] ?> años)
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge bg-light text-dark border me-1" title="Rutinas incluidas">
                                                    <i class="bi bi-calendar2-week text-info me-1"></i><?= (int)($pc['total_rutinas'] ?? 0) ?> rutinas
                                                </span>
                                                <span class="badge bg-light text-dark border" title="Planes de ejercicio">
                                                    <i class="bi bi-card-checklist text-success me-1"></i><?= (int)($pc['total_planes'] ?? 0) ?> planes
                                                </span>
                                            </td>
                                            <td class="fw-semibold text-dark">
                                                <i class="bi bi-calendar-event text-primary me-1"></i><?= !empty($pc['fechainicio']) ? date('d/m/Y', strtotime($pc['fechainicio'])) : '-' ?>
                                            </td>
                                            <td>
                                                <span class="badge <?= $badgeColor ?> px-2 py-1">
                                                    <i class="bi bi-flag-fill me-1"></i><?= esc($pc['estado_nombre']) ?>
                                                </span>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('programacliente/actual/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-primary" title="Ver Ficha de Ejecución del Programa">
                                                        <i class="bi bi-eye"></i> Ver Ejecución
                                                    </a>
                                                    <a href="<?= base_url('programacliente/edit/' . $pc['idprogramacliente']) ?>" class="btn btn-outline-warning" title="Editar Asignación">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
