<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white border-top border-4 border-danger shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-danger me-2"></i>Editar Relación Mi Entretenimiento - Música #<?= $relacion['idmientretenimientomusica'] ?></h5>
                <a href="<?= base_url('mientretenimientomusica/actual/' . $relacion['idmientretenimientomusica']) ?>" class="btn btn-sm btn-outline-secondary">Volver</a>
            </div>
            <div class="card-body p-4">
                <form action="<?= base_url('mientretenimientomusica/update/' . $relacion['idmientretenimientomusica']) ?>" method="post">
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
                        <label class="form-label fw-bold">Música <span class="text-danger">*</span></label>
                        <select name="idmusica" class="form-select" required>
                            <?php foreach ($musicas as $m): ?>
                                <option value="<?= $m['idmusica'] ?>" <?= ($relacion['idmusica'] == $m['idmusica']) ? 'selected' : '' ?>><?= esc($m['nombre']) ?> (<?= esc($m['artista'] ?: 'Varios') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-danger px-4">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
