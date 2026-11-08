<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-danger">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle-fill text-danger me-2"></i>Vincular Música a Entretenimiento</h5>
                <a href="<?= base_url('entretenimientomusica/listar') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-warning"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('entretenimientomusica/save') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="identretenimiento" class="form-label fw-bold">Entretenimiento <span class="text-danger">*</span></label>
                        <select name="identretenimiento" id="identretenimiento" class="form-select" required>
                            <option value="">-- Seleccione Entretenimiento --</option>
                            <?php foreach ($entretenimientos as $ent): ?>
                                <option value="<?= $ent['identretenimiento'] ?>" <?= (old('identretenimiento', $preselectedEntretenimiento) == $ent['identretenimiento']) ? 'selected' : '' ?>>
                                    <?= esc($ent['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="idmusica" class="form-label fw-bold">Música <span class="text-danger">*</span></label>
                        <select name="idmusica" id="idmusica" class="form-select" required>
                            <option value="">-- Seleccione Música --</option>
                            <?php foreach ($musicas as $m): ?>
                                <option value="<?= $m['idmusica'] ?>" <?= (old('idmusica', $preselectedMusica) == $m['idmusica']) ? 'selected' : '' ?>>
                                    <?= esc($m['nombre']) ?><?= !empty($m['artista']) ? ' — ' . esc($m['artista']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('entretenimientomusica') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-danger"><i class="bi bi-check-circle me-1"></i>Guardar Relación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
