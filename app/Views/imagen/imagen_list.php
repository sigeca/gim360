<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Encabezado con buscador y botón de nuevo -->
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-images text-primary me-2 fs-3"></i>Catálogo de Imágenes
                    </h4>
                    <p class="text-muted small mb-0">Gestión de imágenes y archivos multimedia almacenados en <code>repositorio/imagen/</code> con nomenclatura SICA.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('imagen/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar por nombre, tag o descripción..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('imagen/listar') ?>" class="btn btn-outline-secondary" title="Limpiar búsqueda">
                                    <i class="bi bi-x-lg"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('imagen/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Imagen
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

    <!-- Tabla de Registros -->
    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 70px;">ID</th>
                            <th style="width: 90px;">Miniatura</th>
                            <th>Nombre de Archivo</th>
                            <th>Formato</th>
                            <th>Descripción</th>
                            <th>Fecha Captura</th>
                            <th>Estado en Disco</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($imagenes)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-image fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron imágenes registradas en el sistema.
                                    <div class="mt-3">
                                        <a href="<?= base_url('imagen/add') ?>" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-plus-lg me-1"></i>Registrar la primera imagen
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($imagenes as $img): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $img['idimagen'] ?></td>
                                    <td>
                                        <?php if ($img['archivoExiste'] && !empty($img['urlImagen'])): ?>
                                            <img src="<?= $img['urlImagen'] ?>" alt="Thumb" class="rounded border shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                        <?php else: ?>
                                            <div class="rounded bg-light border d-flex align-items-center justify-content-center text-muted" style="width: 50px; height: 50px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('imagen/actual/' . $img['idimagen']) ?>" class="fw-semibold text-dark text-decoration-none hover-primary">
                                            <span class="font-monospace"><?= esc($img['nombre'] ?: 'Sin nombre') ?></span>
                                        </a>
                                        <?php if (!empty($img['licencia'])): ?>
                                            <span class="d-block text-muted small" style="font-size: 0.75rem;"><?= esc($img['licencia']) ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($img['formato_nombre'])): ?>
                                            <span class="badge bg-info-subtle text-info border border-info font-monospace text-uppercase">
                                                <?= esc($img['formato_nombre']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted small">-</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="small text-secondary">
                                        <?= !empty($img['descripcion']) ? esc(mb_strimwidth($img['descripcion'], 0, 70, '...')) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                    </td>
                                    <td class="small text-muted">
                                        <?= !empty($img['fechacaptura']) ? esc(substr($img['fechacaptura'], 0, 10)) : '-' ?>
                                    </td>
                                    <td>
                                        <?php if ($img['archivoExiste']): ?>
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
                                            <a href="<?= base_url('imagen/actual/' . $img['idimagen']) ?>" class="btn btn-outline-primary" title="Ver ficha">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="<?= base_url('imagen/edit/' . $img['idimagen']) ?>" class="btn btn-outline-warning text-dark" title="Editar">
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
