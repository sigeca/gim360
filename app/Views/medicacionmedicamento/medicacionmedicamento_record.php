<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'medicacionmedicamento']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'medicacionmedicamento', 'currentId' => $relacion['idmedicacionmedicamento']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-success shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-capsule text-success me-2"></i>Medicación - Medicamento #<?= $relacion['idmedicacionmedicamento'] ?></h5>
                    <a href="<?= base_url('medicacion/actual/' . $relacion['idmedicacion']) ?>" class="btn btn-sm btn-outline-primary">Volver a Medicación</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmedicacionmedicamento'] ?></td></tr>
                        <tr><th class="table-light">Medicación</th><td><a href="<?= base_url('medicacion/actual/' . $relacion['idmedicacion']) ?>" class="fw-bold"><?= esc($relacion['medicacion_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Afección</th><td><a href="<?= base_url('afeccion/actual/' . $relacion['idafeccion']) ?>"><?= esc($relacion['afeccion_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Medicamento</th><td><a href="<?= base_url('medicamento/actual/' . $relacion['idmedicamento']) ?>" class="fw-bold text-success"><?= esc($relacion['medicamento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Dosis Prescrita</th><td><span class="badge bg-light text-dark border fs-6"><?= esc($relacion['dosis'] ?: '-') ?></span></td></tr>
                        <tr><th class="table-light">Frecuencia</th><td><?= esc($relacion['frecuencia'] ?: '-') ?></td></tr>
                        <tr><th class="table-light">Instrucciones</th><td><?= !empty($relacion['instrucciones']) ? nl2br(esc($relacion['instrucciones'])) : '<span class="text-muted fst-italic">Sin instrucciones</span>' ?></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
