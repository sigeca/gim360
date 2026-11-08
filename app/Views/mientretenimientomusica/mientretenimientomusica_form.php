<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle text-danger me-2"></i>Vincular Música a Mi Entretenimiento</h5>
                <a href="<?= base_url('mientretenimiento') ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mientretenimientomusica/save') ?>" method="post">
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
                        <label class="form-label fw-bold">Música <span class="text-danger">*</span></label>
                        <select name="idmusica" class="form-select" required>
                            <option value="">-- Seleccionar Música --</option>
                            <?php foreach ($musicas as $m): ?>
                                <option value="<?= $m['idmusica'] ?>" <?= (old('idmusica', $selectedIdMusica) == $m['idmusica']) ? 'selected' : '' ?>><?= esc($m['nombre']) ?> (<?= esc($m['artista'] ?: 'Varios') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-danger px-4"><i class="bi bi-save me-1"></i>Vincular</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
