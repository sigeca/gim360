<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card card-custom bg-white shadow-sm border-top border-4 border-warning">
            <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="bi bi-pencil-square text-warning me-2"></i>Editar Relación Entretenimiento - Juego #<?= $rel['identretenimientojuego'] ?></h5>
                <a href="<?= base_url('entretenimientojuego/actual/' . $rel['identretenimientojuego']) ?>" class="btn btn-outline-secondary btn-sm"><i class="bi bi-arrow-left me-1"></i>Ver Ficha</a>
            </div>
            <div class="card-body p-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-warning"><?= session()->getFlashdata('error') ?></div>
                <?php endif; ?>

                <form action="<?= base_url('entretenimientojuego/update/' . $rel['identretenimientojuego']) ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="identretenimiento" class="form-label fw-bold">Entretenimiento <span class="text-danger">*</span></label>
                        <select name="identretenimiento" id="identretenimiento" class="form-select" required>
                            <?php foreach ($entretenimientos as $ent): ?>
                                <option value="<?= $ent['identretenimiento'] ?>" <?= (old('identretenimiento', $rel['identretenimiento']) == $ent['identretenimiento']) ? 'selected' : '' ?>>
                                    <?= esc($ent['nombre']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="idjuego" class="form-label fw-bold">Juego Tradicional <span class="text-danger">*</span></label>
                        <select name="idjuego" id="idjuego" class="form-select" required>
                            <?php foreach ($juegos as $j): ?>
                                <option value="<?= $j['idjuego'] ?>" <?= (old('idjuego', $rel['idjuego']) == $j['idjuego']) ? 'selected' : '' ?>>
                                    <?= esc($j['nombre']) ?><?= !empty($j['categoria']) ? ' — ' . esc($j['categoria']) : '' ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <a href="<?= base_url('entretenimientojuego/actual/' . $rel['identretenimientojuego']) ?>" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-warning text-dark fw-bold"><i class="bi bi-check-circle me-1"></i>Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
