<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-9">

        <?php if (empty($receta)): ?>
            <?= view('layout/empty_record', ['module' => 'receta']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'receta',
                'currentId' => $receta['idreceta']
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

            <!-- Ficha Principal de la Receta -->
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-book-half text-warning fs-3"></i>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark"><?= esc($receta['nombre']) ?></h5>
                            <small class="text-muted">Receta Nutricional #<?= $receta['idreceta'] ?></small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <?php $cat = $receta['categoria_tiempo']; ?>
                        <span class="badge <?= $cat['badge_class'] ?> px-3 py-2 fs-6 shadow-sm">
                            <i class="bi <?= $cat['icono'] ?> me-1"></i><?= $cat['etiqueta'] ?>
                        </span>
                    </div>
                </div>

                <div class="card-body p-4">

                    <!-- Tarjetas de Resumen Rápido -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-people-fill text-primary me-1"></i>Rendimiento / Porciones</span>
                                <h4 class="fw-bold text-dark mb-0"><?= esc($receta['porciones'] ?? 1) ?> <span class="fs-6 fw-normal text-muted">porción(es)</span></h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-stopwatch text-danger me-1"></i>Tiempo de Preparación</span>
                                <h4 class="fw-bold text-dark mb-0"><?= esc($receta['tiempo_texto']) ?></h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="p-3 bg-light rounded-3 border text-center">
                                <span class="text-muted small d-block mb-1"><i class="bi bi-heart-pulse-fill text-success me-1"></i>Aporte Nutricional</span>
                                <span class="badge bg-success-subtle text-success border border-success mt-1 px-3 py-1">Dieta & Fitness</span>
                            </div>
                        </div>
                    </div>

                    <!-- Ingredientes Requeridos (alimentoreceta) -->
                    <div class="card border border-warning-subtle shadow-sm mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-basket3 text-warning me-2 fs-5"></i>Ingredientes Requeridos
                                <span class="badge bg-warning text-dark ms-2"><?= count($ingredientes ?? []) ?></span>
                            </h6>
                            <a href="<?= base_url('alimentoreceta/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Agregar Ingrediente
                            </a>
                        </div>
                        <div class="card-body p-0">
                            <?php if (empty($ingredientes)): ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-basket2 fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-2">Aún no se han asignado ingredientes específicos a esta receta.</p>
                                    <a href="<?= base_url('alimentoreceta/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-plus-lg me-1"></i>Asignar primer ingrediente
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="ps-4">Alimento / Ingrediente</th>
                                                <th>Grupo Nutricional</th>
                                                <th>Cantidad</th>
                                                <th>Unidad</th>
                                                <th class="text-end pe-4">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($ingredientes as $ing): ?>
                                                <tr>
                                                    <td class="ps-4">
                                                        <a href="<?= base_url('alimento/actual/' . $ing['idalimento']) ?>" class="fw-bold text-success text-decoration-none">
                                                            <i class="bi bi-apple me-1"></i><?= esc($ing['alimento_nombre']) ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-muted border"><?= esc($ing['grupo_nombre'] ?? 'General') ?></span>
                                                    </td>
                                                    <td class="fw-bold text-primary fs-6">
                                                        <?= number_format((float)$ing['cantidad'], 2) ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info-subtle text-info border border-info font-monospace">
                                                            <?= esc($ing['unidad_nombre']) ?> (<?= esc($ing['unidad_abreviatura']) ?>)
                                                        </span>
                                                    </td>
                                                    <td class="text-end pe-4">
                                                        <a href="<?= base_url('alimentoreceta/edit/' . $ing['idalimentoreceta']) ?>" class="btn btn-xs btn-outline-warning text-dark" title="Editar cantidad">
                                                            <i class="bi bi-pencil-square"></i>
                                                        </a>
                                                        <a href="<?= base_url('alimentoreceta/delete/' . $ing['idalimentoreceta'] . '?from_receta=1') ?>" class="btn btn-xs btn-outline-danger" title="Remover" onclick="return confirm('¿Remover este ingrediente de la receta?');">
                                                            <i class="bi bi-x-lg"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Instrucciones y Modo de Preparación -->
                    <div class="card border border-warning-subtle shadow-sm mb-4">
                        <div class="card-header bg-warning bg-opacity-10 py-3 border-bottom border-warning-subtle">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-card-checklist text-warning me-2 fs-5"></i>Instrucciones de Preparación
                            </h6>
                        </div>
                        <div class="card-body p-4">
                            <?php if (!empty($receta['instrucciones'])): ?>
                                <div class="bg-light p-3 rounded-3 border text-secondary" style="white-space: pre-line; line-height: 1.7; font-size: 0.95rem;">
                                    <?= esc($receta['instrucciones']) ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4 text-muted">
                                    <i class="bi bi-file-earmark-text fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-0">No se han registrado pasos o instrucciones para esta receta.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Componentes Nutricionales de la Receta -->
                    <div class="card border border-info-subtle shadow-sm mb-4">
                        <div class="card-header bg-info bg-opacity-10 py-3 d-flex justify-content-between align-items-center border-bottom border-info-subtle">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-pie-chart-fill text-info me-2 fs-5"></i>Componentes Nutricionales Destacados
                                <span class="badge bg-info-subtle text-info border border-info ms-2"><?= count($componentes ?? []) ?></span>
                            </h6>
                            <a href="<?= base_url('recetacomponentenutricional/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-info text-white">
                                <i class="bi bi-plus-circle me-1"></i> Asignar Componente
                            </a>
                        </div>
                        <div class="card-body p-3">
                            <?php if (empty($componentes)): ?>
                                <div class="text-center py-3 text-muted">
                                    <i class="bi bi-pie-chart fs-2 d-block mb-2 text-secondary"></i>
                                    <p class="mb-2 small">No se han asociado componentes nutricionales a esta receta.</p>
                                    <a href="<?= base_url('recetacomponentenutricional/add?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-plus-lg me-1"></i>Asignar primer nutriente
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($componentes as $comp): ?>
                                        <div class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2 shadow-sm">
                                            <i class="bi bi-check-circle-fill text-info"></i>
                                            <span class="fw-semibold"><?= esc($comp['componente_nombre']) ?></span>
                                            <a href="<?= base_url('recetacomponentenutricional/actual/' . $comp['idrecetacomponentenutricional']) ?>" class="text-primary text-decoration-none" title="Ver asignación">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Galería e Imágenes de la Receta -->
                    <div class="card border border-warning-subtle shadow-sm mb-4">
                        <div class="card-header bg-warning bg-opacity-10 py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom border-warning-subtle">
                            <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-images text-warning me-2 fs-5"></i>Galería e Imágenes de la Receta
                                <span class="badge bg-warning text-dark border border-warning ms-2"><?= count($imagenes ?? []) ?></span>
                            </h6>
                            <div class="d-flex align-items-center gap-2">
                                <a href="<?= base_url('imagenreceta/listar?idreceta=' . $receta['idreceta']) ?>" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-list-task me-1"></i> Gestionar en módulo
                                </a>
                                <button type="button" class="btn btn-sm btn-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Imagen
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <?php if (empty($imagenes)): ?>
                                <div class="text-center py-4 bg-light rounded-3 border">
                                    <i class="bi bi-images text-secondary fs-1 d-block mb-2"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Sin imágenes asignadas</h6>
                                    <p class="text-muted small mb-3">Esta receta aún no cuenta con fotografías o recursos visuales asociados.</p>
                                    <button type="button" class="btn btn-sm btn-outline-warning text-dark fw-bold" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                                        <i class="bi bi-plus-lg me-1"></i> Asociar primera imagen
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="row g-3">
                                    <?php foreach ($imagenes as $img): ?>
                                        <div class="col-sm-6 col-md-4">
                                            <div class="card h-100 border shadow-sm">
                                                <div class="p-2 text-center bg-light border-bottom position-relative" style="height: 150px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    <?php if ($img['archivoExiste'] && !empty($img['urlImagen'])): ?>
                                                        <img src="<?= $img['urlImagen'] ?>" 
                                                             onerror="this.onerror=null; this.src='<?= !empty($img['urlFallback']) ? $img['urlFallback'] : base_url('imagen/imagen/' . esc($img['imagen_nombre'])) ?>';"
                                                             alt="<?= esc($img['imagen_nombre']) ?>" 
                                                             class="img-fluid rounded" 
                                                             style="max-height: 135px; width: auto; object-fit: contain;">
                                                    <?php else: ?>
                                                        <div class="text-muted small">
                                                            <i class="bi bi-image fs-1 text-secondary d-block"></i>
                                                            <span>Sin archivo físico</span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="card-body p-2 d-flex flex-column justify-content-between">
                                                    <div>
                                                        <span class="d-block font-monospace small fw-bold text-dark text-truncate" title="<?= esc($img['imagen_nombre']) ?>">
                                                            <?= esc($img['imagen_nombre']) ?>
                                                        </span>
                                                        <div class="d-flex align-items-center justify-content-between mt-1">
                                                            <span class="badge bg-secondary-subtle text-secondary border font-monospace" style="font-size: 0.65rem;">
                                                                <?= strtoupper(esc($img['formato_nombre'] ?: 'IMG')) ?>
                                                            </span>
                                                            <small class="text-muted font-monospace" style="font-size: 0.7rem;">
                                                                <i class="bi bi-folder me-1 text-warning"></i><?= esc($img['directorio_ruta'] ?: 'repositorio/imagen') ?>
                                                            </small>
                                                        </div>
                                                        <?php if (!empty($img['imagen_descripcion'])): ?>
                                                            <p class="text-secondary small mt-1 mb-0 text-truncate" style="font-size: 0.75rem;" title="<?= esc($img['imagen_descripcion']) ?>">
                                                                <?= esc($img['imagen_descripcion']) ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>

                                                    <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                                                        <div class="btn-group btn-group-sm">
                                                            <?php if (!empty($img['urlImagen'])): ?>
                                                                <a href="<?= $img['urlImagen'] ?>" target="_blank" class="btn btn-outline-primary btn-sm py-0 px-2" title="Abrir imagen original">
                                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="<?= base_url('imagen/actual/' . $img['idimagen']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Ver ficha en Imágenes">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url('imagenreceta/actual/' . $img['idimagenreceta']) ?>" class="btn btn-outline-info btn-sm py-0 px-2" title="Ver vínculo">
                                                                <i class="bi bi-link-45deg"></i>
                                                            </a>
                                                        </div>
                                                        <form action="<?= base_url('receta/quitarImagen/' . $receta['idreceta'] . '/' . $img['idimagen']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular esta imagen de la receta?');">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Quitar de esta receta">
                                                                <i class="bi bi-x-lg"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-light py-3 px-4 d-flex justify-content-between align-items-center">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Receta disponible para ser incluida en planes nutricionales y recomendaciones dietéticas.
                    </span>
                    <a href="<?= base_url('receta/add') ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>Registrar otra receta
                    </a>
                </div>
            </div>

            <!-- Modal para Asignar Imagen a la Receta -->
            <div class="modal fade" id="modalAsignarImagen" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?= base_url('receta/asignarImagen/' . $receta['idreceta']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-header bg-warning bg-opacity-25 border-bottom border-warning-subtle">
                                <h5 class="modal-title fw-bold text-dark">
                                    <i class="bi bi-images text-warning me-2"></i>Asignar Imagen a la Receta
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <p class="text-muted small mb-3">
                                    Seleccione una imagen del repositorio institucional de Gim360 para ilustrar esta receta:
                                </p>

                                <div class="mb-3">
                                    <label for="idimagenSelect" class="form-label fw-bold">Imagen del Catálogo <span class="text-danger">*</span></label>
                                    <select name="idimagen" id="idimagenSelect" class="form-select font-monospace" required>
                                        <option value="">-- Seleccionar imagen disponible --</option>
                                        <?php if (!empty($todasImagenes)): ?>
                                            <?php foreach ($todasImagenes as $img): ?>
                                                <option value="<?= $img['idimagen'] ?>">
                                                    #<?= $img['idimagen'] ?> - <?= esc($img['nombre']) ?> <?= !empty($img['descripcion']) ? ' (' . esc(mb_strimwidth($img['descripcion'], 0, 35, '...')) . ')' : '' ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>

                                <div class="text-end">
                                    <a href="<?= base_url('imagen/add') ?>" target="_blank" class="small text-decoration-none">
                                        <i class="bi bi-upload me-1"></i>Subir nueva imagen al repositorio
                                    </a>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-warning text-dark fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Vincular a Receta
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
