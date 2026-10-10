<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row align-items-center mb-4">
    <div class="col-md-6">
        <h2 class="fw-bold mb-1 text-dark">
            <i class="bi bi-person-arms-up text-danger me-2"></i>Catálogo de Músculos
        </h2>
        <p class="text-muted mb-0">Imágenes anatómicas cargadas desde el repositorio oficial (<code>repositorio/images/muscles</code>).</p>
    </div>
    <div class="col-md-6 text-md-end mt-3 mt-md-0 d-flex justify-content-md-end gap-2">
        <a href="<?= base_url('musculo/galeria') ?>" class="btn btn-outline-danger fw-semibold">
            <i class="bi bi-grid-3x3-gap-fill me-1"></i> Galería Visual
        </a>
        <a href="<?= base_url('musculo/add') ?>" class="btn btn-danger text-white fw-semibold">
            <i class="bi bi-plus-circle me-1"></i> + Nuevo Músculo
        </a>
    </div>
</div>

<!-- Filtro de Búsqueda y Selector de Vista -->
<div class="card card-custom bg-white mb-4 shadow-sm">
    <div class="card-body p-3">
        <form method="get" action="<?= base_url('musculo/listar') ?>" class="row g-2 align-items-center">
            <input type="hidden" name="vista" value="<?= esc($vista ?? 'grid') ?>">
            <div class="col-md-8">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="q" value="<?= esc($search ?? '') ?>" class="form-control border-start-0" placeholder="Buscar por nombre de músculo o ID...">
                </div>
            </div>
            <div class="col-md-2 d-grid d-md-flex gap-2">
                <button type="submit" class="btn btn-danger text-white fw-semibold flex-fill">Buscar</button>
                <?php if (!empty($search)): ?>
                    <a href="<?= base_url('musculo/listar?vista=' . esc($vista ?? 'grid')) ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                <?php endif; ?>
            </div>
            <div class="col-md-2 text-md-end">
                <div class="btn-group w-100" role="group">
                    <a href="<?= base_url('musculo/listar?vista=grid' . (!empty($search) ? '&q=' . urlencode($search) : '')) ?>" 
                       class="btn btn-sm <?= ($vista ?? 'grid') === 'grid' ? 'btn-danger' : 'btn-outline-secondary' ?>" 
                       title="Vista en Tarjetas">
                        <i class="bi bi-grid-fill me-1"></i>Tarjetas
                    </a>
                    <a href="<?= base_url('musculo/listar?vista=tabla' . (!empty($search) ? '&q=' . urlencode($search) : '')) ?>" 
                       class="btn btn-sm <?= ($vista ?? 'grid') === 'tabla' ? 'btn-danger' : 'btn-outline-secondary' ?>" 
                       title="Vista en Tabla">
                        <i class="bi bi-table me-1"></i>Tabla
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (empty($musculos)): ?>
    <div class="card card-custom bg-white py-5 text-center shadow-sm">
        <div class="card-body">
            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
            <h5 class="fw-bold mt-3 text-dark">No se encontraron músculos</h5>
            <p class="text-muted">No existen registros que coincidan con la búsqueda.</p>
            <a href="<?= base_url('musculo/add') ?>" class="btn btn-danger btn-sm">Registrar Nuevo Músculo</a>
        </div>
    </div>
<?php elseif (($vista ?? 'grid') === 'grid'): ?>

    <!-- VISTA EN TARJETAS CON IMÁGENES DESTACADAS -->
    <div class="row g-4">
        <?php foreach ($musculos as $m): ?>
            <div class="col-sm-6 col-md-4 col-xl-3">
                <div class="card h-100 bg-white border-0 shadow-sm rounded-4 overflow-hidden position-relative hover-shadow transition-all">
                    <!-- Contenedor de la Imagen del Músculo -->
                    <div class="p-3 text-center bg-light border-bottom position-relative" style="min-height: 190px; display: flex; align-items: center; justify-content: center;">
                        <span class="position-absolute top-0 start-0 m-2 badge bg-dark bg-opacity-75 rounded-pill">
                            #<?= $m['idmusculo'] ?>
                        </span>
                        <?php if (!empty($m['imagen'])): ?>
                            <img src="<?= base_url('repositorio/images/muscles/' . esc($m['imagen'])) ?>" 
                                 onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($m['imagen'])) ?>';"
                                 alt="<?= esc($m['nombre']) ?>" 
                                 class="img-fluid" 
                                 style="max-height: 160px; object-fit: contain; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.1)); transition: transform 0.2s;"
                                 loading="lazy">
                        <?php else: ?>
                            <div class="text-muted py-4">
                                <i class="bi bi-image fs-1 d-block mb-1"></i>
                                <small>Sin imagen</small>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-body p-3 text-center d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold text-dark mb-1"><?= esc($m['nombre']) ?></h6>
                            <span class="text-muted small fst-italic d-block text-truncate" title="<?= esc($m['imagen'] ?? '') ?>">
                                <i class="bi bi-file-earmark-image me-1"></i><?= esc($m['imagen'] ?? 'Sin archivo') ?>
                            </span>
                        </div>

                        <div class="btn-group btn-group-sm w-100 mt-3" role="group">
                            <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="btn btn-outline-primary" title="Ver Detalle">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                            <a href="<?= base_url('musculo/edit/' . $m['idmusculo']) ?>" class="btn btn-outline-warning" title="Editar">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delModalGrid<?= $m['idmusculo'] ?>">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal Borrar para Tarjeta -->
                <div class="modal fade text-start" id="delModalGrid<?= $m['idmusculo'] ?>" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header bg-danger text-white">
                                <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Músculo</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de que desea eliminar el músculo <strong><?= esc($m['nombre']) ?></strong> (#<?= $m['idmusculo'] ?>)?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="<?= base_url('musculo/delete/' . $m['idmusculo']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

<?php else: ?>

    <!-- VISTA EN TABLA TRADICIONAL -->
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Imagen</th>
                            <th>Nombre del Músculo</th>
                            <th>Archivo de Imagen</th>
                            <th class="text-end pe-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($musculos as $m): ?>
                            <tr>
                                <td class="ps-4 fw-bold text-muted">#<?= $m['idmusculo'] ?></td>
                                <td>
                                    <?php if (!empty($m['imagen'])): ?>
                                        <img src="<?= base_url('repositorio/images/muscles/' . esc($m['imagen'])) ?>" 
                                             onerror="this.onerror=null; this.src='<?= base_url('uploads/muscles/' . esc($m['imagen'])) ?>';"
                                             alt="<?= esc($m['nombre']) ?>" 
                                             class="rounded border bg-light p-1" 
                                             style="width: 48px; height: 48px; object-fit: contain;">
                                    <?php else: ?>
                                        <div class="bg-light rounded border d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="fw-bold text-dark text-decoration-none fs-6">
                                        <?= esc($m['nombre']) ?>
                                    </a>
                                </td>
                                <td>
                                    <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                        <i class="bi bi-file-earmark-image me-1"></i><?= esc($m['imagen'] ?? 'Sin asignar') ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group btn-group-sm">
                                        <a href="<?= base_url('musculo/actual/' . $m['idmusculo']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= base_url('musculo/edit/' . $m['idmusculo']) ?>" class="btn btn-outline-warning" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#delModalTbl<?= $m['idmusculo'] ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <!-- Modal de confirmación para eliminar fila -->
                                    <div class="modal fade text-start" id="delModalTbl<?= $m['idmusculo'] ?>" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Eliminar Músculo</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro de que desea eliminar el músculo <strong><?= esc($m['nombre']) ?></strong> (#<?= $m['idmusculo'] ?>)?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <form action="<?= base_url('musculo/delete/' . $m['idmusculo']) ?>" method="post">
                                                        <?= csrf_field() ?>
                                                        <button type="submit" class="btn btn-danger">Sí, eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif; ?>

<style>
.hover-shadow:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}
.transition-all {
    transition: all 0.25s ease-in-out;
}
</style>

<?= $this->endSection() ?>
