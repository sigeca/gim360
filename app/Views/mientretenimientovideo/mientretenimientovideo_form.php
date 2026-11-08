<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-primary shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle text-primary me-2"></i>Vincular Video a Mi Entretenimiento</h5>
                <a href="<?= base_url('mientretenimiento') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mientretenimientovideo/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mi Entretenimiento <span class="text-danger">*</span></label>
                        <select name="idmientretenimiento" class="form-select" required>
                            <option value="">-- Seleccionar --</option>
                            <?php foreach ($misEntretenimientos as $me): ?>
                                <option value="<?= $me['idmientretenimiento'] ?>" <?= (old('idmientretenimiento', $selectedIdMiEntre) == $me['idmientretenimiento']) ? 'selected' : '' ?>><?= esc($me['nombre']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Video <span class="text-danger">*</span></label>
                        <select name="idvideo" class="form-select" required>
                            <option value="">-- Seleccionar Video --</option>
                            <?php foreach ($videos as $v): ?>
                                <option value="<?= $v['idvideo'] ?>" <?= (old('idvideo', $selectedIdVideo) == $v['idvideo']) ? 'selected' : '' ?>><?= esc($v['nombre']) ?> [<?= esc($v['categoria'] ?: 'General') ?>]</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary px-4"><i class="bi bi-save me-1"></i>Vincular</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
