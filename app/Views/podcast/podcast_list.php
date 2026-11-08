<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-mic-fill text-warning me-2 fs-3"></i>Catálogo de Podcasts
                    </h4>
                    <p class="text-muted small mb-0">Enlaces a podcasts sobre nutrición, salud, deporte, motivación y bienestar.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('podcast/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar podcast, presentador, tema..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('podcast/listar') ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <a href="<?= base_url('podcast/add') ?>" class="btn btn-warning text-dark fw-semibold btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Podcast
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
                            <th>Nombre del Podcast</th>
                            <th>Presentador</th>
                            <th>Tema</th>
                            <th>Enlace</th>
                            <th class="text-center">Entretenimientos</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($podcasts)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No se encontraron podcasts registrados.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($podcasts as $p): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $p['idpodcast'] ?></td>
                                    <td>
                                        <a href="<?= base_url('podcast/actual/' . $p['idpodcast']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($p['nombre']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($p['presentador'] ?: '-') ?></td>
                                    <td><span class="badge bg-warning-subtle text-dark border border-warning"><?= esc($p['tema'] ?: 'Bienestar') ?></span></td>
                                    <td>
                                        <a href="<?= esc($p['enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-warning text-dark">
                                            <i class="bi bi-headphones me-1"></i>Escuchar
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= (int)($p['total_entretenimientos'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('podcast/actual/' . $p['idpodcast']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('podcast/edit/' . $p['idpodcast']) ?>" class="btn btn-outline-warning text-dark"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('podcast/delete/' . $p['idpodcast']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar este podcast?');"><i class="bi bi-trash"></i></a>
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
