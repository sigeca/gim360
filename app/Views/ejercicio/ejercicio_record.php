<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($ejercicio)): ?>
            <?= view('layout/empty_record', ['module' => 'ejercicio']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'ejercicio',
                'currentId' => $ejercicio['idejercicio']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-fire text-danger me-2"></i>Ficha Técnica de Ejercicio
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($ejercicio['imagen'])): ?>
                            <?php if (str_contains($ejercicio['imagen'], '-start.webp')): ?>
                                <span class="badge bg-primary"><i class="bi bi-play-circle me-1"></i>Fase Inicial</span>
                            <?php elseif (str_contains($ejercicio['imagen'], '-peak.webp')): ?>
                                <span class="badge bg-success"><i class="bi bi-bullseye me-1"></i>Fase Final / Pico</span>
                            <?php else: ?>
                                <span class="badge bg-info text-dark"><i class="bi bi-image me-1"></i>Ilustración</span>
                            <?php endif; ?>
                        <?php endif; ?>
                        <span class="badge bg-danger fs-6">ID #<?= $ejercicio['idejercicio'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">

                    <div class="row g-4 mb-4 align-items-start">
                        <!-- Columna de la Imagen del Ejercicio -->
                        <div class="col-md-5 col-lg-4 text-center">
                            <div class="p-3 bg-light rounded border shadow-sm">
                                <?php if (!empty($ejercicio['imagen'])): ?>
                                    <div class="position-relative">
                                        <img src="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" 
                                             alt="<?= esc($ejercicio['nombre']) ?>" 
                                             class="img-fluid rounded" 
                                             style="max-height: 290px; width: 100%; object-fit: contain; background-color: #ffffff; border-radius: 8px;">
                                    </div>
                                    <div class="mt-2 text-start small text-muted">
                                        <i class="bi bi-file-image me-1"></i><code><?= esc($ejercicio['imagen']) ?></code>
                                    </div>
                                    <div class="d-grid gap-2 mt-2">
                                        <?php if (!empty($parejaEjercicio)): ?>
                                            <a href="<?= base_url('ejercicio/actual/' . $parejaEjercicio['idejercicio']) ?>" class="btn btn-outline-danger btn-sm">
                                                <i class="bi bi-arrow-left-right me-1"></i>
                                                <?= str_contains($parejaEjercicio['imagen'], '-start.webp') ? 'Ver Fase Inicial (Start)' : 'Ver Fase Final (Peak)' ?>
                                            </a>
                                        <?php endif; ?>
                                        <a href="<?= base_url('ejercicio/imagen/' . esc($ejercicio['imagen'])) ?>" target="_blank" class="btn btn-light btn-sm border text-secondary">
                                            <i class="bi bi-arrows-fullscreen me-1"></i> Ampliar Imagen
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image display-4 d-block mb-2 text-secondary"></i>
                                        <em>Sin imagen disponible</em>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Columna de Datos Técnicos -->
                        <div class="col-md-7 col-lg-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-30 text-muted">ID Ejercicio</th>
                                            <td class="fw-bold text-muted"><?= $ejercicio['idejercicio'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Ejercicio</th>
                                            <td class="fs-5 fw-bold text-dark">
                                                <?= esc($ejercicio['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Archivo Gráfico</th>
                                            <td>
                                                <?php if (!empty($ejercicio['imagen'])): ?>
                                                    <span class="badge bg-light text-dark border">
                                                        <i class="bi bi-file-earmark-image text-danger me-1"></i><?= esc($ejercicio['imagen']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted"><i class="bi bi-x-circle me-1"></i>No asignado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Demostración / Video</th>
                                            <td>
                                                <?php if (!empty($ejercicio['urlvideo'])): ?>
                                                    <a href="<?= esc($ejercicio['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                                        <i class="bi bi-youtube me-1"></i> Ver Video Tutorial <i class="bi bi-box-arrow-up-right ms-1"></i>
                                                    </a>
                                                    <small class="d-block text-muted font-monospace mt-1"><?= esc($ejercicio['urlvideo']) ?></small>
                                                <?php else: ?>
                                                    <span class="text-muted"><i class="bi bi-camera-video-off me-1"></i>Sin enlace de video</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Músculos Afectados / Involucrados en el Ejercicio -->
                    <div class="mb-4 border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                <i class="bi bi-person-arms-up text-danger me-2 fs-5"></i>Músculos Afectados / Involucrados:
                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle ms-2">
                                    <?= count($musculos) ?> <?= count($musculos) === 1 ? 'músculo' : 'músculos' ?>
                                </span>
                            </h6>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarMusculo">
                                <i class="bi bi-plus-circle me-1"></i>Vincular Músculo
                            </button>
                        </div>

                        <?php if (empty($musculos)): ?>
                            <div class="p-4 bg-light rounded border text-center text-muted">
                                <i class="bi bi-person-arms-up fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                <p class="mb-2">No se han registrado músculos afectados para este ejercicio.</p>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarMusculo">
                                    <i class="bi bi-plus-lg me-1"></i>Vincular Músculos Ahora
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($musculos as $m): ?>
                                    <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                                        <div class="card h-100 bg-light border shadow-xs rounded-3 p-2 position-relative hover-shadow transition-all">
                                            <div class="position-relative" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <img src="<?= base_url('repositorio/images/muscles/' . esc($m['imagen'])) ?>" 
                                                     onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($m['imagen'])) ?>';"
                                                     alt="<?= esc($m['nombre']) ?>" 
                                                     class="img-fluid" 
                                                     style="max-height: 90px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                            </div>
                                            <div class="mt-2">
                                                <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" 
                                                   class="fw-bold text-dark text-decoration-none small d-block text-truncate" 
                                                   title="<?= esc($m['nombre']) ?>">
                                                    <?= esc($m['nombre']) ?>
                                                </a>
                                            </div>
                                            <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
                                                <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="btn btn-link btn-sm p-0 text-primary small text-decoration-none" title="Ver ficha del músculo">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="<?= base_url('ejercicio/quitarMusculo/' . $ejercicio['idejercicio'] . '/' . $m['idmusculo']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular <?= esc($m['nombre']) ?> de este ejercicio?');">
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

                    <!-- Modal para Vincular Músculo -->
                    <div class="modal fade" id="modalAsignarMusculo" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Vincular Músculo al Ejercicio</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= base_url('ejercicio/asignarMusculo/' . $ejercicio['idejercicio']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <p class="small text-muted mb-3">
                                            Seleccione el músculo anatómico que es activado o trabajado por <strong><?= esc($ejercicio['nombre']) ?></strong>:
                                        </p>
                                        <div class="mb-3">
                                            <label for="selectMusculoModal" class="form-label fw-semibold">Músculo a Vincular <span class="text-danger">*</span></label>
                                            <select name="idmusculo" id="selectMusculoModal" class="form-select" required>
                                                <option value="">-- Seleccionar Músculo --</option>
                                                <?php foreach ($todosLosMusculos as $tm): ?>
                                                    <?php $yaAsignado = in_array($tm['idmusculo'], array_column($musculos, 'idmusculo')); ?>
                                                    <option value="<?= $tm['idmusculo'] ?>" <?= $yaAsignado ? 'disabled class="text-muted"' : '' ?>>
                                                        <?= esc($tm['nombre']) ?> <?= $yaAsignado ? '✓ (Ya vinculado)' : '' ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-danger">Vincular Músculo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Equipamiento / Máquinas Requeridas en el Ejercicio -->
                    <div class="mb-4 border-top pt-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-bold text-dark mb-0 d-flex align-items-center">
                                <i class="bi bi-gear-wide-connected text-primary me-2 fs-5"></i>Equipamiento / Máquinas Requeridas:
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle ms-2">
                                    <?= count($equipos) ?> <?= count($equipos) === 1 ? 'equipo' : 'equipos' ?>
                                </span>
                            </h6>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarEquipo">
                                <i class="bi bi-plus-circle me-1"></i>Vincular Equipo
                            </button>
                        </div>

                        <?php if (empty($equipos)): ?>
                            <div class="p-4 bg-light rounded border text-center text-muted">
                                <i class="bi bi-gear-wide fs-2 d-block mb-2 text-secondary opacity-50"></i>
                                <p class="mb-2">No se han registrado equipos o máquinas requeridas para este ejercicio (peso corporal / calistenia).</p>
                                <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarEquipo">
                                    <i class="bi bi-plus-lg me-1"></i>Vincular Equipo Ahora
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="row g-3">
                                <?php foreach ($equipos as $eq): ?>
                                    <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                                        <div class="card h-100 bg-light border shadow-xs rounded-3 p-2 position-relative hover-shadow transition-all">
                                            <div class="position-relative" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                                <?php if (!empty($eq['imagen'])): ?>
                                                    <img src="<?= base_url('repositorio/images/equipment/' . esc($eq['imagen'])) ?>" 
                                                         onerror="this.onerror=null; this.src='<?= base_url('equipos/imagen/' . esc($eq['imagen'])) ?>';"
                                                         alt="<?= esc($eq['nombre']) ?>" 
                                                         class="img-fluid" 
                                                         style="max-height: 90px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                                <?php else: ?>
                                                    <i class="bi bi-image fs-1 text-muted"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mt-2">
                                                <span class="badge bg-secondary-subtle text-secondary border font-monospace small"><?= esc($eq['codigo']) ?></span>
                                                <a href="<?= base_url('equipos/actual/' . $eq['idequipo']) ?>" 
                                                   class="fw-bold text-dark text-decoration-none small d-block text-truncate mt-1" 
                                                   title="<?= esc($eq['nombre']) ?>">
                                                    <?= esc($eq['nombre']) ?>
                                                </a>
                                            </div>
                                            <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
                                                <a href="<?= base_url('equipos/actual/' . $eq['idequipo']) ?>" class="btn btn-link btn-sm p-0 text-primary small text-decoration-none" title="Ver ficha del equipo">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="<?= base_url('ejercicio/quitarEquipo/' . $ejercicio['idejercicio'] . '/' . $eq['idequipo']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular <?= esc($eq['nombre']) ?> de este ejercicio?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-link btn-sm p-0 text-danger" title="Desvincular equipo">
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

                    <!-- Modal para Vincular Equipo -->
                    <div class="modal fade" id="modalAsignarEquipo" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Vincular Equipo al Ejercicio</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= base_url('ejercicio/asignarEquipo/' . $ejercicio['idejercicio']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="modal-body">
                                        <p class="small text-muted mb-3">
                                            Seleccione el equipo, máquina o implemento empleado para realizar <strong><?= esc($ejercicio['nombre']) ?></strong>:
                                        </p>
                                        <div class="mb-3">
                                            <label for="selectEquipoModal" class="form-label fw-semibold">Equipo a Vincular <span class="text-danger">*</span></label>
                                            <select name="idequipo" id="selectEquipoModal" class="form-select" required>
                                                <option value="">-- Seleccionar Equipo --</option>
                                                <?php foreach ($todosLosEquipos as $te): ?>
                                                    <?php $yaAsignadoEq = in_array($te['id_equipo'], array_column($equipos, 'idequipo')); ?>
                                                    <option value="<?= $te['id_equipo'] ?>" <?= $yaAsignadoEq ? 'disabled class="text-muted"' : '' ?>>
                                                        <?= esc($te['codigo']) ?> - <?= esc($te['nombre']) ?> <?= !empty($te['modelo']) ? '(' . esc($te['modelo']) . ')' : '' ?> <?= $yaAsignadoEq ? '✓ (Ya vinculado)' : '' ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Vincular Equipo</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Demostración en Video -->
                    <?php if (!empty($youtubeId)): ?>
                        <div class="mb-4 border-top pt-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="bi bi-play-circle-fill text-danger me-2 fs-5"></i>Demostración en Video:
                            </h6>
                            <div class="ratio ratio-16x9 rounded overflow-hidden shadow-sm border">
                                <iframe src="https://www.youtube.com/embed/<?= esc($youtubeId) ?>" title="<?= esc($ejercicio['nombre']) ?>" allowfullscreen></iframe>
                            </div>
                        </div>
                    <?php elseif (!empty($ejercicio['urlvideo'])): ?>
                        <div class="mb-4 border-top pt-4">
                            <h6 class="fw-bold text-dark mb-3 d-flex align-items-center">
                                <i class="bi bi-play-circle-fill text-danger me-2 fs-5"></i>Demostración en Video:
                            </h6>
                            <div class="p-3 bg-light rounded border d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-camera-video text-danger fs-3"></i>
                                    <div>
                                        <span class="fw-semibold text-dark">Video tutorial registrado:</span>
                                        <small class="d-block text-muted font-monospace"><?= esc($ejercicio['urlvideo']) ?></small>
                                    </div>
                                </div>
                                <a href="<?= esc($ejercicio['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-box-arrow-up-right me-1"></i> Abrir Demostración
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Descripción y Ejecución Técnica (A LO ÚLTIMO) -->
                    <div class="mb-2 border-top pt-4">
                        <h6 class="fw-bold text-dark mb-2 d-flex align-items-center">
                            <i class="bi bi-card-text text-danger me-2 fs-5"></i>Descripción y Ejecución Técnica:
                        </h6>
                        <div class="p-3 bg-light rounded border text-secondary" style="font-size: 0.95rem; line-height: 1.6;">
                            <?= !empty($ejercicio['descripcion']) ? nl2br(esc($ejercicio['descripcion'])) : '<em class="text-muted">No se ha registrado una descripción para este ejercicio.</em>' ?>
                        </div>
                    </div>

                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
