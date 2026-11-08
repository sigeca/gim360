<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($entretenimiento)): ?>
            <?= view('layout/empty_record', ['module' => 'entretenimiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'entretenimiento',
                'currentId' => $entretenimiento['identretenimiento']
            ]) ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Ficha Principal de Entretenimiento -->
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-controller text-primary me-2 fs-4"></i>Entretenimiento: <?= esc($entretenimiento['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <a href="<?= base_url('mientretenimiento/add?identretenimiento=' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-info text-dark fw-bold shadow-sm" title="Guardar y personalizar esta lista para una persona">
                            <i class="bi bi-person-check-fill me-1"></i>Personalizar en Mi Entretenimiento
                        </a>
                        <span class="badge bg-primary text-white fs-6">ID #<?= $entretenimiento['identretenimiento'] ?></span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-stars fs-1"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-1"><?= esc($entretenimiento['nombre']) ?></h5>
                                <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-music-note-beamed me-1"></i><?= count($entretenimiento['musicas'] ?? []) ?> Músicas</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><i class="bi bi-camera-reels me-1"></i><?= count($entretenimiento['videos'] ?? []) ?> Videos</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-joystick me-1"></i><?= count($entretenimiento['juegos'] ?? []) ?> Juegos</span>
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle"><i class="bi bi-mic me-1"></i><?= count($entretenimiento['podcasts'] ?? []) ?> Podcasts</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Entretenimiento</th>
                                        <td class="fw-bold text-secondary">#<?= $entretenimiento['identretenimiento'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre</th>
                                        <td class="fs-5 fw-bold text-dark"><?= esc($entretenimiento['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Descripción</th>
                                        <td class="text-secondary">
                                            <?= !empty($entretenimiento['descripcion']) ? nl2br(esc($entretenimiento['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1. Músicas Relacionadas -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-danger">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-music-note-beamed text-danger me-2"></i>Músicas Relacionadas (<code>entretenimientomusica</code>)
                        <span class="badge bg-danger ms-1"><?= count($entretenimiento['musicas'] ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientomusica/add?identretenimiento=' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-outline-danger">
                        <i class="bi bi-plus-circle me-1"></i>Vincular Música
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimiento['musicas'])): ?>
                        <div class="p-3 text-center text-muted small">No hay músicas vinculadas a este registro de entretenimiento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Música</th>
                                        <th>Artista / Género</th>
                                        <th>Enlace</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entretenimiento['musicas'] as $m): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $m['identretenimientomusica'] ?></td>
                                            <td>
                                                <a href="<?= base_url('musica/actual/' . $m['idmusica']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($m['musica_nombre']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-secondary small"><?= esc($m['musica_artista'] ?: '-') ?></span>
                                                <?php if (!empty($m['musica_genero'])): ?>
                                                    <span class="badge bg-light text-dark border ms-1"><?= esc($m['musica_genero']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= esc($m['musica_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-play-circle-fill me-1"></i>Escuchar
                                                </a>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('entretenimientomusica/actual/' . $m['identretenimientomusica']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('entretenimientomusica/delete/' . $m['identretenimientomusica']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Desvincular esta música?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 2. Videos Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-camera-reels-fill text-primary me-2"></i>Videos Relacionados (<code>entretenimientovideo</code>)
                        <span class="badge bg-primary ms-1"><?= count($entretenimiento['videos'] ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientovideo/add?identretenimiento=' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-plus-circle me-1"></i>Vincular Video
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimiento['videos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay videos vinculados a este registro de entretenimiento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Video</th>
                                        <th>Autor / Categoría</th>
                                        <th>Enlace</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entretenimiento['videos'] as $v): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $v['identretenimientovideo'] ?></td>
                                            <td>
                                                <a href="<?= base_url('video/actual/' . $v['idvideo']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($v['video_nombre']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-secondary small"><?= esc($v['video_autor'] ?: '-') ?></span>
                                                <?php if (!empty($v['video_categoria'])): ?>
                                                    <span class="badge bg-light text-dark border ms-1"><?= esc($v['video_categoria']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= esc($v['video_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-play-btn-fill me-1"></i>Ver Video
                                                </a>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('entretenimientovideo/actual/' . $v['identretenimientovideo']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('entretenimientovideo/delete/' . $v['identretenimientovideo']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Desvincular este video?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 3. Juegos Tradicionales Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-success">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-joystick text-success me-2"></i>Juegos Tradicionales Relacionados (<code>entretenimientojuego</code>)
                        <span class="badge bg-success ms-1"><?= count($entretenimiento['juegos'] ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientojuego/add?identretenimiento=' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-outline-success">
                        <i class="bi bi-plus-circle me-1"></i>Vincular Juego
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimiento['juegos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay juegos vinculados a este registro de entretenimiento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Juego Tradicional</th>
                                        <th>Categoría</th>
                                        <th>Enlace</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entretenimiento['juegos'] as $j): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $j['identretenimientojuego'] ?></td>
                                            <td>
                                                <a href="<?= base_url('juego/actual/' . $j['idjuego']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($j['juego_nombre']) ?>
                                                </a>
                                            </td>
                                            <td><span class="badge bg-success-subtle text-success border border-success-subtle"><?= esc($j['juego_categoria'] ?: 'Tradicional') ?></span></td>
                                            <td>
                                                <a href="<?= esc($j['juego_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-success">
                                                    <i class="bi bi-controller me-1"></i>Jugar Ahora
                                                </a>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('entretenimientojuego/actual/' . $j['identretenimientojuego']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('entretenimientojuego/delete/' . $j['identretenimientojuego']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Desvincular este juego?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- 4. Podcasts Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-mic-fill text-warning me-2"></i>Podcasts Relacionados (<code>entretenimientopodcast</code>)
                        <span class="badge bg-warning text-dark ms-1"><?= count($entretenimiento['podcasts'] ?? []) ?></span>
                    </h6>
                    <a href="<?= base_url('entretenimientopodcast/add?identretenimiento=' . $entretenimiento['identretenimiento']) ?>" class="btn btn-sm btn-outline-warning text-dark">
                        <i class="bi bi-plus-circle me-1"></i>Vincular Podcast
                    </a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($entretenimiento['podcasts'])): ?>
                        <div class="p-3 text-center text-muted small">No hay podcasts vinculados a este registro de entretenimiento.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light small">
                                    <tr>
                                        <th class="ps-3">ID Rel.</th>
                                        <th>Podcast</th>
                                        <th>Presentador / Tema</th>
                                        <th>Enlace</th>
                                        <th class="text-end pe-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entretenimiento['podcasts'] as $p): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $p['identretenimientopodcast'] ?></td>
                                            <td>
                                                <a href="<?= base_url('podcast/actual/' . $p['idpodcast']) ?>" class="fw-bold text-dark text-decoration-none">
                                                    <?= esc($p['podcast_nombre']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="text-secondary small"><?= esc($p['podcast_presentador'] ?: '-') ?></span>
                                                <?php if (!empty($p['podcast_tema'])): ?>
                                                    <span class="badge bg-warning-subtle text-dark border border-warning ms-1"><?= esc($p['podcast_tema']) ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="<?= esc($p['podcast_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-warning text-dark fw-semibold">
                                                    <i class="bi bi-headphones me-1"></i>Escuchar Podcast
                                                </a>
                                            </td>
                                            <td class="text-end pe-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('entretenimientopodcast/actual/' . $p['identretenimientopodcast']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('entretenimientopodcast/delete/' . $p['identretenimientopodcast']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Desvincular este podcast?');"><i class="bi bi-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
