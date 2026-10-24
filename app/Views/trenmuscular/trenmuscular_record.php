<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($tren)): ?>
            <?= view('layout/empty_record', ['module' => 'trenmuscular']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'trenmuscular',
                'currentId' => $tren['idtrenmuscular']
            ]) ?>

            <!-- Ficha Principal del Registro -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-layers-half text-info me-2 fs-4"></i>Ficha de Tren Muscular: <?= esc($tren['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $tren['idtrenmuscular'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-5 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-person-arms-up fs-1"></i>
                                </div>
                                <h4 class="fw-bold text-dark mb-1"><?= esc($tren['nombre']) ?></h4>
                                <span class="badge bg-info-subtle text-info border border-info px-3 py-1">División Anatómica</span>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Tren Muscular</th>
                                            <td class="fw-bold text-secondary">#<?= $tren['idtrenmuscular'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-tag-fill text-info me-2"></i><?= esc($tren['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Músculos Asignados</th>
                                            <td>
                                                <span class="badge bg-danger fs-6"><?= count($musculos) ?> músculos</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ejercicios Asignados</th>
                                            <td>
                                                <span class="badge bg-primary fs-6"><?= count($ejercicios) ?> ejercicios</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Programas Modelo</th>
                                            <td>
                                                <span class="badge bg-success fs-6"><?= count($programas) ?> programas</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestañas de Elementos Asociados (Músculos, Ejercicios, Programas) -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <ul class="nav nav-tabs card-header-tabs" id="trenTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-semibold text-danger d-flex align-items-center gap-2" id="musculos-tab" data-bs-toggle="tab" data-bs-target="#musculos-pane" type="button" role="tab">
                                <i class="bi bi-person-arms-up"></i>
                                <span>Músculos (<?= count($musculos) ?>)</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-primary d-flex align-items-center gap-2" id="ejercicios-tab" data-bs-toggle="tab" data-bs-target="#ejercicios-pane" type="button" role="tab">
                                <i class="bi bi-card-list"></i>
                                <span>Ejercicios (<?= count($ejercicios) ?>)</span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-semibold text-success d-flex align-items-center gap-2" id="programas-tab" data-bs-toggle="tab" data-bs-target="#programas-pane" type="button" role="tab">
                                <i class="bi bi-clipboard2-pulse"></i>
                                <span>Programas (<?= count($programas) ?>)</span>
                            </button>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">
                    <div class="tab-content" id="trenTabsContent">
                        
                        <!-- TAB 1: Músculos -->
                        <div class="tab-pane fade show active" id="musculos-pane" role="tabpanel">
                            <?php if (empty($musculos)): ?>
                                <div class="alert alert-light border text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    No hay músculos asignados a este tren muscular actualmente.
                                </div>
                            <?php else: ?>
                                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
                                    <?php foreach ($musculos as $m): ?>
                                        <div class="col">
                                            <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="card h-100 text-decoration-none border shadow-sm hover-shadow transition">
                                                <div class="p-2 text-center bg-light">
                                                    <?php if (!empty($m['imagen'])): ?>
                                                        <img src="<?= base_url('repositorio/images/muscles/' . esc($m['imagen'])) ?>" 
                                                             onerror="this.onerror=null; this.src='<?= base_url('musculo/imagen/' . esc($m['imagen'])) ?>';"
                                                             alt="<?= esc($m['nombre']) ?>" 
                                                             class="img-fluid rounded" 
                                                             style="max-height: 80px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <i class="bi bi-person-arms-up text-secondary fs-1 py-3"></i>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="card-body p-2 text-center">
                                                    <span class="d-block fw-semibold text-dark small text-truncate"><?= esc($m['nombre']) ?></span>
                                                    <span class="badge bg-secondary-subtle text-secondary small">#<?= $m['idmusculo'] ?></span>
                                                </div>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TAB 2: Ejercicios -->
                        <div class="tab-pane fade" id="ejercicios-pane" role="tabpanel">
                            <?php if (empty($ejercicios)): ?>
                                <div class="alert alert-light border text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    No hay ejercicios asignados a este tren muscular actualmente.
                                </div>
                            <?php else: ?>
                                <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light sticky-top">
                                            <tr>
                                                <th style="width: 60px;">Foto</th>
                                                <th>Ejercicio (Español / Inglés)</th>
                                                <th class="text-end" style="width: 100px;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ejercicios as $e): ?>
                                                <tr>
                                                    <td>
                                                        <?php if (!empty($e['imagen'])): ?>
                                                            <img src="<?= base_url('repositorio/ejercicios/' . esc($e['imagen'])) ?>" 
                                                                 onerror="this.onerror=null; this.src='<?= base_url('ejercicio/imagen/' . esc($e['imagen'])) ?>';"
                                                                 alt="<?= esc($e['nombreespanol']) ?>" 
                                                                 class="rounded border" 
                                                                 style="width: 44px; height: 44px; object-fit: cover;">
                                                        <?php else: ?>
                                                            <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 44px; height: 44px;">
                                                                <i class="bi bi-image"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="fw-semibold text-dark"><?= esc($e['nombreespanol']) ?></div>
                                                        <div class="text-muted small"><?= esc($e['nombreingles']) ?></div>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="<?= base_url('ejercicio/actual/' . $e['idejercicio']) ?>" class="btn btn-sm btn-outline-primary" title="Ver Detalle">
                                                            <i class="bi bi-eye"></i> Ver
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TAB 3: Programas -->
                        <div class="tab-pane fade" id="programas-pane" role="tabpanel">
                            <?php if (empty($programas)): ?>
                                <div class="alert alert-light border text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    No hay programas modelo asignados a este tren muscular actualmente.
                                    <div class="mt-2">
                                        <a href="<?= base_url('programaentrenamiento/add?idtrenmuscular=' . $tren['idtrenmuscular']) ?>" class="btn btn-sm btn-success">
                                            <i class="bi bi-plus-circle me-1"></i> Crear Programa con este Tren
                                        </a>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nombre del Programa</th>
                                                <th>Motivo</th>
                                                <th>Rango de Edad</th>
                                                <th class="text-center">Rutinas</th>
                                                <th class="text-end">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($programas as $p): ?>
                                                <tr>
                                                    <td class="fw-bold text-muted">#<?= $p['idprogramaentrenamiento'] ?></td>
                                                    <td class="fw-semibold text-dark"><?= esc($p['nombre']) ?></td>
                                                    <td>
                                                        <span class="badge bg-warning text-dark"><?= esc($p['motivo_nombre']) ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info-subtle text-info border border-info"><?= esc($p['rango_nombre'] ?? 'Todos') ?></span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary rounded-pill"><?= $p['total_rutinas'] ?></span>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="<?= base_url('programaentrenamiento/actual/' . $p['idprogramaentrenamiento']) ?>" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i> Ver
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
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<style>
.hover-shadow:hover {
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    transform: translateY(-2px);
}
.transition {
    transition: all .2s ease-in-out;
}
</style>

<?= $this->endSection() ?>
