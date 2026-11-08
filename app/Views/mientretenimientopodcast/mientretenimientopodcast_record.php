<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mientretenimientopodcast']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mientretenimientopodcast', 'currentId' => $relacion['idmientretenimientopodcast']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-warning shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-mic-fill text-warning me-2"></i>Mi Entretenimiento - Podcast #<?= $relacion['idmientretenimientopodcast'] ?></h5>
                    <a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="btn btn-sm btn-outline-info">Volver a Mi Entretenimiento</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmientretenimientopodcast'] ?></td></tr>
                        <tr><th class="table-light">Mi Entretenimiento</th><td><a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="fw-bold"><?= esc($relacion['mientretenimiento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Persona</th><td><a href="<?= base_url('persona/actual/' . $relacion['idpersona']) ?>"><?= esc($relacion['persona_apellidos'] . ' ' . $relacion['persona_nombres']) ?></a></td></tr>
                        <tr><th class="table-light">Podcast</th><td><a href="<?= base_url('podcast/actual/' . $relacion['idpodcast']) ?>" class="fw-bold"><?= esc($relacion['podcast_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Presentador / Tema</th><td><?= esc($relacion['podcast_presentador'] ?: '-') ?> | <?= esc($relacion['podcast_tema'] ?: '-') ?></td></tr>
                        <tr><th class="table-light">Enlace</th><td><a href="<?= esc($relacion['podcast_enlace']) ?>" target="_blank" class="btn btn-sm btn-warning text-dark fw-bold"><i class="bi bi-headphones me-1"></i>Escuchar</a></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
