<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-camera-reels-fill text-primary me-2 fs-3"></i>Catálogo de Videos
                    </h4>
                    <p class="text-muted small mb-0">Enlaces a videos educativos, demostrativos y motivacionales de la sección de entretenimiento.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('video/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar video, autor, categoría..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('video/listar') ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <a href="<?= base_url('video/add') ?>" class="btn btn-primary btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Video
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
                            <th class="ps-4" style="width: 75px;">ID</th>
                            <th>Nombre del Video</th>
                            <th>Autor / Canal</th>
                            <th>Categoría</th>
                            <th>Enlace</th>
                            <th class="text-center">Entretenimientos</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($videos)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No se encontraron videos registrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($videos as $v): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $v['idvideo'] ?></td>
                                    <td>
                                        <a href="<?= base_url('video/actual/' . $v['idvideo']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($v['nombre']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($v['autor'] ?: '-') ?></td>
                                    <td><span class="badge bg-primary-subtle text-primary border"><?= esc($v['categoria'] ?: 'General') ?></span></td>
                                    <td>
                                        <a href="<?= esc($v['enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-play-btn-fill me-1"></i>Ver Video
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= (int)($v['total_entretenimientos'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('video/actual/' . $v['idvideo']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('video/edit/' . $v['idvideo']) ?>" class="btn btn-outline-warning text-dark"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('video/delete/' . $v['idvideo']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar este video?');"><i class="bi bi-trash"></i></a>
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
