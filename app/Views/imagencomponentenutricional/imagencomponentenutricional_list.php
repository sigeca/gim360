<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y filtros -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-images text-info me-2 fs-3"></i>Imágenes por Componente Nutricional
                    </h4>
                    <p class="text-muted small mb-0">Gestión de la vinculación entre imágenes del repositorio y componentes nutricionales.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('imagencomponentenutricional/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        
                        <!-- Filtro por Componente Nutricional -->
                        <select name="idcomponente" class="form-select form-select-sm" style="max-width: 200px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Componentes --</option>
                            <?php foreach ($componentes as $comp): ?>
                                <option value="<?= $comp['idcomponentenutricional'] ?>" <?= ($selectedComponente == $comp['idcomponentenutricional']) ? 'selected' : '' ?>>
                                    <?= esc($comp['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <!-- Buscador por texto -->
                        <div class="input-group input-group-sm" style="max-width: 250px;">
                            <input type="text" name="q" class="form-control" placeholder="Buscar por componente o archivo..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search) || !empty($selectedComponente) || !empty($selectedImagen)): ?>
                                <a href="<?= base_url('imagencomponentenutricional/listar') ?>" class="btn btn-outline-secondary" title="Limpiar filtros">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('imagencomponentenutricional/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Asignar Imagen
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensajes Flash -->
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
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th style="width: 80px;">Miniatura</th>
                            <th>Componente Nutricional</th>
                            <th>Archivo de Imagen</th>
                            <th>Directorio</th>
                            <th>Descripción</th>
                            <th>Estado en Disco</th>
                            <th class="text-end pe-4" style="width: 140px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listado)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-images fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron relaciones registradas.
                                    <div class="mt-3">
                                        <a href="<?= base_url('imagencomponentenutricional/add') ?>" class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-plus-lg me-1"></i>Asignar la primera imagen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listado as $item): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $item['idimagencomponentenutricional'] ?></td>
                                    <td>
                                        <?php if (!empty($item['urlImagen']) && $item['archivoExiste']): ?>
                                            <img src="<?= $item['urlImagen'] ?>" 
                                                 onerror="this.onerror=null; this.src='<?= !empty($item['urlFallback']) ? $item['urlFallback'] : base_url('imagen/imagen/' . esc($item['imagen_nombre'])) ?>';"
                                                 alt="Thumb" class="rounded border shadow-sm" style="width: 48px; height: 48px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted" style="width: 48px; height: 48px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('componentenutricional/actual/' . $item['idcomponentenutricional']) ?>" class="fw-bold text-dark text-decoration-none hover-primary">
                                            <i class="bi bi-pie-chart-fill text-info me-1"></i><?= esc($item['componente_nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('imagen/actual/' . $item['idimagen']) ?>" class="font-monospace small text-decoration-none text-dark">
                                            <?= esc($item['imagen_nombre']) ?>
                                        </a>
                                        <?php if (!empty($item['formato_nombre'])): ?>
                                            <span class="badge bg-secondary-subtle text-secondary border font-monospace ms-1" style="font-size: 0.65rem;">
                                                <?= strtoupper(esc($item['formato_nombre'])) ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="d-inline-flex align-items-center gap-1 small">
                                            <i class="bi bi-folder text-warning"></i>
                                            <code><?= esc($item['directorio_ruta'] ?: 'repositorio/imagen') ?></code>
                                        </span>
                                    </td>
                                    <td class="small text-secondary">
                                        <?= !empty($item['imagen_descripcion']) ? esc(mb_strimwidth($item['imagen_descripcion'], 0, 50, '...')) : '<span class="text-muted fst-italic">-</span>' ?>
                                    </td>
                                    <td>
                                        <?php if ($item['archivoExiste']): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle">
                                                <i class="bi bi-check-circle me-1"></i>En Disco
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle">
                                                <i class="bi bi-dash-circle me-1"></i>Sin Archivo
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('imagencomponentenutricional/actual/' . $item['idimagencomponentenutricional']) ?>" class="btn btn-outline-primary" title="Ver ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('imagencomponentenutricional/edit/' . $item['idimagencomponentenutricional']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
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

</div>

<?= $this->endSection() ?>
