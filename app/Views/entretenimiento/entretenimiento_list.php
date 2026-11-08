<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-controller text-primary me-2 fs-3"></i>Catálogo de Entretenimiento
                    </h4>
                    <p class="text-muted small mb-0">Gestión de secciones y paquetes de entretenimiento que agrupan música, videos, juegos tradicionales y podcasts.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('entretenimiento/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar entretenimiento..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('entretenimiento/listar') ?>" class="btn btn-outline-secondary" title="Limpiar"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>

                    <a href="<?= base_url('entretenimiento/add') ?>" class="btn btn-success btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Entretenimiento
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom bg-white shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4" style="width: 80px;">ID</th>
                            <th>Nombre del Entretenimiento</th>
                            <th>Descripción</th>
                            <th class="text-center">Contenido Vinculado</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($entretenimientos)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-controller fs-1 d-block mb-2"></i>
                                    No se encontraron registros de entretenimiento.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($entretenimientos as $item): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $item['identretenimiento'] ?></td>
                                    <td>
                                        <a href="<?= base_url('entretenimiento/actual/' . $item['identretenimiento']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($item['nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="text-secondary small"><?= esc($item['descripcion'] ?: '-') ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-danger-subtle text-danger border me-1" title="Músicas"><i class="bi bi-music-note-beamed me-1"></i><?= (int)($item['total_musicas'] ?? 0) ?></span>
                                        <span class="badge bg-primary-subtle text-primary border me-1" title="Videos"><i class="bi bi-camera-reels me-1"></i><?= (int)($item['total_videos'] ?? 0) ?></span>
                                        <span class="badge bg-success-subtle text-success border me-1" title="Juegos"><i class="bi bi-joystick me-1"></i><?= (int)($item['total_juegos'] ?? 0) ?></span>
                                        <span class="badge bg-warning-subtle text-dark border" title="Podcasts"><i class="bi bi-mic me-1"></i><?= (int)($item['total_podcasts'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('mientretenimiento/add?identretenimiento=' . $item['identretenimiento']) ?>" class="btn btn-outline-info" title="Personalizar en Mi Entretenimiento"><i class="bi bi-person-check"></i></a>
                                            <a href="<?= base_url('entretenimiento/actual/' . $item['identretenimiento']) ?>" class="btn btn-outline-primary" title="Ver ficha"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('entretenimiento/edit/' . $item['identretenimiento']) ?>" class="btn btn-outline-warning text-dark" title="Editar"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('entretenimiento/delete/' . $item['identretenimiento']) ?>" class="btn btn-outline-danger" title="Eliminar" onclick="return confirm('¿Eliminar este entretenimiento?');"><i class="bi bi-trash"></i></a>
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
