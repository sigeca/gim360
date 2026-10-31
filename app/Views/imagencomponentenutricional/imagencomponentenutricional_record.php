<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'imagencomponentenutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'imagencomponentenutricional',
                'currentId' => $rel['idimagencomponentenutricional']
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
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-images text-info me-2 fs-4"></i>Imagen de Componente Nutricional #<?= $rel['idimagencomponentenutricional'] ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $rel['idimagencomponentenutricional'] ?></span>
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

                        <!-- Columna Derecha: Detalles del Componente y la Relación -->
                        <div class="col-md-7 ps-md-4">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-40 text-muted">ID Asignación</th>
                                        <td class="fw-bold text-secondary">#<?= $rel['idimagencomponentenutricional'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Componente Nutricional</th>
                                        <td>
                                            <a href="<?= base_url('componentenutricional/actual/' . $rel['idcomponentenutricional']) ?>" class="badge bg-info text-white text-decoration-none px-3 py-2 fs-6">
                                                <i class="bi bi-pie-chart-fill me-1"></i><?= esc($rel['componente_nombre']) ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Archivo de Imagen</th>
                                        <td>
                                            <a href="<?= base_url('imagen/actual/' . $rel['idimagen']) ?>" class="fw-bold text-dark text-decoration-none hover-primary font-monospace">
                                                <i class="bi bi-file-earmark-image text-primary me-1"></i><?= esc($rel['imagen_nombre']) ?>
                                            </a>
                                            <?php if (!empty($rel['formato_nombre'])): ?>
                                                <span class="badge bg-secondary-subtle text-secondary border ms-1 font-monospace text-uppercase" style="font-size: 0.7rem;">
                                                    <?= esc($rel['formato_nombre']) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Directorio de Almacenamiento</th>
                                        <td>
                                            <span class="d-inline-flex align-items-center gap-1 small">
                                                <i class="bi bi-folder-fill text-warning"></i>
                                                <code><?= esc($rel['directorio_ruta'] ?: 'repositorio/imagen') ?></code>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted align-top">Descripción de Imagen</th>
                                        <td class="small text-secondary">
                                            <?= !empty($rel['imagen_descripcion']) ? nl2br(esc($rel['imagen_descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted align-top">Función del Componente</th>
                                        <td class="small text-secondary">
                                            <?= !empty($rel['componente_descripcion']) ? nl2br(esc($rel['componente_descripcion'])) : '<span class="text-muted fst-italic">Sin función registrada</span>' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                    <a href="<?= base_url('componentenutricional/actual/' . $rel['idcomponentenutricional']) ?>" class="btn btn-sm btn-outline-info">
                        <i class="bi bi-arrow-left me-1"></i>Ver Ficha del Componente Nutricional
                    </a>
                    <a href="<?= base_url('imagencomponentenutricional/add?idcomponente=' . $rel['idcomponentenutricional']) ?>" class="btn btn-sm btn-info text-white">
                        <i class="bi bi-plus-circle me-1"></i>Asignar otra imagen
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
