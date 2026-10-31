<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    #nutricionalTabs .nav-link {
        border-radius: 0;
        color: #64748b;
        background-color: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        transition: all 0.2s ease-in-out;
    }
    #nutricionalTabs .nav-link:hover {
        color: #0f172a;
        background-color: rgba(0, 0, 0, 0.02);
    }
    #alimentos-tab.active {
        color: #198754 !important;
        border-bottom: 3px solid #198754 !important;
    }
    #recetas-tab.active {
        color: #0d6efd !important;
        border-bottom: 3px solid #0d6efd !important;
    }
    #imagenes-tab.active {
        color: #0dcaf0 !important;
        border-bottom: 3px solid #0dcaf0 !important;
    }
    .hover-shadow {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-shadow:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }
</style>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($componente)): ?>
            <?= view('layout/empty_record', ['module' => 'componentenutricional']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'componentenutricional',
                'currentId' => $componente['idcomponentenutricional']
            ]) ?>

            <!-- Ficha Principal del Componente Nutricional -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-pie-chart-fill text-info me-2 fs-4"></i>Componente Nutricional: <?= esc($componente['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-secondary text-white fs-6">ID #<?= $componente['idcomponentenutricional'] ?></span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <?php if (!empty($imagenes) && !empty($imagenes[0]['urlImagen'])): ?>
                                    <div class="mb-3 position-relative d-inline-block">
                                        <img src="<?= $imagenes[0]['urlImagen'] ?>" 
                                             onerror="this.onerror=null; this.src='<?= !empty($imagenes[0]['urlFallback']) ? $imagenes[0]['urlFallback'] : base_url('imagen/imagen/' . esc($imagenes[0]['imagen_nombre'])) ?>';"
                                             alt="<?= esc($componente['nombre']) ?>" 
                                             class="img-fluid rounded-4 shadow-sm border bg-white p-1" 
                                             style="max-height: 120px; width: auto; object-fit: contain;">
                                    </div>
                                <?php else: ?>
                                    <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 90px; height: 90px;">
                                        <i class="bi bi-heart-pulse-fill fs-1"></i>
                                    </div>
                                <?php endif; ?>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($componente['nombre']) ?></h5>
                                <span class="badge bg-info-subtle text-info-emphasis border border-info px-3 py-1">Valor Nutricional</span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th class="table-light w-35 text-muted">ID Componente</th>
                                            <td class="fw-bold text-secondary">#<?= $componente['idcomponentenutricional'] ?></td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted">Nombre del Componente</th>
                                            <td class="fs-5 fw-semibold text-dark">
                                                <i class="bi bi-check2-circle text-info me-2"></i><?= esc($componente['nombre']) ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="table-light text-muted align-top">Descripción y Función</th>
                                            <td>
                                                <?php if (!empty($componente['descripcion'])): ?>
                                                    <div class="p-3 bg-light rounded border-start border-3 border-info text-secondary small">
                                                        <i class="bi bi-quote text-muted me-1"></i><?= nl2br(esc($componente['descripcion'])) ?>
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

                <!-- Barra de Resumen / Métricas Clave -->
                <div class="card-footer bg-light py-3 px-4 border-top">
                    <div class="row g-3 text-center text-sm-start align-items-center">
                        <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-sm-start gap-3">
                            <div class="rounded-3 bg-success bg-opacity-10 text-success p-2 px-3 border border-success-subtle">
                                <i class="bi bi-apple fs-4"></i>
                            </div>
                            <div>
                                <div class="fs-5 fw-bold text-dark"><?= count($alimentos ?? []) ?></div>
                                <div class="small text-muted">Alimentos con este componente</div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-sm-start gap-3">
                            <div class="rounded-3 bg-primary bg-opacity-10 text-primary p-2 px-3 border border-primary-subtle">
                                <i class="bi bi-book-half fs-4"></i>
                            </div>
                            <div>
                                <div class="fs-5 fw-bold text-dark"><?= count($recetas ?? []) ?></div>
                                <div class="small text-muted">Recetas que aportan este nutriente</div>
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-center justify-content-center justify-content-sm-start gap-3">
                            <div class="rounded-3 bg-info bg-opacity-10 text-info p-2 px-3 border border-info-subtle">
                                <i class="bi bi-images fs-4"></i>
                            </div>
                            <div>
                                <div class="fs-5 fw-bold text-dark"><?= count($imagenes ?? []) ?></div>
                                <div class="small text-muted">Imágenes multimedia asociadas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Panel de Alimentos, Recetas e Imágenes Relacionadas (Pestañas Interactivas) -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-0">
                <div class="card-header bg-white border-bottom p-0">
                    <ul class="nav nav-tabs card-header-tabs m-0 border-0" id="nutricionalTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active fw-bold py-3 px-4 d-flex align-items-center gap-2" 
                                    id="alimentos-tab" data-bs-toggle="tab" data-bs-target="#alimentos-pane" type="button" role="tab" aria-controls="alimentos-pane" aria-selected="true">
                                <i class="bi bi-apple fs-5"></i>
                                <span>Alimentos</span>
                                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill ms-1"><?= count($alimentos ?? []) ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold py-3 px-4 d-flex align-items-center gap-2" 
                                    id="recetas-tab" data-bs-toggle="tab" data-bs-target="#recetas-pane" type="button" role="tab" aria-controls="recetas-pane" aria-selected="false">
                                <i class="bi bi-journal-bookmark-fill fs-5"></i>
                                <span>Recetas</span>
                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill ms-1"><?= count($recetas ?? []) ?></span>
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link fw-bold py-3 px-4 d-flex align-items-center gap-2" 
                                    id="imagenes-tab" data-bs-toggle="tab" data-bs-target="#imagenes-pane" type="button" role="tab" aria-controls="imagenes-pane" aria-selected="false">
                                <i class="bi bi-images fs-5"></i>
                                <span>Imágenes</span>
                                <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill ms-1"><?= count($imagenes ?? []) ?></span>
                            </button>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body p-4">
                    <div class="tab-content" id="nutricionalTabsContent">
                        
                        <!-- TAB 1: ALIMENTOS -->
                        <div class="tab-pane fade show active" id="alimentos-pane" role="tabpanel" aria-labelledby="alimentos-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">
                                        <i class="bi bi-basket2 text-success me-1"></i> Alimentos Fuente de <?= esc($componente['nombre']) ?>
                                    </h6>
                                    <small class="text-muted">Alimentos registrados en el catálogo que aportan este componente nutricional.</small>
                                </div>
                                <a href="<?= base_url('alimentocomponentenutricional/add?idcomponente=' . $componente['idcomponentenutricional']) ?>" class="btn btn-sm btn-success">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Alimento a este Componente
                                </a>
                            </div>

                            <?php if (empty($alimentos)): ?>
                                <div class="text-center py-5 bg-light rounded-3 border">
                                    <i class="bi bi-basket3 text-secondary fs-1 d-block mb-2"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Sin alimentos asociados</h6>
                                    <p class="text-muted small mb-3">Actualmente no hay alimentos registrados que contengan este componente nutricional.</p>
                                    <a href="<?= base_url('alimentocomponentenutricional/add?idcomponente=' . $componente['idcomponentenutricional']) ?>" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-plus-lg me-1"></i> Asociar el primer alimento
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 70px;">ID</th>
                                                <th>Alimento</th>
                                                <th>Grupo Nutricional</th>
                                                <th>Descripción / Propiedades</th>
                                                <th class="text-end" style="width: 140px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($alimentos as $ali): ?>
                                                <tr>
                                                    <td class="fw-bold text-muted">#<?= $ali['idalimento'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('alimento/actual/' . $ali['idalimento']) ?>" class="fw-bold text-dark text-decoration-none d-inline-flex align-items-center">
                                                            <i class="bi bi-tag-fill text-success me-2"></i>
                                                            <?= esc($ali['alimento_nombre']) ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($ali['grupo_nombre'])): ?>
                                                            <a href="<?= base_url('grupoalimento/actual/' . $ali['idgrupo']) ?>" class="badge bg-success-subtle text-success border border-success-subtle text-decoration-none py-1 px-2">
                                                                <i class="bi bi-diagram-3 me-1"></i><?= esc($ali['grupo_nombre']) ?>
                                                            </a>
                                                        <?php else: ?>
                                                            <span class="text-muted small fst-italic">Sin grupo</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-secondary small">
                                                        <?= !empty($ali['alimento_descripcion']) ? esc(mb_strimwidth($ali['alimento_descripcion'], 0, 90, '...')) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('alimento/actual/' . $ali['idalimento']) ?>" class="btn btn-outline-primary" title="Ver ficha del alimento">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="<?= base_url('alimentocomponentenutricional/actual/' . $ali['idalimentocomponentenutricional']) ?>" class="btn btn-outline-secondary" title="Ver asignación de componente">
                                                                <i class="bi bi-link-45deg"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TAB 2: RECETAS -->
                        <div class="tab-pane fade" id="recetas-pane" role="tabpanel" aria-labelledby="recetas-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">
                                        <i class="bi bi-journal-bookmark-fill text-primary me-1"></i> Recetas con Alimentos que aportan <?= esc($componente['nombre']) ?>
                                    </h6>
                                    <small class="text-muted">Recetas culinarias que incluyen ingredientes con este nutriente o lo destacan en su perfil.</small>
                                </div>
                                <a href="<?= base_url('recetacomponentenutricional/add?idcomponente=' . $componente['idcomponentenutricional']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i> Asignar Receta Directa
                                </a>
                            </div>

                            <?php if (empty($recetas)): ?>
                                <div class="text-center py-5 bg-light rounded-3 border">
                                    <i class="bi bi-journal-x text-secondary fs-1 d-block mb-2"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Sin recetas vinculadas</h6>
                                    <p class="text-muted small mb-3">No existen recetas que incluyan alimentos con este componente ni registradas directamente.</p>
                                    <a href="<?= base_url('recetacomponentenutricional/add?idcomponente=' . $componente['idcomponentenutricional']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-plus-lg me-1"></i> Asociar una receta
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th style="width: 70px;">ID</th>
                                                <th>Receta</th>
                                                <th style="width: 170px;">Tiempo & Porciones</th>
                                                <th>Alimentos en la Receta con este Nutriente</th>
                                                <th style="width: 150px;">Vía de Aporte</th>
                                                <th class="text-end" style="width: 120px;">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recetas as $rec): ?>
                                                <tr>
                                                    <td class="fw-bold text-muted">#<?= $rec['idreceta'] ?></td>
                                                    <td>
                                                        <a href="<?= base_url('receta/actual/' . $rec['idreceta']) ?>" class="fw-bold text-dark text-decoration-none d-inline-flex align-items-center">
                                                            <i class="bi bi-egg-fried text-warning me-2 fs-5"></i>
                                                            <?= esc($rec['receta_nombre']) ?>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1 small">
                                                            <?php if (!empty($rec['tiempopreparacion'])): ?>
                                                                <span class="text-muted"><i class="bi bi-clock me-1 text-primary"></i><?= esc($rec['tiempopreparacion']) ?> min</span>
                                                            <?php endif; ?>
                                                            <?php if (!empty($rec['porciones'])): ?>
                                                                <span class="text-muted"><i class="bi bi-pie-chart me-1 text-success"></i><?= esc($rec['porciones']) ?> <?= ($rec['porciones'] == 1) ? 'porción' : 'porciones' ?></span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($rec['alimentos'])): ?>
                                                            <div class="d-flex flex-wrap gap-1">
                                                                <?php foreach ($rec['alimentos'] as $aliRec): ?>
                                                                    <a href="<?= base_url('alimento/actual/' . $aliRec['idalimento']) ?>" 
                                                                       class="badge bg-success-subtle text-success-emphasis border border-success-subtle text-decoration-none py-1 px-2"
                                                                       title="Ver alimento <?= esc($aliRec['nombre']) ?>">
                                                                        <i class="bi bi-check-circle-fill text-success me-1"></i><?= esc($aliRec['nombre']) ?>
                                                                    </a>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            <span class="text-muted small fst-italic">Ingredientes no detallados en la receta</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column gap-1">
                                                            <?php if ($rec['por_ingredientes']): ?>
                                                                <span class="badge bg-success-subtle text-success border border-success-subtle py-1 px-2">
                                                                    <i class="bi bi-basket me-1"></i>Por Ingredientes (<?= $rec['total_alimentos_con_componente'] ?>)
                                                                </span>
                                                            <?php endif; ?>
                                                            <?php if ($rec['es_directa']): ?>
                                                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle py-1 px-2">
                                                                    <i class="bi bi-star-fill text-warning me-1"></i>Nutriente Clave
                                                                </span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-end">
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="<?= base_url('receta/actual/' . $rec['idreceta']) ?>" class="btn btn-outline-primary" title="Ver ficha de la receta">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <?php if ($rec['es_directa']): ?>
                                                                <a href="<?= base_url('recetacomponentenutricional/actual/' . $rec['idrecetacomponentenutricional']) ?>" class="btn btn-outline-secondary" title="Ver asignación directa">
                                                                    <i class="bi bi-link-45deg"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- TAB 3: IMÁGENES ASOCIADAS -->
                        <div class="tab-pane fade" id="imagenes-pane" role="tabpanel" aria-labelledby="imagenes-tab">
                            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3 pb-2 border-bottom">
                                <div>
                                    <h6 class="fw-bold mb-1 text-dark">
                                        <i class="bi bi-images text-info me-1"></i> Imágenes de <?= esc($componente['nombre']) ?>
                                    </h6>
                                    <small class="text-muted">Imágenes multimedia y recursos gráficos vinculados a este componente nutricional.</small>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="<?= base_url('imagencomponentenutricional/listar?idcomponente=' . $componente['idcomponentenutricional']) ?>" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-list-task me-1"></i> Gestionar en módulo
                                    </a>
                                    <button type="button" class="btn btn-sm btn-info text-white" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                                        <i class="bi bi-plus-circle me-1"></i> Asignar Imagen
                                    </button>
                                </div>
                            </div>

                            <?php if (empty($imagenes)): ?>
                                <div class="text-center py-5 bg-light rounded-3 border">
                                    <i class="bi bi-images text-secondary fs-1 d-block mb-2"></i>
                                    <h6 class="fw-bold text-secondary mb-1">Sin imágenes vinculadas</h6>
                                    <p class="text-muted small mb-3">Actualmente este componente nutricional no tiene imágenes asignadas.</p>
                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalAsignarImagen">
                                        <i class="bi bi-plus-lg me-1"></i> Asociar la primera imagen
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="row g-3">
                                    <?php foreach ($imagenes as $img): ?>
                                        <div class="col-sm-6 col-md-4 col-lg-3">
                                            <div class="card h-100 border shadow-sm hover-shadow">
                                                <div class="p-2 text-center bg-light border-bottom position-relative" style="height: 140px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                                    <?php if ($img['archivoExiste'] && !empty($img['urlImagen'])): ?>
                                                        <img src="<?= $img['urlImagen'] ?>" 
                                                             onerror="this.onerror=null; this.src='<?= !empty($img['urlFallback']) ? $img['urlFallback'] : base_url('imagen/imagen/' . esc($img['imagen_nombre'])) ?>';"
                                                             alt="<?= esc($img['imagen_nombre']) ?>" 
                                                             class="img-fluid rounded" 
                                                             style="max-height: 125px; object-fit: contain;">
                                                    <?php else: ?>
                                                        <div class="text-muted small">
                                                            <i class="bi bi-image fs-1 text-secondary d-block"></i>
                                                            <span>Sin archivo</span>
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
                                                                <a href="<?= $img['urlImagen'] ?>" target="_blank" class="btn btn-outline-primary btn-sm py-0 px-2" title="Abrir imagen">
                                                                    <i class="bi bi-box-arrow-up-right"></i>
                                                                </a>
                                                            <?php endif; ?>
                                                            <a href="<?= base_url('imagen/actual/' . $img['idimagen']) ?>" class="btn btn-outline-secondary btn-sm py-0 px-2" title="Ver ficha de imagen">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                        </div>
                                                        <form action="<?= base_url('componentenutricional/quitarImagen/' . $componente['idcomponentenutricional'] . '/' . $img['idimagen']) ?>" method="post" class="d-inline" onsubmit="return confirm('¿Desvincular esta imagen del componente?');">
                                                            <?= csrf_field() ?>
                                                            <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" title="Quitar de este componente">
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
            </div>

            <!-- Modal Rápido para Asignar Imagen -->
            <div class="modal fade" id="modalAsignarImagen" tabindex="-1" aria-labelledby="modalAsignarImagenLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="<?= base_url('componentenutricional/asignarImagen/' . $componente['idcomponentenutricional']) ?>" method="post">
                            <?= csrf_field() ?>
                            <div class="modal-header bg-info text-white">
                                <h5 class="modal-title" id="modalAsignarImagenLabel">
                                    <i class="bi bi-images me-2"></i>Asignar Imagen a <?= esc($componente['nombre']) ?>
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="modal_idimagen" class="form-label fw-bold">Seleccionar Imagen del Repositorio</label>
                                    <select name="idimagen" id="modal_idimagen" class="form-select" required>
                                        <option value="">-- Seleccionar imagen --</option>
                                        <?php foreach ($todasImagenes as $tImg): ?>
                                            <option value="<?= $tImg['idimagen'] ?>">
                                                #<?= $tImg['idimagen'] ?> - <?= esc($tImg['nombre']) ?> (<?= esc($tImg['directorio_ruta'] ?: 'repositorio/imagen') ?>)
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text text-muted">
                                        Seleccione una imagen existente o registre una nueva en el módulo <a href="<?= base_url('imagen/add') ?>" target="_blank">Imágenes</a>.
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-info text-white">
                                    <i class="bi bi-plus-circle me-1"></i> Asociar Imagen
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
