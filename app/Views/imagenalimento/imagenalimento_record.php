<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'imagenalimento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'imagenalimento',
                'currentId' => $rel['idimagenalimento']
            ]) ?>

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

            <!-- Ficha Principal de la Asignación -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-images text-success me-2 fs-4"></i>Imagen de Alimento #<?= $rel['idimagenalimento'] ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $rel['idimagenalimento'] ?></span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        
                        <!-- Columna Izquierda: Vista previa de la imagen -->
                        <div class="col-md-5 text-center border-end pe-md-4">
                            <div class="p-3 bg-light rounded-4 border shadow-sm mb-2">
                                <label class="fw-bold text-dark d-block mb-3 small text-uppercase text-muted">
                                    <i class="bi bi-image me-1"></i>Vista Previa de la Imagen
                                </label>

                                <?php if (!empty($urlImagen) && $archivoExiste): ?>
                                    <div class="position-relative d-inline-block w-100 mb-2">
                                        <img src="<?= $urlImagen ?>" 
                                             onerror="this.onerror=null; this.src='<?= !empty($urlFallback) ? $urlFallback : base_url('imagen/imagen/' . esc($rel['imagen_nombre'])) ?>';"
                                             alt="<?= esc($rel['imagen_nombre']) ?>" 
                                             class="img-fluid rounded-3 shadow-sm border" 
                                             style="max-height: 220px; width: auto; object-fit: contain;">
                                    </div>
                                    <div class="d-flex justify-content-center gap-2 mt-2">
                                        <a href="<?= $urlImagen ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Original
                                        </a>
                                        <a href="<?= base_url('imagen/actual/' . $rel['idimagen']) ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-eye me-1"></i>Ficha Imagen
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="py-4 text-center text-muted bg-white rounded-3 border border-dashed">
                                        <i class="bi bi-image text-secondary fs-1 d-block mb-1"></i>
                                        <span class="d-block fw-semibold text-secondary small"><?= esc($rel['imagen_nombre']) ?></span>
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle mt-1">Sin archivo en disco</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <small class="text-muted d-block font-monospace" style="font-size: 0.75rem;">
                                <i class="bi bi-folder text-warning me-1"></i><?= esc($rel['directorio_ruta'] ?: 'repositorio/imagen') ?>/<?= esc($rel['imagen_nombre']) ?>
                            </small>
                        </div>

                        <!-- Columna Derecha: Detalles del Alimento y la Relación -->
                        <div class="col-md-7 ps-md-4">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Asignación</th>
                                        <td class="fw-bold text-secondary">#<?= $rel['idimagenalimento'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Alimento del Catálogo</th>
                                        <td>
                                            <a href="<?= base_url('alimento/actual/' . $rel['idalimento']) ?>" class="badge bg-success text-white text-decoration-none px-3 py-2 fs-6">
                                                <i class="bi bi-apple me-1"></i><?= esc($rel['alimento_nombre']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Grupo de Alimento</th>
                                        <td>
                                            <span class="badge bg-light text-dark border">
                                                <i class="bi bi-diagram-3 text-success me-1"></i><?= esc($rel['grupo_nombre'] ?? 'Sin Grupo') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre Archivo Imagen</th>
                                        <td class="fw-bold text-dark font-monospace small">
                                            <?= esc($rel['imagen_nombre']) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Formato</th>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary border font-monospace">
                                                <?= strtoupper(esc($rel['formato_nombre'] ?: 'DESCONOCIDO')) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Directorio</th>
                                        <td>
                                            <span class="font-monospace small text-muted">
                                                <i class="bi bi-folder-fill text-warning me-1"></i><?= esc($rel['directorio_nombre'] ?: 'repositorio/imagen') ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php if (!empty($rel['imagen_descripcion'])): ?>
                                    <tr>
                                        <th class="table-light text-muted">Descripción Imagen</th>
                                        <td class="text-secondary small">
                                            <?= esc($rel['imagen_descripcion']) ?>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>

                            <div class="d-flex justify-content-between align-items-center mt-3 pt-3 border-top">
                                <a href="<?= base_url('alimento/actual/' . $rel['idalimento']) ?>" class="btn btn-outline-success btn-sm">
                                    <i class="bi bi-arrow-left me-1"></i>Ir a la Ficha del Alimento
                                </a>
                                <a href="<?= base_url('imagen/actual/' . $rel['idimagen']) ?>" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-image me-1"></i>Ver Imagen Completa
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        <i class="bi bi-link-45deg me-1"></i>Relación vinculada entre el catálogo de imágenes y el inventario de alimentos de Gim360.
                    </span>
                    <a href="<?= base_url('imagenalimento/add?idalimento=' . $rel['idalimento']) ?>" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i>Asignar otra imagen a este alimento
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
