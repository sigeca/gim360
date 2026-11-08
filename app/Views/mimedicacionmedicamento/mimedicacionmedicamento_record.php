<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-8">
        <?php if (empty($relacion)): ?>
            <?= view('layout/empty_record', ['module' => 'mimedicacionmedicamento']) ?>
        <?php else: ?>
            <?= view('layout/nav_toolbar', ['module' => 'mimedicacionmedicamento', 'currentId' => $relacion['idmimedicacionmedicamento']]) ?>
            <div class="card card-custom bg-white border-top border-4 border-info shadow-sm mb-4">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-capsule text-info me-2"></i>Mi Medicación - Medicamento #<?= $relacion['idmimedicacionmedicamento'] ?></h5>
                    <a href="<?= base_url('mimedicacion/actual/' . $relacion['idmimedicacion']) ?>" class="btn btn-sm btn-outline-info">Volver a Mi Medicación</a>
                </div>
                <div class="card-body p-4">
                    <table class="table table-bordered align-middle">
                        <tr><th class="table-light w-35">ID Relación</th><td>#<?= $relacion['idmimedicacionmedicamento'] ?></td></tr>
                        <tr><th class="table-light">Mi Medicación</th><td><a href="<?= base_url('mimedicacion/actual/' . $relacion['idmimedicacion']) ?>" class="fw-bold"><?= esc($relacion['mimedicacion_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Persona</th><td><a href="<?= base_url('persona/actual/' . $relacion['idpersona']) ?>"><?= esc($relacion['persona_apellidos'] . ' ' . $relacion['persona_nombres']) ?></a> (C.I. <?= esc($relacion['persona_cedula']) ?>)</td></tr>
                        <tr><th class="table-light">Medicamento</th><td><a href="<?= base_url('medicamento/actual/' . $relacion['idmedicamento']) ?>" class="fw-bold text-success"><?= esc($relacion['medicamento_nombre']) ?></a></td></tr>
                        <tr><th class="table-light">Dosis Personalizada</th><td><span class="badge bg-light text-dark border fs-6"><?= esc($relacion['dosis'] ?: '-') ?></span></td></tr>
                        <tr><th class="table-light">Frecuencia</th><td><?= esc($relacion['frecuencia'] ?: '-') ?></td></tr>
                        <tr><th class="table-light">Instrucciones</th><td><?= !empty($relacion['instrucciones']) ? nl2br(esc($relacion['instrucciones'])) : '<span class="text-muted fst-italic">Sin instrucciones</span>' ?></td></tr>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>
