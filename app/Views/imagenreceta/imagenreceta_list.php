<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado Principal -->
    <div class="card card-custom bg-white border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-images text-warning me-2"></i>Gestión de Imágenes de Recetas
                    </h4>
                    <p class="text-muted small mb-0">Catálogo de relaciones multimedia entre imágenes del repositorio y recetas saludables.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="<?= base_url('imagenreceta/add' . (!empty($idreceta) ? '?idreceta=' . $idreceta : '')) ?>" class="btn btn-success fw-bold shadow-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Vinculación
                    </a>
                    <a href="<?= base_url('receta/listar') ?>" class="btn btn-outline-warning text-dark fw-bold shadow-sm ms-2">
                        <i class="bi bi-book-half me-1"></i> Ver Recetas
                    </a>
                </div>
            </div>

            <!-- Barra de Filtros y Búsqueda -->
            <form method="get" action="<?= base_url('imagenreceta/listar') ?>" class="row g-2 mt-3 pt-3 border-top align-items-center">
                
                <!-- Búsqueda textual -->
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="q" class="form-control" placeholder="Buscar por nombre de archivo o receta..." value="<?= esc($search ?? '') ?>">
                    </div>
                </div>

                <!-- Filtro por Receta -->
                <div class="col-md-4">
                    <select name="idreceta" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Filtrar por Receta (Todas) --</option>
                        <?php foreach ($recetas as $r): ?>
                            <option value="<?= $r['idreceta'] ?>" <?= ((string)$idreceta === (string)$r['idreceta']) ? 'selected' : '' ?>>
                                <?= esc($r['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Botones de Acción -->
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-funnel me-1"></i> Filtrar
                    </button>
                    <?php if (!empty($search) || !empty($idreceta) || !empty($idimagen)): ?>
                        <a href="<?= base_url('imagenreceta/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    <?php endif; ?>
                </div>

            </form>

            <?php if (!empty($selectedReceta)): ?>
                <div class="alert alert-warning d-flex align-items-center justify-content-between mt-3 mb-0 py-2">
                    <span class="small">
                        <i class="bi bi-info-circle-fill me-1"></i>Mostrando imágenes asociadas a la receta: <strong><?= esc($selectedReceta['nombre']) ?></strong>
                    </span>
                    <a href="<?= base_url('receta/actual/' . $selectedReceta['idreceta']) ?>" class="btn btn-xs btn-outline-dark">
                        <i class="bi bi-box-arrow-up-right me-1"></i>Ver Ficha de Receta
                    </a>
                </div>
            <?php endif; ?>

        </div>
    </div>

    <!-- Mensajes Flash de Sesión -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Tabla de Registros -->
    <div class="card card-custom bg-white border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th style="width: 100px;">Miniatura</th>
                            <th>Archivo de Imagen</th>
                            <th>Receta Nutricional</th>
                            <th>Directorio / Formato</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($records)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-images fs-1 text-secondary d-block mb-2"></i>
                                    <h6 class="fw-bold text-secondary mb-1">No se encontraron vinculaciones</h6>
                                    <p class="small mb-3">No hay registros que coincidan con los criterios de búsqueda.</p>
                                    <a href="<?= base_url('imagenreceta/add') ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-plus-lg me-1"></i>Crear primera vinculación
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($records as $r): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $r['idimagenreceta'] ?></td>
                                    <td>
                                        <div class="rounded border bg-light d-flex align-items-center justify-content-center overflow-hidden" style="width: 64px; height: 64px;">
                                            <?php if ($r['archivoExiste'] && !empty($r['urlImagen'])): ?>
                                                <img src="<?= $r['urlImagen'] ?>" 
                                                     onerror="this.onerror=null; this.src='<?= !empty($r['urlFallback']) ? $r['urlFallback'] : base_url('imagen/imagen/' . esc($r['imagen_nombre'])) ?>';"
                                                     alt="<?= esc($r['imagen_nombre']) ?>" 
                                                     class="img-fluid" 
                                                     style="max-height: 60px; object-fit: contain;">
                                            <?php else: ?>
                                                <i class="bi bi-image text-secondary fs-4"></i>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold font-monospace text-dark text-truncate" style="max-width: 250px;" title="<?= esc($r['imagen_nombre']) ?>">
                                            <?= esc($r['imagen_nombre']) ?>
                                        </div>
                                        <?php if (!empty($r['imagen_descripcion'])): ?>
                                            <small class="text-muted text-truncate d-block" style="max-width: 250px;">
                                                <?= esc($r['imagen_descripcion']) ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('receta/actual/' . $r['idreceta']) ?>" class="fw-bold text-dark text-decoration-none d-inline-flex align-items-center">
                                            <i class="bi bi-book-half text-warning me-1 fs-5"></i>
                                            <?= esc($r['receta_nombre']) ?>
                                        </a>
                                        <div class="small text-muted">
                                            <?= esc($r['receta_porciones'] ?? 1) ?> porción(es) 
                                            <?= !empty($r['receta_tiempopreparacion']) ? '• ' . esc($r['receta_tiempopreparacion']) . ' min' : '' ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="font-monospace small text-muted">
                                            <i class="bi bi-folder text-warning me-1"></i><?= esc($r['directorio_ruta'] ?: 'repositorio/imagen') ?>
                                        </div>
                                        <span class="badge bg-secondary-subtle text-secondary border font-monospace mt-1" style="font-size: 0.7rem;">
                                            <?= strtoupper(esc($r['formato_nombre'] ?: 'IMG')) ?>
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('imagenreceta/actual/' . $r['idimagenreceta']) ?>" class="btn btn-outline-primary" title="Ver Detalle">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('imagenreceta/edit/' . $r['idimagenreceta']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline-danger" title="Borrar" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalDeleteIr" 
                                                    data-id="<?= $r['idimagenreceta'] ?>" 
                                                    data-imagen="<?= esc($r['imagen_nombre']) ?>" 
                                                    data-receta="<?= esc($r['receta_nombre']) ?>">
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

<!-- Modal para confirmar eliminación -->
<div class="modal fade" id="modalDeleteIr" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formDeleteIr" method="post" action="">
                <?= csrf_field() ?>
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle-fill me-2"></i>Confirmar Eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-center">
                    <p class="mb-2">¿Está seguro de que desea desvincular la imagen de la receta?</p>
                    <div class="p-3 bg-light rounded border my-3 text-start">
                        <div class="mb-1"><strong>Imagen:</strong> <span id="delImgName" class="font-monospace text-primary"></span></div>
                        <div><strong>Receta:</strong> <span id="delRecName" class="text-dark fw-bold"></span></div>
                    </div>
                    <p class="small text-danger mb-0">Esta acción removerá el enlace entre ambos registros, pero no eliminará la imagen ni la receta de la base de datos.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger"><i class="bi bi-trash-fill me-1"></i>Eliminar Enlace</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modalDel = document.getElementById('modalDeleteIr');
    if (modalDel) {
        modalDel.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            const imgName = button.getAttribute('data-imagen');
            const recName = button.getAttribute('data-receta');
            
            document.getElementById('delImgName').textContent = imgName;
            document.getElementById('delRecName').textContent = recName;
            document.getElementById('formDeleteIr').action = '<?= base_url('imagenreceta/delete/') ?>/' + id;
        });
    }
});
</script>

<?= $this->endSection() ?>
