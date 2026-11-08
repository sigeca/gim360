<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mientretenimientojuego']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mientretenimientojuego', 'currentId' => $relacion['idmientretenimientojuego']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-joystick text-success me-2"></i>Mi Entretenimiento - Juego Tradicional #<?= $relacion['idmientretenimientojuego'] ?></h5>
                    <a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="btn btn-sm btn-outline-info">Volver a Mi Entretenimiento</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmientretenimientojuego'] ?></td></tr>
                        <tr><th class="table-light">Mi Entretenimiento</th><td><a href="<?= base_url('mientretenimiento/actual/' . $relacion['idmientretenimiento']) ?>" class="fw-bold"><?= esc($relacion['mientretenimiento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Persona</th><td><a href="<?= base_url('persona/actual/' . $relacion['idpersona']) ?>"><?= esc($relacion['persona_apellidos'] . ' ' . $relacion['persona_nombres']) ?></a></td></tr>
                        <tr><th class="table-light">Juego</th><td><a href="<?= base_url('juego/actual/' . $relacion['idjuego']) ?>" class="fw-bold"><?= esc($relacion['juego_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Categoría</th><td><?= esc($relacion['juego_categoria'] ?: 'Tradicional') ?></td></tr>
                        <tr><th class="table-light">Enlace</th><td><a href="<?= esc($relacion['juego_enlace']) ?>" target="_blank" class="btn btn-sm btn-success"><i class="bi bi-controller me-1"></i>Jugar Ahora</a></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
