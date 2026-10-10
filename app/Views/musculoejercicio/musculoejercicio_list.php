<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-diagram-3-fill text-danger me-2"></i>Músculos y Ejercicios
        </h2>
        <p class="text-muted mb-0">
            Relación de músculos afectados en cada ejercicio. Total: <strong><?= number_format($total ?? count($listado)) ?></strong> relaciones registradas.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('musculoejercicio/add') ?>" class="btn btn-danger text-white">
            <i class="bi bi-plus-circle me-1"></i> + Asignar Músculo a Ejercicio
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('musculoejercicio/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de ejercicio o músculo...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('musculoejercicio/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Ejercicio</th>
                        <th>Músculo Afectado</th>
                        <th class="text-end pe-4" style="width: 140px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listado)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No se encontraron relaciones registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listado as $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $item['idmusculoejecicio'] ?></td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['ejercicio_imagen'])): ?>
                                            <img src="<?= base_url('ejercicio/imagen/' . esc($item['ejercicio_imagen'])) ?>" 
                                                 alt="<?= esc($item['ejercicio_nombre']) ?>" 
                                                 class="rounded border bg-light p-1" 
                                                 style="width: 44px; height: 44px; object-fit: contain;">
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?= base_url('ejercicio/actual/' . $item['idejercicio']) ?>" class="fw-bold text-dark text-decoration-none">
                                                <?= esc($item['ejercicio_nombre']) ?>
                                            </a>
                                            <small class="text-muted d-block font-monospace">#<?= $item['idejercicio'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['musculo_imagen'])): ?>
                                            <img src="<?= base_url('repositorio/images/muscles/' . esc($item['musculo_imagen'])) ?>" 
                                                 onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($item['musculo_imagen'])) ?>';"
                                                 alt="<?= esc($item['musculo_nombre']) ?>" 
                                                 class="rounded border bg-light p-1" 
                                                 style="width: 44px; height: 44px; object-fit: contain;">
                                        <?php endif; ?>
                                        <div>
                                            <a href="<?= base_url('musculo/actual/' . $item['idmusculo']) ?>" class="fw-bold text-danger text-decoration-none">
                                                <?= esc($item['musculo_nombre']) ?>
                                            </a>
                                            <small class="text-muted d-block font-monospace">#<?= $item['idmusculo'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('musculoejercicio/actual/' . $item['idmusculoejecicio']) ?>" class="btn btn-outline-primary" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('musculoejercicio/edit/' . $item['idmusculoejecicio']) ?>" class="btn btn-outline-warning" title="Editar">
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
    <?php if (isset($pager)): ?>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
