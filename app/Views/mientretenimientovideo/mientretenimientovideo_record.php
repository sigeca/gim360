<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mientretenimientovideo']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mientretenimientovideo', 'currentId' => $relacion['idmientretenimientovideo']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-camera-reels-fill text-primary me-2"></i>Mi Entretenimiento - Video #<?= $relacion['idmientretenimientovideo'] ?></h5>
                    <a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="btn btn-sm btn-outline-info">Volver a Mi Entretenimiento</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmientretenimientovideo'] ?></td></tr>
                        <tr><th class="table-light">Mi Entretenimiento</th><td><a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="fw-bold"><?= esc($relacion['mientretenimiento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Persona</th><td><a href="<?= base_url('persona/actual/' . $relacion['idpersona']) ?>"><?= esc($relacion['persona_apellidos'] . ' ' . $relacion['persona_nombres']) ?></a></td></tr>
                        <tr><th class="table-light">Video</th><td><a href="<?= base_url('video/actual/' . $relacion['idvideo']) ?>" class="fw-bold"><?= esc($relacion['video_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Autor / Categoría</th><td><?= esc($relacion['video_autor'] ?: '-') ?> | <?= esc($relacion['video_categoria'] ?: '-') ?></td></tr>
                        <tr><th class="table-light">Enlace</th><td><a href="<?= esc($relacion['video_enlace']) ?>" target="_blank" class="btn btn-sm btn-primary"><i class="bi bi-play-btn-fill me-1"></i>Ver Video</a></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
