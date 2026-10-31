<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-book-half text-warning me-2 fs-3"></i>Catálogo de Recetas
                    </h4>
                    <p class="text-muted small mb-0">Preparaciones e instrucciones culinarias saludables para deportistas y planes de nutrición.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('receta/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre o pasos..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('receta/listar') ?>" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('imagenreceta') ?>" class="btn btn-outline-warning text-dark btn-sm">
                        <i class="bi bi-images me-1"></i> Imágenes de Recetas
                    </a>
                    <a href="<?= base_url('receta/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Receta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Registros -->
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th>Receta</th>
                            <th>Porciones</th>
                            <th>Tiempo Prep.</th>
                            <th>Categoría</th>
                            <th>Instrucciones</th>
                            <th class="text-end pe-4" style="width: 170px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($recetas)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No se encontraron recetas registradas.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($recetas as $r): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $r['idreceta'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <?php if (!empty($r['primera_imagen']) && $r['primera_imagen']['archivoExiste']): ?>
                                                <div class="rounded border overflow-hidden bg-light flex-shrink-0" style="width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                                                    <img src="<?= $r['primera_imagen']['urlImagen'] ?>" 
                                                         onerror="this.onerror=null; this.src='<?= !empty($r['primera_imagen']['urlFallback']) ? $r['primera_imagen']['urlFallback'] : base_url('imagen/imagen/' . esc($r['primera_imagen']['imagen_nombre'])) ?>';"
                                                         alt="<?= esc($r['nombre']) ?>" 
                                                         style="max-height: 42px; max-width: 42px; object-fit: contain;">
                                                </div>
                                            <?php else: ?>
                                                <div class="rounded border bg-light text-warning flex-shrink-0 d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                                                    <i class="bi bi-book-half fs-5"></i>
                                                </div>
                                            <?php endif; ?>
                                            <div>
                                                <a href="<?= base_url('receta/actual/' . $r['idreceta']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($r['nombre']) ?>
                                                </a>
                                                <?php if (!empty($r['total_imagenes']) && $r['total_imagenes'] > 0): ?>
                                                    <div>
                                                        <a href="<?= base_url('imagenreceta/listar?idreceta=' . $r['idreceta']) ?>" class="badge bg-warning-subtle text-dark border border-warning text-decoration-none" style="font-size: 0.65rem;">
                                                            <i class="bi bi-images me-1 text-warning"></i><?= $r['total_imagenes'] ?> <?= $r['total_imagenes'] == 1 ? 'imagen' : 'imágenes' ?>
                                                        </a>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <i class="bi bi-people me-1 text-primary"></i><?= esc($r['porciones'] ?? 1) ?>
                                        </span>
                                    </td>
                                    <td class="fw-semibold text-secondary small">
                                        <i class="bi bi-stopwatch text-danger me-1"></i><?= esc($r['tiempo_texto']) ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $r['categoria_tiempo']['badge_class'] ?>">
                                            <i class="bi <?= $r['categoria_tiempo']['icono'] ?> me-1"></i><?= $r['categoria_tiempo']['etiqueta'] ?>
                                        </span>
                                    </td>
                                    <td class="text-secondary small text-truncate" style="max-width: 320px;" title="<?= esc($r['instrucciones'] ?? '') ?>">
                                        <?= !empty($r['instrucciones']) ? esc(mb_substr($r['instrucciones'], 0, 90)) . '...' : '<span class="text-muted fst-italic">Sin instrucciones</span>' ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('receta/actual/' . $r['idreceta']) ?>" class="btn btn-outline-primary" title="Ver Ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('receta/edit/' . $r['idreceta']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteReceta"
                                                    data-id="<?= $r['idreceta'] ?>"
                                                    data-nombre="<?= esc($r['nombre']) ?>">
                                                <i class="bi bi-trash"></i>
                                            </button>
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

</div>

<!-- Modal para eliminar receta -->
<div class="modal fade" id="modalDeleteReceta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteReceta" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="mb-2">¿Está seguro de que desea eliminar la receta culinaria:</p>
                    <h5 class="fw-bold text-danger text-center my-3" id="deleteTargetReceta"></h5>
                    <p class="small text-danger text-center mt-3 mb-0">Esta acción no se puede deshacer.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-1"></i>Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalDelete = document.getElementById('modalDeleteReceta');
    if (modalDelete) {
        modalDelete.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const nombre = button.getAttribute('data-nombre');
            document.getElementById('deleteTargetReceta').textContent = nombre;
            document.getElementById('formDeleteReceta').action = '<?= base_url('receta/delete/') ?>' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
