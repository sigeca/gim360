<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-primary me-2"></i>Editar Relación Mi Entretenimiento - Video #<?= $relacion['idmientretenimientovideo'] ?></h5>
                <a href="<?= base_url('mientretenimientovideo/actual/' . $relacion['idmientretenimientovideo']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mientretenimientovideo/update/' . $relacion['idmientretenimientovideo']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mi Entretenimiento <span class="text-danger">*</span></label>
                        <select name="idmientretenimiento" class="form-select" required>
                            <?php foreach ($misEntretenimientos as $me): ?>
                                <option value="<?= $me['idmientretenimiento'] ?>" <?= ($relacion['idmientretenimiento'] == $me['idmientretenimiento']) ? 'selected' : '' ?>><?= esc($me['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Video <span class="text-danger">*</span></label>
                        <select name="idvideo" class="form-select" required>
                            <?php foreach ($videos as $v): ?>
                                <option value="<?= $v['idvideo'] ?>" <?= ($relacion['idvideo'] == $v['idvideo']) ? 'selected' : '' ?>><?= esc($v['nombre']) ?> [<?= esc($v['categoria'] ?: 'General') ?>]</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
