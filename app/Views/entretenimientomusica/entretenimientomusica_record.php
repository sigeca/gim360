<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-8">

        <?php if (empty($rel)): ?>
            <?= view('layout/empty_record', ['module' => 'entretenimientomusica']) ?>
        <?php else: ?>

            <?= view('layout/nav_toolbar', [
                'module'    => 'entretenimientomusica',
                'currentId' => $rel['identretenimientomusica']
            ]) ?>

            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="fw-bold mb-0 text-dark">
                        <i class="bi bi-music-note-list text-danger me-2"></i>Entretenimiento y Música #<?= $rel['identretenimientomusica'] ?>
                    </h5>
                    <span class="badge bg-secondary">ID #<?= $rel['identretenimientomusica'] ?></span>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle mb-0">
                        <tbody>
                            <tr>
                                <th class="table-light w-35 text-muted">ID Relación</th>
                                <td class="fw-bold">#<?= $rel['identretenimientomusica'] ?></td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Entretenimiento (ID #<?= $rel['identretenimiento'] ?>)</th>
                                <td>
                                    <a href="<?= base_url('entretenimiento/actual/' . $rel['identretenimiento']) ?>" class="fw-bold text-dark text-decoration-none">
                                        <i class="bi bi-controller text-primary me-1"></i><?= esc($rel['entretenimiento_nombre']) ?>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Música (ID #<?= $rel['idmusica'] ?>)</th>
                                <td>
                                    <a href="<?= base_url('musica/actual/' . $rel['idmusica']) ?>" class="fw-bold text-danger text-decoration-none">
                                        <i class="bi bi-music-note-beamed me-1"></i><?= esc($rel['musica_nombre']) ?>
                                    </a>
                                    <?php if (!empty($rel['musica_artista'])): ?>
                                        <small class="text-muted ms-2">(<?= esc($rel['musica_artista']) ?>)</small>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="table-light text-muted">Enlace de la Música</th>
                                <td>
                                    <a href="<?= esc($rel['musica_enlace']) ?>" target="_blank" rel="noopener" class="btn btn-sm btn-danger">
                                        <i class="bi bi-play-circle-fill me-1"></i>Escuchar Música
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light py-2 px-4 d-flex justify-content-between">
                    <a href="<?= base_url('entretenimiento/actual/' . $rel['identretenimiento']) ?>" class="btn btn-sm btn-outline-primary">
                        <i class="bi bi-arrow-left me-1"></i>Ver Entretenimiento
                    </a>
                    <a href="<?= base_url('entretenimientomusica/add?identretenimiento=' . $rel['identretenimiento']) ?>" class="btn btn-sm btn-danger">
                        <i class="bi bi-plus-circle me-1"></i>Asignar otra Música
                    </a>
                </div>
            </div>

        <?php endif; ?>

    </div>
</div>

<?= $this->endSection() ?>
