<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark"><i class="bi bi-clock-history text-info me-2"></i>Disponibilidad de Equipos</h2>
        <p class="text-muted mb-0">Catálogo de estados de disponibilidad y operatividad para máquinas del gimnasio.</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0">
        <a href="<?= base_url('disponibilidadequipo/add') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Estado de Disponibilidad
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda -->
<div class="card card-custom bg-white mb-4">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('disponibilidadequipo/listar') ?>" class="row g-2 align-items-center">
            <div class="col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de estado de disponibilidad...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-secondary flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('disponibilidadequipo/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
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
                        <th class="ps-4" style="width: 80px;">ID</th>
                        <th>Estado de Disponibilidad</th>
                        <th class="text-center" style="width: 150px;">Equipos Asociados</th>
                        <th class="text-end pe-4">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($disponibilidades)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">No se encontraron estados de disponibilidad registrados.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($disponibilidades as $d): ?>
                            <?php $totalEq = $equipmentCounts[$d['iddisponibilidadequipo']] ?? 0; ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $d['iddisponibilidadequipo'] ?></td>
                                <td>
                                    <a href="<?= base_url('disponibilidadequipo/actual/' . $d['iddisponibilidadequipo']) ?>" class="fw-bold text-dark text-decoration-none">
                                        <i class="bi bi-dot text-info fs-4 align-middle"></i><?= esc($d['nombre']) ?>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $totalEq > 0 ? 'bg-primary' : 'bg-secondary-subtle text-secondary border' ?> px-3 py-1">
                                        <?= $totalEq ?> <?= $totalEq === 1 ? 'equipo' : 'equipos' ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('disponibilidadequipo/actual/' . $d['iddisponibilidadequipo']) ?>" class="btn btn-outline-primary" title="Ver Detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('disponibilidadequipo/edit/' . $d['iddisponibilidadequipo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <a href="<?= base_url('disponibilidadequipo/delete/' . $d['iddisponibilidadequipo']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Confirma que desea eliminar este estado de disponibilidad?');">
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
</div>

<?= $this->endSection() ?>
