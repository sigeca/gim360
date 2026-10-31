<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($alimento)): ?>
            <?= view('layout/empty_record', ['module' => 'alimento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'alimento',
                'currentId' => $alimento['idalimento']
            ]) ?>

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

            <!-- Ficha Principal del Alimento -->
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-apple text-success me-2 fs-4"></i>Ficha de Alimento: <?= esc($alimento['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $alimento['idalimento'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-3 bg-light rounded-4 border shadow-sm">
                                <?php if (!empty($alimento['primera_imagen']) && !empty($alimento['primera_imagen']['urlImagen'])): ?>
                                    <div class="rounded-3 border overflow-hidden bg-white mb-3 shadow-sm mx-auto p-2" style="max-width: 170px; height: 140px; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?= $alimento['primera_imagen']['urlImagen'] ?>" 
                                             onerror="this.onerror=null; this.src='<?= !empty($alimento['primera_imagen']['urlFallback']) ? $alimento['primera_imagen']['urlFallback'] : base_url('imagen/imagen/' . esc($alimento['primera_imagen']['imagen_nombre'])) ?>';"
                                             alt="<?= esc($alimento['nombre']) ?>" 
                                             class="img-fluid" 
                                             style="max-height: 125px; width: auto; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                                        <i class="bi bi-basket3-fill fs-1"></i>
                                    </div>
                                <?php endif; ?>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($alimento['nombre']) ?></h5>
                                <?php if (!empty($alimento['grupo_nombre'])): ?>
                                    <a href="<?= base_url('grupoalimento/actual/' . $alimento['idgrupo']) ?>" class="badge bg-success text-decoration-none px-3 py-1 mt-1 shadow-sm">
                                        <i class="bi bi-egg-fried me-1"></i><?= esc($alimento['grupo_nombre']) ?>
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary px-3 py-1">Sin Grupo</span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Alimento</th>
                                            <td class="fw-bold text-secondary">#<?= $alimento['idalimento'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Alimento</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-tag-fill text-success me-2"></i><?= esc($alimento['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Grupo Nutricional</th>
                                            <td>
                                                <?php if (!empty($alimento['grupo_nombre'])): ?>
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <span class="fw-bold text-success">
                                                            <i class="bi bi-diagram-3 me-1"></i><?= esc($alimento['grupo_nombre']) ?>
                                                        </span>
                                                        <a href="<?= base_url('grupoalimento/actual/' . $alimento['idgrupo']) ?>" class="btn btn-xs btn-outline-success py-0 px-2 small" title="Ver ficha del grupo">
                                                            Ver Grupo <i class="bi bi-arrow-right"></i>
                                                        </a>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">No asignado</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción y Propiedades</th>
                                            <td>
                                                <?php if (!empty($alimento['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-success text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($alimento['descripcion'])) ?>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-muted fst-italic">Sin descripción ni información nutricional adicional.</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-light d-flex justify-content-between align-items-center py-2 px-4">
                    <span class="small text-muted">
                        <i class="bi bi-info-circle me-1"></i>Alimento disponible para planes dietéticos.
                    </span>
                    <a href="<?= base_url('alimento/listar?idgrupo=' . $alimento['idgrupo']) ?>" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-filter me-1"></i>Ver todos los de este grupo
                    </a>
                </div>
            </div>

            <!-- Galería e Imágenes del Alimento -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex flex-wrap justify-content-between align-items-center gap-2 border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-images text-success me-2 fs-5"></i>Galería e Imágenes del Alimento
                        <span class="badge bg-success text-white ms-2"><?= count($imagenes ?? []) ?></span>
                    </h6>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('imagenalimento/listar?idalimento=' . $alimento['idalimento']) ?>" class="btn btn-sm btn-outline-secondary">
                            <i class="bi bi-list-task me-1"></i> Gestionar en módulo
                        </a>
                        <button type="button" class="btn btn-sm btn-success text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                            <i class="bi bi-plus-circle me-1"></i> Asignar Imagen
                        </button>
                    </div>
                </div>
                <div class="card-body p-3">
                    <?php if (empty($imagenes)): ?>
                        <div class="text-center py-4 bg-light rounded-3 border">
                            <i class="bi bi-images text-secondary fs-1 d-block mb-2"></i>
                            <h6 class="fw-bold text-secondary mb-1">Sin imágenes asignadas</h6>
                            <p class="text-muted small mb-3">Este alimento aún no cuenta con fotografías o recursos visuales asociados.</p>
                            <button type="button" class="btn btn-sm btn-outline-success fw-bold" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                                <i class="bi bi-plus-lg me-1"></i> Asociar primera imagen
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="row g-3">
                            <?php foreach ($imagenes as $img): ?>
                                <div class="col-sm-6 col-md-4">
                                    <div class="card h-100 border shadow-sm">
                                        <div class="p-2 text-center bg-light border-bottom position-relative" style="height: 140px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                            <?php if ($img['archivoExiste'] && !empty($img['urlImagen'])): ?>
                                                <img src="<?= $img['urlImagen'] ?>" 
                                                     onerror="this.onerror=null; this.src='<?= !empty($img['urlFallback']) ? $img['urlFallback'] : base_url('imagen/imagen/' . esc($img['imagen_nombre'])) ?>';"
                                                     alt="<?= esc($img['imagen_nombre']) ?>" 
                                                     class="img-fluid rounded" 
                                                     style="max-height: 125px; width: auto; object-fit: contain;">
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
                                                    <a href="<?= base_url('imagenalimento/actual/' . $img['idimagenalimento']) ?>" class="btn btn-outline-info btn-sm py-0 px-2" title="Ver vínculo">
                                                        <i class="bi bi-link-45deg"></i>
                                                    </a>
                                                </div>
                                                <form action="<?= base_url('alimento/quitarImagen/' . $alimento['idalimento'] . '/' . $img['idimagen']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular esta imagen del alimento?');">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Quitar de este alimento">
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

            <!-- Componentes Nutricionales Asociados -->
            <div class="card card-custom bg-white shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill text-info me-2 fs-5"></i>Componentes Nutricionales del Alimento
                        <span class="badge bg-info-subtle text-info border border-info ms-2"><?= count($componentes ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('alimentocomponentenutricional/add?idalimento=' . $alimento['idalimento']) ?>" class="btn btn-sm btn-info text-white">
                        <i class="bi bi-plus-circle me-1"></i> Asignar Componente
                    </a>
                </div>
                <div class="card-body p-3">
                    <?php if (empty($componentes)): ?>
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-pie-chart fs-2 d-block mb-2 text-secondary"></i>
                            <p class="mb-2">No se han asociado componentes nutricionales a este alimento.</p>
                            <a href="<?= base_url('alimentocomponentenutricional/add?idalimento=' . $alimento['idalimento']) ?>" class="btn btn-sm btn-outline-info">
                                <i class="bi bi-plus-lg me-1"></i>Asignar primer nutriente
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($componentes as $comp): ?>
                                <div class="badge bg-light text-dark border p-2 d-flex align-items-center gap-2 shadow-sm">
                                    <i class="bi bi-check-circle-fill text-success"></i>
                                    <span class="fw-semibold"><?= esc($comp['componente_nombre']) ?></span>
                                    <a href="<?= base_url('alimentocomponentenutricional/actual/' . $comp['idalimentocomponentenutricional']) ?>" class="text-primary text-decoration-none" title="Ver asignación">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Modal para Asignar Imagen al Alimento -->
            <div class="modal fade" id="modalAsignarImagen" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?= base_url('alimento/asignarImagen/' . $alimento['idalimento']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-header bg-success bg-opacity-10 border-bottom border-success-subtle">
                                <h5 class="modal-title fw-bold text-dark">
                                    <i class="bi bi-images text-success me-2"></i>Asignar Imagen al Alimento
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body p-4">
                                <p class="text-muted small mb-3">
                                    Seleccione una imagen del repositorio institucional de Gim360 para ilustrar este alimento:
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
                                <button type="submit" class="btn btn-success text-white fw-bold">
                                    <i class="bi bi-check-circle me-1"></i> Vincular al Alimento
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
