<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-gear-wide-connected text-primary me-2"></i>Ejercicios y Equipamiento
        </h2>
        <p class="text-muted mb-0">
            Relación de máquinas y aparatos utilizados en cada ejercicio. Total: <strong><?= number_format($total ?? count($listado)) ?></strong> relaciones registradas.
        </p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('ejercicioequipo/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> + Asignar Equipo a Ejercicio
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('ejercicioequipo/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por ejercicio, nombre o código de equipo...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('ejercicioequipo/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th>Equipo / Máquina Empleada</th>
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
                                <td class="ps-4 fw-bold text-muted">#<?= $item['idejercicioequipo'] ?></td>
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
                                            <small class="text-muted d-block font-monospace">Ejercicio #<?= $item['idejercicio'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <?php if (!empty($item['equipo_imagen'])): ?>
                                            <img src="<?= base_url('repositorio/images/equipment/' . esc($item['equipo_imagen'])) ?>" 
                                                 onerror="this.onerror=null; this.src='<?= base_url('equipos/imagen/' . esc($item['equipo_imagen'])) ?>';"
                                                 alt="<?= esc($item['equipo_nombre']) ?>" 
                                                 class="rounded border bg-light p-1" 
                                                 style="width: 44px; height: 44px; object-fit: contain;">
                                        <?php endif; ?>
                                        <div>
                                            <span class="badge bg-primary font-monospace"><?= esc($item['equipo_codigo'] ?? '') ?></span>
                                            <a href="<?= base_url('equipos/actual/' . $item['idequipo']) ?>" class="fw-bold text-dark text-decoration-none ms-1">
                                                <?= esc($item['equipo_nombre']) ?>
                                            </a>
                                            <?php if (!empty($item['equipo_modelo'])): ?>
                                                <small class="text-muted d-block"><?= esc($item['equipo_modelo']) ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('ejercicioequipo/actual/' . $item['idejercicioequipo']) ?>" class="btn btn-outline-primary" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('ejercicioequipo/edit/' . $item['idejercicioequipo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="<?= base_url('ejercicioequipo/delete/' . $item['idejercicioequipo']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Eliminar esta asignación?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($pager)): ?>
            <div class="card-footer bg-white d-flex justify-content-center py-3">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
