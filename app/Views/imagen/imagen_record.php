<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($imagen)): ?>
            <?= view('layout/empty_record', ['module' => 'imagen']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'imagen',
                'currentId' => $imagen['idimagen']
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

            <!-- Ficha Principal de la Imagen -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-image text-primary me-2 fs-4"></i>Imagen #<?= $imagen['idimagen'] ?>: <?= esc($imagen['nombre'] ?: 'Sin nombre asignado') ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $imagen['idimagen'] ?></span>
                        <?php if ($archivoExiste): ?>
                            <span class="badge bg-success-subtle text-success border border-success-subtle fs-6"><i class="bi bi-check2-circle me-1"></i>En Repositorio</span>
                        <?php else: ?>
                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle fs-6"><i class="bi bi-exclamation-circle me-1"></i>Pendiente de archivo</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-start">
                        
                        <!-- Columna Izquierda: Vista Previa y Carga Rápida -->
                        <div class="col-md-5 text-center border-end pe-md-4">
                            <div class="p-3 bg-light rounded-4 border shadow-sm mb-3">
                                <label class="fw-bold text-dark d-block mb-3">
                                    <i class="bi bi-eye me-1"></i>Vista Previa de la Imagen
                                </label>
                                
                                <?php if ($archivoExiste && !empty($urlImagen)): ?>
                                    <div class="position-relative d-inline-block w-100 mb-2">
                                        <img src="<?= $urlImagen ?>" 
                                             alt="<?= esc($imagen['nombre']) ?>" 
                                             class="img-fluid rounded-3 shadow-sm border" 
                                             style="max-height: 280px; width: auto; object-fit: contain;">
                                    </div>
                                    <div class="d-flex justify-content-center gap-2 mt-2">
                                        <a href="<?= $urlImagen ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-box-arrow-up-right me-1"></i>Abrir original
                                        </a>
                                        <a href="<?= $urlImagen ?>" download="<?= esc($imagen['nombre']) ?>" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-download me-1"></i>Descargar
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="py-5 text-center text-muted bg-white rounded-3 border border-dashed">
                                        <i class="bi bi-image-alt fs-1 d-block mb-2 text-secondary"></i>
                                        <span class="d-block fw-semibold text-secondary">No hay archivo en disco</span>
                                        <small class="text-muted d-block mt-1">Ubicación esperada: <code>repositorio/imagen/<?= esc($imagen['nombre']) ?></code></small>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Formulario de Subida Rápida (Estilo SICA) -->
                            <div class="card border border-primary-subtle shadow-sm text-start">
                                <div class="card-header bg-primary bg-opacity-10 py-2 border-bottom border-primary-subtle">
                                    <span class="fw-bold small text-primary">
                                        <i class="bi bi-cloud-arrow-up-fill me-1"></i>Subir / Reemplazar Imagen en Disco
                                    </span>
                                </div>
                                <div class="card-body p-3">
                                    <form action="<?= base_url('imagen/upload/' . $imagen['idimagen']) ?>" method="post" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                        <div class="mb-2">
                                            <input type="file" name="archivo_imagen" id="archivo_imagen" class="form-control form-control-sm" accept="image/*" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-upload me-1"></i> Guardar en repositorio/imagen
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Columna Derecha: Metadatos Detallados -->
                        <div class="col-md-7 ps-md-4">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Registro</th>
                                            <td class="fw-bold text-secondary">#<?= $imagen['idimagen'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre de Archivo</th>
                                            <td>
                                                <span class="font-monospace fw-semibold text-dark">
                                                    <?= esc($imagen['nombre'] ?: 'Generación pendiente') ?>
                                                </span>
                                                <small class="d-block text-muted" style="font-size: 0.75rem;">
                                                    Formato SICA: <code>YYYYmmdd_HHiiss-00000.ext</code>
                                                </small>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Formato de Imagen</th>
                                            <td>
                                                <?php if (!empty($imagen['formato_nombre'])): ?>
                                                    <span class="badge bg-info-subtle text-info border border-info px-3 py-1 font-monospace text-uppercase">
                                                        <?= esc($imagen['formato_nombre']) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No especificado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha de Captura</th>
                                            <td class="text-dark">
                                                <i class="bi bi-calendar-event text-primary me-2"></i>
                                                <?= !empty($imagen['fechacaptura']) ? esc($imagen['fechacaptura']) : '<span class="text-muted fst-italic">No registrada</span>' ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Licencia</th>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1">
                                                    <?= esc($imagen['licencia'] ?: 'No asignada') ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Palabras Clave</th>
                                            <td>
                                                <?php if (!empty($imagen['palabrasclave'])): ?>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        <?php foreach (explode(',', $imagen['palabrasclave']) as $tag): ?>
                                                            <?php if (trim($tag)): ?>
                                                                <span class="badge bg-light text-dark border"><i class="bi bi-hash"></i><?= esc(trim($tag)) ?></span>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin palabras clave</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Servidor / Ordenador</th>
                                            <td>
                                                <i class="bi bi-hdd-network text-secondary me-1"></i>
                                                <?= esc($imagen['ordenador_nombre'] ?: 'Servidor Local gim360') ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Ruta en Repositorio</th>
                                            <td>
                                                <i class="bi bi-folder2-open text-warning me-1"></i>
                                                <code class="text-dark"><?= esc($imagen['directorio_ruta'] ?: 'repositorio/imagen') ?>/<?= esc($imagen['nombre']) ?></code>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Fecha Creación</th>
                                            <td class="text-muted small">
                                                <i class="bi bi-clock-history me-1"></i><?= esc($imagen['fechacreacion']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción</th>
                                            <td>
                                                <?php if (!empty($imagen['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-primary text-secondary small">
                                                        <?= nl2br(esc($imagen['descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción registrada.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Las imágenes se sincronizan directamente en el directorio físico <code>repositorio/imagen/</code>.
                    </span>
                    <a href="<?= base_url('imagen/add') ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>Registrar otra imagen
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
