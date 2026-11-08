<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1 d-flex align-items-center">
                        <i class="bi bi-music-note-beamed text-danger me-2 fs-3"></i>Catálogo de Música
                    </h4>
                    <p class="text-muted small mb-0">Enlaces a pistas musicales y listas de reproducción para entrenamiento y relajación.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('musica/listar') ?>" method="get" class="d-flex align-items-center gap-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar música, artista, género..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if (!empty($search)): ?>
                                <a href="<?= base_url('musica/listar') ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <a href="<?= base_url('musica/add') ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Música
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
                            <th>Nombre / Canción</th>
                            <th>Artista</th>
                            <th>Género</th>
                            <th>Enlace</th>
                            <th class="text-center">Entretenimientos</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($musicas)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">No se encontraron registros de música.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($musicas as $m): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $m['idmusica'] ?></td>
                                    <td>
                                        <a href="<?= base_url('musica/actual/' . $m['idmusica']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <?= esc($m['nombre']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($m['artista'] ?: '-') ?></td>
                                    <td><span class="badge bg-danger-subtle text-danger border"><?= esc($m['genero'] ?: 'General') ?></span></td>
                                    <td>
                                        <a href="<?= esc($m['enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-play-circle-fill me-1"></i>Escuchar
                                        </a>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary"><?= (int)($m['total_entretenimientos'] ?? 0) ?></span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('musica/actual/' . $m['idmusica']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('musica/edit/' . $m['idmusica']) ?>" class="btn btn-outline-warning text-dark"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('musica/delete/' . $m['idmusica']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar esta música?');"><i class="bi bi-trash"></i></a>
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
