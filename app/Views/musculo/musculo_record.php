<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($musculo)): ?>
            <?= view('layout/empty_record', ['module' => 'musculo']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'musculo',
                'currentId' => $musculo['idmusculo']
            ]) ?>

            <!-- Ficha Principal del Músculo -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-person-arms-up text-danger me-2 fs-4"></i>Ficha de Músculo: <?= esc($musculo['nombre']) ?>
                    </h5>
                    <span class="badge bg-danger text-white fs-6">ID #<?= $musculo['idmusculo'] ?></span>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Panel de Presentación de la Imagen del Músculo -->
                        <div class="col-md-5 text-center">
                            <div class="p-3 bg-light rounded-4 border shadow-sm position-relative">
                                <?php if (!empty($musculo['imagen'])): ?>
                                    <img src="<?= base_url('repositorio/images/muscles/' . esc($musculo['imagen'])) ?>" 
                                         onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($musculo['imagen'])) ?>';"
                                         alt="<?= esc($musculo['nombre']) ?>" 
                                         class="img-fluid rounded-3" 
                                         style="max-height: 280px; object-fit: contain; filter: drop-shadow(0 6px 12px rgba(0,0,0,0.12));">
                                    <div class="mt-2 text-muted small fst-italic">
                                        <i class="bi bi-file-earmark-image me-1"></i><?= esc($musculo['imagen']) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-muted">
                                        <i class="bi bi-image fs-1 d-block mb-2"></i>
                                        <span>Sin imagen registrada</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Detalles e Información del Músculo -->
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-40 text-muted">ID Músculo</th>
                                            <td class="fw-bold text-secondary">#<?= $musculo['idmusculo'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Músculo</th>
                                            <td>
                                                <span class="fs-5 fw-bold text-dark">
                                                    <?= esc($musculo['nombre']) ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Tren Muscular</th>
                                            <td>
                                                <?php if (!empty($musculo['idtrenmuscular'])): ?>
                                                    <a href="<?= base_url('trenmuscular/actual/' . $musculo['idtrenmuscular']) ?>" class="badge bg-info-subtle text-info border border-info text-decoration-none px-3 py-2 fs-6">
                                                        <i class="bi bi-layers-half me-1"></i><?= esc($musculo['tren_nombre'] ?? 'ID #' . $musculo['idtrenmuscular']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="badge bg-light text-muted border px-2 py-1">Sin asignar</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Archivo de Imagen</th>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                                    <i class="bi bi-image me-1"></i><?= esc($musculo['imagen'] ?? 'Sin asignar') ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Origen del Repositorio</th>
                                            <td>
                                                <span class="small text-muted font-monospace">repositorio/images/muscles/</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Estadísticas de Activación</th>
                                            <td>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                        <i class="bi bi-gear-wide-connected me-1"></i><?= count($equipos ?? []) ?> <?= count($equipos ?? []) === 1 ? 'máquina / equipo' : 'máquinas / equipos' ?>
                                                    </span>
                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1">
                                                        <i class="bi bi-activity me-1"></i><?= count($ejercicios ?? []) ?> <?= count($ejercicios ?? []) === 1 ? 'ejercicio' : 'ejercicios' ?>
                                                    </span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex gap-2 mt-4 flex-wrap">
                                <a href="<?= base_url('musculo/galeria') ?>" class="btn btn-outline-danger btn-sm">
                                    <i class="bi bi-grid-3x3-gap-fill me-1"></i>Ver en Galería Visual
                                </a>
                                <a href="<?= base_url('musculo/listar') ?>" class="btn btn-outline-secondary btn-sm">
                                    <i class="bi bi-list-task me-1"></i>Ver Catálogo Completo
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Card: Máquinas y Equipos que Ejercitan este Músculo -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-gear-wide-connected text-primary me-2 fs-4"></i>Máquinas y Equipos que ejercitan este músculo
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-primary-subtle text-primary border border-primary px-3 py-2 fs-6">
                            <i class="bi bi-check2-circle me-1"></i><?= count($equipos ?? []) ?> <?= count($equipos ?? []) === 1 ? 'máquina' : 'máquinas / equipos' ?>
                        </span>
                        <button type="button" class="btn btn-primary btn-sm fw-bold px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#modalAsignarEquipo">
                            <i class="bi bi-plus-circle me-1"></i>+ Vincular Equipo
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php if (empty($equipos)): ?>
                        <div class="p-4 bg-light rounded-3 border text-center text-muted">
                            <i class="bi bi-gear-wide fs-1 d-block mb-2 text-primary opacity-50"></i>
                            <p class="mb-2">No se han registrado máquinas o equipos vinculados directamente a <strong><?= esc($musculo['nombre']) ?></strong>.</p>
                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarEquipo">
                                <i class="bi bi-plus-lg me-1"></i>Vincular primera máquina / equipo
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($equipos as $eq): ?>
                                <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                                    <div class="card h-100 bg-light border shadow-xs rounded-3 p-2 position-relative hover-shadow transition-all">
                                        <div class="position-relative" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                            <?php if (!empty($eq['equipo_imagen'] ?? $eq['imagen'])): ?>
                                                <?php $imgFile = $eq['equipo_imagen'] ?? $eq['imagen']; ?>
                                                <img src="<?= base_url('repositorio/images/equipment/' . esc($imgFile)) ?>" 
                                                     onerror="this.onerror=null; this.src='<?= base_url('equipo/imagen/' . esc($imgFile)) ?>';"
                                                     alt="<?= esc($eq['equipo_nombre'] ?? $eq['nombre']) ?>" 
                                                     class="img-fluid" 
                                                     style="max-height: 90px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                            <?php else: ?>
                                                <i class="bi bi-gear-wide-connected fs-1 text-primary"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <span class="badge bg-secondary-subtle text-secondary border font-monospace small px-2 py-0">
                                                <?= esc($eq['equipo_codigo'] ?? $eq['codigo']) ?>
                                            </span>
                                            <a href="<?= base_url('equipo/actual/' . $eq['idequipo']) ?>" 
                                               class="fw-bold text-dark text-decoration-none small d-block text-truncate mt-1" 
                                               title="<?= esc($eq['equipo_nombre'] ?? $eq['nombre']) ?>">
                                                <?= esc($eq['equipo_nombre'] ?? $eq['nombre']) ?>
                                            </a>
                                            <?php if (!empty($eq['disponibilidad_nombre'])): ?>
                                                <?php 
                                                    $dispId = (int)($eq['iddisponibilidadequipo'] ?? 1);
                                                    $badgeDisp = match($dispId) {
                                                        1 => 'bg-success text-white',
                                                        2 => 'bg-primary text-white',
                                                        3 => 'bg-warning text-dark',
                                                        4 => 'bg-danger text-white',
                                                        5 => 'bg-secondary text-white',
                                                        6 => 'bg-info text-dark',
                                                        default => 'bg-light text-dark border'
                                                    };
                                                ?>
                                                <div class="mt-1">
                                                    <span class="badge <?= $badgeDisp ?> small" style="font-size: 0.68rem;">
                                                        <?= esc($eq['disponibilidad_nombre']) ?>
                                                    </span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
                                            <a href="<?= base_url('equipo/actual/' . $eq['idequipo']) ?>" class="btn btn-link btn-sm p-0 text-primary small text-decoration-none" title="Ver ficha del equipo">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="<?= base_url('musculo/quitarEquipo/' . $musculo['idmusculo'] . '/' . $eq['idequipo']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular <?= esc($eq['equipo_nombre'] ?? $eq['nombre']) ?> de este músculo?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-link btn-sm p-0 text-danger" title="Desvincular máquina">
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

            <!-- Card: Ejercicios que se Realizan para Ejercitar este Músculo -->
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mt-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-activity text-danger me-2 fs-4"></i>Ejercicios que ejercitan este músculo
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-2 fs-6">
                            <i class="bi bi-check2-circle me-1"></i><?= count($ejercicios ?? []) ?> <?= count($ejercicios ?? []) === 1 ? 'ejercicio' : 'ejercicios' ?>
                        </span>
                        <button type="button" class="btn btn-danger btn-sm fw-bold px-3 shadow-xs" data-bs-toggle="modal" data-bs-target="#modalAsignarEjercicio">
                            <i class="bi bi-plus-circle me-1"></i>+ Vincular Ejercicio
                        </button>
                    </div>
                </div>
                <div class="card-body p-4">
                    <?php if (empty($ejercicios)): ?>
                        <div class="p-4 bg-light rounded-3 border text-center text-muted">
                            <i class="bi bi-activity fs-1 d-block mb-2 text-danger opacity-50"></i>
                            <p class="mb-2">No se han registrado ejercicios que activen a <strong><?= esc($musculo['nombre']) ?></strong>.</p>
                            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalAsignarEjercicio">
                                <i class="bi bi-plus-lg me-1"></i>Vincular primer ejercicio
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($ejercicios as $ej): ?>
                                <div class="col-6 col-sm-4 col-md-3 col-xl-2 text-center">
                                    <div class="card h-100 bg-light border shadow-xs rounded-3 p-2 position-relative hover-shadow transition-all">
                                        <div class="position-relative" style="height: 100px; display: flex; align-items: center; justify-content: center;">
                                            <?php if (!empty($ej['ejercicio_imagen'] ?? $ej['imagen'])): ?>
                                                <?php $imgEj = $ej['ejercicio_imagen'] ?? $ej['imagen']; ?>
                                                <img src="<?= base_url('repositorio/ejercicios/' . esc($imgEj)) ?>" 
                                                     onerror="this.onerror=null; this.src='<?= base_url('ejercicio/imagen/' . esc($imgEj)) ?>';"
                                                     alt="<?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?>" 
                                                     class="img-fluid" 
                                                     style="max-height: 90px; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));">
                                            <?php else: ?>
                                                <i class="bi bi-activity fs-1 text-danger"></i>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2">
                                            <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" 
                                               class="fw-bold text-dark text-decoration-none small d-block text-truncate mt-1" 
                                               title="<?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?>">
                                                <?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?>
                                            </a>
                                            <?php if (!empty($ej['nombreingles'] ?? $ej['ejercicio_nombreingles'])): ?>
                                                <div class="text-muted small text-truncate fst-italic" style="font-size: 0.72rem;">
                                                    <?= esc($ej['nombreingles'] ?? $ej['ejercicio_nombreingles']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-2 pt-1 border-top d-flex justify-content-between align-items-center">
                                            <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="btn btn-link btn-sm p-0 text-danger small text-decoration-none" title="Ver ficha del ejercicio">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <form action="<?= base_url('musculo/quitarEjercicio/' . $musculo['idmusculo'] . '/' . $ej['idejercicio']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular <?= esc($ej['nombreespanol'] ?? $ej['ejercicio_nombre']) ?> de este músculo?');">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-link btn-sm p-0 text-danger" title="Desvincular ejercicio">
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

            <!-- Modal para Vincular Equipo / Máquina al Músculo -->
            <div class="modal fade" id="modalAsignarEquipo" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title"><i class="bi bi-gear-wide-connected me-2"></i>Vincular Máquina / Equipo al Músculo</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('musculo/asignarEquipo/' . $musculo['idmusculo']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <p class="small text-muted mb-3">
                                    Seleccione la máquina o equipo del gimnasio en el cual se ejercita o estimula directamente el músculo <strong><?= esc($musculo['nombre']) ?></strong>:
                                </p>
                                <div class="mb-3">
                                    <label for="selectEquipoModal" class="form-label fw-semibold">Equipo / Máquina <span class="text-danger">*</span></label>
                                    <select name="idequipo" id="selectEquipoModal" class="form-select" required>
                                        <option value="">-- Seleccionar Equipo o Máquina --</option>
                                        <?php 
                                            $equiposAsignadosIds = array_column($equipos ?? [], 'idequipo');
                                            foreach ($todosLosEquipos as $te): 
                                                $yaVinculado = in_array($te['idequipo'], $equiposAsignadosIds);
                                        ?>
                                            <option value="<?= $te['idequipo'] ?>" <?= $yaVinculado ? 'disabled class="text-muted"' : '' ?>>
                                                [<?= esc($te['codigo']) ?>] <?= esc($te['nombre']) ?> <?= $yaVinculado ? '✓ (Ya vinculado)' : '' ?>
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

            <!-- Modal para Vincular Ejercicio al Músculo -->
            <div class="modal fade" id="modalAsignarEjercicio" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title"><i class="bi bi-activity me-2"></i>Vincular Ejercicio al Músculo</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="<?= base_url('musculo/asignarEjercicio/' . $musculo['idmusculo']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <p class="small text-muted mb-3">
                                    Seleccione el ejercicio en el cual se trabaja o activa activamente el músculo <strong><?= esc($musculo['nombre']) ?></strong>:
                                </p>
                                <div class="mb-3">
                                    <label for="selectEjercicioModal" class="form-label fw-semibold">Ejercicio <span class="text-danger">*</span></label>
                                    <select name="idejercicio" id="selectEjercicioModal" class="form-select" required>
                                        <option value="">-- Seleccionar Ejercicio --</option>
                                        <?php 
                                            $ejerciciosAsignadosIds = array_column($ejercicios ?? [], 'idejercicio');
                                            foreach ($todosLosEjercicios as $tej): 
                                                $yaVinculado = in_array($tej['idejercicio'], $ejerciciosAsignadosIds);
                                        ?>
                                            <option value="<?= $tej['idejercicio'] ?>" <?= $yaVinculado ? 'disabled class="text-muted"' : '' ?>>
                                                <?= esc($tej['nombreespanol']) ?> (<?= esc($tej['nombreingles']) ?>) <?= $yaVinculado ? '✓ (Ya vinculado)' : '' ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Vincular Ejercicio</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
