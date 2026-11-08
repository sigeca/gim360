<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <div class="card card-custom bg-white shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1"><i class="bi bi-music-note-list text-danger me-2"></i>Relación Entretenimiento - Música</h4>
                    <p class="text-muted small mb-0">Asignación de pistas y listas musicales a cada registro de entretenimiento.</p>
                </div>

                <div class="d-flex flex-wrap align-items-center gap-2">
                    <form action="<?= base_url('entretenimientomusica/listar') ?>" method="get" class="d-flex flex-wrap align-items-center gap-2">
                        <select name="identretenimiento" class="form-select form-select-sm" style="max-width: 220px;" onchange="this.form.submit()">
                            <option value="">-- Todos los Entretenimientos --</option>
                            <?php foreach ($entretenimientos as $ent): ?>
                                <option value="<?= $ent['identretenimiento'] ?>" <?= ($selectedEntretenimiento == $ent['identretenimiento']) ? 'selected' : '' ?>>
                                    <?= esc($ent['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="input-group input-group-sm">
                            <input type="text" name="q" class="form-control" placeholder="Buscar..." value="<?= esc($search ?? '') ?>">
                            <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                            <?php if (!empty($search) || !empty($selectedEntretenimiento)): ?>
                                <a href="<?= base_url('entretenimientomusica/listar') ?>" class="btn btn-outline-secondary"><i class="bi bi-x-lg"></i></a>
                            <?php endif; ?>
                        </div>
                    </form>
                    <a href="<?= base_url('entretenimientomusica/add' . (!empty($selectedEntretenimiento) ? '?identretenimiento=' . $selectedEntretenimiento : '')) ?>" class="btn btn-danger btn-sm">
                        <i class="bi bi-plus-circle me-1"></i> Vincular Música
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
                            <th>Entretenimiento</th>
                            <th>Música</th>
                            <th>Artista / Género</th>
                            <th>Enlace</th>
                            <th class="text-end pe-4" style="width: 150px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($listado)): ?>
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No se encontraron relaciones registradas.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($listado as $item): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-muted">#<?= $item['identretenimientomusica'] ?></td>
                                    <td>
                                        <a href="<?= base_url('entretenimiento/actual/' . $item['identretenimiento']) ?>" class="fw-bold text-dark text-decoration-none">
                                            <i class="bi bi-controller text-primary me-1"></i><?= esc($item['entretenimiento_nombre']) ?>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('musica/actual/' . $item['idmusica']) ?>" class="fw-bold text-danger text-decoration-none">
                                            <i class="bi bi-music-note-beamed me-1"></i><?= esc($item['musica_nombre']) ?>
                                        </a>
                                    </td>
                                    <td class="small text-secondary"><?= esc($item['musica_artista'] ?: '-') ?> <?= !empty($item['musica_genero']) ? '(' . esc($item['musica_genero']) . ')' : '' ?></td>
                                    <td>
                                        <a href="<?= esc($item['musica_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-play-circle-fill me-1"></i>Escuchar
                                        </a>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?= base_url('entretenimientomusica/actual/' . $item['identretenimientomusica']) ?>" class="btn btn-outline-primary"><i class="bi bi-eye"></i></a>
                                            <a href="<?= base_url('entretenimientomusica/edit/' . $item['identretenimientomusica']) ?>" class="btn btn-outline-warning text-dark"><i class="bi bi-pencil-square"></i></a>
                                            <a href="<?= base_url('entretenimientomusica/delete/' . $item['identretenimientomusica']) ?>" class="btn btn-outline-danger" onclick="return confirm('¿Eliminar esta relación?');"><i class="bi bi-trash"></i></a>
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
