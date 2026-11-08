<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mientretenimientomusica']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mientretenimientomusica', 'currentId' => $relacion['idmientretenimientomusica']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-music-note-beamed text-danger me-2"></i>Mi Entretenimiento - Música #<?= $relacion['idmientretenimientomusica'] ?></h5>
                    <a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="btn btn-sm btn-outline-info">Volver a Mi Entretenimiento</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmientretenimientomusica'] ?></td></tr>
                        <tr><th class="table-light">Mi Entretenimiento</th><td><a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="fw-bold"><?= esc($relacion['mientretenimiento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Persona</th><td><a href="<?= base_url('persona/actual/' . $relacion['idpersona']) ?>"><?= esc($relacion['persona_apellidos'] . ' ' . $relacion['persona_nombres']) ?></a> (C.I. <?= esc($relacion['persona_cedula']) ?>)</td></tr>
                        <tr><th class="table-light">Música</th><td><a href="<?= base_url('musica/actual/' . $relacion['idmusica']) ?>" class="fw-bold"><?= esc($relacion['musica_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Artista / Género</th><td><?= esc($relacion['musica_artista'] ?: '-') ?> | <?= esc($relacion['musica_genero'] ?: '-') ?></td></tr>
                        <tr><th class="table-light">Enlace</th><td><a href="<?= esc($relacion['musica_enlace']) ?>" target="_blank" class="btn btn-sm btn-danger"><i class="bi bi-play-circle-fill me-1"></i>Escuchar</a></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
