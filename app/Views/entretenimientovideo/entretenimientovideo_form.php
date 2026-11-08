<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-primary">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-plus-circle-fill text-primary me-2"></i>Vincular Video a Entretenimiento</h5>
                <a href="<?= base_url('entretenimientovideo/listar') ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Volver</a>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-warning"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('entretenimientovideo/save') ?>" method="post">
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
                        <label for="idvideo" class="form-label fw-bold">Video <span class="text-danger">*</span></label>
                        <select name="idvideo" id="idvideo" class="form-select" required>
                            <option value="">-- Seleccione Video --</option>
                            <?php foreach ($videos as $v): ?>
                                <option value="<?= $v['idvideo'] ?>" <?= (old('idvideo', $preselectedVideo) == $v['idvideo']) ? 'selected' : '' ?>>
                                    <?= esc($v['nombre']) ?><?= !empty($v['autor']) ? ' — ' . esc($v['autor']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('entretenimientovideo') ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle me-1"></i>Guardar Relación</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
