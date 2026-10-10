<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-fire text-danger me-2"></i>Catálogo de Ejercicios</h2>
        <p class="text-muted mb-0">
            Base de datos visual con <strong><?= number_format($total ?? count($ejercicios)) ?></strong> ejercicios registrados.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('ejercicio/add') ?>" class="btn btn-danger text-white">
            <i class="bi bi-plus-circle me-1"></i> + Registrar Nuevo Ejercicio
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('ejercicio/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar ejercicio por nombre, descripción o archivo de imagen...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('ejercicio/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom bg-white shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 70px;">ID</th>
                        <th style="width: 80px;">Imagen</th>
                        <th>Nombre del Ejercicio</th>
                        <th>Descripción</th>
                        <th>Video Tutorial</th>
                        <th class="text-end pe-4" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ejercicios)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">No se encontraron ejercicios registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ejercicios as $ej): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted"><?= $ej['idejercicio'] ?></td>
                                <td>
                                    <?php if (!empty($ej['imagen'])): ?>
                                        <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" title="Ver ficha">
                                            <img src="<?= base_url('ejercicio/imagen/' . esc($ej['imagen'])) ?>" 
                                                 alt="<?= esc($ej['nombre']) ?>" 
                                                 class="rounded border bg-light"
                                                 style="width: 55px; height: 55px; object-fit: contain; padding: 2px;">
                                        </a>
                                    <?php else: ?>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 55px; height: 55px;">
                                            <i class="bi bi-image small"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div>
                                        <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($ej['nombre']) ?>
                                        </a>
                                    </div>
                                    <div class="mt-1">
                                        <?php if (!empty($ej['imagen'])): ?>
                                            <?php if (str_contains($ej['imagen'], '-start.webp')): ?>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle py-0 px-2" style="font-size: 0.72rem;">Fase Inicial</span>
                                            <?php elseif (str_contains($ej['imagen'], '-peak.webp')): ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle py-0 px-2" style="font-size: 0.72rem;">Fase Final</span>
                                            <?php else: ?>
                                                <span class="badge bg-info-subtle text-info border border-info-subtle py-0 px-2" style="font-size: 0.72rem;">General</span>
                                            <?php endif; ?>
                                            <small class="text-muted ms-1 font-monospace" style="font-size: 0.75rem;"><?= esc($ej['imagen']) ?></small>
                                        <?php endif; ?>
                                    </div>
                                    <?php $mList = $musculosBatch[$ej['idejercicio']] ?? []; ?>
                                    <?php if (!empty($mList)): ?>
                                        <div class="d-flex align-items-center gap-1 flex-wrap mt-2">
                                            <span class="small text-muted me-1" style="font-size: 0.72rem;"><i class="bi bi-person-arms-up text-danger"></i> Músculos:</span>
                                            <?php foreach ($mList as $musc): ?>
                                                <a href="<?= base_url('musculo/actual/' . $musc['idmusculo']) ?>" 
                                                   title="<?= esc($musc['nombre']) ?>" 
                                                   class="badge bg-light text-dark border d-inline-flex align-items-center gap-1 py-1 px-2 text-decoration-none"
                                                   style="font-size: 0.72rem;">
                                                    <img src="<?= base_url('repositorio/images/muscles/' . esc($musc['imagen'])) ?>" 
                                                         onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($musc['imagen'])) ?>';"
                                                         alt="<?= esc($musc['nombre']) ?>" 
                                                         style="width: 16px; height: 16px; object-fit: contain;">
                                                    <span><?= esc($musc['nombre']) ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <small class="text-secondary text-truncate d-inline-block" style="max-width: 320px;">
                                        <?= esc($ej['descripcion'] ?? '-') ?>
                                    </small>
                                </td>
                                <td>
                                    <?php if (!empty($ej['urlvideo'])): ?>
                                        <a href="<?= esc($ej['urlvideo']) ?>" target="_blank" class="btn btn-outline-danger btn-sm py-0 px-2" title="Abrir video">
                                            <i class="bi bi-play-circle-fill me-1"></i> Video
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('ejercicio/actual/' . $ej['idejercicio']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejercicio/edit/' . $ej['idejercicio']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('ejercicio/delete/' . $ej['idejercicio']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar este ejercicio?');">
                                            <i class="bi bi-trash"></i>
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

    <?php if (!empty($pager)): ?>
        <div class="card-footer bg-white d-flex flex-column flex-md-row justify-content-between align-items-center py-3 gap-2 border-top">
            <small class="text-muted">
                Mostrando <?= count($ejercicios) ?> de <?= number_format($total ?? 1056) ?> ejercicios
            </small>
            <div>
                <?= $pager->links('default', 'bootstrap_pagination') ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
