<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-10">

        <?php if (empty($mientretenimiento)): ?>
            <?= view('layout/empty_record', ['module' => 'mientretenimiento']) ?>
        <?php else: ?>

            <!-- Menú Superior de Navegación y Gestión -->
            <?= view('layout/nav_toolbar', [
                'module'    => 'mientretenimiento',
                'currentId' => $mientretenimiento['idmientretenimiento']
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

            <!-- Ficha Principal de Mi Entretenimiento -->
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-person-heart text-info me-2 fs-4"></i>Mi Entretenimiento: <?= esc($mientretenimiento['nombre']) ?>
                    </h5>
                    <div class="d-flex align-items-center gap-2">
                        <?php if (!empty($mientretenimiento['identretenimiento'])): ?>
                            <a href="<?= base_url('entretenimiento/actual/' . $mientretenimiento['identretenimiento']) ?>" class="badge bg-light text-primary border text-decoration-none" title="Ver entretenimiento base">
                                <i class="bi bi-controller me-1"></i>Base: <?= esc($mientretenimiento['base_entretenimiento_nombre'] ?: ('#' . $mientretenimiento['identretenimiento'])) ?>
                            </a>
                        <?php endif; ?>
                        <span class="badge bg-info text-dark fs-6">ID #<?= $mientretenimiento['idmientretenimiento'] ?></span>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4 align-items-center">
                        <div class="col-md-4 text-center">
                            <div class="p-4 bg-light rounded-4 border shadow-sm">
                                <div class="rounded-circle bg-info bg-opacity-10 text-info d-inline-flex align-items-center justify-content-center mb-3" style="width: 85px; height: 85px;">
                                    <i class="bi bi-person-circle fs-1"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">
                                    <a href="<?= base_url('persona/actual/' . $mientretenimiento['idpersona']) ?>" class="text-dark text-decoration-none">
                                        <?= esc($mientretenimiento['persona_apellidos'] . ' ' . $mientretenimiento['persona_nombres']) ?>
                                    </a>
                                </h6>
                                <p class="text-muted small mb-2"><i class="bi bi-card-text me-1"></i>C.I. <?= esc($mientretenimiento['persona_cedula'] ?: '-') ?></p>

                                <div class="d-flex flex-wrap justify-content-center gap-1 mt-2">
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle"><i class="bi bi-music-note-beamed me-1"></i><?= count($mientretenimiento['musicas'] ?? []) ?> Músicas</span>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle"><i class="bi bi-camera-reels me-1"></i><?= count($mientretenimiento['videos'] ?? []) ?> Videos</span>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle"><i class="bi bi-joystick me-1"></i><?= count($mientretenimiento['juegos'] ?? []) ?> Juegos</span>
                                    <span class="badge bg-warning-subtle text-dark border border-warning-subtle"><i class="bi bi-mic me-1"></i><?= count($mientretenimiento['podcasts'] ?? []) ?> Podcasts</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <table class="table table-bordered align-middle mb-0">
                                <tbody>
                                    <tr>
                                        <th class="table-light w-35 text-muted">ID Registro</th>
                                        <td class="fw-bold text-secondary">#<?= $mientretenimiento['idmientretenimiento'] ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Persona Propietaria</th>
                                        <td class="fs-6 fw-bold text-dark">
                                            <a href="<?= base_url('persona/actual/' . $mientretenimiento['idpersona']) ?>" class="text-decoration-none">
                                                <i class="bi bi-person-badge me-1"></i><?= esc($mientretenimiento['persona_apellidos'] . ' ' . $mientretenimiento['persona_nombres']) ?>
                                            </a>
                                            <span class="badge bg-secondary ms-1">C.I. <?= esc($mientretenimiento['persona_cedula']) ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Nombre de la Lista</th>
                                        <td class="fs-5 fw-bold text-primary"><?= esc($mientretenimiento['nombre']) ?></td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Entretenimiento Base</th>
                                        <td>
                                            <?php if (!empty($mientretenimiento['identretenimiento'])): ?>
                                                <a href="<?= base_url('entretenimiento/actual/' . $mientretenimiento['identretenimiento']) ?>" class="badge bg-primary-subtle text-primary border border-primary-subtle text-decoration-none fs-6">
                                                    <i class="bi bi-controller me-1"></i><?= esc($mientretenimiento['base_entretenimiento_nombre']) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted fst-italic">Creado desde cero (Sin plantilla base)</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="table-light text-muted">Descripción Personal</th>
                                        <td class="text-secondary">
                                            <?= !empty($mientretenimiento['descripcion']) ? nl2br(esc($mientretenimiento['descripcion'])) : '<span class="text-muted fst-italic">Sin descripción</span>' ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 1. Mi Música Relacionada -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-danger">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-music-note-beamed text-danger me-2"></i>Mi Música (<code>mientretenimientomusica</code>)
                        <span class="badge bg-danger ms-1"><?= count($mientretenimiento['musicas'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="collapse" data-bs-target="#boxSumarMusica">
                        <i class="bi bi-plus-circle me-1"></i>+ Sumar Música
                    </button>
                </div>

                <!-- Formulario desplegable para sumar música directamente -->
                <div class="collapse p-3 bg-light border-bottom" id="boxSumarMusica">
                    <form action="<?= base_url('mientretenimiento/agregarMusica/' . $mientretenimiento['idmientretenimiento']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Elegir del catálogo existente:</label>
                                <select name="idmusica" class="form-select form-select-sm">
                                    <option value="">-- Seleccionar Música Existente --</option>
                                    <?php foreach ($catalogoMusicas as $cm): ?>
                                        <option value="<?= $cm['idmusica'] ?>"><?= esc($cm['nombre']) ?><?= !empty($cm['artista']) ? ' (' . esc($cm['artista']) . ')' : '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-check-lg me-1"></i>Sumar Existente</button>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-muted small">-- O registrar un nuevo enlace de música --</div>
                        <div class="row g-2 mt-1">
                            <div class="col-md-4">
                                <input type="text" name="nuevo_nombre" class="form-control form-control-sm" placeholder="Título de la canción">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nuevo_artista" class="form-control form-control-sm" placeholder="Artista / Banda">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="nuevo_enlace" class="form-control" placeholder="Enlace YouTube, Spotify, MP3...">
                                    <button type="submit" class="btn btn-outline-danger"><i class="bi bi-plus-lg"></i> Crear y Sumar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($mientretenimiento['musicas'])): ?>
                        <div class="p-3 text-center text-muted small">No hay músicas vinculadas a esta lista personal.</div>
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
                                    <?php foreach ($mientretenimiento['musicas'] as $m): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $m['idmientretenimientomusica'] ?></td>
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
                                                    <a href="<?= base_url('mientretenimientomusica/actual/' . $m['idmientretenimientomusica']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('mientretenimientomusica/delete/' . $m['idmientretenimientomusica']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Quitar esta música de tu lista?');"><i class="bi bi-trash"></i></a>
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

            <!-- 2. Mis Videos Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-primary">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-camera-reels-fill text-primary me-2"></i>Mis Videos (<code>mientretenimientovideo</code>)
                        <span class="badge bg-primary ms-1"><?= count($mientretenimiento['videos'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="collapse" data-bs-target="#boxSumarVideo">
                        <i class="bi bi-plus-circle me-1"></i>+ Sumar Video
                    </button>
                </div>

                <div class="collapse p-3 bg-light border-bottom" id="boxSumarVideo">
                    <form action="<?= base_url('mientretenimiento/agregarVideo/' . $mientretenimiento['idmientretenimiento']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Elegir del catálogo existente:</label>
                                <select name="idvideo" class="form-select form-select-sm">
                                    <option value="">-- Seleccionar Video Existente --</option>
                                    <?php foreach ($catalogoVideos as $cv): ?>
                                        <option value="<?= $cv['idvideo'] ?>"><?= esc($cv['nombre']) ?><?= !empty($cv['categoria']) ? ' [' . esc($cv['categoria']) . ']' : '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-check-lg me-1"></i>Sumar Existente</button>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-muted small">-- O registrar un nuevo enlace de video --</div>
                        <div class="row g-2 mt-1">
                            <div class="col-md-4">
                                <input type="text" name="nuevo_nombre" class="form-control form-control-sm" placeholder="Título del video">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nuevo_categoria" class="form-control form-control-sm" placeholder="Categoría (Técnica, Motivación...)">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="nuevo_enlace" class="form-control" placeholder="Enlace YouTube, Vimeo...">
                                    <button type="submit" class="btn btn-outline-primary"><i class="bi bi-plus-lg"></i> Crear y Sumar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($mientretenimiento['videos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay videos vinculados a esta lista personal.</div>
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
                                    <?php foreach ($mientretenimiento['videos'] as $v): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $v['idmientretenimientovideo'] ?></td>
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
                                                    <a href="<?= base_url('mientretenimientovideo/actual/' . $v['idmientretenimientovideo']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('mientretenimientovideo/delete/' . $v['idmientretenimientovideo']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Quitar este video de tu lista?');"><i class="bi bi-trash"></i></a>
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

            <!-- 3. Mis Juegos Tradicionales Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-success">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-joystick text-success me-2"></i>Mis Juegos Tradicionales (<code>mientretenimientojuego</code>)
                        <span class="badge bg-success ms-1"><?= count($mientretenimiento['juegos'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-success" data-bs-toggle="collapse" data-bs-target="#boxSumarJuego">
                        <i class="bi bi-plus-circle me-1"></i>+ Sumar Juego
                    </button>
                </div>

                <div class="collapse p-3 bg-light border-bottom" id="boxSumarJuego">
                    <form action="<?= base_url('mientretenimiento/agregarJuego/' . $mientretenimiento['idmientretenimiento']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Elegir del catálogo existente:</label>
                                <select name="idjuego" class="form-select form-select-sm">
                                    <option value="">-- Seleccionar Juego Existente --</option>
                                    <?php foreach ($catalogoJuegos as $cj): ?>
                                        <option value="<?= $cj['idjuego'] ?>"><?= esc($cj['nombre']) ?><?= !empty($cj['categoria']) ? ' [' . esc($cj['categoria']) . ']' : '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-sm btn-success"><i class="bi bi-check-lg me-1"></i>Sumar Existente</button>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-muted small">-- O registrar un nuevo juego básico/tradicional --</div>
                        <div class="row g-2 mt-1">
                            <div class="col-md-4">
                                <input type="text" name="nuevo_nombre" class="form-control form-control-sm" placeholder="Nombre del juego (Ajedrez, Damas...)">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nuevo_categoria" class="form-control form-control-sm" placeholder="Categoría (Tablero, Cartas...)">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="nuevo_enlace" class="form-control" placeholder="Enlace web del juego...">
                                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-plus-lg"></i> Crear y Sumar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($mientretenimiento['juegos'])): ?>
                        <div class="p-3 text-center text-muted small">No hay juegos vinculados a esta lista personal.</div>
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
                                    <?php foreach ($mientretenimiento['juegos'] as $j): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $j['idmientretenimientojuego'] ?></td>
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
                                                    <a href="<?= base_url('mientretenimientojuego/actual/' . $j['idmientretenimientojuego']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('mientretenimientojuego/delete/' . $j['idmientretenimientojuego']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Quitar este juego de tu lista?');"><i class="bi bi-trash"></i></a>
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

            <!-- 4. Mis Podcasts Relacionados -->
            <div class="card card-custom bg-white shadow-sm mb-4 border-start border-4 border-warning">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom flex-wrap gap-2">
                    <h6 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-mic-fill text-warning me-2"></i>Mis Podcasts (<code>mientretenimientopodcast</code>)
                        <span class="badge bg-warning text-dark ms-1"><?= count($mientretenimiento['podcasts'] ?? []) ?></span>
                    </h6>
                    <button type="button" class="btn btn-sm btn-warning text-dark fw-semibold" data-bs-toggle="collapse" data-bs-target="#boxSumarPodcast">
                        <i class="bi bi-plus-circle me-1"></i>+ Sumar Podcast
                    </button>
                </div>

                <div class="collapse p-3 bg-light border-bottom" id="boxSumarPodcast">
                    <form action="<?= base_url('mientretenimiento/agregarPodcast/' . $mientretenimiento['idmientretenimiento']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Elegir del catálogo existente:</label>
                                <select name="idpodcast" class="form-select form-select-sm">
                                    <option value="">-- Seleccionar Podcast Existente --</option>
                                    <?php foreach ($catalogoPodcasts as $cp): ?>
                                        <option value="<?= $cp['idpodcast'] ?>"><?= esc($cp['nombre']) ?><?= !empty($cp['tema']) ? ' [' . esc($cp['tema']) . ']' : '' ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 text-end">
                                <button type="submit" class="btn btn-sm btn-warning text-dark fw-bold"><i class="bi bi-check-lg me-1"></i>Sumar Existente</button>
                            </div>
                        </div>
                        <div class="mt-2 text-center text-muted small">-- O registrar un nuevo podcast --</div>
                        <div class="row g-2 mt-1">
                            <div class="col-md-4">
                                <input type="text" name="nuevo_nombre" class="form-control form-control-sm" placeholder="Título del Podcast">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="nuevo_tema" class="form-control form-control-sm" placeholder="Tema (Salud, Nutrición...)">
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="url" name="nuevo_enlace" class="form-control" placeholder="Enlace Spotify, YouTube, Apple...">
                                    <button type="submit" class="btn btn-outline-warning text-dark"><i class="bi bi-plus-lg"></i> Crear y Sumar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0">
                    <?php if (empty($mientretenimiento['podcasts'])): ?>
                        <div class="p-3 text-center text-muted small">No hay podcasts vinculados a esta lista personal.</div>
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
                                    <?php foreach ($mientretenimiento['podcasts'] as $p): ?>
                                        <tr>
                                            <td class="ps-3 text-muted fw-bold">#<?= $p['idmientretenimientopodcast'] ?></td>
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
                                                    <a href="<?= base_url('mientretenimientopodcast/actual/' . $p['idmientretenimientopodcast']) ?>" class="btn btn-outline-primary" title="Ver relación"><i class="bi bi-eye"></i></a>
                                                    <a href="<?= base_url('mientretenimientopodcast/delete/' . $p['idmientretenimientopodcast']) ?>" class="btn btn-outline-danger" title="Desvincular" onclick="return confirm('¿Quitar este podcast de tu lista?');"><i class="bi bi-trash"></i></a>
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
