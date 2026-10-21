<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-gear-wide-connected text-success me-2"></i>Relación Equipo - Músculo</h2>
        <p class="text-muted mb-0">Gestión de músculos que se ejercitan con cada máquina o equipo (tabla <code>equipomusculo</code>).</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('equipomusculo/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Asignar Músculo a Equipo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('equipomusculo/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por código, nombre de equipo o nombre de músculo...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('equipomusculo/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>

<div class="card card-custom bg-white">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width: 70px;">ID</th>
                        <th style="width: 80px;">Foto Eq.</th>
                        <th>Código</th>
                        <th>Equipo / Máquina</th>
                        <th style="width: 80px;">Anatomía</th>
                        <th>Músculo Ejercitado</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($listado)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">No se encontraron relaciones registradas.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($listado as $item): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $item['idequipomusculo'] ?></td>
                                <td>
                                    <?php if (!empty($item['equipo_imagen'])): ?>
                                        <img src="<?= base_url('repositorio/images/equipment/' . esc($item['equipo_imagen'])) ?>" 
                                             onerror="this.onerror=null; this.src='<?= base_url('equipo/imagen/' . esc($item['equipo_imagen'])) ?>';"
                                             alt="<?= esc($item['equipo_nombre']) ?>" 
                                             class="rounded border bg-light shadow-xs" 
                                             style="width: 44px; height: 44px; object-fit: contain; padding: 2px;">
                                    <?php else: ?>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 44px; height: 44px;">
                                            <i class="bi bi-gear"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-primary font-monospace"><?= esc($item['equipo_codigo']) ?></span>
                                </td>
                                <td>
                                    <a href="<?= base_url('equipo/actual/' . $item['idequipo']) ?>" class="fw-bold text-dark text-decoration-none">
                                        <?= esc($item['equipo_nombre']) ?>
                                    </a>
                                    <?php if (!empty($item['equipo_modelo'])): ?>
                                        <small class="text-muted d-block"><?= esc($item['equipo_modelo']) ?></small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($item['musculo_imagen'])): ?>
                                        <img src="<?= base_url('uploads/muscles/' . esc($item['musculo_imagen'])) ?>" 
                                             onerror="this.onerror=null; this.src='<?= base_url('musculo/imagen/' . esc($item['musculo_imagen'])) ?>';"
                                             alt="<?= esc($item['musculo_nombre']) ?>" 
                                             class="rounded border bg-light shadow-xs" 
                                             style="width: 44px; height: 44px; object-fit: contain; padding: 2px;">
                                    <?php else: ?>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 44px; height: 44px;">
                                            <i class="bi bi-diagram-3 text-danger"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('musculo/actual/' . $item['idmusculo']) ?>" class="fw-semibold text-danger text-decoration-none">
                                        <i class="bi bi-dot"></i><?= esc($item['musculo_nombre']) ?>
                                    </a>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('equipomusculo/actual/' . $item['idequipomusculo']) ?>" class="btn btn-outline-primary" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('equipomusculo/edit/' . $item['idequipomusculo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('equipomusculo/delete/' . $item['idequipomusculo']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar esta asignación?');">
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
        <div class="card-footer bg-white d-flex justify-content-between align-items-center py-3">
            <span class="text-muted small">Total: <strong><?= $total ?></strong> asignaciones registradas</span>
            <?= $pager->links() ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
