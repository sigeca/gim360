<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($equipo)): ?>
            <?= view('layout/empty_record', ['module' => 'equipo']) ?>
        <?php else: ?>
            <?php
                $youtubeEmbedUrl = null;
                if (!empty($equipo['video'])) {
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/|youtube\.com/shorts/)([^"&?/\s]{11})%i', $equipo['video'], $match)) {
                        $youtubeEmbedUrl = 'https://www.youtube.com/embed/' . $match[1];
                    }
                }
            ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'equipo',
                'currentId' => $equipo['idequipo']
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
                    <div class="row g-4 mb-4 align-items-start">
                        <!-- Panel de Imagen del Equipo -->
                        <div class="col-md-5 col-lg-4 text-center">
                            <div class="p-3 bg-light rounded-4 border shadow-sm position-relative">
                                <?php if (!empty($equipo['imagen'])): ?>
                                    <div class="position-relative bg-white rounded-3 p-2 border mb-2">
                                        <img src="<?= base_url('repositorio/images/equipment/' . esc($equipo['imagen'])) ?>" 
                                             onerror="this.onerror=null; this.src='<?= base_url('equipo/imagen/' . esc($equipo['imagen'])) ?>';"
                                             alt="<?= esc($equipo['nombre']) ?>" 
                                             class="img-fluid rounded" 
                                             style="max-height: 280px; width: 100%; object-fit: contain;">
                                    </div>
                                    <div class="small text-muted text-break text-start mb-2">
                                        <i class="bi bi-file-earmark-image me-1"></i><code><?= esc($equipo['imagen']) ?></code>
                                    </div>
                                    <div class="d-grid">
                                        <a href="<?= base_url('equipo/imagen/' . esc($equipo['imagen'])) ?>" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-arrows-fullscreen me-1"></i>Ver en tamaño completo
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <span>Sin imagen registrada</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Detalles Principales del Equipo -->
                        <div class="col-md-7 col-lg-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Equipo</th>
                                        <td class="fw-bold text-muted">#<?= $equipo['idequipo'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Código Interno</th>
                                        <td class="font-monospace fw-bold text-primary"><?= esc($equipo['codigo']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre del Equipo</th>
                                        <td class="fw-bold text-dark fs-5"><?= esc($equipo['nombre']) ?></td>
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
                                        <th class="table-light text-muted">Disponibilidad</th>
                                        <td>
                                            <?php
                                                $dispId = $equipo['iddisponibilidadequipo'] ?? 1;
                                                $dispName = $disponibilidades[$dispId] ?? 'Disponible';
                                                $badgeDisp = match((int)$dispId) {
                                                    1 => 'bg-success text-white',
                                                    2 => 'bg-primary text-white',
                                                    3 => 'bg-warning text-dark',
                                                    4 => 'bg-danger text-white',
                                                    5 => 'bg-secondary text-white',
                                                    6 => 'bg-info text-dark',
                                                    default => 'bg-light text-dark border'
                                                };
                                            ?>
                                            <span class="badge <?= $badgeDisp ?> px-3 py-1">
                                                <i class="bi bi-clock-history me-1"></i><?= esc($dispName) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Ubicación en Gimnasio</th>
                                        <td>
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <?= esc($ubicaciones[$equipo['id_ubicacion']] ?? 'No asignada') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Video de Uso / Guía</th>
                                        <td>
                                            <?php if (!empty($equipo['video'])): ?>
                                                <a href="<?= esc($equipo['video']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                                    <i class="bi bi-youtube me-1"></i>Ver en YouTube <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                </a>
                                                <small class="d-block text-muted font-monospace mt-1"><?= esc($equipo['video']) ?></small>
                                            <?php else: ?>
                                                <span class="text-muted small"><i class="bi bi-camera-video-off me-1"></i>Sin video asignado</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Datos Complementarios y Registro -->
                    <div class="row g-4 mb-3">
                        <div class="col-md-6">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">Número de Serie</th>
                                        <td class="font-monospace text-muted"><?= !empty($equipo['numero_serie']) ? esc($equipo['numero_serie']) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Archivo de Imagen</th>
                                        <td class="text-secondary font-monospace small">
                                            <?= !empty($equipo['imagen']) ? esc($equipo['imagen']) : '<span class="text-muted">-</span>' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Origen del Repositorio</th>
                                        <td class="small text-muted font-monospace">repositorio/images/equipment/</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">Fecha de Adquisición</th>
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

                    <!-- Video Demostrativo y Guía de Uso del Equipo -->
                    <?php if (!empty($equipo['video'])): ?>
                        <div class="mb-4 border-top pt-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="bi bi-youtube text-danger me-2 fs-5"></i>Video Demostrativo y Guía de Uso del Equipo:
                            </h6>
                            <div class="p-3 bg-light rounded-4 border">
                                <?php if ($youtubeEmbedUrl): ?>
                                    <div class="ratio ratio-16x9 rounded-3 shadow-sm overflow-hidden mb-3">
                                        <iframe src="<?= $youtubeEmbedUrl ?>" title="Video de <?= esc($equipo['nombre']) ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                <?php endif; ?>
                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-play-circle-fill text-danger fs-4"></i>
                                        <div>
                                            <span class="fw-semibold text-dark">Enlace del video tutorial:</span>
                                            <small class="d-block text-muted font-monospace"><?= esc($equipo['video']) ?></small>
                                        </div>
                                    </div>
                                    <a href="<?= esc($equipo['video']) ?>" target="_blank" class="btn btn-danger btn-sm">
                                        <i class="bi bi-youtube me-1"></i>Ver en YouTube <i class="bi bi-box-arrow-up-right ms-1"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

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

            <!-- Card: Músculos que se Ejercitan con este Equipo -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-diagram-3-fill text-danger me-2 fs-4"></i>Músculos que se ejercitan con este equipo
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 fs-6">
                            <i class="bi bi-check2-circle me-1"></i><?= count($musculos ?? []) ?> <?= count($musculos ?? []) === 1 ? 'músculo' : 'músculos' ?>
                        </span>
                        <button type="button" class="btn btn-danger btn-sm fw-bold px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#modalVincularMusculoEquipo">
                            <i class="bi bi-plus-circle me-1"></i>+ Vincular Músculo
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php if (empty($musculos)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-diagram-3 fs-1 d-block mb-2 text-danger opacity-50"></i>
                            <p class="mb-2">No se han registrado músculos vinculados directamente a este equipo.</p>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalVincularMusculoEquipo">
                                <i class="bi bi-plus-lg me-1"></i>Asignar primer músculo
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($musculos as $m): ?>
                                <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                                    <div class="card h-100 bg-light border shadow-xs rounded-3 p-2 position-relative hover-shadow transition-all">
                                        <div class="position-relative" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                            <?php if (!empty($m['imagen'])): ?>
                                                <img src="<?= base_url('uploads/muscles/' . esc($m['imagen'])) ?>" 
                                                     onerror="this.onerror=null; this.src='<?= base_url('musculo/imagen/' . esc($m['imagen'])) ?>';"
                                                     alt="<?= esc($m['nombre']) ?>" 
                                                     class="img-fluid" 
                                                     style="max-height: 90px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                            <?php else: ?>
                                                <i class="bi bi-diagram-3 fs-1 text-danger"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" 
                                               class="fw-bold text-dark text-decoration-none small d-block text-truncate mt-1" 
                                               title="<?= esc($m['nombre']) ?>">
                                                <?= esc($m['nombre']) ?>
                                            </a>
                                        </div>
                                        <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
                                            <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="btn btn-link btn-sm p-0 text-danger small text-decoration-none" title="Ver ficha del músculo">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="<?= base_url('equipo/quitarMusculo/' . $equipo['idequipo'] . '/' . $m['idmusculo']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular <?= esc($m['nombre']) ?> de este equipo?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-link btn-sm p-0 text-danger" title="Desvincular músculo">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Modal para Vincular Músculo a este Equipo -->
            <div class="modal fade" id="modalVincularMusculoEquipo" tabindex="-1" aria-labelledby="modalVincularMusculoEquipoLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="<?= base_url('equipo/asignarMusculo/' . $equipo['idequipo']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title fw-bold" id="modalVincularMusculoEquipoLabel">
                                    <i class="bi bi-plus-circle me-1"></i>Vincular Músculo al Equipo
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="small text-muted mb-3">
                                    Seleccione el músculo o grupo muscular que se ejercita con <strong><?= esc($equipo['nombre']) ?></strong>:
                                </p>
                                <div class="mb-3">
                                    <label for="selectMusculoModalEquipo" class="form-label fw-semibold">Músculo a Vincular <span class="text-danger">*</span></label>
                                    <select name="idmusculo" id="selectMusculoModalEquipo" class="form-select" required>
                                        <option value="">-- Seleccionar Músculo --</option>
                                        <?php foreach ($todosLosMusculos as $tm): ?>
                                            <?php $yaAsignadoM = in_array($tm['idmusculo'], array_column($musculos ?? [], 'idmusculo')); ?>
                                            <option value="<?= $tm['idmusculo'] ?>" <?= $yaAsignadoM ? 'disabled class="text-muted"' : '' ?>>
                                                <?= esc($tm['nombre']) ?> <?= $yaAsignadoM ? '✓ (Ya vinculado)' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger fw-bold">Vincular Músculo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tabla de Ejercicios Relacionados con el Equipo -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-activity text-info me-2 fs-4"></i>Ejercicios que se realizan con este equipo
                    </h5>
                    <span class="badge bg-info-subtle text-dark border border-info px-3 py-2 fs-6">
                        <i class="bi bi-card-checklist me-1"></i><?= count($ejercicios ?? []) ?> <?= count($ejercicios ?? []) === 1 ? 'ejercicio vinculado' : 'ejercicios vinculados' ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($ejercicios)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-info-circle fs-2 d-block mb-2 text-secondary opacity-50"></i>
                            <p class="mb-0">No hay ejercicios registrados actualmente para este equipo.</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center" style="width: 80px;">Animación</th>
                                        <th style="width: 70px;">ID</th>
                                        <th>Ejercicio</th>
                                        <th>Músculos Implicados</th>
                                        <th>Descripción Técnica</th>
                                        <th class="text-center" style="width: 110px;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($ejercicios as $ej): ?>
                                        <tr>
                                            <td class="text-center p-2">
                                                <div class="bg-light rounded border p-1 d-inline-block shadow-xs" style="width: 72px; height: 50px;">
                                                    <?php if (!empty($ej['ejercicio_imagen'])): ?>
                                                        <img src="<?= base_url('repositorio/ejercicios/' . esc($ej['ejercicio_imagen'])) ?>" 
                                                             onerror="this.onerror=null; this.src='<?= base_url('ejercicio/imagen/' . esc($ej['ejercicio_imagen'])) ?>';"
                                                             alt="<?= esc($ej['ejercicio_nombre']) ?>" 
                                                             class="img-fluid rounded" 
                                                             style="max-height: 42px; width: 100%; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="bi bi-image text-muted fs-4"></i>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary font-monospace border">
                                                    #<?= $ej['idejercicio'] ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark">
                                                    <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="text-primary text-decoration-none">
                                                        <?= esc($ej['ejercicio_nombre']) ?>
                                                    </a>
                                                </div>
                                                <?php if (!empty($ej['ejercicio_nombreingles'])): ?>
                                                    <div class="small text-muted fst-italic">
                                                        <?= esc($ej['ejercicio_nombreingles']) ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php 
                                                    $musculos = $musculosPorEjercicio[$ej['idejercicio']] ?? []; 
                                                ?>
                                                <?php if (!empty($musculos)): ?>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <?php foreach ($musculos as $m): ?>
                                                            <span class="badge bg-light text-dark border small py-1">
                                                                <i class="bi bi-dot text-danger"></i><?= esc($m['nombre']) ?>
                                                            </span>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small fst-italic">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($ej['ejercicio_descripcion'])): ?>
                                                    <div class="small text-secondary" style="max-height: 52px; overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                        <?= esc(strip_tags($ej['ejercicio_descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted small fst-italic">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="btn btn-outline-primary btn-sm px-2 py-1" title="Ver Ficha del Ejercicio">
                                                    <i class="bi bi-eye me-1"></i>Ver
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
